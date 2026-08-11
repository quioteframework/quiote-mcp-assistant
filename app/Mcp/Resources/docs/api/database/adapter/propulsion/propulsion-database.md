# PropulsionDatabase

> First-class adapter for Propulsion (the quioteframework/propulsion fork of Propel 1).

First-class adapter for Propulsion (the quioteframework/propulsion fork of Propel 1).

The adapter bootstraps Propulsion from its runtime config and returns a datasource PDO connection from [`PropulsionDatabase::getConnection()`](/api/database/adapter/propulsion/propulsion-database/#getconnection).

Configuration parameters (in `databases.xml`): - `config`                  : path to the Propulsion runtime config file - `datasource`              : datasource to use (default = config default) - `overrides`               : key/value overrides applied after init - `init_queries`            : extra connection init queries to append - `enable_instance_pooling` : true/false to force pooling behavior

## Synopsis

`class PropulsionDatabase extends Database`

|  |  |
|---|---|
| Extends | [`Database`](/api/database/database/) |
| Source | `PropulsionDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`getConfigPath(): string`](#getconfigpath) | Returns the `config` parameter as configured. |
| [`getConnection(): mixed`](#getconnection) | Resolves the connection from Propulsion on every call instead of trusting the base class's connect-once cache. |
| [`getDatasource(): string`](#getdatasource) | Returns the Propulsion datasource this database connects through. |
| [`getPdo(): PDO`](#getpdo) | Returns the datasource connection as a plain PDO handle. |
| [`getPropulsionConnection(): PropulsionPDO`](#getpropulsionconnection) | Returns the connection narrowed to Propulsion's own PDO subclass. |
| [`getResource(): mixed`](#getresource) | Retrieve a raw database resource associated with this Database implementation. |
| [`initialize(DatabaseManager $databaseManager, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Database. |
| [`ping(): bool`](#ping) | Probes the connection with `SELECT 1`. |
| [`reset(): void`](#reset) | Returns this database to its pre-initialize() state, dropping Propulsion's request-scoped session first. |
| [`shutdown(): mixed`](#shutdown) | Closes Propulsion and drops the connection. |

### getConfigPath()

`public function getConfigPath(): string`

Returns the `config` parameter as configured.

This is the raw parameter value, not the directive-expanded path that initialize() actually loaded.

Returns `string`

| Throws | When |
|---|---|
| `DatabaseException` | If the `config` parameter is absent or not a non-empty string. |

### getConnection()

`public function getConnection(): mixed`

Resolves the connection from Propulsion on every call instead of trusting the base class's connect-once cache.

Propulsion::initialize() can drop its pooled connections underneath this adapter (see [`PropulsionDatabase::initialize()`](/api/database/adapter/propulsion/propulsion-database/#initialize)'s reconfiguration branch), which empties Propulsion's own connection map without touching `$this->connection`. If that cached handle were returned here, this adapter and the ORM acting through Propulsion would silently operate on two different backends -- e.g. a lock taken through this handle would never be visible to a write Propulsion itself performs. Propulsion::getConnection() is a pooled map lookup, so re-resolving on every call costs nothing and can never go stale.

Returns `mixed`

| Throws | When |
|---|---|
| `DatabaseException` | If a connection could not be created. |

### getDatasource()

`public function getDatasource(): string`

Returns the Propulsion datasource this database connects through.

Resolved during initialize() from the `datasource` parameter or from the config file's default datasource; `default` until then.

Returns `string`

### getPdo()

`public function getPdo(): PDO`

Returns the datasource connection as a plain PDO handle.

PropulsionPDO is an interface, and each concrete implementation extends the driver-specific PDO subclass rather than PDO itself, so the PDO instance is checked for here instead of being taken on trust.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

| Throws | When |
|---|---|
| `DatabaseException` | If the connection could not be created, is not a PropulsionPDO, or is a PropulsionPDO that does not extend PDO. |

### getPropulsionConnection()

`public function getPropulsionConnection(): PropulsionPDO`

Returns the connection narrowed to Propulsion's own PDO subclass.

Connects lazily on first call. Use this over getConnection() when the caller needs Propulsion-specific PDO behaviour.

Returns `PropulsionPDO`

| Throws | When |
|---|---|
| `DatabaseException` | If a connection could not be created, or the datasource handed back something that is not a PropulsionPDO. |

### getResource()

`public function getResource(): mixed`

Retrieve a raw database resource associated with this Database implementation.

Returns `mixed` — A database resource.

| Throws | When |
|---|---|
| `DatabaseException` | If a connection could not be created. |

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

Probes the connection with `SELECT 1`.

Returns true when no connection has been opened yet, since lazy connect will create a fresh one on first use. On any failure — including the connection not being a PDO instance — the connection and resource are cleared so the next getConnection() reconnects, and false is returned.

Returns `bool`

### reset()

`public function reset(): void`

Returns this database to its pre-initialize() state, dropping Propulsion's request-scoped session first.

That session (instance pool, unit-of-work state) lives on Propulsion itself rather than on this object, so the base teardown -- which shuts the connection down and clears the parameters, the manager reference and the name -- would leave it behind. Re-initialize() this instance before using it again.

| Throws | When |
|---|---|
| `DatabaseException` | If shutting the connection down fails. |

### shutdown()

`public function shutdown(): mixed`

Closes Propulsion and drops the connection.

Propulsion::close() is only called when Propulsion was initialized; the connection and resource are cleared either way, so a later getConnection() opens a new one.

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getDatabaseManager()` | [`Database`](/api/database/database/) | Retrieve the Database Manager instance for this implementation. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getName()` | [`Database`](/api/database/database/) | Retrieve the name of this database connection. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
