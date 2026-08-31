# LedgerBackedPropulsionPdo

> A Propulsion connection that answers from a replaying EffectLedger and never opens a database.

A Propulsion connection that answers from a replaying [`EffectLedger`](/api/replay/replay/effect-ledger/) and never opens a database.

Substituting the connection is the only way to isolate Propulsion, and it turns out to be the better seam anyway. Propulsion's observers cannot intercept: `QueryObserver`'s own contract says "an observer must not throw ... telemetry breaking the query it is measuring is a strictly worse * outcome than losing the telemetry", and `queryStarted()` has no return channel. Giving that interface the power to replace a result would turn every existing observer -- `SlowQueryObserver`, `QueryStatsObserver`, `OpenTelemetryQueryObserver` -- into something that could lie about a query. `Propulsion::setConnection()` replaces what the observers observe instead, which keeps observation and control apart.

Extends `\PDO` as well as implementing `PropulsionPDO`, deliberately and necessarily: the interface alone is not enough, because `Propulsion\Util\BasePeer` guards its sequence/autoincrement paths with `if (!$con instanceof \PDO) throw` (twice), and `Propulsion::getOpenConnections()` filters on the same check. `parent::__construct()` is never called, so nothing is opened -- the shape `GenericPropulsionPDO` has minus the connecting, and the same trick [`StubbedPdo`](/api/replay/replay/stubbed-pdo/) already relies on.

Liveness is answered rather than refused, because `Propulsion::checkOutPooled()` will *replace* a pooled connection that fails its check -- and replacing this one would reopen a real connection mid-replay, quietly undoing the isolation. Reporting zero idle seconds means the check is normally skipped outright; `ping()` returning true covers the case where it is not.

## Synopsis

`class LedgerBackedPropulsionPdo extends PDO implements PropulsionPDO`

|  |  |
|---|---|
| Extends | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |
| Implements | `PropulsionPDO` |
| Source | `LedgerBackedPropulsionPdo.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger): mixed`

Deliberately does not call `parent::__construct()`: an isolated replay opens nothing.

Every method below either answers from the ledger or from local state, so no driver handle is ever needed.

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`beginTransaction(): bool`](#begintransaction) | Accepted rather than refused. |
| [`clearStatementCache(): void`](#clearstatementcache) | Clears any stored prepared statements for this connection. |
| [`commit(): boolean`](#commit) | Overrides PDO::commit() to only commit the transaction if we are in the outermost transaction nesting level. |
| [`errorCode(): ?string`](#errorcode) |  |
| [`errorInfo(): array<int, mixed>`](#errorinfo) | Fetches extended error information for the last operation on this connection: [SQLSTATE code, driver-specific error code, driver-specific error message], the latter two `null` when there was no error. |
| [`exec(string $sql): int|false`](#exec) | Execute an SQL statement and return the number of affected rows. |
| [`forceRollBack(): boolean`](#forcerollback) | Rollback the whole transaction, even if this is a nested rollback and reset the nested transaction count to 0. |
| [`getAttribute(integer $attribute): mixed`](#getattribute) | Gets a connection attribute. |
| [`getConfiguration(): PropulsionConfiguration`](#getconfiguration) | An empty configuration when none was injected, because the interface promises a `PropulsionConfiguration` rather than a nullable one, and a caller that reads a setting off it should get the default rather than a null dereference. |
| [`getDebugSnapshot(): array<string, float|int>`](#getdebugsnapshot) | The same timing and memory keys a real connection reports, because that is what the interface promises and what a caller subtracts one snapshot from another to get. |
| [`getIdleSeconds(): float`](#getidleseconds) | Zero, so `Propulsion::checkOutPooled()` skips the liveness check entirely. |
| [`getLastExecutedQuery(): string`](#getlastexecutedquery) | Get the SQL code for the latest query executed by Propulsion |
| [`getLogger(): LoggerInterface|null`](#getlogger) | Gets the per-connection logger override, if any. |
| [`getNestedTransactionCount(): integer`](#getnestedtransactioncount) | Gets the current transaction depth. |
| [`getQueryCount(): integer`](#getquerycount) | Returns the number of queries this instance has performed on the database connection. |
| [`handleDroppedConnection(PDOException $e, string $methodName = ''): void`](#handledroppedconnection) | A dropped connection is not a thing that can happen here, and the real implementation's job -- evicting the pooled connection so a replacement is opened -- is exactly what must not happen mid-replay. |
| [`incrementQueryCount(): int`](#incrementquerycount) | Increments the number of queries performed by this instance. |
| [`isCommitable(): boolean`](#iscommitable) | Check whether the connection contains a transaction that can be committed. |
| [`isInTransaction(): boolean`](#isintransaction) | Is this PDO connection currently in-transaction? |
| [`lastInsertId(?string $name = null): string|false`](#lastinsertid) | The generated id an auto-increment insert would have produced. |
| [`log(string $msg, string $level = null, string $methodName = null, array<string, float|int>|null $debugSnapshot = null): void`](#log) | Logs the method call or SQL using the Propulsion::log() method or a registered logger class. |
| [`ping(): bool`](#ping) | True, so a liveness check that does run cannot cause a real connection to replace this one. |
| [`prepare(string $sql, array<int, mixed> $driver_options = []): PDOStatement|false`](#prepare) | Prepares a statement for execution and returns a statement object. |
| [`query(string $query, ?int $fetchMode = null, mixed ...$args): PDOStatement|false`](#query) | Executes an SQL statement, returning a result set as a PDOStatement object. |
| [`quote(string $string, int $type = PDO::PARAM_STR): string|false`](#quote) | ANSI quoting, doubling embedded quotes. |
| [`resetDebugCounters(): void`](#resetdebugcounters) | Reset the two counters above to their initial state. |
| [`rollBack(): boolean`](#rollback) | Overrides PDO::rollBack() to only rollback the transaction if we are in the outermost transaction nesting level |
| [`setAttribute(integer $attribute, mixed $value): bool`](#setattribute) | Sets a connection attribute. |
| [`setConfiguration(PropulsionConfiguration $configuration): void`](#setconfiguration) | Inject the runtime configuration |
| [`setLastExecutedQuery(string $query): void`](#setlastexecutedquery) | Set the SQL code for the latest query executed by Propulsion |
| [`setLogLevel(string $level): void`](#setloglevel) | Sets the logging level to use for logging method calls and SQL statements. |
| [`setLogger(?LoggerInterface $logger): void`](#setlogger) | Sets a PSR-3 logger to use for this connection, overriding Propulsion::log(). |
| [`touchActivity(): void`](#touchactivity) | Record that this connection just ran a statement, resetting its idle timer. |
| [`useDebug(boolean $value = true): void`](#usedebug) | Enable or disable the query debug features |

### beginTransaction()

`public function beginTransaction(): bool`

Accepted rather than refused.

A replayed request may well wrap writes that are themselves being served from the ledger in a transaction, and failing the `BEGIN` would break the replay over bookkeeping with nothing to answer for -- there is no state to commit or roll back when nothing was performed. The nesting count is still tracked, because Propulsion reads it.

Returns `bool`

### clearStatementCache()

`public function clearStatementCache(): void`

Clears any stored prepared statements for this connection.

### commit()

`public function commit(): boolean`

Overrides PDO::commit() to only commit the transaction if we are in the outermost transaction nesting level.

Returns `boolean`

### errorCode()

`public function errorCode(): ?string`

Returns `?``string`

### errorInfo()

`public function errorInfo(): array<int, mixed>`

Fetches extended error information for the last operation on this connection: [SQLSTATE code, driver-specific error code, driver-specific error message], the latter two `null` when there was no error.

Returns `array``<``int``, ``mixed``>`

### exec()

`public function exec(string $sql): int|false`

Execute an SQL statement and return the number of affected rows.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` |  |

Returns `int``|``false`

### forceRollBack()

`public function forceRollBack(): boolean`

Rollback the whole transaction, even if this is a nested rollback and reset the nested transaction count to 0.

Returns `boolean` — Whether operation was successful.

### getAttribute()

`public function getAttribute(integer $attribute): mixed`

Gets a connection attribute.

The attribute to get (e.g. PropulsionPDO::PROPEL_ATTR_CACHE_PREPARES).

| Parameter | Type | Description |
|---|---|---|
| `$attribute` | `integer` | The attribute to get (e.g. PropulsionPDO::PROPEL_ATTR_CACHE_PREPARES). |

Returns `mixed`

### getConfiguration()

`public function getConfiguration(): PropulsionConfiguration`

An empty configuration when none was injected, because the interface promises a `PropulsionConfiguration` rather than a nullable one, and a caller that reads a setting off it should get the default rather than a null dereference.

Returns `PropulsionConfiguration`

### getDebugSnapshot()

`public function getDebugSnapshot(): array<string, float|int>`

The same timing and memory keys a real connection reports, because that is what the interface promises and what a caller subtracts one snapshot from another to get.

Unlike the real implementation this does not throw when debugging is off: a stub has no configuration to consult, and failing here would break a replay over telemetry.

Returns `array``<``string``, ``float``|``int``>`

### getIdleSeconds()

`public function getIdleSeconds(): float`

Zero, so `Propulsion::checkOutPooled()` skips the liveness check entirely.

Returns `float`

### getLastExecutedQuery()

`public function getLastExecutedQuery(): string`

Get the SQL code for the latest query executed by Propulsion

Returns `string` — Executable SQL code

### getLogger()

`public function getLogger(): LoggerInterface|null`

Gets the per-connection logger override, if any.

Returns [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/)`|``null`

### getNestedTransactionCount()

`public function getNestedTransactionCount(): integer`

Gets the current transaction depth.

Returns `integer`

### getQueryCount()

`public function getQueryCount(): integer`

Returns the number of queries this instance has performed on the database connection.

Returns `integer`

### handleDroppedConnection()

`public function handleDroppedConnection(PDOException $e, string $methodName = ''): void`

A dropped connection is not a thing that can happen here, and the real implementation's job -- evicting the pooled connection so a replacement is opened -- is exactly what must not happen mid-replay.

| Parameter | Type | Description |
|---|---|---|
| `$e` | `PDOException` |  |
| `$methodName` | `string` |  |

### incrementQueryCount()

`public function incrementQueryCount(): int`

Increments the number of queries performed by this instance.

Returns `int`

### isCommitable()

`public function isCommitable(): boolean`

Check whether the connection contains a transaction that can be committed.

To be used in an evironment where Propulsionexceptions are caught.

Returns `boolean` — True if the connection is in a committable transaction

### isInTransaction()

`public function isInTransaction(): boolean`

Is this PDO connection currently in-transaction?

This is equivalent to asking whether the current nested transaction count is greater than 0.

Returns `boolean`

### lastInsertId()

`public function lastInsertId(?string $name = null): string|false`

The generated id an auto-increment insert would have produced.

Nothing records generated ids, so there is nothing to replay here -- but unlike Doctrine, where `lastInsertId()` is only called when the application asks, Propulsion's `BasePeer::doInsert()` calls it for *every* auto-increment insert whether the caller wants the id or not. Throwing would therefore make any cassette containing an insert unreplayable, which is too blunt.

So it asks the ledger first -- if a future recorder does capture generated ids, this already reads them -- and the ask books a miss when nothing answers. That miss lands in the drift report as `REPLAY_EFFECT_MISS`, so a replay whose code went on to *use* the id is reported as diverging rather than quietly trusted. The placeholder returned meanwhile is deliberately not a plausible id: a replay that treats it as real should look wrong immediately.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `?``string` |  |

Returns `string``|``false`

### log()

`public function log(string $msg, string $level = null, string $methodName = null, array<string, float|int>|null $debugSnapshot = null): void`

Logs the method call or SQL using the Propulsion::log() method or a registered logger class.

Previous return value from self::getDebugSnapshot().

| Parameter | Type | Description |
|---|---|---|
| `$msg` | `string` | Message to log. |
| `$level` | `string` | Log level to use; will use self::setLogLevel() specified level by default. |
| `$methodName` | `string` | Name of the method whose execution is being logged. |
| `$debugSnapshot` | `array``<``string``, ``float``|``int``>``|``null` | Previous return value from self::getDebugSnapshot(). |

### ping()

`public function ping(): bool`

True, so a liveness check that does run cannot cause a real connection to replace this one.

Returns `bool`

### prepare()

`public function prepare(string $sql, array<int, mixed> $driver_options = []): PDOStatement|false`

Prepares a statement for execution and returns a statement object.

One $array or more key => value pairs to set attribute values
                                     for the PDOStatement object that this method returns.

| Parameter | Type | Description |
|---|---|---|
| `$sql` | `string` | This must be a valid SQL statement for the target database server. |
| `$driver_options` | `array``<``int``, ``mixed``>` | One $array or more key => value pairs to set attribute values for the PDOStatement object that this method returns. |

Returns `PDOStatement``|``false`

### query()

`public function query(string $query, ?int $fetchMode = null, mixed ...$args): PDOStatement|false`

Executes an SQL statement, returning a result set as a PDOStatement object.

| Parameter | Type | Description |
|---|---|---|
| `$query` | `string` |  |
| `$fetchMode` | `?``int` |  |
| `$args` | `mixed` |  |

Returns `PDOStatement``|``false`

### quote()

`public function quote(string $string, int $type = PDO::PARAM_STR): string|false`

ANSI quoting, doubling embedded quotes.

No driver is present to ask, and the result never reaches a database -- it can only end up inside SQL this same object then answers from the ledger by fingerprint. Correct escaping still matters for that fingerprint to match what the recorder saw.

| Parameter | Type | Description |
|---|---|---|
| `$string` | `string` |  |
| `$type` | `int` |  |

Returns `string``|``false`

### resetDebugCounters()

`public function resetDebugCounters(): void`

Reset the two counters above to their initial state.

Called at a worker request boundary (`Session::reset()`). Connections outlive requests in a persistent worker, so without this getQueryCount() reports a process total rather than a per-request one -- which is what it means under PHP-FPM, where the connection died with the request -- and getLastExecutedQuery() can hand back a statement issued while serving an unrelated earlier request.

### rollBack()

`public function rollBack(): boolean`

Overrides PDO::rollBack() to only rollback the transaction if we are in the outermost transaction nesting level

Returns `boolean` — Whether operation was successful.

### setAttribute()

`public function setAttribute(integer $attribute, mixed $value): bool`

Sets a connection attribute.

The attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$attribute` | `integer` | The attribute to set (e.g. PropulsionPDO::PROPEL_ATTR_CACHE_PREPARES). |
| `$value` | `mixed` | The attribute value. |

Returns `bool`

### setConfiguration()

`public function setConfiguration(PropulsionConfiguration $configuration): void`

Inject the runtime configuration

| Parameter | Type | Description |
|---|---|---|
| `$configuration` | `PropulsionConfiguration` |  |

### setLastExecutedQuery()

`public function setLastExecutedQuery(string $query): void`

Set the SQL code for the latest query executed by Propulsion

Executable SQL code

| Parameter | Type | Description |
|---|---|---|
| `$query` | `string` | Executable SQL code |

### setLogLevel()

`public function setLogLevel(string $level): void`

Sets the logging level to use for logging method calls and SQL statements.

One of the Propulsion::LOG_* / Psr\Log\LogLevel::* constants.

| Parameter | Type | Description |
|---|---|---|
| `$level` | `string` | One of the Propulsion::LOG_* / Psr\Log\LogLevel::* constants. |

### setLogger()

`public function setLogger(?LoggerInterface $logger): void`

Sets a PSR-3 logger to use for this connection, overriding Propulsion::log().

| Parameter | Type | Description |
|---|---|---|
| `$logger` | `?`[`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) |  |

### touchActivity()

`public function touchActivity(): void`

Record that this connection just ran a statement, resetting its idle timer.

Part of the interface for the same reason as the method above: `PropulsionStatement::execute()` is where most statements actually run, and it is a separate object from the connection.

### useDebug()

`public function useDebug(boolean $value = true): void`

Enable or disable the query debug features

True to enable debug (default), false to disable it

| Parameter | Type | Description |
|---|---|---|
| `$value` | `boolean` | True to enable debug (default), false to disable it |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `connect()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `getAvailableDrivers()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `inTransaction()` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
