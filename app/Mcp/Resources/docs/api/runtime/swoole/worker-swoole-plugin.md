# WorkerSwoolePlugin

> Registers the `swoole` worker-runtime alias, its settings, and the `swoole:serve` launcher.

Registers the `swoole` worker-runtime alias, its settings, and the `swoole:serve` launcher.

## Synopsis

`final class WorkerSwoolePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `WorkerSwoolePlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `worker.swoole.*` defaults, the runtime alias and the command. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `worker.swoole.*` defaults, the runtime alias and the command.

Adds `swoole` to [`WorkerRuntimeRegistry`](/api/runtime/worker/worker-runtime-registry/) and registers [`SwooleServeCommand`](/api/runtime/swoole/console/swoole-serve-command/). Nothing here touches ext-swoole, so the plugin loads on a machine without it.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
