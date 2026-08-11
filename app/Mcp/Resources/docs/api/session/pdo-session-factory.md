# PdoSessionFactory

> `session` slot factory for PdoSessionPersistence, taking its connection from the application's own database manager so sessions live alongside everything else rather than needing separate credentials.

`session` slot factory for [`PdoSessionPersistence`](/api/session/pdo-session-persistence/), taking its connection from the application's own database manager so sessions live alongside everything else rather than needing separate credentials.

Parameters: `database` (the connection name from databases.xml; the default connection when omitted) and `table` (defaults to `session`).

A dedicated connection is worth considering under SQLite, where session writes and application writes on one file contend for the same lock.

## Synopsis

`final class PdoSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `Session/PdoSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array $parameters): SessionPersistenceInterface`](#createpersistence) | Builds a [`PdoSessionPersistence`](/api/session/pdo-session-persistence/) over a connection from the application's database manager. |

### createPersistence()

`public function createPersistence(Context $context, array $parameters): SessionPersistenceInterface`

Builds a [`PdoSessionPersistence`](/api/session/pdo-session-persistence/) over a connection from the application's database manager.

The `database` parameter names the connection; omitting it takes the default one. The remaining parameters, notably `table`, are passed through.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `StorageException` | if no database manager is bound (`core.use_database` off) or the named connection is not a PDO handle. |
