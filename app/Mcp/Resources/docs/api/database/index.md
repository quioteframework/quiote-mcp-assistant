# Database

> The Quiote\\Database namespace — 16 documented types.

Everything under `Quiote\Database`.

## Classes

| Class | Description |
|---|---|
| [`AbstractOrmDatabase`](/api/database/abstract-orm-database/) | Shared base for ORM adapters whose [`AbstractOrmDatabase::getConnection()`](/api/database/abstract-orm-database/#getconnection) returns an ORM manager (Eloquent Capsule, Doctrine EntityManager, Cycle ORM) rather than a raw PDO handle. |
| [`Database`](/api/database/database/) | Database is a base abstraction class that allows you to setup any type of database connection via a configuration file. |
| [`DatabaseDefinitions`](/api/database/database-definitions/) | What the compiled `databases` configuration declares, as data. |
| [`DatabaseDriverRegistry`](/api/database/database-driver-registry/) | Process-global registry mapping short driver aliases (e.g. |
| [`DatabaseManager`](/api/database/database-manager/) | DatabaseManager allows you to setup your database connectivity before the request is handled. |
| [`PdoDatabase`](/api/database/pdo-database/) | PdoDatabase provides connectivity for the PDO database API layer. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Adapter`](/api/database/adapter/) | 10 types |
