# InitContextAttributeAccess

> The attribute accessor cluster shared by Action and View: a facade over the attributes an execution's init context holds, so an action or view reads and writes them without knowing where they live.

The attribute accessor cluster shared by [`Action`](/api/action/action/) and [`View`](/api/view/view/): a facade over the attributes an execution's init context holds, so an action or view reads and writes them without knowing where they live.

One rule governs every method. Reads answer from `$localAttributes` first and fall back to the init context's holder; writes land in the local store whenever it exists, and go to the holder otherwise. A consumer therefore observes its own write through every reader, whichever accessor it used.

The local store exists for the container-less execution path, where the init context is an immutable snapshot that cannot be written to. Users that never populate it (an action) get holder-backed behaviour throughout, with no branch of their own.

## Synopsis

`trait InitContextAttributeAccess`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Util/InitContextAttributeAccess.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$localAttributes` | `mixed` | _protected._ The consumer's own mutable attribute store, or null when it has none and the init context's holder is the only storage. |

## Methods

| Method | Description |
|---|---|
| [`appendAttribute(string $name, mixed $value): void`](#appendattribute) |  |
| [`appendAttributeByRef(string $name, mixed &$value): void`](#appendattributebyref) |  |
| [`clearAttributes(): void`](#clearattributes) |  |
| [`getAttribute(string $name, mixed $default = null): mixed`](#getattribute) |  |
| [`getAttributeNames(): array<int, int|string>`](#getattributenames) |  |
| [`getAttributes(): array<int|string, mixed>`](#getattributes) |  |
| [`hasAttribute(string $name): bool`](#hasattribute) |  |
| [`removeAttribute(string $name): mixed`](#removeattribute) |  |
| [`setAttribute(string $name, mixed $value): void`](#setattribute) |  |
| [`setAttributeByRef(string $name, mixed &$value): void`](#setattributebyref) |  |
| [`setAttributes(array<int|string, mixed> $attributes): void`](#setattributes) |  |
| [`setAttributesByRef(array<int|string, mixed> &$attributes): void`](#setattributesbyref) |  |

### appendAttribute()

`public function appendAttribute(string $name, mixed $value): void`

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### appendAttributeByRef()

`public function appendAttributeByRef(string $name, mixed &$value): void`

A reference to an attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |

### clearAttributes()

`public function clearAttributes(): void`

### getAttribute()

`public function getAttribute(string $name, mixed $default = null): mixed`

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$default` | `mixed` | A default attribute value. |

Returns `mixed`

### getAttributeNames()

`public function getAttributeNames(): array<int, int|string>`

Returns `array``<``int``, ``int``|``string``>`

### getAttributes()

`public function getAttributes(): array<int|string, mixed>`

Returns `array``<``int``|``string``, ``mixed``>`

### hasAttribute()

`public function hasAttribute(string $name): bool`

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `bool`

### removeAttribute()

`public function removeAttribute(string $name): mixed`

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `mixed` — The removed value, or null when the name was not set.

### setAttribute()

`public function setAttribute(string $name, mixed $value): void`

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### setAttributeByRef()

`public function setAttributeByRef(string $name, mixed &$value): void`

A reference to an attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |

### setAttributes()

`public function setAttributes(array<int|string, mixed> $attributes): void`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` |  |

### setAttributesByRef()

`public function setAttributesByRef(array<int|string, mixed> &$attributes): void`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` |  |
