# PropulsionQueryRecorder

> Records every Propulsion query into whichever request's EffectLedger it belongs to, via Propulsion's own observer seam (RowCapturingQueryObserver).

Records every Propulsion query into whichever request's [`EffectLedger`](/api/replay/replay/effect-ledger/) it belongs to, via Propulsion's own observer seam (`RowCapturingQueryObserver`).

**Registered exactly once, at boot**, by [`ReplayPropulsionPlugin`](/api/replay/adapter/propulsion/replay-propulsion-plugin/). `Propulsion::addQueryObserver()`/`removeQueryObserver()` are process-scoped, not request-scoped: a threaded worker (FrankenPHP `worker <n> > 1`) shares `Propulsion::$session` and everything it reaches across every thread with no per-thread isolation (`docs/WORKER_MODE.md` R10 in the Propulsion repo), so adding/removing an observer per request would read and write process-wide state from what should be request-scoped code. Instead, this class routes each `QueryExecution` to the right ledger via `$execution->correlationId` and [`EffectLedgerRegistry`](/api/replay/recording/effect-ledger-registry/), which [`PropulsionEffectSource`](/api/replay/adapter/propulsion/propulsion-effect-source/) populates for the duration of one request via `Quiote\Replay\Recording\RecorderMiddleware`'s generic `EffectSource` seam.

**Bound parameters and captured rows are redacted here**, at the moment they're about to enter the ledger -- never deferred to serialization, the same rule [`Redactor`](/api/replay/recording/redactor/)'s own docblock states for every other capture path. Both now carry real column names (`BoundParameter::$column`, `QueryExecution::getColumnNames()`), so both go through the same `replay.redact.params` denylist everything else uses. A bound value with no known column (a raw/manual PDO bind, outside the ORM's own SQL-building path) passes through unredacted -- there is nothing to check it against.

**Recorded exactly once per query**: `queryFinished()` records immediately whenever the statement has no result set to report rows for -- `PDO::exec()` (`SOURCE_EXEC`), a `PDOStatement::execute()` that changed rows rather than selecting them (signalled by `QueryExecution::getRowCount()` being non-null -- `PropulsionStatement::execute()` only reports a row count for exactly that case), or a query that was never asked to capture rows at all. A genuine result-set-bearing statement (`getRowCount() === null`) that requested capture is recorded only in [`PropulsionQueryRecorder::rowsCaptured()`](/api/replay/adapter/propulsion/propulsion-query-recorder/#rowscaptured) instead, which `docs/OBSERVABILITY.md` documents as guaranteed to eventually fire once requested (cursor exhausted, an explicit `closeCursor()`, a re-`execute()`, or the statement's own destructor as a last resort). Relying on `wantsRowCapture()` alone here would be wrong: it says a capture was *asked for*, not that the statement has anything to capture, and an INSERT/UPDATE/DELETE that nothing ever calls `fetch()`/`closeCursor()` on would otherwise depend on the statement variable eventually being destructed to be recorded at all.

**A query that threw is not recorded** -- `queryFinished()` still runs for a failed statement, but a failed statement never reaches `rowsCaptured()` either (there is no result set to exhaust), so this is the one place that rule needs to be enforced.

**Row capture is only requested for `SOURCE_STATEMENT`, not `SOURCE_QUERY`** (a raw `$connection->query()` call) -- verified (not assumed): Propulsion's own `PropulsionPDO::query()` builds and notifies a `QueryExecution` but never attaches it to the returned statement's `$currentExecution`, so `rowsCaptured()` can never fire for one no matter what's requested here. The query is still recorded (immediately, in `queryFinished()`, with no rows) rather than silently never appearing in the ledger. This doesn't affect the ORM's own generated code, which always binds through `prepare()`/`bindValue()`/`execute()` (`SOURCE_STATEMENT`) regardless -- only raw application code calling `query()` directly loses row capture, and only until that Propulsion gap is fixed.

## Synopsis

`final class PropulsionQueryRecorder implements RowCapturingQueryObserver`

|  |  |
|---|---|
| Implements | `RowCapturingQueryObserver` |
| Source | `PropulsionQueryRecorder.php` |

## Constructor

### __construct()

`public function __construct(\Closure(): Redactor|null $redactorFactory = null): mixed`

Resolves the [`Redactor`](/api/replay/recording/redactor/) per query.
       A factory rather than an instance because this recorder is constructed once, at
       plugin registration, and `Redactor::fromConfig()` reads `replay.redact.*` at the
       moment it is called: freezing one in at boot meant an application's own denylist,
       not necessarily loaded that early, was silently replaced by the hardcoded defaults
       with no error to notice. `RecorderMiddleware` builds a fresh one per request for the
       same reason. Null uses `Redactor::fromConfig()`.

| Parameter | Type | Description |
|---|---|---|
| `$redactorFactory` | `\Closure(): Redactor``|``null` | Resolves the [`Redactor`](/api/replay/recording/redactor/) per query. A factory rather than an instance because this recorder is constructed once, at plugin registration, and `Redactor::fromConfig()` reads `replay.redact.*` at the moment it is called: freezing one in at boot meant an application's own denylist, not necessarily loaded that early, was silently replaced by the hardcoded defaults with no error to notice. `RecorderMiddleware` builds a fresh one per request for the same reason. Null uses `Redactor::fromConfig()`. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`queryFinished(QueryExecution $execution): void`](#queryfinished) | Called after the statement returns, whether it succeeded or threw -- `$execution->isFailed()` says which, and the exception is rethrown to the caller either way. |
| [`queryStarted(QueryExecution $execution): void`](#querystarted) | Called immediately before the statement is sent to the server. |
| [`rowsCaptured(QueryExecution $execution): void`](#rowscaptured) | Called once per statement that requested row capture, after its result set is exhausted or closed. |

### queryFinished()

`public function queryFinished(QueryExecution $execution): void`

Called after the statement returns, whether it succeeded or threw -- `$execution->isFailed()` says which, and the exception is rethrown to the caller either way.

| Parameter | Type | Description |
|---|---|---|
| `$execution` | `QueryExecution` |  |

### queryStarted()

`public function queryStarted(QueryExecution $execution): void`

Called immediately before the statement is sent to the server.

The same `QueryExecution` instance is passed to [`PropulsionQueryRecorder::queryFinished()`](/api/replay/adapter/propulsion/propulsion-query-recorder/#queryfinished), so state that has to span the call (an open tracing span) belongs on it via `setAttribute()`.

| Parameter | Type | Description |
|---|---|---|
| `$execution` | `QueryExecution` |  |

### rowsCaptured()

`public function rowsCaptured(QueryExecution $execution): void`

Called once per statement that requested row capture, after its result set is exhausted or closed.

Get the rows themselves from `$execution` -- `QueryExecution::getCapturedRows()`, `QueryExecution::isRowsTruncated()`, `QueryExecution::getColumnNames()` -- rather than as separate parameters here, the same shape `queryStarted()`/`queryFinished()` already use.

**Must not throw**, for the same reason `QueryObserver` itself documents: `QueryObservers` catches and logs a throw here too, rather than letting it propagate.

| Parameter | Type | Description |
|---|---|---|
| `$execution` | `QueryExecution` |  |
