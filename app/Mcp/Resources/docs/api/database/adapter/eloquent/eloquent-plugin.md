# EloquentPlugin

> Enables the `eloquent` database driver alias.

Enables the `eloquent` database driver alias.

Add this class to the `plugins` config key to write `class="eloquent"` in `databases.xml`.

When the adapters are extracted into standalone composer packages, this plugin (and its adapter) move to `quioteframework/quiote-eloquent` unchanged.

## Synopsis

`final class EloquentPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `EloquentPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers `eloquent` as a database driver alias for [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/). |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers `eloquent` as a database driver alias for [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/).

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
