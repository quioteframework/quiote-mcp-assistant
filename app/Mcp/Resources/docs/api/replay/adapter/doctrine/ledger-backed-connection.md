# LedgerBackedConnection

> A DBAL driver connection that answers entirely from a replaying EffectLedger and never opens anything.

A DBAL driver connection that answers entirely from a replaying [`EffectLedger`](/api/replay/replay/effect-ledger/) and never opens anything.

[`DoctrineRecordingStatement`](/api/replay/adapter/doctrine/doctrine-recording-statement/) and [`DoctrineRecordingConnection`](/api/replay/adapter/doctrine/doctrine-recording-connection/) already keep a replay's queries away from the real database by refusing to execute them, which is enough to isolate a replay from *production*. It is not enough to run one where there is no database at all: DBAL connects lazily on first use, so the connect itself still had to succeed, and a cassette replayed on a laptop with no server reachable failed before any statement ran.

This is what [`DoctrineRecordingDriver::connect()`](/api/replay/adapter/doctrine/doctrine-recording-driver/#connect) returns instead when a replay is already active. It only helps for a connection first used *during* the replay -- a connection the worker built and recycled earlier is already open, and the statement-level refusal is what covers that one. Both seams together mean a replay neither reads, writes, nor requires a database.

Transaction control is accepted and does nothing. A replayed request may well open a transaction around writes that are themselves being served from the ledger, and refusing the `BEGIN` would fail the replay over bookkeeping that has nothing to answer for -- there is no state to commit or roll back when nothing was performed.

## Synopsis

`final class LedgerBackedConnection implements Connection`

|  |  |
|---|---|
| Implements | `Connection` |
| Source | `LedgerBackedConnection.php` |

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
| [`beginTransaction(): void`](#begintransaction) | Initiates a transaction. |
| [`commit(): void`](#commit) | Commits a transaction. |
| [`exec(string $sql): int`](#exec) | Narrows the interface's `int\|string` to `int`: a recorded affected-row count is always an int by the time `DbResult` has read it back, so there is no numeric-string case to represent. |
| [`getNativeConnection(): never`](#getnativeconnection) | No native handle exists, and callers are documented to expect one only for a real driver. |
| [`getServerVersion(): string`](#getserverversion) | A version string, because DBAL asks the connection for one while building its platform -- and that happens before any query, so throwing here would stop a replay dead. |
| [`lastInsertId(): string|int`](#lastinsertid) | Returns the ID of the last inserted row. |
| [`prepare(string $sql): Statement`](#prepare) | Prepares a statement for execution and returns a Statement object. |
| [`query(string $sql): Result`](#query) | Executes an SQL statement, returning a result set as a Statement object. |
| [`quote(string $value): string`](#quote) | Quotes with the ANSI rule, doubling embedded quotes. |
| [`rollBack(): void`](#rollback) | Rolls back the current transaction, as initiated by beginTransaction(). |

### beginTransaction()

`public function beginTransaction(): void`

Initiates a transaction.

| Throws | When |
|---|---|
| `Exception` |  |

### commit()

`public function commit(): void`

Commits a transaction.

| Throws | When |
|---|---|
| `Exception` |  |

### exec()

`public function exec(string $sql): int`

Narrows the interface's `int|string` to `int`: a recorded affected-row count is always an int by the time `DbResult` has read it back, so there is no numeric-string case to represent.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `int`

### getNativeConnection()

`public function getNativeConnection(): never`

No native handle exists, and callers are documented to expect one only for a real driver.

Returns `never`

### getServerVersion()

`public function getServerVersion(): string`

A version string, because DBAL asks the connection for one while building its platform -- and that happens before any query, so throwing here would stop a replay dead.

Reported as the sqlite-shaped placeholder the platform detection accepts rather than a real version: there is no server to ask, and a replay's SQL is answered by fingerprint rather than dialect, so nothing downstream depends on it being accurate.

Returns `string`

### lastInsertId()

`public function lastInsertId(): string|int`

Returns the ID of the last inserted row.

This method returns an integer or a string representing the value of the auto-increment column from the last row inserted into the database, if any, or throws an exception if a value cannot be returned, in particular when:

- the driver does not support identity columns; - the last statement dit not return an identity (caution: see note below).

Note: if the last statement was not an INSERT to an autoincrement column, this method MAY return an ID from a previous statement. DO NOT RELY ON THIS BEHAVIOR which is driver-dependent: always call this method right after executing an INSERT statement.

Returns `string``|``int`

| Throws | When |
|---|---|
| `RuntimeException` | always: nothing was inserted, so there is no id, and inventing one would let a replay proceed on a value the recording never contained. |

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

Executes an SQL statement, returning a result set as a Statement object.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `Result`

| Throws | When |
|---|---|
| `Exception` |  |

### quote()

`public function quote(string $value): string`

Quotes with the ANSI rule, doubling embedded quotes.

No driver is present to ask, and the result never reaches a database -- it can only end up inside SQL that this same class then answers from the ledger by fingerprint. Correct escaping still matters for that fingerprint to match what the recorder saw.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |

Returns `string`

### rollBack()

`public function rollBack(): void`

Rolls back the current transaction, as initiated by beginTransaction().

| Throws | When |
|---|---|
| `Exception` |  |
