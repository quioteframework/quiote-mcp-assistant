# ReplayCyclePlugin

> Wires Cycle's own PSR-3 logger seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Wires Cycle's own PSR-3 logger seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Registers [`ReplayCycleDatabase`](/api/replay/adapter/cycle/replay-cycle-database/) -- a thin subclass that installs [`CycleRecordingLogger`](/api/replay/adapter/cycle/cycle-recording-logger/) at connect time -- under the same `cycle` driver alias `quioteframework/db-cycle`'s own `CyclePlugin` registers. [`PluginRegistrar::databaseDriver()`](/api/plugin/plugin-registrar/#databasedriver) is last-writer-wins (unlike `service()`'s set-if-absent), so an app that loads this plugin after `CyclePlugin` gets the recording subclass transparently, with no `databases.xml` change.

## Synopsis

`final class ReplayCyclePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayCyclePlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Contribute to the framework. |

### register()

`public function register(PluginRegistrar $registrar): void`

Contribute to the framework.

Called exactly once at boot. Every contribution routes through [`PluginRegistrar`](/api/plugin/plugin-registrar/) to an existing seam; a plugin does not touch framework internals directly.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
