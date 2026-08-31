# CassetteIndexRegistry

> The ordered list of CassetteIndexInterface factories a driver package (today, only `quioteframework/replay-azure`) contributes -- unlike CassetteStoreRegistry's alias-to-class map, resolving a bare id is a *chain* to try in order, not a single named choice, so this registry holds factories, appended in registration order, rather than named aliases.

The ordered list of [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) factories a driver package (today, only `quioteframework/replay-azure`) contributes -- unlike [`CassetteStoreRegistry`](/api/replay/store/cassette-store-registry/)'s alias-to-class map, resolving a bare id is a *chain* to try in order, not a single named choice, so this registry holds factories, appended in registration order, rather than named aliases.

A factory is a closure so that building an index (a real HTTP client, real credentials) stays lazy: registration happens during [`PluginManager::bootFromConfig()`](/api/plugin/plugin-manager/#bootfromconfig), before a request's container necessarily exists, and only `quiote cassette:fetch`/`quiote replay --save` ever actually need one built.

## Synopsis

`final class CassetteIndexRegistry`

|  |  |
|---|---|
| Source | `Index/CassetteIndexRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`build(Container $container): list<CassetteIndexInterface>`](#build) | Builds every registered index, and turns one that cannot be constructed into an index that declines with its reason rather than letting it take the others down. |
| [`register(\Closure(Container): CassetteIndexInterface $factory): void`](#register) |  |
| [`reset(): void`](#reset) |  |

### build()

`public static function build(Container $container): list<CassetteIndexInterface>`

Builds every registered index, and turns one that cannot be constructed into an index that declines with its reason rather than letting it take the others down.

The eager `array_map` this replaces meant a single misconfigured factory aborted the whole chain before any index existed -- and the shipped Azure configuration hit exactly that: the Log Analytics index borrows `replay.store.azure.auth`, whose default `shared_key` cannot authenticate an AAD-only API, so `AzureTokenProviderFactory` correctly threw and an `--key` or `--date` that would have resolved fine never got the chance. That also defeated [`CassetteIndexChain`](/api/replay/index/cassette-index-chain/), which is deliberately built to record a broken index's failure and fall through to the next one.

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |

Returns `list``<`[`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/)`>`

### register()

`public static function register(\Closure(Container): CassetteIndexInterface $factory): void`

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `\Closure(Container): CassetteIndexInterface` |  |

### reset()

`public static function reset(): void`
