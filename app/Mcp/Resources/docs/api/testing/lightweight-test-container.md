# LightweightTestContainer

> A minimal stand-in for the execution container, used only by the PHPUnit test harness.

A minimal stand-in for the execution container, used only by the PHPUnit test harness.

It implements just enough of the attribute and validation-manager surface that tests exercising them — assertContainerAttribute*, argument validation assertions — run without fatally erroring.

Scope: - Attribute holder semantics. Namespaces are ignored; tests in this codebase use a null namespace consistently. Supporting them would mean storing nested arrays. - Request method storage (setRequestMethod/getRequestMethod), for reflective test usage. - A validation manager stub exposing getReport() with the two methods ActionTestCase reads: isArgumentValidated() and isArgumentFailed().

The validation report answers false to every query. A test expecting a validated argument therefore fails rather than silently passing, which points at the missing emulation instead of hiding it.

## Synopsis

`class LightweightTestContainer`

|  |  |
|---|---|
| Source | `Testing/LightweightTestContainer.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`appendAttribute(string $name, mixed $value): void`](#appendattribute) |  |
| [`appendAttributeByRef(string $name, mixed &$value): void`](#appendattributebyref) |  |
| [`clearArguments(): void`](#cleararguments) | Drops the stored argument snapshot, so getArguments() reports null again rather than an empty array. |
| [`clearAttributes(): void`](#clearattributes) | Removes every attribute, leaving getAttributeNames() empty. |
| [`getArguments(): array<string, mixed>|null`](#getarguments) |  |
| [`getAttribute(string $name, mixed $namespace = null, mixed $default = null): mixed`](#getattribute) |  |
| [`getAttributeNames(): array<string>`](#getattributenames) |  |
| [`getAttributes(): array<string, mixed>`](#getattributes) |  |
| [`getRequestMethod(): string`](#getrequestmethod) | Returns the request method the container was told to report; `read` until setRequestMethod() says otherwise. |
| [`getValidationManager(): object`](#getvalidationmanager) | Returns the validation manager, building a stub on first access if none was injected. |
| [`hasAttribute(string $name, mixed $namespace = null): bool`](#hasattribute) |  |
| [`removeAttribute(string $name): mixed`](#removeattribute) |  |
| [`setArguments(array<string, mixed> $args): void`](#setarguments) |  |
| [`setAttribute(string $name, mixed $value): void`](#setattribute) |  |
| [`setAttributeByRef(string $name, mixed &$value): void`](#setattributebyref) |  |
| [`setAttributes(array<string, mixed> $attributes): void`](#setattributes) |  |
| [`setAttributesByRef(array<string, mixed> &$attributes): void`](#setattributesbyref) |  |
| [`setRequestMethod(string $method): void`](#setrequestmethod) | Sets the request method getRequestMethod() reports. |
| [`setValidationManager(object $vm): void`](#setvalidationmanager) | Injects the validation manager getValidationManager() returns. |

### appendAttribute()

`public function appendAttribute(string $name, mixed $value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### appendAttributeByRef()

`public function appendAttributeByRef(string $name, mixed &$value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### clearArguments()

`public function clearArguments(): void`

Drops the stored argument snapshot, so getArguments() reports null again rather than an empty array.

### clearAttributes()

`public function clearAttributes(): void`

Removes every attribute, leaving getAttributeNames() empty.

The request method and stored arguments are untouched.

### getArguments()

`public function getArguments(): array<string, mixed>|null`

Returns `array``<``string``, ``mixed``>``|``null`

### getAttribute()

`public function getAttribute(string $name, mixed $namespace = null, mixed $default = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$namespace` | `mixed` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getAttributeNames()

`public function getAttributeNames(): array<string>`

Returns `array``<``string``>`

### getAttributes()

`public function getAttributes(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getRequestMethod()

`public function getRequestMethod(): string`

Returns the request method the container was told to report; `read` until setRequestMethod() says otherwise.

Returns `string`

### getValidationManager()

`public function getValidationManager(): object`

Returns the validation manager, building a stub on first access if none was injected.

The stub is created lazily and kept, so the same instance — and the same report — is returned on every call. Its report answers false to every query, so a test that expects an argument to have been validated fails rather than passing on emulation.

Returns `object`

### hasAttribute()

`public function hasAttribute(string $name, mixed $namespace = null): bool`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$namespace` | `mixed` |  |

Returns `bool`

### removeAttribute()

`public function removeAttribute(string $name): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `mixed`

### setArguments()

`public function setArguments(array<string, mixed> $args): void`

| Parameter | Type | Description |
|---|---|---|
| `$args` | `array``<``string``, ``mixed``>` |  |

### setAttribute()

`public function setAttribute(string $name, mixed $value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### setAttributeByRef()

`public function setAttributeByRef(string $name, mixed &$value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### setAttributes()

`public function setAttributes(array<string, mixed> $attributes): void`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``string``, ``mixed``>` |  |

### setAttributesByRef()

`public function setAttributesByRef(array<string, mixed> &$attributes): void`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``string``, ``mixed``>` |  |

### setRequestMethod()

`public function setRequestMethod(string $method): void`

Sets the request method getRequestMethod() reports.

The value is stored verbatim; nothing validates or normalizes it.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |

### setValidationManager()

`public function setValidationManager(object $vm): void`

Injects the validation manager getValidationManager() returns.

Call this before the first getValidationManager() to keep the always-false stub from being built; calling it afterwards replaces the stub for subsequent reads. Any object exposing `getReport()` is accepted — the container never inspects it.

| Parameter | Type | Description |
|---|---|---|
| `$vm` | `object` |  |
