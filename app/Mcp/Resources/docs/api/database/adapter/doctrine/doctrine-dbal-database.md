# DoctrineDbalDatabase

> Tier-2 adapter: a Doctrine DBAL connection (connection abstraction + query builder) without the ORM/entity layer.

Tier-2 adapter: a Doctrine DBAL connection (connection abstraction + query builder) without the ORM/entity layer.

[`DoctrineDbalDatabase::getConnection()`](/api/database/adapter/doctrine/doctrine-dbal-database/#getconnection) returns the `Connection`.

Parameters: either an inline `connection` array, a DSN `url`, or flat `driver`/`host`/`dbname`/`user`/`password` params (see [`DoctrineDbalParams`](/api/database/adapter/doctrine/doctrine-dbal-params/)).

## Synopsis

`class DoctrineDbalDatabase extends AbstractOrmDatabase`

|  |  |
|---|---|
| Extends | [`AbstractOrmDatabase`](/api/database/abstract-orm-database/) |
| Uses | [`DoctrineDbalParams`](/api/database/adapter/doctrine/doctrine-dbal-params/) |
| Source | `DoctrineDbalDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`getDbalConnection(): Connection`](#getdbalconnection) | Returns the DBAL connection, connecting on first use. |
| [`getPdo(): PDO`](#getpdo) | Only available when the configured `driver` is a `pdo_*` one (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`, ...) — DBAL 4 also supports native drivers (`mysqli`, `pgsql`) that never construct a \PDO instance at all. |
| [`getQueryBuilder(): QueryBuilder`](#getquerybuilder) | Returns a fresh DBAL query builder bound to this connection. |
| [`ping(): bool`](#ping) | Probes the connection with `SELECT 1`. |
| [`shutdown(): mixed`](#shutdown) | Rolls back any open transaction, closes the connection and drops it. |

### getDbalConnection()

`public function getDbalConnection(): Connection`

Returns the DBAL connection, connecting on first use.

Returns `Connection`

| Throws | When |
|---|---|
| `DatabaseException` | If the connection could not be created, or what was created is not a DBAL Connection. |

### getPdo()

`public function getPdo(): PDO`

Only available when the configured `driver` is a `pdo_*` one (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`, ...) — DBAL 4 also supports native drivers (`mysqli`, `pgsql`) that never construct a \PDO instance at all.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

### getQueryBuilder()

`public function getQueryBuilder(): QueryBuilder`

Returns a fresh DBAL query builder bound to this connection.

A new builder is created on every call, so callers never share state.

Returns `QueryBuilder`

| Throws | When |
|---|---|
| `DatabaseException` | If the connection could not be created. |

### ping()

`public function ping(): bool`

Probes the connection with `SELECT 1`.

Returns true when nothing has been connected yet, since lazy connect handles it on first use. If the query throws, the connection and resource are cleared so the next getConnection() reconnects, and false is returned.

Returns `bool`

### shutdown()

`public function shutdown(): mixed`

Rolls back any open transaction, closes the connection and drops it.

A failure to roll back or close is logged at warning and does not stop the shutdown; the connection and resource are cleared either way.

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getConnection()` | [`Database`](/api/database/database/) | Retrieve the database connection associated with this Database implementation. |
| `getDatabaseManager()` | [`Database`](/api/database/database/) | Retrieve the Database Manager instance for this implementation. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getName()` | [`Database`](/api/database/database/) | Retrieve the name of this database connection. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Database`](/api/database/database/) | Returns this Database to its pre-initialize() state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
