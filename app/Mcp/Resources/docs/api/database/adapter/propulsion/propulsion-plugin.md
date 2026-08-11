# PropulsionPlugin

> Enables the `propulsion` database driver alias.

Enables the `propulsion` database driver alias.

Add this class to the `plugins` config key to write `class="propulsion"` in `databases.xml`.

## Synopsis

`final class PropulsionPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `PropulsionPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers `propulsion` as a database driver alias for [`PropulsionDatabase`](/api/database/adapter/propulsion/propulsion-database/). |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers `propulsion` as a database driver alias for [`PropulsionDatabase`](/api/database/adapter/propulsion/propulsion-database/).

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
