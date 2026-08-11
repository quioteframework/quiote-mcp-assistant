# MiddlewareCatalog

> MiddlewareCatalog stores enable/disable flags for middleware FQCNs, settable programmatically via MiddlewareCatalog::initialize() (tests, app bootstrap code), so the runtime pipeline builder can cheaply skip optional middlewares.

MiddlewareCatalog stores enable/disable flags for middleware FQCNs, settable programmatically via [`MiddlewareCatalog::initialize()`](/api/middleware/middleware-catalog/#initialize) (tests, app bootstrap code), so the runtime pipeline builder can cheaply skip optional middlewares.

Unknown classes default to enabled (backwards compatible). Declarative `middleware.xml` enable/disable is a separate, higher-level mechanism (see [`MiddlewareConfigRegistry`](/api/middleware/config/middleware-config-registry/)) that merges into a [`MiddlewareDefinition`](/api/middleware/compiler/middleware-definition/)'s own `enabled` field rather than this map -- this map still wins when both are present (see the precedence check in [`MiddlewarePipeline::doBuild()`](/api/middleware/middleware-pipeline/#dobuild)).

## Synopsis

`class MiddlewareCatalog`

|  |  |
|---|---|
| Source | `Middleware/MiddlewareCatalog.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `REPLACE_CORE_STACK_ACKNOWLEDGEMENT` | `'I_UNDERSTAND_THIS_DISCARDS_ERROR_HANDLING_SESSIONS_CSRF_S…'` | The exact string [`MiddlewareCatalog::replaceCoreStack()`](/api/middleware/middleware-catalog/#replacecorestack) requires as its second argument. |

## Methods

| Method | Description |
|---|---|
| [`all(): array<string, bool>`](#all) | Raw map mainly for tests. |
| [`attributedFactory(string $fqcn): callable(Context): \Psr\Http\Server\MiddlewareInterface|null`](#attributedfactory) |  |
| [`buildCoreStack(Context $context): list<MiddlewareInterface>`](#buildcorestack) | Invoke the app-supplied replacement factory. |
| [`getAttributedCandidates(): array<string>`](#getattributedcandidates) |  |
| [`getRegistered(): array<string, array{fqcn: string, factory: callable, after: ?string, before: ?string, priority: int}>`](#getregistered) |  |
| [`hasCoreStackOverride(): bool`](#hascorestackoverride) | Whether an app has installed a full core-stack replacement via [`MiddlewareCatalog::replaceCoreStack()`](/api/middleware/middleware-catalog/#replacecorestack). |
| [`hasOverride(string $fqcn): bool`](#hasoverride) | Whether $fqcn has an explicit enabled/disabled entry via [`MiddlewareCatalog::initialize()`](/api/middleware/middleware-catalog/#initialize). |
| [`initialize(array<string, bool> $map): void`](#initialize) | Initialize the catalog (idempotent overwrite). |
| [`isEnabled(string $fqcn): bool`](#isenabled) | Whether a middleware is enabled; unknown => true. |
| [`register(string $fqcn, callable $factory, string|null $after = null, string|null $before = null, int $priority = 0): void`](#register) | Register a custom middleware to be inserted into the pipeline. |
| [`registerAttributed(string $fqcn, ?callable(Context): \Psr\Http\Server\MiddlewareInterface $factory = null): void`](#registerattributed) | Register an app/plugin middleware class as a candidate for `#[Middleware]` attribute scanning. |
| [`replaceCoreStack(callable(Context): list<\Psr\Http\Server\MiddlewareInterface> $factory, string $acknowledgement): void`](#replacecorestack) | Replaces Quiote's ENTIRE built-in middleware stack — including ErrorHandlingMiddleware, SessionMiddleware, CSRF, SecurityMiddleware, and RoutingMiddleware — with one supplied by the application. |
| [`reset(): void`](#reset) | Clear all registered middleware (mainly for tests). |

### all()

`public static function all(): array<string, bool>`

Raw map mainly for tests.

Returns `array``<``string``, ``bool``>`

### attributedFactory()

`public static function attributedFactory(string $fqcn): callable(Context): \Psr\Http\Server\MiddlewareInterface|null`

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `callable(Context): \Psr\Http\Server\MiddlewareInterface``|``null` — The custom factory for $fqcn, if one was supplied to [`MiddlewareCatalog::registerAttributed()`](/api/middleware/middleware-catalog/#registerattributed).

### buildCoreStack()

`public static function buildCoreStack(Context $context): list<MiddlewareInterface>`

Invoke the app-supplied replacement factory.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `list``<`[`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/)`>`

### getAttributedCandidates()

`public static function getAttributedCandidates(): array<string>`

Returns `array``<``string``>` — FQCNs registered via [`MiddlewareCatalog::registerAttributed()`](/api/middleware/middleware-catalog/#registerattributed).

### getRegistered()

`public static function getRegistered(): array<string, array{fqcn: string, factory: callable, after: ?string, before: ?string, priority: int}>`

Returns `array``<``string``, ``array{fqcn: string, factory: callable, after: ?string, before: ?string, priority: int}``>`

### hasCoreStackOverride()

`public static function hasCoreStackOverride(): bool`

Whether an app has installed a full core-stack replacement via [`MiddlewareCatalog::replaceCoreStack()`](/api/middleware/middleware-catalog/#replacecorestack).

Returns `bool`

### hasOverride()

`public static function hasOverride(string $fqcn): bool`

Whether $fqcn has an explicit enabled/disabled entry via [`MiddlewareCatalog::initialize()`](/api/middleware/middleware-catalog/#initialize).

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `bool`

### initialize()

`public static function initialize(array<string, bool> $map): void`

Initialize the catalog (idempotent overwrite).

| Parameter | Type | Description |
|---|---|---|
| `$map` | `array``<``string``, ``bool``>` |  |

### isEnabled()

`public static function isEnabled(string $fqcn): bool`

Whether a middleware is enabled; unknown => true.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `bool`

### register()

`public static function register(string $fqcn, callable $factory, string|null $after = null, string|null $before = null, int $priority = 0): void`

Register a custom middleware to be inserted into the pipeline.

Ordering among registered middleware at the same position (lower = earlier)

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` | Fully-qualified class name (used as key + debug label) |
| `$factory` | `callable` | Factory that returns a PSR-15 MiddlewareInterface |
| `$after` | `string``|``null` | Insert after this middleware FQCN in the stack |
| `$before` | `string``|``null` | Insert before this middleware FQCN in the stack |
| `$priority` | `int` | Ordering among registered middleware at the same position (lower = earlier) |

### registerAttributed()

`public static function registerAttributed(string $fqcn, ?callable(Context): \Psr\Http\Server\MiddlewareInterface $factory = null): void`

Register an app/plugin middleware class as a candidate for `#[Middleware]` attribute scanning.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |
| `$factory` | `?``callable(Context): \Psr\Http\Server\MiddlewareInterface` |  |

### replaceCoreStack()

`public static function replaceCoreStack(callable(Context): list<\Psr\Http\Server\MiddlewareInterface> $factory, string $acknowledgement): void`

Replaces Quiote's ENTIRE built-in middleware stack — including ErrorHandlingMiddleware, SessionMiddleware, CSRF, SecurityMiddleware, and RoutingMiddleware — with one supplied by the application.

Returns the complete ordered stack. Quiote still appends a terminal
       sentinel after it so the pipeline always yields a response instead
       of silently returning null — that's a PSR-15 contract requirement,
       not an opinion about what your stack should contain. Externally
       [`MiddlewareCatalog::register()`](/api/middleware/middleware-catalog/#register)-ed middleware is NOT spliced in when this is
       active; if you want it, add it inside $factory yourself.

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `callable(Context): list<\Psr\Http\Server\MiddlewareInterface>` | Returns the complete ordered stack. Quiote still appends a terminal sentinel after it so the pipeline always yields a response instead of silently returning null — that's a PSR-15 contract requirement, not an opinion about what your stack should contain. Externally [`MiddlewareCatalog::register()`](/api/middleware/middleware-catalog/#register)-ed middleware is NOT spliced in when this is active; if you want it, add it inside $factory yourself. |
| `$acknowledgement` | `string` |  |

| Throws | When |
|---|---|
| `InvalidArgumentException` | if $acknowledgement doesn't match exactly. |

### reset()

`public static function reset(): void`

Clear all registered middleware (mainly for tests).
