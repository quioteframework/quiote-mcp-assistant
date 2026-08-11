# QueueDbPlugin

> Registers the `db` queue driver alias and publishes `queue.db.*` config defaults.

Registers the `db` queue driver alias and publishes `queue.db.*` config defaults.

`DbQueueDriver`/`DbFailedJobStore` are registered as explicit container services (not left to raw constructor autowiring) because they need the app's *real*, already-`initialize()`d `DatabaseManager` — that only exists on the current [`Context`](/api/context/), not as a container-autowired fresh instance (which would have no configured connections). See [`QueueDbPlugin::resolvePdo()`](/api/queue/db/queue-db-plugin/#resolvepdo).

`DbFailedJobStore` is registered as `DbFailedJobStore::class` only, not bound as the default `FailedJobStoreInterface` — an app opts into persistent dead-letter storage explicitly (`$registrar->service(FailedJobStoreInterface::class, ...)` in its own plugin/bootstrap), rather than this package silently overriding [`QueuePlugin`](/api/queue/queue-plugin/)'s default depending on plugin declaration order.

## Synopsis

`final class QueueDbPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `QueueDbPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `queue.db.*` defaults and registers the `db` driver. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `queue.db.*` defaults and registers the `db` driver.

Adds the `db` alias to [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) and binds [`DbQueueDriver`](/api/queue/db/db-queue-driver/) and [`DbFailedJobStore`](/api/queue/db/db-failed-job-store/) as singleton services whose factories pull the configured connection's PDO handle off the current [`Context`](/api/context/). Neither factory runs here — the connection is only touched when something actually resolves one of those services.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
