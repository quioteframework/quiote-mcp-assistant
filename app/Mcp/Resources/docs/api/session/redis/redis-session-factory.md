# RedisSessionFactory

> `session` slot factory for RedisSessionPersistence.

`session` slot factory for [`RedisSessionPersistence`](/api/session/redis/redis-session-persistence/).

```yaml session: class: Quiote\Session\Redis\RedisSessionFactory params: dsn: 'redis://127.0.0.1:6379' prefix: 'session:' ttl: 1440 ```

Redis expires the key itself, so `ttl` doubles as the session lifetime and there is no garbage-collection pass to schedule.

## Synopsis

`final class RedisSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `RedisSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array $parameters): SessionPersistenceInterface`](#createpersistence) | Builds a [`RedisSessionPersistence`](/api/session/redis/redis-session-persistence/) over a Predis client. |

### createPersistence()

`public function createPersistence(Context $context, array $parameters): SessionPersistenceInterface`

Builds a [`RedisSessionPersistence`](/api/session/redis/redis-session-persistence/) over a Predis client.

Parameters, all optional: `dsn` (default `redis://127.0.0.1:6379`), `prefix` (default `session:`) and `ttl` in seconds (default 1440), which Redis enforces as the session lifetime.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | if predis/predis is not installed. |
