# QueuePlugin

> Registers the queue subsystem: `queue.*` setting defaults (`sync` driver, out of the box), a default LogFailedJobStore, the QueueManager/QueueWorker services, `queue:work`, and the `queue:failed:*` dead-letter inspection commands (a no-op error, not a crash, against the default store — see AbstractQueueFailedCommand::resolveInspectableStore()).

Registers the queue subsystem: `queue.*` setting defaults (`sync` driver, out of the box), a default [`LogFailedJobStore`](/api/queue/log-failed-job-store/), the [`QueueManager`](/api/queue/queue-manager/)/[`QueueWorker`](/api/queue/queue-worker/) services, `queue:work`, and the `queue:failed:*` dead-letter inspection commands (a no-op error, not a crash, against the default store — see [`AbstractQueueFailedCommand::resolveInspectableStore()`](/api/queue/console/abstract-queue-failed-command/#resolveinspectablestore)).

A persistent backend (e.g. `quioteframework/queue-db`) registers its own alias into [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) from its own plugin — this class does not need to change for that.

## Synopsis

`final class QueuePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `QueuePlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `queue.*` config defaults, services and console commands. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `queue.*` config defaults, services and console commands.

Registers the `sync` driver default and retry settings, a singleton [`LogFailedJobStore`](/api/queue/log-failed-job-store/) as the [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) binding, the [`QueueConfig`](/api/queue/queue-config/)/[`JobExecutor`](/api/queue/job-executor/)/[`QueueWorker`](/api/queue/queue-worker/)/ [`QueueManager`](/api/queue/queue-manager/) singletons, and the `queue:work` and `queue:failed:*` commands. Because [`PluginRegistrar::service()`](/api/plugin/plugin-registrar/#service) only sets a binding that is absent, an app or a later plugin can override any of these.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
