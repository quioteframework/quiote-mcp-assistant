# DoctrineDatabase

> Modern first-class adapter for Doctrine ORM 3 / DBAL 4.

Modern first-class adapter for Doctrine ORM 3 / DBAL 4.

[`DoctrineDatabase::getConnection()`](/api/database/adapter/doctrine/doctrine-database/#getconnection) returns the `EntityManagerInterface`. Supersedes the legacy in-tree `Doctrine2*` adapters.

Configuration parameters (in `databases.xml`): - `connection`      : the name (string) of a configured DoctrineDbalDatabase to reuse, OR an inline DBAL params array. Omit to build from flat params (see [`DoctrineDbalParams`](/api/database/adapter/doctrine/doctrine-dbal-params/)). NB: DBAL 4 cannot wrap a raw PDO, so referencing a plain PdoDatabase is not supported — reference a DoctrineDbalDatabase. - `entity_paths`    : array of directories/files holding mapping metadata - `metadata`        : "attribute" (default) | "xml" - `dev_mode`        : bool (default = core.debug) — proxy auto-generation etc. - `proxy_dir`       : directory for generated proxies (default: system temp) - `proxy_namespace` : namespace for generated proxy classes

Cache bridging (metadata/query caches to Quiote's PSR-6 pool) is a follow-up; for now ORMSetup's in-memory default is used unless a subclass overrides [`DoctrineDatabase::metadataCache()`](/api/database/adapter/doctrine/doctrine-database/#metadatacache).

## Synopsis

`class DoctrineDatabase extends AbstractOrmDatabase`

|  |  |
|---|---|
| Extends | [`AbstractOrmDatabase`](/api/database/abstract-orm-database/) |
| Uses | [`DoctrineDbalParams`](/api/database/adapter/doctrine/doctrine-dbal-params/) |
| Source | `DoctrineDatabase.php` |

## Methods

| Method | Description |
|---|---|
| [`getDbalConnection(): Connection`](#getdbalconnection) | Returns the DBAL connection the entity manager runs on. |
| [`getEntityManager(): EntityManagerInterface`](#getentitymanager) | Returns the Doctrine entity manager, connecting on first use. |
| [`getPdo(): PDO`](#getpdo) | Only available when the configured `driver` is a `pdo_*` one (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`, ...) — DBAL 4 also supports native drivers (`mysqli`, `pgsql`) that never construct a \PDO instance at all. |
| [`getRepository(class-string<T> $entity): EntityRepository<T>`](#getrepository) |  |
| [`ping(): bool`](#ping) | Probes the connection with `SELECT 1` over DBAL. |
| [`reset(): void`](#reset) | Returns this database to its pre-initialize() state, detaching every managed entity first. |
| [`shutdown(): mixed`](#shutdown) | Rolls back any open transaction, closes the DBAL connection and drops the entity manager. |

### getDbalConnection()

`public function getDbalConnection(): Connection`

Returns the DBAL connection the entity manager runs on.

This is the entry point for custom SQL — `executeQuery()` / `executeStatement()` — on drivers that never expose a PDO handle.

Returns `Connection`

| Throws | When |
|---|---|
| `DatabaseException` | If the entity manager could not be built. |

### getEntityManager()

`public function getEntityManager(): EntityManagerInterface`

Returns the Doctrine entity manager, connecting on first use.

Returns `EntityManagerInterface`

| Throws | When |
|---|---|
| `DatabaseException` | If the entity manager could not be built, or the connection is not an EntityManagerInterface. |

### getPdo()

`public function getPdo(): PDO`

Only available when the configured `driver` is a `pdo_*` one (`pdo_mysql`, `pdo_pgsql`, `pdo_sqlite`, ...) — DBAL 4 also supports native drivers (`mysqli`, `pgsql`) that never construct a \PDO instance at all.

Returns [`PDO`](https://www.php.net/manual/en/class.pdo.php)

### getRepository()

`public function getRepository(class-string<T> $entity): EntityRepository<T>`

| Parameter | Type | Description |
|---|---|---|
| `$entity` | `class-string``<``T``>` |  |

Returns `EntityRepository``<``T``>`

### ping()

`public function ping(): bool`

Probes the connection with `SELECT 1` over DBAL.

Returns true when nothing has been connected yet, since lazy connect handles it on first use. If the query throws, the entity manager and the DBAL resource are cleared so the next getConnection() rebuilds both, and false is returned.

Returns `bool`

### reset()

`public function reset(): void`

Returns this database to its pre-initialize() state, detaching every managed entity first.

The identity map is cleared up front so entities are detached even for a caller still holding the entity manager; the base teardown then shuts the connection down and clears the parameters, the manager reference and the name. Re-initialize() this instance before using it again.

To recycle a worker's connection between requests without discarding the configuration, use [`DoctrineDatabase::ping()`](/api/database/adapter/doctrine/doctrine-database/#ping) -- which is what [`DatabaseManager::recycleConnections()`](/api/database/database-manager/#recycleconnections) calls at the request boundary.

| Throws | When |
|---|---|
| `DatabaseException` | If shutting the connection down fails. |

### shutdown()

`public function shutdown(): mixed`

Rolls back any open transaction, closes the DBAL connection and drops the entity manager.

A failure to roll back or close is logged at warning and does not stop the shutdown; the entity manager and resource are cleared either way.

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
| `getResource()` | [`Database`](/api/database/database/) | Retrieve a raw database resource associated with this Database implementation. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`Database`](/api/database/database/) | Initialize this Database. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`Database`](/api/database/database/) | Do any necessary startup work after initialization. |
