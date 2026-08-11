# VirtualArrayPath

> Path implements handling of virtual paths This class does not implement real filesystem path handling, but uses virtual paths.

Path implements handling of virtual paths This class does not implement real filesystem path handling, but uses virtual paths.

It is primary used in the validation system for handling arrays of input.

## Synopsis

`class VirtualArrayPath implements Stringable`

|  |  |
|---|---|
| Implements | [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Since | `1.0.0` |
| Source | `Util/VirtualArrayPath.php` |

## Constructor

### __construct()

`public function __construct(string|int|null $path): mixed`

constructor

The path to be handled by the object

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string``|``int``|``null` | The path to be handled by the object |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) | Returns the string representation of the path. |
| [`get(int $position): int|string|null`](#get) | Returns the given component of the path. |
| [`getParts(): array<int, int|string>`](#getparts) | Returns the components of this path. |
| [`getValue(array<mixed> &$array, mixed $default = null): mixed`](#getvalue) | Returns the value at the path of this instance in the given array. |
| [`getValueByChildPath(string $path, array<mixed> &$array, mixed $default = null): mixed`](#getvaluebychildpath) | Returns the value at the given child path of this instance in the given array. |
| [`hasValue(array<mixed> &$array): bool`](#hasvalue) | Checks if a value exists at the path of this instance in the given array. |
| [`hasValueByChildPath(string $path, array<mixed> &$array): bool`](#hasvaluebychildpath) | Checks if a value at the given child path exists in the given array. |
| [`isAbsolute(): bool`](#isabsolute) | Returns whether the path is absolute. |
| [`left(bool $addBracketsWhenRelative = false): int|string|null`](#left) | Returns the root component of the path. |
| [`length(): int`](#length) | Returns the number of components the path has. |
| [`pop(): int|string|null`](#pop) | Returns the last component of the path and deletes it from the path. |
| [`push(string|int $path): void`](#push) | Appends one or more components to the path. |
| [`pushRetNew(string|int $path): static`](#pushretnew) | Clones this path, appends one or more components to it and returns it. |
| [`setValue(array<mixed> &$array, mixed $value): void`](#setvalue) | Sets the value at the path of this instance in the given array. |
| [`setValueByChildPath(string $path, array<mixed> &$array, mixed $value): void`](#setvaluebychildpath) | Sets the value at the given child path of this instance in the given array. |
| [`shift(bool $addBracketsWhenRelative = false): int|string|null`](#shift) | Returns the root component of the path and deletes it from the path. |
| [`unshift(string|int $path): void`](#unshift) | Prepends one or more components to the path. |

### __toString()

`public function __toString(): string`

Returns the string representation of the path.

Returns `string` — The path as string.

### get()

`public function get(int $position): int|string|null`

Returns the given component of the path.

Position of the component.

| Parameter | Type | Description |
|---|---|---|
| `$position` | `int` | Position of the component. |

Returns `int``|``string``|``null` — The component at the given position, or null if out of range.

### getParts()

`public function getParts(): array<int, int|string>`

Returns the components of this path.

Returns `array``<``int``, ``int``|``string``>` — The components

### getValue()

`public function getValue(array<mixed> &$array, mixed $default = null): mixed`

Returns the value at the path of this instance in the given array.

The default value to be used if the path doesn't exist.

| Parameter | Type | Description |
|---|---|---|
| `$array` | `array``<``mixed``>` | The array to get the data from. |
| `$default` | `mixed` | The default value to be used if the path doesn't exist. |

Returns `mixed` — The value at the path.

### getValueByChildPath()

`public function getValueByChildPath(string $path, array<mixed> &$array, mixed $default = null): mixed`

Returns the value at the given child path of this instance in the given array.

The default value to be used if the path doesn't exist.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The child path appended to the path in this instance. |
| `$array` | `array``<``mixed``>` | The array to get the data from. |
| `$default` | `mixed` | The default value to be used if the path doesn't exist. |

Returns `mixed` — The value at the path.

### hasValue()

`public function hasValue(array<mixed> &$array): bool`

Checks if a value exists  at the path of this instance in the given array.

The array to check.

| Parameter | Type | Description |
|---|---|---|
| `$array` | `array``<``mixed``>` | The array to check. |

Returns `bool`

### hasValueByChildPath()

`public function hasValueByChildPath(string $path, array<mixed> &$array): bool`

Checks if a value at the given child path exists in the given array.

The array to check.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The child path appended to the path in this instance. |
| `$array` | `array``<``mixed``>` | The array to check. |

Returns `bool`

### isAbsolute()

`public function isAbsolute(): bool`

Returns whether the path is absolute.

Returns `bool` — True if the path is absolute.

### left()

`public function left(bool $addBracketsWhenRelative = false): int|string|null`

Returns the root component of the path.

Whether brackets should be added around the component if
                 this path is not absolute.

| Parameter | Type | Description |
|---|---|---|
| `$addBracketsWhenRelative` | `bool` | Whether brackets should be added around the component if this path is not absolute. |

Returns `int``|``string``|``null` — The root component, or null if the path is empty.

### length()

`public function length(): int`

Returns the number of components the path has.

Returns `int` — The number of components.

### pop()

`public function pop(): int|string|null`

Returns the last component of the path and deletes it from the path.

Returns `int``|``string``|``null` — The last component, or null if the path is empty.

### push()

`public function push(string|int $path): void`

Appends one or more components to the path.

The components to be added.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string``|``int` | The components to be added. |

### pushRetNew()

`public function pushRetNew(string|int $path): static`

Clones this path, appends one or more components to it and returns it.

the components to be added.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string``|``int` | the components to be added. |

Returns `static`

### setValue()

`public function setValue(array<mixed> &$array, mixed $value): void`

Sets the value at the path of this instance in the given array.

The value to be set.

| Parameter | Type | Description |
|---|---|---|
| `$array` | `array``<``mixed``>` | The array to set the data in. |
| `$value` | `mixed` | The value to be set. |

### setValueByChildPath()

`public function setValueByChildPath(string $path, array<mixed> &$array, mixed $value): void`

Sets the value at the given child path of this instance in the given array.

The value to be set.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The child path appended to the path in this instance. |
| `$array` | `array``<``mixed``>` | The array to set the data in. |
| `$value` | `mixed` | The value to be set. |

### shift()

`public function shift(bool $addBracketsWhenRelative = false): int|string|null`

Returns the root component of the path and deletes it from the path.

Whether brackets should be added around the component if
                 this path is not absolute.

| Parameter | Type | Description |
|---|---|---|
| `$addBracketsWhenRelative` | `bool` | Whether brackets should be added around the component if this path is not absolute. |

Returns `int``|``string``|``null` — The root component, or null if the path is empty.

### unshift()

`public function unshift(string|int $path): void`

Prepends one or more components to the path.

The components to be prepended.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string``|``int` | The components to be prepended. |
