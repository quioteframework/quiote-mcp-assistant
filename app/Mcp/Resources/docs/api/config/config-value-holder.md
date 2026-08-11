# ConfigValueHolder

> ConfigValueHolder is the storage class for the XmlConfigHandler

ConfigValueHolder is the storage class for the XmlConfigHandler

:::caution[Deprecated]
This class is deprecated. Not used anymore by XML config handlers, to be removed in Quiote 1.1
:::

## Synopsis

`class ConfigValueHolder implements ArrayAccess, IteratorAggregate, Stringable`

|  |  |
|---|---|
| Implements | [`ArrayAccess`](https://www.php.net/manual/en/class.arrayaccess.php), [`IteratorAggregate`](https://www.php.net/manual/en/class.iteratoraggregate.php), [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Since | `1.0.0` |
| Source | `Config/ConfigValueHolder.php` |

## Methods

| Method | Description |
|---|---|
| [`__get(string $name): ?ConfigValueHolder`](#get) | Magic getter overload. |
| [`__isset(string $name): bool`](#isset) | isset() overload. |
| [`__toString(): string`](#tostring) | Retrieves the string representation of this value node. |
| [`addChildren(string $name, ConfigValueHolder $children): void`](#addchildren) | Adds a named children to this value. |
| [`appendChildren(ConfigValueHolder $children): void`](#appendchildren) | Adds a unnamed children to this value. |
| [`getAttribute(string $name, mixed $default = null): mixed`](#getattribute) | Retrieve an attribute. |
| [`getAttributes(): array<string, mixed>`](#getattributes) | Retrieve all attributes. |
| [`getChildren(?string $nodename = null): array<int|string, ConfigValueHolder>`](#getchildren) | Returns the children of this value. |
| [`getIterator(): ArrayIterator<int|string, ConfigValueHolder>`](#getiterator) | Returns an Iterator for the child nodes. |
| [`getName(): string`](#getname) | Returns the name of this value. |
| [`getNode(): array{name: string, attributes: array<string, mixed>, children: array<(int | string), ConfigValueHolder>, value: (string | null)}`](#getnode) | Retrieves the info of this value node. |
| [`getValue(): ?string`](#getvalue) | Retrieves the value of this value node. |
| [`hasAttribute(string $name): bool`](#hasattribute) | Indicates whether or not an attribute exists. |
| [`hasChildren(?string $child = null): bool`](#haschildren) | Checks whether the value has children at all (no params) or whether a child with the given name exists. |
| [`offsetExists(string $offset): bool`](#offsetexists) | Determines if a named child exists. |
| [`offsetGet(string $offset): ?ConfigValueHolder`](#offsetget) | Retrieves a named child. |
| [`offsetSet(string $offset, ConfigValueHolder $value): void`](#offsetset) | Inserts a named child. |
| [`offsetUnset(string $offset): void`](#offsetunset) | Deletes a named child. |
| [`setAttribute(string $name, mixed $value): void`](#setattribute) | Set an attribute. |
| [`setName(string $name): void`](#setname) | Sets the name of this value. |
| [`setValue(string $value): void`](#setvalue) | Set the value of this value node. |

### __get()

`public function __get(string $name): ?ConfigValueHolder`

Magic getter overload.

Name of the child.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | Name of the child. |

Returns `?`[`ConfigValueHolder`](/api/config/config-value-holder/) — The child, if it exists.

### __isset()

`public function __isset(string $name): bool`

isset() overload.

Name of the child.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | Name of the child. |

Returns `bool` — Whether or not that child exists.

### __toString()

`public function __toString(): string`

Retrieves the string representation of this value node.

This is currently only the value of the node.

Returns `string` — The string representation.

### addChildren()

`public function addChildren(string $name, ConfigValueHolder $children): void`

Adds a named children to this value.

The child value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the child. |
| `$children` | [`ConfigValueHolder`](/api/config/config-value-holder/) | The child value. |

### appendChildren()

`public function appendChildren(ConfigValueHolder $children): void`

Adds a unnamed children to this value.

The child value.

| Parameter | Type | Description |
|---|---|---|
| `$children` | [`ConfigValueHolder`](/api/config/config-value-holder/) | The child value. |

### getAttribute()

`public function getAttribute(string $name, mixed $default = null): mixed`

Retrieve an attribute.

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$default` | `mixed` | A default attribute value. |

Returns `mixed` — An attribute value, if the attribute exists, otherwise null or the given default.

### getAttributes()

`public function getAttributes(): array<string, mixed>`

Retrieve all attributes.

Returns `array``<``string``, ``mixed``>` — An associative array of attributes.

### getChildren()

`public function getChildren(?string $nodename = null): array<int|string, ConfigValueHolder>`

Returns the children of this value.

Return only the childs matching this node (tag) name.

| Parameter | Type | Description |
|---|---|---|
| `$nodename` | `?``string` | Return only the childs matching this node (tag) name. |

Returns `array``<``int``|``string``, `[`ConfigValueHolder`](/api/config/config-value-holder/)`>` — An array with the childs of this value.

### getIterator()

`public function getIterator(): ArrayIterator<int|string, ConfigValueHolder>`

Returns an Iterator for the child nodes.

From IteratorAggregate.

Returns `ArrayIterator``<``int``|``string``, `[`ConfigValueHolder`](/api/config/config-value-holder/)`>` — The iterator.

### getName()

`public function getName(): string`

Returns the name of this value.

Returns `string` — The name.

### getNode()

`public function getNode(): array{name: string, attributes: array<string, mixed>, children: array<(int | string), ConfigValueHolder>, value: (string | null)}`

Retrieves the info of this value node.

Returns `array{name: string, attributes: array<string, mixed>, children: array<(int | string), ConfigValueHolder>, value: (string | null)}` — An array containing the info for this node.

### getValue()

`public function getValue(): ?string`

Retrieves the value of this value node.

Returns `?``string` — The value of this node, or null if none has been set.

### hasAttribute()

`public function hasAttribute(string $name): bool`

Indicates whether or not an attribute exists.

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `bool` — true, if the attribute exists, otherwise false.

### hasChildren()

`public function hasChildren(?string $child = null): bool`

Checks whether the value has children at all (no params) or whether a child with the given name exists.

The name of the child.

| Parameter | Type | Description |
|---|---|---|
| `$child` | `?``string` | The name of the child. |

Returns `bool` — True if children exist, false if not.

### offsetExists()

`public function offsetExists(string $offset): bool`

Determines if a named child exists.

Offset to check

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `string` | Offset to check |

Returns `bool` — Whether the offset exists.

### offsetGet()

`public function offsetGet(string $offset): ?ConfigValueHolder`

Retrieves a named child.

Offset to retrieve

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `string` | Offset to retrieve |

Returns `?`[`ConfigValueHolder`](/api/config/config-value-holder/) — The child value.

### offsetSet()

`public function offsetSet(string $offset, ConfigValueHolder $value): void`

Inserts a named child.

The child value.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `string` | Offset to modify |
| `$value` | [`ConfigValueHolder`](/api/config/config-value-holder/) | The child value. |

### offsetUnset()

`public function offsetUnset(string $offset): void`

Deletes a named child.

Offset to delete.

| Parameter | Type | Description |
|---|---|---|
| `$offset` | `string` | Offset to delete. |

### setAttribute()

`public function setAttribute(string $name, mixed $value): void`

Set an attribute.

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### setName()

`public function setName(string $name): void`

Sets the name of this value.

The name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name. |

### setValue()

`public function setValue(string $value): void`

Set the value of this value node.

A value.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` | A value. |
