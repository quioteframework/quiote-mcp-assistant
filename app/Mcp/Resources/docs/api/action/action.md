# Action

> Base class for an application's actions: the unit that runs the business logic of one routed request and names the view that presents the result.

Base class for an application's actions: the unit that runs the business logic of one routed request and names the view that presents the result.

An application subclasses this and implements one or more `execute<Token>()` methods -- `executeRead()`, `executeWrite()`, `executeUpdate()`, `executeRemove()` for the tokens [`HttpMethodMapper`](/api/execution/http-method-mapper/) derives from the HTTP verb, plus any custom token that mapping is extended with -- or a single `execute()` handling every verb. None of them is declared here: [`ActionResolver`](/api/execution/action-resolver/) invokes the first one the subclass actually implements and falls back to [`Action::getDefaultViewName()`](/api/action/action/#getdefaultviewname) when it finds none. Such a method takes the [`WebRequest`](/api/request/web-request/) and returns the view to render, either as a name or as a `[module, view]` pair naming a view in another module.

The framework builds the instance through the container, so constructor dependencies are autowired, then calls [`Action::initialize()`](/api/action/action/#initialize) with the [`ActionInitContext`](/api/execution/action-init-context/) for this dispatch and consults the hooks a subclass may override: [`Action::isSecure()`](/api/action/action/#issecure) and [`Action::getCredentials()`](/api/action/action/#getcredentials) for authorization, [`Action::isSimple()`](/api/action/action/#issimple), [`Action::registerValidators()`](/api/action/action/#registervalidators) and [`Action::validate()`](/api/action/action/#validate) for validation, [`Action::handleError()`](/api/action/action/#handleerror) for the path taken when validation fails, and [`Action::isCacheable()`](/api/action/action/#iscacheable), [`Action::cacheTtlSeconds()`](/api/action/action/#cachettlseconds) and [`Action::cacheVaryByUser()`](/api/action/action/#cachevarybyuser) for output caching. Every one has a working default, so a subclass overrides only what it needs.

[`Action::registerValidators()`](/api/action/action/#registervalidators) is the one default with real behaviour: it loads the module's compiled or hand-written validator-builder file for this action and registers the validators derived from a `#[MapRequest]` DTO parameter, so an override that still wants those must call `parent::registerValidators()`.

An instance serves a single dispatch, and [`Action::reset()`](/api/action/action/#reset) drops the request-scoped context so a persistent worker never carries one request's state into the next -- per-request data belongs in local variables or on the request, not in properties that outlive it.

## Synopsis

`abstract class Action implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Uses | [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/) |
| Source | `Action/Action.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | `mixed` | _protected._ |
| `$initContext` | `mixed` | _protected._ |
| `$localAttributes` | `mixed` | _protected._ The consumer's own mutable attribute store, or null when it has none and the init context's holder is the only storage. |

## Methods

| Method | Description |
|---|---|
| [`appendAttribute(string $name, mixed $value): void`](#appendattribute) |  |
| [`appendAttributeByRef(string $name, mixed &$value): void`](#appendattributebyref) |  |
| [`cacheTtlSeconds(?string $outputType = null): ?int`](#cachettlseconds) | TTL (seconds) for cached content when isCacheable() returns true. |
| [`cacheVaryByUser(?string $outputType = null): bool`](#cachevarybyuser) | Whether cached output for this action must be partitioned per user. |
| [`clearAttributes(): void`](#clearattributes) |  |
| [`getAttribute(string $name, mixed $default = null): mixed`](#getattribute) |  |
| [`getAttributeNames(): array<int, int|string>`](#getattributenames) |  |
| [`getAttributes(): array<int|string, mixed>`](#getattributes) |  |
| [`getContainer(): ?ActionInitContext`](#getcontainer) | Backward compatible accessor (legacy name) for the init context. |
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`getCredentials(): mixed`](#getcredentials) | Retrieve the credential required to access this action. |
| [`getDefaultViewName(): mixed`](#getdefaultviewname) | Get the default View name if this Action doesn't serve the Request method. |
| [`getInitContext(): ?ActionInitContext`](#getinitcontext) | Retrieve the initialization context for this action. |
| [`handleError(WebRequest $rd): mixed`](#handleerror) | Execute any post-validation error application logic. |
| [`hasAttribute(string $name): bool`](#hasattribute) |  |
| [`initialize(ActionInitContext $context): void`](#initialize) | Initialize this action with a lightweight initialization context. |
| [`isCacheable(?string $outputType = null): bool`](#iscacheable) | Indicates whether this action's output may be cached. |
| [`isSecure(): bool`](#issecure) | Indicates that this action requires security. |
| [`isSimple(): bool`](#issimple) | Whether or not this action is "simple", i.e. |
| [`registerValidators(): void`](#registervalidators) | Manually register validators for this action. |
| [`removeAttribute(string $name): mixed`](#removeattribute) |  |
| [`reset(): void`](#reset) | Reset action state for FrankenPHP worker compatibility. |
| [`setAttribute(string $name, mixed $value): void`](#setattribute) |  |
| [`setAttributeByRef(string $name, mixed &$value): void`](#setattributebyref) |  |
| [`setAttributes(array<int|string, mixed> $attributes): void`](#setattributes) |  |
| [`setAttributesByRef(array<int|string, mixed> &$attributes): void`](#setattributesbyref) |  |
| [`validate(WebRequest $request): bool`](#validate) | Manually validate files and parameters. |

### appendAttribute()

`public function appendAttribute(string $name, mixed $value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### appendAttributeByRef()

`public function appendAttributeByRef(string $name, mixed &$value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

A reference to an attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |

### cacheTtlSeconds()

`public function cacheTtlSeconds(?string $outputType = null): ?int`

TTL (seconds) for cached content when isCacheable() returns true.

Default null (framework default handling).

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?``string` |  |

Returns `?``int`

### cacheVaryByUser()

`public function cacheVaryByUser(?string $outputType = null): bool`

Whether cached output for this action must be partitioned per user.

The output type being rendered, or null.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?``string` | The output type being rendered, or null. |

Returns `bool` — True to partition the cache per user.

### clearAttributes()

`public function clearAttributes(): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

### getAttribute()

`public function getAttribute(string $name, mixed $default = null): mixed`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$default` | `mixed` | A default attribute value. |

Returns `mixed`

### getAttributeNames()

`public function getAttributeNames(): array<int, int|string>`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

Returns `array``<``int``, ``int``|``string``>`

### getAttributes()

`public function getAttributes(): array<int|string, mixed>`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

Returns `array``<``int``|``string``, ``mixed``>`

### getContainer()

`final public function getContainer(): ?ActionInitContext`

Backward compatible accessor (legacy name) for the init context.

Returns `?`[`ActionInitContext`](/api/execution/action-init-context/)

### getContext()

`final public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

### getCredentials()

`public function getCredentials(): mixed`

Retrieve the credential required to access this action.

Returns `mixed` — Data that indicates the level of security for this action.

### getDefaultViewName()

`public function getDefaultViewName(): mixed`

Get the default View name if this Action doesn't serve the Request method.

Returns `mixed` — A string containing the view name associated with this action. Or an array with the following indices: - The parent module of the view that will be executed. - The view that will be executed.

### getInitContext()

`final public function getInitContext(): ?ActionInitContext`

Retrieve the initialization context for this action.

Returns `?`[`ActionInitContext`](/api/execution/action-init-context/)

### handleError()

`public function handleError(WebRequest $rd): mixed`

Execute any post-validation error application logic.

The action's request data holder.

| Parameter | Type | Description |
|---|---|---|
| `$rd` | [`WebRequest`](/api/request/web-request/) | The action's request data holder. |

Returns `mixed` — A string containing the view name associated with this action. Or an array with the following indices: - The parent module of the view that will be executed. - The view that will be executed.

### hasAttribute()

`public function hasAttribute(string $name): bool`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `bool`

### initialize()

`public function initialize(ActionInitContext $context): void`

Initialize this action with a lightweight initialization context.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`ActionInitContext`](/api/execution/action-init-context/) |  |

### isCacheable()

`public function isCacheable(?string $outputType = null): bool`

Indicates whether this action's output may be cached.

Default false. Framework middleware will call this unconditionally (no method_exists guard).

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?``string` |  |

Returns `bool`

### isSecure()

`public function isSecure(): bool`

Indicates that this action requires security.

Returns `bool` — true, if this action requires security, otherwise false.

### isSimple()

`public function isSimple(): bool`

Whether or not this action is "simple", i.e.

doesn't use validation etc.

Returns `bool` — true, if this action should act in simple mode, or false.

### registerValidators()

`public function registerValidators(): void`

Manually register validators for this action.

The default implementation loads a compiled/hand-written PHP validator-builder file for this module/action, if one exists at %core.module_dir%/{Module}/Validate/{Action}.generated.php (or the hand-written .php variant of the same name) -- see CompiledValidatorRegistry. This runs alongside (not instead of) any XML validators.xml for the same action; both add to the same ValidationManager instance.

Override this (or register[Method]Validators(), e.g. registerWriteValidators()) to register validators directly in PHP via Quiote\Validator\Compiler\Runtime\ValidatorBuilder without a generated file at all -- call parent::registerValidators() first if you still want the file-based ones loaded too.

### removeAttribute()

`public function removeAttribute(string $name): mixed`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |

Returns `mixed` — The removed value, or null when the name was not set.

### reset()

`public function reset(): void`

Reset action state for FrankenPHP worker compatibility.

Clears request-specific properties that could leak between requests.

### setAttribute()

`public function setAttribute(string $name, mixed $value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

An attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | An attribute value. |

### setAttributeByRef()

`public function setAttributeByRef(string $name, mixed &$value): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

A reference to an attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$value` | `mixed` | A reference to an attribute value. |

### setAttributes()

`public function setAttributes(array<int|string, mixed> $attributes): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` |  |

### setAttributesByRef()

`public function setAttributesByRef(array<int|string, mixed> &$attributes): void`

Composed in from [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/).

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``int``|``string``, ``mixed``>` |  |

### validate()

`public function validate(WebRequest $request): bool`

Manually validate files and parameters.

The action's request data holder.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`WebRequest`](/api/request/web-request/) | The action's request data holder. |

Returns `bool` — true, if validation completed successfully, otherwise false.
