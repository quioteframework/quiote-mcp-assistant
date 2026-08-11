# WorkerRoadRunnerPlugin

> Registers the `roadrunner` worker-runtime alias.

Registers the `roadrunner` worker-runtime alias.

Registration has to happen during plugin boot rather than at runtime selection, and it does: `Quiote::bootstrap()` boots plugins before `Kernel::run()` picks a runtime, so the alias -- and its `isSupported()` vote during auto-detection -- are both in place by then.

## Synopsis

`final class WorkerRoadRunnerPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `WorkerRoadRunnerPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `worker.roadrunner.chunk_size` default and the runtime alias. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `worker.roadrunner.chunk_size` default and the runtime alias.

Adds `roadrunner` to [`WorkerRuntimeRegistry`](/api/runtime/worker/worker-runtime-registry/), which is what lets both an explicitly configured alias and auto-detection find the runtime.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
