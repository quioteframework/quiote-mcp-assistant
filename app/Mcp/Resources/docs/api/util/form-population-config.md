# FormPopulationConfig

> Helper to bridge configuration storage for form population between legacy namespaced attributes and the PSR-7 attribute bag on WebRequest.

Helper to bridge configuration storage for form population between legacy namespaced attributes and the PSR-7 attribute bag on WebRequest.

WebRequest is immutable, so seed()/merge()/setScopedValue()/store() return the (possibly new) request instance; callers must capture and propagate it. Legacy namespaced-attribute holders mutate in place and are returned unchanged for API symmetry.

## Synopsis

`final class FormPopulationConfig`

|  |  |
|---|---|
| Source | `Util/FormPopulationConfig.php` |

## Methods

| Method | Description |
|---|---|
| [`get(mixed $request): array<string, mixed>`](#get) | Retrieve the current configuration map. |
| [`getScopedValue(mixed $request, string $key, mixed $default = null): mixed`](#getscopedvalue) | Retrieve a single scoped value with default fallback. |
| [`merge(mixed $request, array<string, mixed> $overrides): mixed`](#merge) | Merge configuration overrides, allowing new values to replace existing ones. |
| [`seed(mixed $request, array<string, mixed> $defaults): mixed`](#seed) | Seed configuration defaults without overwriting previously provided values. |
| [`setScopedValue(mixed $request, string $key, mixed $value): mixed`](#setscopedvalue) | Convenience helper to set a single scoped value. |

### get()

`public static function get(mixed $request): array<string, mixed>`

Retrieve the current configuration map.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `mixed` |  |

Returns `array``<``string``, ``mixed``>`

### getScopedValue()

`public static function getScopedValue(mixed $request, string $key, mixed $default = null): mixed`

Retrieve a single scoped value with default fallback.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `mixed` |  |
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### merge()

`public static function merge(mixed $request, array<string, mixed> $overrides): mixed`

Merge configuration overrides, allowing new values to replace existing ones.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `mixed` |  |
| `$overrides` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

### seed()

`public static function seed(mixed $request, array<string, mixed> $defaults): mixed`

Seed configuration defaults without overwriting previously provided values.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `mixed` |  |
| `$defaults` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

### setScopedValue()

`public static function setScopedValue(mixed $request, string $key, mixed $value): mixed`

Convenience helper to set a single scoped value.

| Parameter | Type | Description |
|---|---|---|
| `$request` | `mixed` |  |
| `$key` | `string` |  |
| `$value` | `mixed` |  |

Returns `mixed`
