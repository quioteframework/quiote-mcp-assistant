# CyclePlugin

> Enables the `cycle` database driver alias.

Enables the `cycle` database driver alias.

Add this class to the `plugins` config key to write `class="cycle"` in `databases.xml`.

Extracts to `quioteframework/quiote-cycle` unchanged.

## Synopsis

`final class CyclePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `CyclePlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers `cycle` as a database driver alias for [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/). |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers `cycle` as a database driver alias for [`CycleDatabase`](/api/database/adapter/cycle/cycle-database/).

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
