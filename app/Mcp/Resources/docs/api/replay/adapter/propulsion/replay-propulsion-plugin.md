# ReplayPropulsionPlugin

> Wires Propulsion's own query observer seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Wires Propulsion's own query observer seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses.

Unlike `Quiote\Replay\ReplayPlugin` (which guards every Propulsion reference behind `class_exists()`, since it must not hard-depend on any ORM), this plugin's whole reason to exist is that Propulsion *is* installed -- an app that doesn't want this integration simply doesn't require this package.

## Synopsis

`final class ReplayPropulsionPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayPropulsionPlugin.php` |

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
