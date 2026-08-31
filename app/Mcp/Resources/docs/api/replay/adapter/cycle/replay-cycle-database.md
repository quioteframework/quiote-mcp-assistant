# ReplayCycleDatabase

> CycleDatabase, with CycleRecordingLogger installed on the `Cycle\\Database\\DatabaseManager` it builds.

[`CycleDatabase`](/api/database/adapter/cycle/cycle-database/), with [`CycleRecordingLogger`](/api/replay/adapter/cycle/cycle-recording-logger/) installed on the `Cycle\Database\DatabaseManager` it builds.

Registered under the `cycle` driver alias by [`ReplayCyclePlugin`](/api/replay/adapter/cycle/replay-cycle-plugin/) in place of the plain [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) `quioteframework/db-cycle`'s own `CyclePlugin` registers.

Reads `$this->resource` directly rather than `getCycleDatabaseManager()` (which only promises `Cycle\Database\DatabaseProviderInterface`, with no `setLogger()`): the concrete `Cycle\Database\DatabaseManager` `connect()` builds also implements PSR-3's `LoggerAwareInterface`, which is the contract this checks against instead of the concrete class.

Calling `setLogger()` after `parent::connect()` (rather than duplicating that method's body) is safe: `Cycle\Database\DatabaseManager::setLogger()` re-applies the logger to every driver already initialized as well as every one created afterward, and `connect()` itself never resolves a driver -- only `new Cycle\Database\DatabaseManager(...)`/`new Cycle\ORM\ORM(...)`, neither of which touches an actual connection.

`setLogger()` is a whole-value assignment, so the recording logger [`CycleRecordingLogger::wrapping()`](/api/replay/adapter/cycle/cycle-recording-logger/#wrapping) composes with whatever the application had installed rather than replacing it. Installing this package must not silently end an application's own Cycle query logging -- the Eloquent adapter next door already gets this right by adding a listener alongside an existing dispatcher, and the two should not disagree.

## Synopsis

`final class ReplayCycleDatabase extends CycleDatabase`

|  |  |
|---|---|
| Extends | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) |
| Source | `ReplayCycleDatabase.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getConnection()` | [`Database`](/api/database/database/) | Retrieve the database connection associated with this Database implementation. |
| `getCycleDatabaseManager()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) | Returns Cycle's own database manager, the DBAL layer beneath the ORM. |
| `getDatabaseManager()` | [`Database`](/api/database/database/) | Retrieve the Database Manager instance for this implementation. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getName()` | [`Database`](/api/database/database/) | Retrieve the name of this database connection. |
| `getOrm()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) | Returns the Cycle ORM instance, connecting on first use. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getPdo()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) | Cycle's driver never exposes its underlying PDO/PDOInterface publicly (`Driver::getPDO()` is protected, and its return type isn't even guaranteed to be `\PDO`). |
| `getRepository()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) |  |
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `ping()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) | Probes the connection with `SELECT 1` through Cycle's database manager. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) | Returns this database to its pre-initialize() state, cleaning the ORM heap first. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `shutdown()` | [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/) | Cleans the ORM heap and drops the ORM and DBAL resource. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
