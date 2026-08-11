# PdoSessionFactory

> `session` slot factory for this package's PdoSessionPersistence.

`session` slot factory for this package's [`PdoSessionPersistence`](/api/session/pdo/pdo-session-persistence/).

```yaml session: class: Quiote\Session\Pdo\PdoSessionFactory params: database: sessions table: session ```

Core ships an equivalent pair ([`PdoSessionFactory`](/api/session/pdo-session-factory/) over [`PdoSessionPersistence`](/api/session/pdo-session-persistence/)) with no extra dependency, and that is the one to reach for in a new application. This exists so an application already requiring this package keeps working.

## Synopsis

`final class PdoSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `PdoSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array $parameters): SessionPersistenceInterface`](#createpersistence) | Builds a [`PdoSessionPersistence`](/api/session/pdo/pdo-session-persistence/) over a connection from the application's database manager. |

### createPersistence()

`public function createPersistence(Context $context, array $parameters): SessionPersistenceInterface`

Builds a [`PdoSessionPersistence`](/api/session/pdo/pdo-session-persistence/) over a connection from the application's database manager.

The `database` parameter names the connection; omitting it takes the default one. `table` defaults to `session`.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `StorageException` | if no database manager is bound (`core.use_database` off) or the named connection is not a PDO handle. |
