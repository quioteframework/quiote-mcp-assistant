# Database

> Database is a base abstraction class that allows you to setup any type of database connection via a configuration file.

Database is a base abstraction class that allows you to setup any type of database connection via a configuration file.

## Synopsis

`abstract class Database extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `Database/Database.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$connection` | `mixed` | _protected._ |
| `$databaseManager` | `mixed` | _protected._ |
| `$lastUsedAt` | `?``float` | _protected._ Timestamp (microtime(true)) of the last time this connection was confirmed alive -- either by an actual getConnection() use or by a ping() round trip. |
| `$resource` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`connect(): void`](#connect) | Connect to the database. |
| [`getConnection(): mixed`](#getconnection) | Retrieve the database connection associated with this Database implementation. |
| [`getDatabaseManager(): DatabaseManager`](#getdatabasemanager) | Retrieve the Database Manager instance for this implementation. |
| [`getName(): string|null`](#getname) | Retrieve the name of this database connection. |
| [`getPdo(): PDO`](#getpdo) | Retrieve the raw PDO connection underlying this database, for callers that need to hand-write SQL (custom queries, driver-specific optimizations) rather than go through an ORM's query builder. |
| [`getResource(): mixed`](#getresource) | Retrieve a raw database resource associated with this Database implementation. |
| [`initialize(DatabaseManager $databaseManager, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Database. |
| [`ping(): bool`](#ping) | Probe whether the connection is still alive. |
| [`reset(): void`](#reset) | Returns this Database to its pre-initialize() state. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |
| [`startup(): void`](#startup) | Do any necessary startup work after initialization. |
| [`wasRecentlyVerified(): bool`](#wasrecentlyverified) | Whether this connection was used or successfully pinged within PING_IDLE_THRESHOLD_SECONDS. |

### connect()

`abstract protected function connect(): void`

Connect to the database.

| Throws | When |
|---|---|
| `DatabaseException` | If a connection could not be created. |

### getConnection()

`public function getConnection(): mixed`

Retrieve the database connection associated with this Database implementation.

When this is executed on a Database implementation that isn't an abstraction layer, a copy of the resource will be returned.

Returns `mixed` — A database connection.

| Throws | When |
|---|---|
| `DatabaseException` | If a connection could not be retrieved. |

### getDatabaseManager()

`public function getDatabaseManager(): DatabaseManager`

Retrieve the Database Manager instance for this implementation.

Returns [`DatabaseManager`](/api/database/database-manager/) — A Database Manager instance.

| Throws | When |
|---|---|
| `InitializationException` | If this Database has not been initialized yet. |

### getName()

`public function getName(): string|null`

Retrieve the name of this database connection.

Returns `string``|``null` — The name of the database, or null if this Database has not been initialized yet.

### getPdo()

`public function getPdo(): PDO`

Retrieve the raw PDO connection underlying this database, for callers that need to hand-write SQL (custom queries, driver-specific optimizations) rather than go through an ORM's query builder.

Adapters that are PDO-backed override this; adapters that cannot expose a PDO instance (e.g. a driver that never wraps PDO) should throw [`DatabaseException`](/api/exception/database-exception/) explaining what to use instead.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

| Throws | When |
|---|---|
| `DatabaseException` | If this adapter does not expose a raw PDO connection. |

### getResource()

`public function getResource(): mixed`

Retrieve a raw database resource associated with this Database implementation.

Returns `mixed` — A database resource.

| Throws | When |
|---|---|
| `DatabaseException` | If no resource could be retrieved |

### initialize()

`public function initialize(DatabaseManager $databaseManager, array<string, mixed> $parameters = []): void`

Initialize this Database.

An assoc array of initialization params.

| Parameter | Type | Description |
|---|---|---|
| `$databaseManager` | [`DatabaseManager`](/api/database/database-manager/) | The database manager of this instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An assoc array of initialization params. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing this Database. |

### ping()

`public function ping(): bool`

Probe whether the connection is still alive.

Returns true if healthy or no connection has been established yet (lazy connect will handle it on first getConnection()). Returns false if the connection appears dead, signalling recycleConnections() to null it so getConnection() reconnects lazily on the next use. Subclasses SHOULD override with a driver-specific probe (e.g. SELECT 1).

Returns `bool`

### reset()

`public function reset(): void`

Returns this Database to its pre-initialize() state.

Shuts the connection down if one was established, then clears the connection, the raw resource, all parameters, the manager reference and the name. After this the instance must be initialize()d again before it can be used; getDatabaseManager() will throw until then.

| Throws | When |
|---|---|
| `DatabaseException` | If shutting the connection down fails. |

### shutdown()

`abstract public function shutdown(): void`

Execute the shutdown procedure.

| Throws | When |
|---|---|
| `DatabaseException` | If an error occurs while shutting down this database. |

### startup()

`public function startup(): void`

Do any necessary startup work after initialization.

This method is not called directly after initialize(). It is called during the startup() of the database manager.

### wasRecentlyVerified()

`protected function wasRecentlyVerified(): bool`

Whether this connection was used or successfully pinged within PING_IDLE_THRESHOLD_SECONDS.

Subclasses' ping() overrides should check this before paying an actual round trip.

Returns `bool`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
