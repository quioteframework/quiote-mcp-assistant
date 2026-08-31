# ReplayDoctrinePlugin

> Wires Doctrine's own DBAL driver-middleware seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Wires Doctrine's own DBAL driver-middleware seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Registers [`ReplayDoctrineDatabase`](/api/replay/adapter/doctrine/replay-doctrine-database/)/[`ReplayDoctrineDbalDatabase`](/api/replay/adapter/doctrine/replay-doctrine-dbal-database/) -- thin subclasses that install [`DoctrineRecordingMiddleware`](/api/replay/adapter/doctrine/doctrine-recording-middleware/) at connect time -- under the same `doctrine`/`doctrine_dbal` driver aliases `quioteframework/db-doctrine`'s own `DoctrinePlugin` registers. [`PluginRegistrar::databaseDriver()`](/api/plugin/plugin-registrar/#databasedriver) is last-writer-wins (unlike `service()`'s set-if-absent), so an app that loads this plugin after `DoctrinePlugin` gets the recording subclasses transparently, with no `databases.xml` change.

## Synopsis

`final class ReplayDoctrinePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayDoctrinePlugin.php` |

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
