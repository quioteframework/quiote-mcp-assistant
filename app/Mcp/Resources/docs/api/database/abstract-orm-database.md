# AbstractOrmDatabase

> Shared base for ORM adapters whose AbstractOrmDatabase::getConnection() returns an ORM manager (Eloquent Capsule, Doctrine EntityManager, Cycle ORM) rather than a raw PDO handle.

Shared base for ORM adapters whose [`AbstractOrmDatabase::getConnection()`](/api/database/abstract-orm-database/#getconnection) returns an ORM manager (Eloquent Capsule, Doctrine EntityManager, Cycle ORM) rather than a raw PDO handle.

It pulls up the two things every such adapter needs:

1. Underlying-connection resolution in two modes: - *layer mode*  — the `connection` parameter is the name (string) of another configured [`Database`](/api/database/database/); the ORM reuses that connection (credentials live in one place, PDO-level ping/reconnect is reused). - *standalone mode* — the ORM builds its own connection from the `connection` array or from flat dsn/username/password parameters. 2. A worker-safe lifecycle skeleton (`shutdown()` nulls the handle; concrete adapters override `ping()`/`reset()` to clear per-request ORM state).

Concrete adapters remain thin: they only translate resolved connection info into their ORM's bootstrap and expose typed accessors.

## Synopsis

`abstract class AbstractOrmDatabase extends Database`

|  |  |
|---|---|
| Extends | [`Database`](/api/database/database/) |
| Source | `Database/AbstractOrmDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`requireLibrary(string $probeClass, string $composerPackage): void`](#requirelibrary) | Assert that an ORM library is installed, with an actionable error message naming the composer package to install. |
| [`resolveUnderlyingConnection(): mixed`](#resolveunderlyingconnection) | Resolve the `connection` parameter to an underlying object: - string → the name of another configured Database; returns its getConnection() (typically a PDO or a DBAL Connection). |
| [`resolveUnderlyingPdo(): PDO`](#resolveunderlyingpdo) | Like [`AbstractOrmDatabase::resolveUnderlyingConnection()`](/api/database/abstract-orm-database/#resolveunderlyingconnection) but requires the referenced connection to be a PDO instance (for ORMs that layer on a raw PDO). |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |

### requireLibrary()

`protected function requireLibrary(string $probeClass, string $composerPackage): void`

Assert that an ORM library is installed, with an actionable error message naming the composer package to install.

| Parameter | Type | Description |
|---|---|---|
| `$probeClass` | `string` |  |
| `$composerPackage` | `string` |  |

### resolveUnderlyingConnection()

`protected function resolveUnderlyingConnection(): mixed`

Resolve the `connection` parameter to an underlying object: - string → the name of another configured Database; returns its getConnection() (typically a PDO or a DBAL Connection).

- array  → returned as-is (inline connection details for the ORM). - null   → null (adapter should build its own from flat params).

Returns `mixed`

### resolveUnderlyingPdo()

`protected function resolveUnderlyingPdo(): PDO`

Like [`AbstractOrmDatabase::resolveUnderlyingConnection()`](/api/database/abstract-orm-database/#resolveunderlyingconnection) but requires the referenced connection to be a PDO instance (for ORMs that layer on a raw PDO).

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure.

| Throws | When |
|---|---|
| `DatabaseException` | If an error occurs while shutting down this database. |

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
| `getPdo()` | [`Database`](/api/database/database/) | Retrieve the raw PDO connection underlying this database, for callers that need to hand-write SQL (custom queries, driver-specific optimizations) rather than go through an ORM's query builder. |
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `ping()` | [`Database`](/api/database/database/) | Probe whether the connection is still alive. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Database`](/api/database/database/) | Returns this Database to its pre-initialize() state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
