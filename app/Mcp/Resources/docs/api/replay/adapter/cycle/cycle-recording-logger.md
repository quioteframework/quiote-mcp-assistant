# CycleRecordingLogger

> Records one EffectKind::Db entry per successful query on a Cycle (`cycle/database`) connection, and forwards every message to whatever logger the application already had, via Cycle's own PSR-3 logger seam -- `Cycle\\Database\\Driver\\Driver::statement()` logs every query through whatever `Psr\\Log\\LoggerInterface` was installed on it, at `info` on success and `error`+`alert` on failure (read directly from `vendor/cycle/database/src/Driver/Driver.php`, not assumed).

Records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per successful query on a Cycle (`cycle/database`) connection, and forwards every message to whatever logger the application already had, via Cycle's own PSR-3 logger seam -- `Cycle\Database\Driver\Driver::statement()` logs every query through whatever `Psr\Log\LoggerInterface` was installed on it, at `info` on success and `error`+`alert` on failure (read directly from `vendor/cycle/database/src/Driver/Driver.php`, not assumed).

Wiring this logger onto a connection is `Cycle\Database\DatabaseManager::setLogger()`, called before any driver is resolved so the manager's `getLoggerForDriver()` fallback picks it up for every driver it creates.

Only the `info` level is recorded -- a failed query logs at `error`, which this class deliberately ignores, matching every other recorder in this package's rule that a failed call is never given a fabricated ledger entry. The real exception still propagates from `Driver::statement()` regardless of what this logger does; PSR-3 logging is a side channel, not part of the call's control flow.

`$context['rowCount']`/`$context['elapsed']` are always present (set by `Driver::defineLoggerContext()`); `$context['parameters']` is only present when the driver's `logQueryParameters` option is enabled (default `false`) -- absent otherwise, recorded here as an empty list in that case.

Records into [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s current ledger rather than a fixed one taken at construction: this logger is installed once, at `CycleDatabase::connect()`, and per that adapter's own docblock Cycle is "the data-mapper built for long-running (RoadRunner/FrankenPHP) processes" -- its `DatabaseManager` is recycled (not rebuilt) across every later request in a worker. See [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s own docblock for why a fixed ledger would be wrong past the connection's first use. A query that runs with nothing currently active (e.g. before any request is being recorded) is simply not recorded.

## Synopsis

`final class CycleRecordingLogger extends AbstractLogger`

|  |  |
|---|---|
| Extends | `AbstractLogger` |
| Source | `CycleRecordingLogger.php` |

## Constructor

### __construct()

`public function __construct(LoggerInterface|null $inner = null): mixed`

A logger every message is forwarded to after
       recording. `Cycle\Database\DatabaseManager::setLogger()` is a whole-value
       assignment, so without this, installing the recorder silently ended whatever query
       logging the application had.

| Parameter | Type | Description |
|---|---|---|
| `$inner` | [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/)`|``null` | A logger every message is forwarded to after recording. `Cycle\Database\DatabaseManager::setLogger()` is a whole-value assignment, so without this, installing the recorder silently ended whatever query logging the application had. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fingerprintOf(string $sql): string`](#fingerprintof) | Trim + collapse internal whitespace runs; deliberately not full SQL normalization. |
| [`log(mixed $level, Stringable|string $message, array $context = []): void`](#log) | Logs with an arbitrary level. |
| [`wrapping(?LoggerInterface $existing): CycleRecordingLogger`](#wrapping) | A recording logger that also forwards to $existing, or a plain one when there is none. |

### fingerprintOf()

`public static function fingerprintOf(string $sql): string`

Trim + collapse internal whitespace runs; deliberately not full SQL normalization.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `string`

### log()

`public function log(mixed $level, Stringable|string $message, array $context = []): void`

Logs with an arbitrary level.

| Parameter | Type | Description |
|---|---|---|
| `$level` | `mixed` |  |
| `$message` | [`Stringable`](https://www.php.net/manual/en/class.stringable.php)`|``string` |  |
| `$context` | `array` |  |

| Throws | When |
|---|---|
| `InvalidArgumentException` |  |

### wrapping()

`public static function wrapping(?LoggerInterface $existing): CycleRecordingLogger`

A recording logger that also forwards to $existing, or a plain one when there is none.

| Parameter | Type | Description |
|---|---|---|
| `$existing` | `?`[`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) |  |

Returns [`CycleRecordingLogger`](/api/replay/adapter/cycle/cycle-recording-logger/)

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `alert()` | `AbstractLogger` | Action must be taken immediately. |
| `critical()` | `AbstractLogger` | Critical conditions. |
| `debug()` | `AbstractLogger` | Detailed debug information. |
| `emergency()` | `AbstractLogger` | System is unusable. |
| `error()` | `AbstractLogger` | Runtime errors that do not require immediate action but should typically be logged and monitored. |
| `info()` | `AbstractLogger` | Interesting events. |
| `notice()` | `AbstractLogger` | Normal but significant events. |
| `warning()` | `AbstractLogger` | Exceptional occurrences that are not errors. |
