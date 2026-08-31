# LedgerBackedStatement

> The statement LedgerBackedConnection prepares: collects bound values, then answers from the ledger by the same fingerprint the recorder wrote.

The statement [`LedgerBackedConnection`](/api/replay/adapter/doctrine/ledger-backed-connection/) prepares: collects bound values, then answers from the ledger by the same fingerprint the recorder wrote.

Bound values are collected rather than ignored because they are half the fingerprint. Without them two executions of one prepared statement in a loop would be indistinguishable and could only be matched by position -- see `Quiote\Replay\Db\RecordingPdoStatement::fingerprintFor()`.

## Synopsis

`final class LedgerBackedStatement implements Statement`

|  |  |
|---|---|
| Implements | `Statement` |
| Source | `LedgerBackedStatement.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger, string $sql): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$sql` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`bindValue(int|string $param, mixed $value, ParameterType $type): void`](#bindvalue) | Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional placeholder in the SQL statement that was used to prepare the statement. |
| [`execute(): Result`](#execute) | Executes a prepared statement |

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

Executes a prepared statement

Returns `Result`

| Throws | When |
|---|---|
| `Exception` |  |
