# ReplayEloquentDatabase

> EloquentDatabase, with EloquentQueryRecorder attached to the Illuminate connection it builds.

[`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/), with [`EloquentQueryRecorder`](/api/replay/adapter/eloquent/eloquent-query-recorder/) attached to the Illuminate connection it builds.

Registered under the `eloquent` driver alias by [`ReplayEloquentPlugin`](/api/replay/adapter/eloquent/replay-eloquent-plugin/) in place of the plain [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) `quioteframework/db-eloquent`'s own `EloquentPlugin` registers.

Attaching after `parent::connect()` (rather than overriding the whole method) is safe here, unlike Doctrine's DBAL middleware: `attach()` only calls `Connection::listen()`, which has nothing to do before the connection object already exists.

## Synopsis

`final class ReplayEloquentDatabase extends EloquentDatabase`

|  |  |
|---|---|
| Extends | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) |
| Source | `ReplayEloquentDatabase.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getCapsule()` | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) | Returns the Capsule manager, connecting on first use. |
| `getConnection()` | [`Database`](/api/database/database/) | Retrieve the database connection associated with this Database implementation. |
| `getDatabaseManager()` | [`Database`](/api/database/database/) | Retrieve the Database Manager instance for this implementation. |
| `getEloquentConnection()` | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) | The underlying Illuminate connection (query builder, PDO, transactions). |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getName()` | [`Database`](/api/database/database/) | Retrieve the name of this database connection. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getPdo()` | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) | Returns the PDO handle Eloquent is using for the configured connection. |
| `getResource()` | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) | Returns the Illuminate connection, routed through [`ReplayEloquentDatabase::getCapsule()`](/api/replay/adapter/eloquent/replay-eloquent-database/#getcapsule) so a layer-mode rebind happens before the caller sees it -- the base class's getResource() would otherwise hand back `$this->resource` directly and skip that check. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `ping()` | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) | Probes the connection with `SELECT 1` on the raw PDO handle. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Database`](/api/database/database/) | Returns this Database to its pre-initialize() state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `shutdown()` | [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/) | Rolls back any open transaction, purges the connection from Eloquent's database manager and drops the capsule. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
