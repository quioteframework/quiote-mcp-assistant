# ReplayPdoPlugin

> Registers the `pdo` cassette store alias and its `CassetteStoreInterface` binding, through the same plugin mechanism every other Quiote package uses.

Registers the `pdo` cassette store alias and its `CassetteStoreInterface` binding, through the same plugin mechanism every other Quiote package uses.

Load order does not matter, and installing this package does not commit an application to a database-backed store. It contributes an alias, a factory and a config family; `ReplayPlugin`'s single `CassetteStoreInterface` binding then builds whichever store `replay.store` actually names. Previously this plugin claimed that binding itself with a set-if-absent `service()` call, which only worked when it loaded first -- and, having loaded first, then won regardless of `replay.store`.

## Synopsis

`final class ReplayPdoPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayPdoPlugin.php` |

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
