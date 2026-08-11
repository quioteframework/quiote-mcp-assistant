# QueueRedisPlugin

> Registers the `redis` queue driver alias and publishes `queue.redis.*` config defaults.

Registers the `redis` queue driver alias and publishes `queue.redis.*` config defaults.

Unlike [`QueueDbPlugin`](/api/queue/db/queue-db-plugin/), the Redis connection is self-contained (built straight from a DSN, no dependency on the current [`Context`](/api/context/)'s `DatabaseManager`).

## Synopsis

`final class QueueRedisPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `QueueRedisPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `queue.redis.*` defaults and registers the `redis` driver. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `queue.redis.*` defaults and registers the `redis` driver.

Adds the `redis` alias to [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) and binds [`RedisQueueDriver`](/api/queue/redis/redis-queue-driver/) as a singleton whose factory builds a Predis client from `queue.redis.dsn`. The client is constructed lazily, when the driver is first resolved, not while plugins are registering.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
