# IDeclarationConfigHandler

> A config handler whose compiled artifact is a declaration -- data -- plus the code that applies that data to runtime state.

A config handler whose compiled artifact is a declaration -- data -- plus the code that applies that data to runtime state.

[`ConfigCache::load()`](/api/config/config-cache/#load) reads the artifact's value and hands it to [`IDeclarationConfigHandler::apply()`](/api/config/i-declaration-config-handler/#apply). The artifact itself never runs statements, so a poisoned cache entry can only produce wrong configuration, never execution: the code that acts on the declaration is this class, shipped with the framework or the package, not a string in the cache.

A declaration arrives from the cache or from a hand-authored `.php`/`.yaml` source, so [`IDeclarationConfigHandler::apply()`](/api/config/i-declaration-config-handler/#apply) is a trust boundary: validate the shape and throw [`ConfigurationException`](/api/exception/configuration-exception/) rather than assuming what the compiler produced.

## Synopsis

`interface IDeclarationConfigHandler`

|  |  |
|---|---|
| Implemented by | [`MiddlewareConfigHandler`](/api/config/middleware-config-handler/), [`PluginConfigHandler`](/api/config/plugin-config-handler/), [`SettingConfigHandler`](/api/config/setting-config-handler/) |
| Since | `4.0.0` |
| Source | `Config/IDeclarationConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`apply(mixed $declaration, string $sourceRef): void`](#apply) | Apply a compiled declaration to runtime state. |

### apply()

`abstract public function apply(mixed $declaration, string $sourceRef): void`

Apply a compiled declaration to runtime state.

The configuration file the declaration came from, for diagnostics.

| Parameter | Type | Description |
|---|---|---|
| `$declaration` | `mixed` | The value the compiled configuration returned. |
| `$sourceRef` | `string` | The configuration file the declaration came from, for diagnostics. |

| Throws | When |
|---|---|
| `ConfigurationException` | If the declaration is not the shape this handler compiles. |
