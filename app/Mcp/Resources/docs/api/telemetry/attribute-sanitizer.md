# AttributeSanitizer

> Validates arbitrary attribute maps against the shape the OTel SDK's own span/meter APIs require: non-empty-string keys, and values that are `array|bool|float|int|string|null` (arrays homogeneous, one scalar type throughout).

Validates arbitrary attribute maps against the shape the OTel SDK's own span/meter APIs require: non-empty-string keys, and values that are `array|bool|float|int|string|null` (arrays homogeneous, one scalar type throughout).

Instrumentation call sites hand in whatever a caller passed as `mixed`; this is where that gets enforced, once, rather than every handle re-deriving its own idea of what's acceptable.

## Synopsis

`final class AttributeSanitizer`

|  |  |
|---|---|
| Source | `AttributeSanitizer.php` |

## Methods

| Method | Description |
|---|---|
| [`sanitize(array<array-key, mixed> $attributes): array<non-empty-string, array<int, bool|float|int|string>|bool|float|int|string|null>`](#sanitize) |  |
| [`sanitizeEntry(string|int $key, mixed $value): array{0: non-empty-string, 1: (array<int, (bool | float | int | string)> | bool | float | int | string | null)}`](#sanitizeentry) |  |

### sanitize()

`public static function sanitize(array<array-key, mixed> $attributes): array<non-empty-string, array<int, bool|float|int|string>|bool|float|int|string|null>`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``array-key``, ``mixed``>` |  |

Returns `array``<``non-empty-string``, ``array``<``int``, ``bool``|``float``|``int``|``string``>``|``bool``|``float``|``int``|``string``|``null``>`

### sanitizeEntry()

`public static function sanitizeEntry(string|int $key, mixed $value): array{0: non-empty-string, 1: (array<int, (bool | float | int | string)> | bool | float | int | string | null)}`

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string``|``int` |  |
| `$value` | `mixed` |  |

Returns `array{0: non-empty-string, 1: (array<int, (bool | float | int | string)> | bool | float | int | string | null)}`
