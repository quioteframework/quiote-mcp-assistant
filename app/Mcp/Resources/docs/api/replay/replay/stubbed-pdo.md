# StubbedPdo

> The isolated-replay counterpart to `Quiote\\Replay\\Db\\RecordingPdo`: never calls `parent::__construct()`, so no real connection is ever attempted, and answers every `exec()`/`query()`/`prepare()->execute()` from an injected EffectLedger via StubbedPdoStatement.

The isolated-replay counterpart to `Quiote\Replay\Db\RecordingPdo`: never calls `parent::__construct()`, so no real connection is ever attempted, and answers every `exec()`/`query()`/`prepare()->execute()` from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) via [`StubbedPdoStatement`](/api/replay/replay/stubbed-pdo-statement/).

Only the statement-producing surface (`exec()`, `query()`, `prepare()`) is implemented -- transactions, `lastInsertId()` and the rest of `\PDO` are out of scope for this iteration and are not called by anything that goes through this class.

## Synopsis

`final class StubbedPdo extends PDO`

|  |  |
|---|---|
| Extends | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |
| Source | `Replay/StubbedPdo.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`exec(string $statement): int`](#exec) | Narrows `\PDO::exec()`'s native `int\|false` return type: this implementation always either answers from the ledger or throws, so it never has a `false` (driver-level failure) case to represent. |
| [`prepare(string $query, array<int, mixed> $options = []): PDOStatement`](#prepare) | Narrows `\PDO::prepare()`'s native `PDOStatement\|false` return type; see [`StubbedPdo::exec()`](/api/replay/replay/stubbed-pdo/#exec). |
| [`query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement`](#query) | Narrows `\PDO::query()`'s native `PDOStatement\|false` return type; see [`StubbedPdo::exec()`](/api/replay/replay/stubbed-pdo/#exec). |

### exec()

`public function exec(string $statement): int`

Narrows `\PDO::exec()`'s native `int|false` return type: this implementation always either answers from the ledger or throws, so it never has a `false` (driver-level failure) case to represent.

| Parameter | Type | Description |
|---|---|---|
| `$statement` | `string` |  |

Returns `int`

### prepare()

`public function prepare(string $query, array<int, mixed> $options = []): PDOStatement`

Narrows `\PDO::prepare()`'s native `PDOStatement|false` return type; see [`StubbedPdo::exec()`](/api/replay/replay/stubbed-pdo/#exec).

Accepted for signature compatibility; unused.

| Parameter | Type | Description |
|---|---|---|
| `$query` | `string` |  |
| `$options` | `array``<``int``, ``mixed``>` | Accepted for signature compatibility; unused. |

Returns `PDOStatement`

### query()

`public function query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement`

Narrows `\PDO::query()`'s native `PDOStatement|false` return type; see [`StubbedPdo::exec()`](/api/replay/replay/stubbed-pdo/#exec).

| Parameter | Type | Description |
|---|---|---|
| `$query` | `string` |  |
| `$fetchMode` | `?``int` |  |
| `$fetchModeArgs` | `mixed` |  |

Returns `PDOStatement`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `beginTransaction()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `commit()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `connect()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `errorCode()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `errorInfo()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `getAttribute()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `getAvailableDrivers()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `inTransaction()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `lastInsertId()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `quote()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `rollBack()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `setAttribute()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
