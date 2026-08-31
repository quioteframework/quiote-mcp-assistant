# ReplayEloquentPlugin

> Wires Eloquent's own `QueryExecuted` event seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Wires Eloquent's own `QueryExecuted` event seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Registers [`ReplayEloquentDatabase`](/api/replay/adapter/eloquent/replay-eloquent-database/) -- a thin subclass that attaches [`EloquentQueryRecorder`](/api/replay/adapter/eloquent/eloquent-query-recorder/) at connect time -- under the same `eloquent` driver alias `quioteframework/db-eloquent`'s own `EloquentPlugin` registers. [`PluginRegistrar::databaseDriver()`](/api/plugin/plugin-registrar/#databasedriver) is last-writer-wins (unlike `service()`'s set-if-absent), so an app that loads this plugin after `EloquentPlugin` gets the recording subclass transparently, with no `databases.xml` change.

## Synopsis

`final class ReplayEloquentPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayEloquentPlugin.php` |

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
