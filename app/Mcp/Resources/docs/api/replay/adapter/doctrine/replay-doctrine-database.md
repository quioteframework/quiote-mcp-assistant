# ReplayDoctrineDatabase

> DoctrineDatabase, with DoctrineRecordingMiddleware installed on every DBAL connection it builds.

[`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/), with [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/) installed on every DBAL connection it builds.

Registered under the `doctrine` driver alias by [`ReplayDoctrinePlugin`](/api/replay/adapter/doctrine/replay-doctrine-plugin/) in place of the plain [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) `quioteframework/db-doctrine`'s own `DoctrinePlugin` registers.

`buildOrmConfiguration()` is the seam [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) already exposes for exactly this: DBAL only accepts a `Configuration`'s middlewares at `DriverManager::getConnection($params, $config)` time (inside the inherited `connect()`), so they cannot be added after the fact once a `Doctrine\ORM\EntityManager`/`Doctrine\DBAL\Connection` already exists.

## Synopsis

`final class ReplayDoctrineDatabase extends DoctrineDatabase`

|  |  |
|---|---|
| Extends | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) |
| Source | `ReplayDoctrineDatabase.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getConnection()` | [`Database`](/api/database/database/) | Retrieve the database connection associated with this Database implementation. |
| `getDatabaseManager()` | [`Database`](/api/database/database/) | Retrieve the Database Manager instance for this implementation. |
| `getDbalConnection()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Returns the DBAL connection the entity manager runs on. |
| `getEntityManager()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Returns the Doctrine entity manager, connecting on first use. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getName()` | [`Database`](/api/database/database/) | Retrieve the name of this database connection. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getPdo()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Only available when the configured `driver` is a `pdo_*` one (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`, ...) — DBAL 4 also supports native drivers (`mysqli`, `pgsql`) that never construct a \PDO instance at all. |
| `getRepository()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) |  |
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `ping()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Probes the connection with `SELECT 1` over DBAL. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Returns this database to its pre-initialize() state, detaching every managed entity first. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `shutdown()` | [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Rolls back any open transaction, closes the DBAL connection and drops the entity manager. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
