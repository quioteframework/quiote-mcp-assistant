# EffectSourceRegistry

> Every registered EffectSource, for RecorderMiddleware to activate/deactivate around one request.

Every registered [`EffectSource`](/api/replay/recording/effect-source/), for [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) to activate/deactivate around one request.

A plain list, not a driver-alias map like [`CassetteStoreRegistry`](/api/replay/store/cassette-store-registry/): more than one process-scoped-observer-style driver could plausibly be active in the same app (unlikely, but nothing here assumes exactly one).

## Synopsis

`final class EffectSourceRegistry`

|  |  |
|---|---|
| Source | `Recording/EffectSourceRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`all(): list<EffectSource>`](#all) |  |
| [`register(EffectSource $source): void`](#register) |  |
| [`reset(): void`](#reset) | Test isolation. |

### all()

`public static function all(): list<EffectSource>`

Returns `list``<`[`EffectSource`](/api/replay/recording/effect-source/)`>`

### register()

`public static function register(EffectSource $source): void`

| Parameter | Type | Description |
|---|---|---|
| `$source` | [`EffectSource`](/api/replay/recording/effect-source/) |  |

### reset()

`public static function reset(): void`

Test isolation.
