# DoctrineRecordingMiddleware

> A `Doctrine\\DBAL\\Driver\\Middleware` (DBAL 4's own extension seam, installed via `Doctrine\\DBAL\\Configuration::setMiddlewares([$middleware])` passed to `Doctrine\\DBAL\\DriverManager::getConnection($params, $config)`) that appends one EffectKind::Db entry per query to whichever EffectLedger ActiveEffectLedger currently holds.

A `Doctrine\DBAL\Driver\Middleware` (DBAL 4's own extension seam, installed via `Doctrine\DBAL\Configuration::setMiddlewares([$middleware])` passed to `Doctrine\DBAL\DriverManager::getConnection($params, $config)`) that appends one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per query to whichever [`EffectLedger`](/api/replay/replay/effect-ledger/) [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) currently holds.

Structured after DBAL's own `Doctrine\DBAL\Logging\Middleware` (a Driver/Connection/Statement decorator chain built on the abstract middleware base classes DBAL ships for exactly this purpose), not a raw reimplementation of the `Driver`/`Connection`/`Statement` interfaces.

Reads [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) rather than taking a fixed `EffectLedger` at construction: a DBAL connection wrapped by this middleware is built once, at `DoctrineDatabase`/`DoctrineDbalDatabase::connect()`, and then recycled (not rebuilt) across every later request in a worker process -- see [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s own docblock for why a fixed ledger would be wrong past the connection's first use.

A failing query (bad SQL, a constraint violation, ...) is never recorded: the real exception propagates unchanged and no ledger entry is written for it, matching every other recorder in this package -- a failed call has no result to replay, and no entry is a more honest state than a fabricated one.

Wiring this into an application's own Doctrine connection (deciding WHEN to record, redaction, sampling, ...) is `RecorderMiddleware`/plugin territory and is out of scope here; this class only has to work correctly when installed.

## Synopsis

`final class DoctrineRecordingMiddleware implements Middleware`

|  |  |
|---|---|
| Implements | `Middleware` |
| Source | `DoctrineRecordingMiddleware.php` |

## Constructor

### __construct()

`public function __construct(ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`wrap(Driver $driver): Driver`](#wrap) |  |

### wrap()

`public function wrap(Driver $driver): Driver`

| Parameter | Type | Description |
|---|---|---|
| `$driver` | `Driver` |  |

Returns `Driver`
