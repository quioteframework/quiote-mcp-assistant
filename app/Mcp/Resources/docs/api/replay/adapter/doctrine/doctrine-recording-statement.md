# DoctrineRecordingStatement

> Records one EffectKind::Db entry per `execute()`, following the same shape as RecordingPdoStatement: bound parameters are captured via `bindValue()` (mirroring `Doctrine\\DBAL\\Logging\\Statement`, DBAL's own reference middleware for observing a statement), and the real `Result` is snapshotted once into a DoctrineSnapshotResult so the caller's own fetch calls keep working after the row set has been read once for the ledger.

Records one [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) entry per `execute()`, following the same shape as [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/): bound parameters are captured via `bindValue()` (mirroring `Doctrine\DBAL\Logging\Statement`, DBAL's own reference middleware for observing a statement), and the real `Result` is snapshotted once into a [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/) so the caller's own fetch calls keep working after the row set has been read once for the ledger.

Records into [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/)'s current ledger -- see that class's own docblock for why a statement built once around a recycled connection cannot take a fixed ledger at construction.

## Synopsis

`final class DoctrineRecordingStatement extends AbstractStatementMiddleware`

|  |  |
|---|---|
| Extends | `AbstractStatementMiddleware` |
| Source | `DoctrineRecordingStatement.php` |

## Constructor

### __construct()

`public function __construct(Statement $statement, string $sql, ClockInterface $clock): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$statement` | `Statement` |  |
| `$sql` | `string` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`bindValue(int|string $param, mixed $value, ParameterType $type): void`](#bindvalue) | Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional placeholder in the SQL statement that was used to prepare the statement. |
| [`execute(): Result`](#execute) | The ledger is consulted *before* the result set is touched, and the real `Result` is handed straight back when nothing is recording. |

### bindValue()

`public function bindValue(int|string $param, mixed $value, ParameterType $type): void`

Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional placeholder in the SQL statement that was used to prepare the statement.

Explicit data type for the parameter using the `ParameterType`
                            constants.

| Parameter | Type | Description |
|---|---|---|
| `$param` | `int``|``string` | Parameter identifier. For a prepared statement using named placeholders, this will be a parameter name of the form :name. For a prepared statement using question mark placeholders, this will be the 1-indexed position of the parameter. |
| `$value` | `mixed` | The value to bind to the parameter. |
| `$type` | `ParameterType` | Explicit data type for the parameter using the `ParameterType` constants. |

| Throws | When |
|---|---|
| `Exception` |  |

### execute()

`public function execute(): Result`

The ledger is consulted *before* the result set is touched, and the real `Result` is handed straight back when nothing is recording.

This middleware is installed on the connection permanently, by `ReplayDoctrinePlugin`'s driver-alias registration -- it is not gated on `replay.enabled`, because a connection is built once and recycled for the rest of the worker's life, long before any request has said whether it wants recording. Snapshotting unconditionally therefore meant every query in the application was fully materialized into PHP memory for the entire life of the process: unbuffered and cursor-based reads became impossible, and a caller streaming a large result set paid for the whole of it. Measured on a real DBAL connection streaming 20 000 rows with no ledger active, the snapshot cost 12 MiB of peak memory against 0 for the undecorated connection.

Passing the real `Result` through is also the more correct answer, not merely the cheaper one: [`DoctrineSnapshotResult`](/api/replay/adapter/doctrine/doctrine-snapshot-result/) is a faithful stand-in only for what a recorded query needs, and a caller that is not being recorded has no reason to receive it.

Returns `Result`
