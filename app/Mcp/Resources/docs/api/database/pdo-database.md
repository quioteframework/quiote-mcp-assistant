# PdoDatabase

> PdoDatabase provides connectivity for the PDO database API layer.

PdoDatabase provides connectivity for the PDO database API layer.

## Synopsis

`class PdoDatabase extends Database`

|  |  |
|---|---|
| Extends | [`Database`](/api/database/database/) |
| Since | `1.0.0` |
| Source | `Database/PdoDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`getPdo(): PDO`](#getpdo) | Retrieve the underlying PDO connection. |
| [`initialize(DatabaseManager $databaseManager, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Database. |
| [`ping(): bool`](#ping) | Probe whether the PDO connection is still alive by running a lightweight query. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |

### getPdo()

`public function getPdo(): PDO`

Retrieve the underlying PDO connection.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

### initialize()

`public function initialize(DatabaseManager $databaseManager, array<string, mixed> $parameters = []): void`

Initialize this Database.

An assoc array of initialization params.

| Parameter | Type | Description |
|---|---|---|
| `$databaseManager` | [`DatabaseManager`](/api/database/database-manager/) | The database manager of this instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An assoc array of initialization params. |

### ping()

`public function ping(): bool`

Probe whether the PDO connection is still alive by running a lightweight query.

On failure (e.g. the MySQL server went away because the laptop slept while Docker was running) the stale connection is nulled so that the next call to getConnection() will reconnect transparently.

Returns `bool`

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
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Database`](/api/database/database/) | Returns this Database to its pre-initialize() state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
