# EloquentDatabase

> First-class adapter for Eloquent (illuminate/database) used standalone via the Capsule Manager.

First-class adapter for Eloquent (illuminate/database) used standalone via the Capsule Manager.

[`EloquentDatabase::getConnection()`](/api/database/adapter/eloquent/eloquent-database/#getconnection) returns the `Manager`; models (`extends Illuminate\Database\Eloquent\Model`) work once `global`/`boot_eloquent` is enabled.

Configuration parameters (in `databases.xml`): - `connection`      : inline Eloquent config array, OR the name of another configured database to borrow a live PDO from (layer mode — still requires a `driver` so Eloquent knows the SQL grammar). Omit for standalone mode using flat params. - `driver`          : mysql | pgsql | sqlite | sqlsrv (required unless an inline `connection` array supplies it) - `host`,`port`,`database`,`username`,`password`,`charset`,`collation`,`prefix` - `connection_name` : Capsule connection name (default "default") - `global`          : call setAsGlobal() (default false) - `boot_eloquent`   : call bootEloquent() (default = value of `global`)

## Synopsis

`class EloquentDatabase extends AbstractOrmDatabase`

|  |  |
|---|---|
| Extends | [`AbstractOrmDatabase`](/api/database/abstract-orm-database/) |
| Source | `EloquentDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`getCapsule(): Manager`](#getcapsule) | Returns the Capsule manager, connecting on first use. |
| [`getEloquentConnection(): Connection`](#geteloquentconnection) | The underlying Illuminate connection (query builder, PDO, transactions). |
| [`getPdo(): PDO`](#getpdo) | Returns the PDO handle Eloquent is using for the configured connection. |
| [`getResource(): mixed`](#getresource) | Returns the Illuminate connection, routed through [`EloquentDatabase::getCapsule()`](/api/database/adapter/eloquent/eloquent-database/#getcapsule) so a layer-mode rebind happens before the caller sees it -- the base class's getResource() would otherwise hand back `$this->resource` directly and skip that check. |
| [`ping(): bool`](#ping) | Probes the connection with `SELECT 1` on the raw PDO handle. |
| [`shutdown(): mixed`](#shutdown) | Rolls back any open transaction, purges the connection from Eloquent's database manager and drops the capsule. |

### getCapsule()

`public function getCapsule(): Manager`

Returns the Capsule manager, connecting on first use.

In layer mode, re-checks the borrowed database's current PDO on every call and rebinds it into the Illuminate connection if it has changed. The source can rotate its own live handle independently of this adapter -- a PropulsionDatabase resolving fresh from Propulsion's pool on every call, or a PdoDatabase reconnecting after ping() found its old handle dead -- and a rotated-away handle often keeps answering queries just fine on its own, so nothing here would notice the divergence without asking the source again.

Returns `Manager`

| Throws | When |
|---|---|
| `DatabaseException` | If the capsule could not be built, or the connection is not a Capsule. |

### getEloquentConnection()

`public function getEloquentConnection(): Connection`

The underlying Illuminate connection (query builder, PDO, transactions).

Returns `Connection`

### getPdo()

`public function getPdo(): PDO`

Returns the PDO handle Eloquent is using for the configured connection.

In layer mode this is the handle borrowed from another configured database rather than one Eloquent opened itself.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

| Throws | When |
|---|---|
| `DatabaseException` | If the capsule could not be built. |

### getResource()

`public function getResource(): mixed`

Returns the Illuminate connection, routed through [`EloquentDatabase::getCapsule()`](/api/database/adapter/eloquent/eloquent-database/#getcapsule) so a layer-mode rebind happens before the caller sees it -- the base class's getResource() would otherwise hand back `$this->resource` directly and skip that check.

Returns `mixed`

| Throws | When |
|---|---|
| `DatabaseException` | If the capsule could not be built. |

### ping()

`public function ping(): bool`

Probes the connection with `SELECT 1` on the raw PDO handle.

Returns true when nothing has been connected yet, since lazy connect handles it on first use. If the query throws, the capsule and resource are cleared so the next getConnection() rebuilds them, and false is returned.

Returns `bool`

### shutdown()

`public function shutdown(): mixed`

Rolls back any open transaction, purges the connection from Eloquent's database manager and drops the capsule.

Both steps are attempted independently; a failure in either is logged at warning and does not stop the shutdown. The capsule and resource are cleared regardless.

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
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Database`](/api/database/database/) | Returns this Database to its pre-initialize() state. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
