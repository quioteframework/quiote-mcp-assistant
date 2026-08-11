# User

> User wraps a client session and provides accessor methods for user attributes.

User wraps a client session and provides accessor methods for user attributes.

It also makes storing and retrieving multiple page form data rather easy by allowing user attributes to be stored in namespaces, which help organize data.

## Synopsis

`class User extends AttributeHolder implements ContextComponentInterface`

|  |  |
|---|---|
| Extends | [`AttributeHolder`](/api/util/attribute-holder/) |
| Implements | [`ContextComponentInterface`](/api/context-component-interface/) |
| Since | `1.0.0` |
| Source | `User/User.php` |

## Methods

| Method | Description |
|---|---|
| [`__sleep(): array`](#sleep) |  |
| [`appendAttribute(mixed $name, mixed $value, mixed $ns = null): void`](#appendattribute) | Appends a value to an array attribute and marks the user dirty. |
| [`appendAttributeByRef(mixed $name, mixed &$value, mixed $ns = null): void`](#appendattributebyref) | Appends a value by reference to an array attribute and marks the user dirty. |
| [`clearAttributes(): void`](#clearattributes) | Removes every attribute in every namespace and marks the user dirty. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getStorageNamespace(): string`](#getstoragenamespace) | Retrieve the Storage namespace |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this User. |
| [`isDirty(): bool`](#isdirty) | Whether this request changed user state that still needs persisting. |
| [`markClean(): void`](#markclean) | Record that in-memory state now matches what is persisted. |
| [`markDirty(): void`](#markdirty) | Force this user to be persisted at the request boundary. |
| [`persistAttributesImmediate(?array<int, string> $onlyKeys = null): void`](#persistattributesimmediate) | Immediately persist current user attributes (or a filtered subset) to storage. |
| [`removeAttribute(mixed $name, mixed $ns = null): mixed`](#removeattribute) | Removes a single attribute and marks the user dirty so the removal is persisted. |
| [`removeAttributeNamespace(mixed $ns): mixed`](#removeattributenamespace) | Removes a whole attribute namespace and marks the user dirty. |
| [`reset(): void`](#reset) | Returns this user to its just-constructed state for reuse across requests. |
| [`restoreContext(Context $context): void`](#restorecontext) | Re-bind context after unserialization without re-running full initialize logic. |
| [`setAttribute(mixed $name, mixed $value, mixed $ns = null): void`](#setattribute) | Sets an attribute and marks the user dirty so shutdown() persists it. |
| [`setAttributeByRef(mixed $name, mixed &$value, mixed $ns = null): void`](#setattributebyref) | Sets an attribute by reference and marks the user dirty. |
| [`setAttributes(array $attributes, mixed $ns = null): void`](#setattributes) | Merges a set of attributes into a namespace and marks the user dirty. |
| [`setAttributesByRef(array &$attributes, mixed $ns = null): void`](#setattributesbyref) | Merges a set of attributes by reference into a namespace and marks the user dirty. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |
| [`startup(): void`](#startup) | Startup the user. |

### __sleep()

`public function __sleep(): array`

Returns `array`

### appendAttribute()

`public function appendAttribute(mixed $name, mixed $value, mixed $ns = null): void`

Appends a value to an array attribute and marks the user dirty.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |
| `$ns` | `mixed` |  |

### appendAttributeByRef()

`public function appendAttributeByRef(mixed $name, mixed &$value, mixed $ns = null): void`

Appends a value by reference to an array attribute and marks the user dirty.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |
| `$ns` | `mixed` |  |

### clearAttributes()

`public function clearAttributes(): void`

Removes every attribute in every namespace and marks the user dirty.

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — An Context instance.

| Throws | When |
|---|---|
| `InitializationException` | If this User has not been initialized yet. |

### getStorageNamespace()

`public function getStorageNamespace(): string`

Retrieve the Storage namespace

Returns `string` — The Storage namespace

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this User.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | An Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing this User. |

### isDirty()

`public function isDirty(): bool`

Whether this request changed user state that still needs persisting.

Returns `bool`

### markClean()

`public function markClean(): void`

Record that in-memory state now matches what is persisted.

### markDirty()

`public function markDirty(): void`

Force this user to be persisted at the request boundary.

The escape valve for a subclass that mutates $attributes, $credentials or $roles directly instead of going through the mutators below -- those writes are invisible to dirty tracking and would otherwise be dropped.

### persistAttributesImmediate()

`public function persistAttributesImmediate(?array<int, string> $onlyKeys = null): void`

Immediately persist current user attributes (or a filtered subset) to storage.

Optional whitelist of attribute keys to persist.

| Parameter | Type | Description |
|---|---|---|
| `$onlyKeys` | `?``array``<``int``, ``string``>` | Optional whitelist of attribute keys to persist. |

### removeAttribute()

`public function removeAttribute(mixed $name, mixed $ns = null): mixed`

Removes a single attribute and marks the user dirty so the removal is persisted.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$ns` | `mixed` |  |

Returns `mixed`

### removeAttributeNamespace()

`public function removeAttributeNamespace(mixed $ns): mixed`

Removes a whole attribute namespace and marks the user dirty.

| Parameter | Type | Description |
|---|---|---|
| `$ns` | `mixed` |  |

Returns `mixed`

### reset()

`public function reset(): void`

Returns this user to its just-constructed state for reuse across requests.

Drops the context reference, parameters and attributes, restores the default storage namespace and clears the dirty flag, so a pooled worker cannot leak one request's identity into the next. Nothing is persisted on the way out -- pending changes are discarded, not flushed.

### restoreContext()

`public function restoreContext(Context $context): void`

Re-bind context after unserialization without re-running full initialize logic.

Called by Context::getUser() fast-restore path when available.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

### setAttribute()

`public function setAttribute(mixed $name, mixed $value, mixed $ns = null): void`

Sets an attribute and marks the user dirty so shutdown() persists it.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |
| `$ns` | `mixed` |  |

### setAttributeByRef()

`public function setAttributeByRef(mixed $name, mixed &$value, mixed $ns = null): void`

Sets an attribute by reference and marks the user dirty.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |
| `$ns` | `mixed` |  |

### setAttributes()

`public function setAttributes(array $attributes, mixed $ns = null): void`

Merges a set of attributes into a namespace and marks the user dirty.

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array` |  |
| `$ns` | `mixed` |  |

### setAttributesByRef()

`public function setAttributesByRef(array &$attributes, mixed $ns = null): void`

Merges a set of attributes by reference into a namespace and marks the user dirty.

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array` |  |
| `$ns` | `mixed` |  |

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure.

### startup()

`public function startup(): void`

Startup the user.

You'd usually try to auth from a cookie here etc.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an attribute. |
| `getAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute names. |
| `getAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getAttributeNamespaces()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute namespaces. |
| `getAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getDefaultNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Get the default namespace name |
| `getFlatAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of flattened attribute names. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute exists. |
| `hasAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute namespace exists. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
