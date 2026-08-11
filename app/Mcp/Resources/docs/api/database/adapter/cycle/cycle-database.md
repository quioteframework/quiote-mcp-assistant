# CycleDatabase

> First-class adapter for Cycle ORM v2 — the data-mapper built for long-running (RoadRunner/FrankenPHP) processes, a natural fit for Quiote's worker mode.

First-class adapter for Cycle ORM v2 — the data-mapper built for long-running (RoadRunner/FrankenPHP) processes, a natural fit for Quiote's worker mode.

[`CycleDatabase::getConnection()`](/api/database/adapter/cycle/cycle-database/#getconnection) returns the `ORMInterface`.

Configuration parameters (in `databases.xml`): - `cycle`           : a native Cycle DatabaseConfig array (`default`, `databases`, `connections`). Required — Cycle owns its own connection/driver configuration. - `schema`          : a precompiled Cycle schema array, OR - `schema_provider` : a callable(self): (Schema|array) that returns the schema.

Schema *compilation* from annotated entities (cycle/annotated + cycle/schema-builder) is an app/console concern, not something this adapter does on every boot — supply a compiled/cached schema here.

## Synopsis

`class CycleDatabase extends AbstractOrmDatabase`

|  |  |
|---|---|
| Extends | [`AbstractOrmDatabase`](/api/database/abstract-orm-database/) |
| Source | `CycleDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`getCycleDatabaseManager(): DatabaseProviderInterface`](#getcycledatabasemanager) | Returns Cycle's own database manager, the DBAL layer beneath the ORM. |
| [`getOrm(): ORMInterface`](#getorm) | Returns the Cycle ORM instance, connecting on first use. |
| [`getPdo(): PDO`](#getpdo) | Cycle's driver never exposes its underlying PDO/PDOInterface publicly (`Driver::getPDO()` is protected, and its return type isn't even guaranteed to be `\PDO`). |
| [`getRepository(class-string|non-empty-string $role): RepositoryInterface<object>`](#getrepository) |  |
| [`ping(): bool`](#ping) | Probes the connection with `SELECT 1` through Cycle's database manager. |
| [`reset(): void`](#reset) | Returns this database to its pre-initialize() state, cleaning the ORM heap first. |
| [`shutdown(): mixed`](#shutdown) | Cleans the ORM heap and drops the ORM and DBAL resource. |

### getCycleDatabaseManager()

`public function getCycleDatabaseManager(): DatabaseProviderInterface`

Returns Cycle's own database manager, the DBAL layer beneath the ORM.

Triggers a connect first so the resource is populated. Use this to reach query builders and raw `query()`/`execute()` calls, which is how custom SQL is written for this adapter.

Returns `DatabaseProviderInterface`

| Throws | When |
|---|---|
| `DatabaseException` | If the connection could not be built, or the resource is not a DatabaseProviderInterface. |

### getOrm()

`public function getOrm(): ORMInterface`

Returns the Cycle ORM instance, connecting on first use.

Returns `ORMInterface`

| Throws | When |
|---|---|
| `DatabaseException` | If the connection could not be built, or what was built is not an ORMInterface. |

### getPdo()

`public function getPdo(): PDO`

Cycle's driver never exposes its underlying PDO/PDOInterface publicly (`Driver::getPDO()` is protected, and its return type isn't even guaranteed to be `\PDO`).

Write custom SQL via the Cycle database's own `query()`/`execute()` methods, or `Cycle\Database\Injection\Fragment` inside a query builder, instead of dropping to raw PDO.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

### getRepository()

`public function getRepository(class-string|non-empty-string $role): RepositoryInterface<object>`

| Parameter | Type | Description |
|---|---|---|
| `$role` | `class-string``|``non-empty-string` |  |

Returns `RepositoryInterface``<``object``>`

### ping()

`public function ping(): bool`

Probes the connection with `SELECT 1` through Cycle's database manager.

Returns true when nothing has been connected yet, since lazy connect handles it on first use. If the probe throws, the ORM and the DBAL resource are both cleared so the next getConnection() rebuilds them, and false is returned.

Returns `bool`

### reset()

`public function reset(): void`

Returns this database to its pre-initialize() state, cleaning the ORM heap first.

The heap (identity map) is cleaned up front so hydrated entities are detached even for a caller still holding the ORM; the base teardown then shuts the connection down and clears the parameters, the manager reference and the name -- including the compiled schema, which is rebuilt from the parameters on the next initialize(). Re-initialize() this instance before using it again.

To recycle a worker's connection between requests without discarding the configuration, use [`CycleDatabase::ping()`](/api/database/adapter/cycle/cycle-database/#ping) -- which is what [`DatabaseManager::recycleConnections()`](/api/database/database-manager/#recycleconnections) calls at the request boundary.

| Throws | When |
|---|---|
| `DatabaseException` | If shutting the connection down fails. |

### shutdown()

`public function shutdown(): mixed`

Cleans the ORM heap and drops the ORM and DBAL resource.

A heap that refuses to clean is logged at debug and does not stop the shutdown, since the heap goes away with the connection anyway.

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
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
