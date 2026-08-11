# DatabaseManager

> DatabaseManager allows you to setup your database connectivity before the request is handled.

DatabaseManager allows you to setup your database connectivity before the request is handled.

This eliminates the need for a filter to manage database connections.

## Synopsis

`class DatabaseManager implements ContextComponentInterface`

|  |  |
|---|---|
| Implements | [`ContextComponentInterface`](/api/context-component-interface/) |
| Since | `1.0.0` |
| Source | `Database/DatabaseManager.php` |

## Methods

| Method | Description |
|---|---|
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getDatabase(string $name = null): Database`](#getdatabase) | Retrieve the database connection associated with this Database implementation. |
| [`getDatabaseName(Database $database): ?string`](#getdatabasename) | Retrieve the name of the given database instance. |
| [`getDefaultDatabaseName(): string`](#getdefaultdatabasename) | Returns the name of the default database. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this DatabaseManager. |
| [`recycleConnections(): void`](#recycleconnections) | Probe all managed database connections and null any that are stale. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |
| [`startup(): void`](#startup) | Do any necessary startup work after initialization. |

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — The current Context instance.

### getDatabase()

`public function getDatabase(string $name = null): Database`

Retrieve the database connection associated with this Database implementation.

A database name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A database name. |

Returns [`Database`](/api/database/database/) — A Database instance.

| Throws | When |
|---|---|
| `DatabaseException` | If the requested database name does not exist. |

### getDatabaseName()

`public function getDatabaseName(Database $database): ?string`

Retrieve the name of the given database instance.

The database to fetch the name of.

| Parameter | Type | Description |
|---|---|---|
| `$database` | [`Database`](/api/database/database/) | The database to fetch the name of. |

Returns `?``string` — The name of the database, or null if it was not found.

### getDefaultDatabaseName()

`public function getDefaultDatabaseName(): string`

Returns the name of the default database.

Returns `string` — The name of the default database.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this DatabaseManager.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | An Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An array of initialization parameters. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing this DatabaseManager. |

### recycleConnections()

`public function recycleConnections(): void`

Probe all managed database connections and null any that are stale.

Called from Context::reset() instead of shutdown() so that this manager object stays alive across requests, avoiding the re-initialization cost on every request. Any connection that fails its ping() is nulled inside the database object; getConnection() will then reconnect lazily on the next use — which fixes "connection lost after laptop sleep" without a full restart.

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure.

| Throws | When |
|---|---|
| `DatabaseException` | If an error occurs while shutting down this DatabaseManager. |

### startup()

`public function startup(): void`

Do any necessary startup work after initialization.

This method is not called directly after initialize().
