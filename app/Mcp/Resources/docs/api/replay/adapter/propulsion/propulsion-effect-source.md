# PropulsionEffectSource

> Propulsion's hook into both halves of the replay lifecycle.

Propulsion's hook into both halves of the replay lifecycle.

**Recording** works by correlation id: [`PropulsionQueryRecorder`](/api/replay/adapter/propulsion/propulsion-query-recorder/) is registered once at boot, because `Propulsion::addQueryObserver()` is process-scoped rather than request-scoped, so it needs telling which request's [`EffectLedger`](/api/replay/replay/effect-ledger/) a given correlation id belongs to.

**Isolation** cannot use that seam at all, and substitutes the connection instead. Propulsion's observers are observation-only by contract -- `QueryObserver` states that an observer must not throw, and `queryStarted()` has no way to return a result -- so there is no point at which one could answer a query from the ledger. `Propulsion::setConnection()` replaces what the observers observe, which is both the available seam and the better one: it keeps observation and control apart, where a return channel on `QueryObserver` would let every existing observer lie about a query. See [`LedgerBackedPropulsionPdo`](/api/replay/adapter/propulsion/ledger-backed-propulsion-pdo/).

## Synopsis

`final class PropulsionEffectSource implements IsolatesFromLedger`

|  |  |
|---|---|
| Implements | [`IsolatesFromLedger`](/api/replay/replay/isolates-from-ledger/) |
| Source | `PropulsionEffectSource.php` |

## Methods

| Method | Description |
|---|---|
| [`activate(string $correlationId, EffectLedger $ledger): void`](#activate) | Called once, before `$handler->handle()`, for every request `RecorderMiddleware` buffers. |
| [`beginIsolation(EffectLedger $ledger): void`](#beginisolation) | Points every datasource at a connection that answers from $ledger. |
| [`deactivate(string $correlationId): void`](#deactivate) | Called once, as soon as `$handler->handle()` returns or throws. |
| [`endIsolation(): void`](#endisolation) | Removes what [`PropulsionEffectSource::beginIsolation()`](/api/replay/adapter/propulsion/propulsion-effect-source/#beginisolation) installed, so the next real query opens a real connection. |

### activate()

`public function activate(string $correlationId, EffectLedger $ledger): void`

Called once, before `$handler->handle()`, for every request `RecorderMiddleware` buffers.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### beginIsolation()

`public function beginIsolation(EffectLedger $ledger): void`

Points every datasource at a connection that answers from $ledger.

Both read and write modes, per datasource: a replayed request that reads through the slave and writes through the master would otherwise have half its queries isolated and half of them reaching a real server, which is worse than either.

The datasource list comes from `Propulsion::getDatabaseMapNames()`, plus the default -- a map is registered for every datasource the ORM's generated code touches, which is the set that can produce a query. A datasource nothing has touched yet has no map, and also no query to serve.

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

### deactivate()

`public function deactivate(string $correlationId): void`

Called once, as soon as `$handler->handle()` returns or throws.

| Parameter | Type | Description |
|---|---|---|
| `$correlationId` | `string` |  |

### endIsolation()

`public function endIsolation(): void`

Removes what [`PropulsionEffectSource::beginIsolation()`](/api/replay/adapter/propulsion/propulsion-effect-source/#beginisolation) installed, so the next real query opens a real connection.

`discardConnection()` rather than putting the previous connection back, because there is no way to have captured it: `Propulsion::getConnection()` *opens* one when the map is empty, so reading the pre-replay state would have created the very connection an isolated replay exists to avoid. Discarding leaves the map empty and Propulsion reopens from configuration on next use -- one extra connect in a long-lived process, and nothing wrong in a CLI one, which is where a replay usually runs. A non-opening peek keyed by datasource and mode would make this exact; Propulsion has none today.

Never throws: it runs in `IsolatedReplay`'s `finally`, where a throw would replace whatever the replay itself was reporting and leave a stub connection installed for the rest of the process.
