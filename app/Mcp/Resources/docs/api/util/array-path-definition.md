# ArrayPathDefinition

> Path implements handling of virtual paths This class does not implement real filesystem path handling, but uses virtual paths.

Path implements handling of virtual paths This class does not implement real filesystem path handling, but uses virtual paths.

It is primary used in the validation system for handling arrays of input.

## Synopsis

`final class ArrayPathDefinition`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Util/ArrayPathDefinition.php` |

## Methods

| Method | Description |
|---|---|
| [`flatten(array<int|string, mixed> $array, string|null $prefix = null): array<int|string, mixed>`](#flatten) | Returns the flattened version of an array. |
| [`getFlatKeyNames(array<int|string, mixed> $array, string|null $prefix = null): array<int, string>`](#getflatkeynames) | Returns the flat key names of an array. |
| [`getPartsFromPath(string $path): array{parts: array<int, string>, absolute: bool}`](#getpartsfrompath) | Returns an array with the single parts of the given path. |
| [`getValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> &$array, mixed $default = null): mixed`](#getvalue) | Returns the value at the given path. |
| [`hasValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> $array): bool`](#hasvalue) | Checks whether the array has a value at the given path. |
| [`setValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> &$array, mixed $value): void`](#setvalue) | Sets the value at the given path. |
| [`unsetValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> &$array): mixed`](#unsetvalue) | Unsets a value at the given path. |

### flatten()

`public static function flatten(array<int|string, mixed> $array, string|null $prefix = null): array<int|string, mixed>`

Returns the flattened version of an array.

The prefix for the key names (only for internal use).

| Parameter | Type | Description |
|---|---|---|
| `$array` | `array``<``int``|``string``, ``mixed``>` | The array which should be flattened. |
| `$prefix` | `string``|``null` | The prefix for the key names (only for internal use). |

Returns `array``<``int``|``string``, ``mixed``>` — The flattened array.

### getFlatKeyNames()

`public static function getFlatKeyNames(array<int|string, mixed> $array, string|null $prefix = null): array<int, string>`

Returns the flat key names of an array.

The prefix for the name (only for internal use).

| Parameter | Type | Description |
|---|---|---|
| `$array` | `array``<``int``|``string``, ``mixed``>` | The array which keys should be returned. |
| `$prefix` | `string``|``null` | The prefix for the name (only for internal use). |

Returns `array``<``int``, ``string``>` — The flattened keys.

### getPartsFromPath()

`public static function getPartsFromPath(string $path): array{parts: array<int, string>, absolute: bool}`

Returns an array with the single parts of the given path.

The path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The path. |

Returns `array{parts: array<int, string>, absolute: bool}` — The parts of the given path.

### getValue()

`public static function getValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> &$array, mixed $default = null): mixed`

Returns the value at the given path.

A default value if the path doesn't exist in the array.

| Parameter | Type | Description |
|---|---|---|
| `$partsArrayOrPathString` | `array``<``int``, ``mixed``>``|``string` | The path string or an array containing the path divided into its individual parts. |
| `$array` | `array``<``int``|``string``, ``mixed``>` | The array we should operate on. |
| `$default` | `mixed` | A default value if the path doesn't exist in the array. |

Returns `mixed` — The value stored at the given path.

### hasValue()

`public static function hasValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> $array): bool`

Checks whether the array has a value at the given path.

The array we should operate on.

| Parameter | Type | Description |
|---|---|---|
| `$partsArrayOrPathString` | `array``<``int``, ``mixed``>``|``string` | The path string or an array containing the path divided into its individual parts. |
| `$array` | `array``<``int``|``string``, ``mixed``>` | The array we should operate on. |

Returns `bool` — Whether the path exists in this array.

### setValue()

`public static function setValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> &$array, mixed $value): void`

Sets the value at the given path.

The value.

| Parameter | Type | Description |
|---|---|---|
| `$partsArrayOrPathString` | `array``<``int``, ``mixed``>``|``string` | The path string or an array containing the path divided into its individual parts. |
| `$array` | `array``<``int``|``string``, ``mixed``>` | The array we should operate on. |
| `$value` | `mixed` | The value. |

### unsetValue()

`public static function unsetValue(array<int, mixed>|string $partsArrayOrPathString, array<int|string, mixed> &$array): mixed`

Unsets a value at the given path.

The array we should operate on.

| Parameter | Type | Description |
|---|---|---|
| `$partsArrayOrPathString` | `array``<``int``, ``mixed``>``|``string` | The path string or an array containing the path divided into its individual parts. |
| `$array` | `array``<``int``|``string``, ``mixed``>` | The array we should operate on. |

Returns `mixed` — The previously stored value.
