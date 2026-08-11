# AttributeHolder

> AttributeHolder provides a base class for managing attributes with namespaces.

AttributeHolder provides a base class for managing attributes with namespaces.

It contains all the functionality ParameterHolder provides.

## Synopsis

`abstract class AttributeHolder extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `Util/AttributeHolder.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attributes` | `mixed` | _protected._ |
| `$defaultNamespace` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`appendAttribute(int|string $name, mixed $value, string $ns = null): void`](#appendattribute) | Append an attribute. |
| [`appendAttributeByRef(int|string $name, mixed &$value, string $ns = null): void`](#appendattributebyref) | Append an attribute by reference. |
| [`clearAttributes(): void`](#clearattributes) | Clear all attributes. |
| [`getAttribute(int|string $name, string $ns = null, mixed $default = null): mixed`](#getattribute) | Retrieve an attribute. |
| [`getAttributeNames(string $ns = null): ?array<int, int|string>`](#getattributenames) | Retrieve an array of attribute names. |
| [`getAttributeNamespace(string $ns = null): array<int|string, mixed>|null`](#getattributenamespace) | Retrieve all attributes within a namespace. |
| [`getAttributeNamespaces(): array<int, string>`](#getattributenamespaces) | Retrieve an array of attribute namespaces. |
| [`getAttributes(string $ns = null): array<int|string, mixed>`](#getattributes) | Retrieve all attributes within a namespace. |
| [`getDefaultNamespace(): string`](#getdefaultnamespace) | Get the default namespace name |
| [`getFlatAttributeNames(string $ns = null): ?array<int, string>`](#getflatattributenames) | Retrieve an array of flattened attribute names. |
| [`hasAttribute(int|string $name, string $ns = null): bool`](#hasattribute) | Indicates whether or not an attribute exists. |
| [`hasAttributeNamespace(string $ns): bool`](#hasattributenamespace) | Indicates whether or not an attribute namespace exists. |
| [`removeAttribute(int|string $name, string $ns = null): mixed`](#removeattribute) | Remove an attribute. |
| [`removeAttributeNamespace(string $ns): mixed`](#removeattributenamespace) | Remove an attribute namespace and all of its associated attributes. |
| [`setAttribute(int|string $name, mixed $value, string $ns = null): void`](#setattribute) | Set an attribute. |
| [`setAttributeByRef(int|string $name, mixed &$value, string $ns = null): void`](#setattributebyref) | Set an attribute by reference. |
| [`setAttributes(array<int|string, mixed> $attributes, string $ns = null): void`](#setattributes) | Set an array of attributes. |
| [`setAttributesByRef(array<int|string, mixed> &$attributes, string $ns = null): void`](#setattributesbyref) | Set an array of attributes by reference. |

### appendAttribute()

`public function appendAttribute(int|string $name, mixed $value, string $ns = null): void`

Append an attribute.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |
| `$ns` | `string` | An attribute namespace. |

### appendAttributeByRef()

`public function appendAttributeByRef(int|string $name, mixed &$value, string $ns = null): void`

Append an attribute by reference.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |
| `$ns` | `string` | An attribute namespace. |

### clearAttributes()

`public function clearAttributes(): void`

Clear all attributes.

### getAttribute()

`public function getAttribute(int|string $name, string $ns = null, mixed $default = null): mixed`

Retrieve an attribute.

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$ns` | `string` | An attribute namespace. |
| `$default` | `mixed` | A default attribute value. |

Returns `mixed` — An attribute value, if the attribute exists, otherwise null.

### getAttributeNames()

`public function getAttributeNames(string $ns = null): ?array<int, int|string>`

Retrieve an array of attribute names.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `string` | An attribute namespace. |

Returns `?``array``<``int``, ``int``|``string``>` — An indexed array of attribute names, if the namespace exists, otherwise null.

### getAttributeNamespace()

`public function getAttributeNamespace(string $ns = null): array<int|string, mixed>|null`

Retrieve all attributes within a namespace.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `string` | An attribute namespace. |

Returns `array``<``int``|``string``, ``mixed``>``|``null` — An associative array of attributes if the namespace exists, otherwise null.

### getAttributeNamespaces()

`public function getAttributeNamespaces(): array<int, string>`

Retrieve an array of attribute namespaces.

Returns `array``<``int``, ``string``>` — An indexed array of attribute namespaces.

### getAttributes()

`public function getAttributes(string $ns = null): array<int|string, mixed>`

Retrieve all attributes within a namespace.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `string` | An attribute namespace. |

Returns `array``<``int``|``string``, ``mixed``>` — An associative array of attributes.

### getDefaultNamespace()

`public function getDefaultNamespace(): string`

Get the default namespace name

Returns `string` — The default namespace name

### getFlatAttributeNames()

`public function getFlatAttributeNames(string $ns = null): ?array<int, string>`

Retrieve an array of flattened attribute names.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `string` | An attribute namespace. |

Returns `?``array``<``int``, ``string``>` — An indexed array of attribute names, if the namespace exists, otherwise null.

### hasAttribute()

`public function hasAttribute(int|string $name, string $ns = null): bool`

Indicates whether or not an attribute exists.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$ns` | `string` | An attribute namespace. |

Returns `bool` — true, if the attribute exists, otherwise false.

### hasAttributeNamespace()

`public function hasAttributeNamespace(string $ns): bool`

Indicates whether or not an attribute namespace exists.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `string` | An attribute namespace. |

Returns `bool` — true, if the namespace exists, otherwise false.

### removeAttribute()

`public function removeAttribute(int|string $name, string $ns = null): mixed`

Remove an attribute.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$ns` | `string` | An attribute namespace. |

Returns `mixed` — An attribute value, if the attribute was removed, otherwise null.

### removeAttributeNamespace()

`public function removeAttributeNamespace(string $ns): mixed`

Remove an attribute namespace and all of its associated attributes.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `string` | An attribute namespace. |

Returns `mixed` — An array with all namespace attributes, if the namespace was removed, or null otherwise.

### setAttribute()

`public function setAttribute(int|string $name, mixed $value, string $ns = null): void`

Set an attribute.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |
| `$ns` | `string` | An attribute namespace. |

### setAttributeByRef()

`public function setAttributeByRef(int|string $name, mixed &$value, string $ns = null): void`

Set an attribute by reference.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `int``|``string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |
| `$ns` | `string` | An attribute namespace. |

### setAttributes()

`public function setAttributes(array<int|string, mixed> $attributes, string $ns = null): void`

Set an array of attributes.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` | An associative array of attributes and their associated values. |
| `$ns` | `string` | An attribute namespace. |

### setAttributesByRef()

`public function setAttributesByRef(array<int|string, mixed> &$attributes, string $ns = null): void`

Set an array of attributes by reference.

An attribute namespace.

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` | An associative array of attributes and references to their associated values. |
| `$ns` | `string` | An attribute namespace. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
