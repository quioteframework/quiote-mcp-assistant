# DoctrineRecordingConnection

> Records `query()`/`exec()` called directly on the connection (bypassing a prepared Statement), and hands back a DoctrineRecordingStatement from `prepare()` so a prepared statement's own `execute()` is recorded too.

Records `query()`/`exec()` called directly on the connection (bypassing a prepared `Statement`), and hands back a [`DoctrineRecordingStatement`](/api/replay/adapter/doctrine/doctrine-recording-statement/) from `prepare()` so a prepared statement's own `execute()` is recorded too.

Mirrors the shape of `Doctrine\DBAL\Logging\Connection`, DBAL's own reference middleware.

Records into [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s current ledger rather than a fixed one -- see that class's own docblock -- so a query is simply not recorded when nothing is currently active (e.g. a boot-time query run before any request is being recorded), the same as every other recorder in this package does for a call it declines to observe.

## Synopsis

`final class DoctrineRecordingConnection extends AbstractConnectionMiddleware`

|  |  |
|---|---|
| Extends | `AbstractConnectionMiddleware` |
| Source | `DoctrineRecordingConnection.php` |

## Constructor

### __construct()

`public function __construct(Connection $connection, ClockInterface $clock): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$connection` | `Connection` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`exec(string $sql): string|int`](#exec) | `exec()` has no result set to snapshot, so there is nothing to skip when the ledger is absent -- the null-safe call is the whole guard. |
| [`prepare(string $sql): Statement`](#prepare) | Prepares a statement for execution and returns a Statement object. |
| [`query(string $sql): Result`](#query) | Consults the ledger before touching the result set and hands the real `Result` straight back when nothing is recording -- see [`DoctrineRecordingStatement::execute()`](/api/replay/adapter/doctrine/doctrine-recording-statement/#execute) for why an unconditional snapshot here changed the behaviour of every query in the application. |

### exec()

`public function exec(string $sql): string|int`

`exec()` has no result set to snapshot, so there is nothing to skip when the ledger is absent -- the null-safe call is the whole guard.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `string``|``int`

### prepare()

`public function prepare(string $sql): Statement`

Prepares a statement for execution and returns a Statement object.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `Statement`

| Throws | When |
|---|---|
| `Exception` |  |

### query()

`public function query(string $sql): Result`

Consults the ledger before touching the result set and hands the real `Result` straight back when nothing is recording -- see [`DoctrineRecordingStatement::execute()`](/api/replay/adapter/doctrine/doctrine-recording-statement/#execute) for why an unconditional snapshot here changed the behaviour of every query in the application.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `Result`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `beginTransaction()` | `AbstractConnectionMiddleware` |  |
| `commit()` | `AbstractConnectionMiddleware` |  |
| `getNativeConnection()` | `AbstractConnectionMiddleware` |  |
| `getServerVersion()` | `AbstractConnectionMiddleware` |  |
| `lastInsertId()` | `AbstractConnectionMiddleware` |  |
| `quote()` | `AbstractConnectionMiddleware` |  |
| `rollBack()` | `AbstractConnectionMiddleware` |  |
