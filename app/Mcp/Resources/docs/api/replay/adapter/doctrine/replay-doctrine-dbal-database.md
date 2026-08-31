# ReplayDoctrineDbalDatabase

> DoctrineDbalDatabase, with DoctrineRecordingMiddleware installed on the connection it builds.

[`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/), with [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/) installed on the connection it builds.

Registered under the `doctrine_dbal` driver alias by [`ReplayDoctrinePlugin`](/api/replay/adapter/doctrine/replay-doctrine-plugin/) in place of the plain [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) `quioteframework/db-doctrine`'s own `DoctrinePlugin` registers.

## Synopsis

`final class ReplayDoctrineDbalDatabase extends DoctrineDbalDatabase`

|  |  |
|---|---|
| Extends | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) |
| Source | `ReplayDoctrineDbalDatabase.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getConnection()` | [`Database`](/api/database/database/) | Retrieve the database connection associated with this Database implementation. |
| `getDatabaseManager()` | [`Database`](/api/database/database/) | Retrieve the Database Manager instance for this implementation. |
| `getDbalConnection()` | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) | Returns the DBAL connection, connecting on first use. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getName()` | [`Database`](/api/database/database/) | Retrieve the name of this database connection. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getPdo()` | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) | Only available when the configured `driver` is a `pdo_*` one (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`, ...) — DBAL 4 also supports native drivers (`mysqli`, `pgsql`) that never construct a \PDO instance at all. |
| `getQueryBuilder()` | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) | Returns a fresh DBAL query builder bound to this connection. |
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `ping()` | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) | Probes the connection with `SELECT 1`. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Database`](/api/database/database/) | Returns this Database to its pre-initialize() state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `shutdown()` | [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) | Rolls back any open transaction, closes the connection and drops it. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
