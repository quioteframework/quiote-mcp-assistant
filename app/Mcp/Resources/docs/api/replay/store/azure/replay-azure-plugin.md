# ReplayAzurePlugin

> Registers the `azure-blob` cassette store alias and its `CassetteStoreInterface` binding, and contributes the three cassette-index strategies -- an explicit key, a Log Analytics lookup, and a date-hinted prefix scan -- that let `quiote cassette:fetch`/`quiote replay --save` resolve a bare id copied out of a log line back to a cassette, in that order: the explicit key always wins when `--key` is given, Log Analytics resolves a bare id with no hint at all, and the prefix scan is the fallback for a developer with blob read but no workspace access.

Registers the `azure-blob` cassette store alias and its `CassetteStoreInterface` binding, and contributes the three cassette-index strategies -- an explicit key, a Log Analytics lookup, and a date-hinted prefix scan -- that let `quiote cassette:fetch`/`quiote replay --save` resolve a bare id copied out of a log line back to a cassette, in that order: the explicit key always wins when `--key` is given, Log Analytics resolves a bare id with no hint at all, and the prefix scan is the fallback for a developer with blob read but no workspace access.

Load order does not matter, and installing this package does not commit an application to Azure. It contributes an alias, a factory, a config family and three index factories; `ReplayPlugin`'s single `CassetteStoreInterface` binding then builds whichever store `replay.store` actually names. Previously this plugin claimed that binding itself with a set-if-absent `service()` call, which only worked when it loaded first -- and, having loaded first, then won regardless of `replay.store`, so merely installing the package forced every cassette through a blob container the application may never have named.

## Synopsis

`final class ReplayAzurePlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayAzurePlugin.php` |

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
