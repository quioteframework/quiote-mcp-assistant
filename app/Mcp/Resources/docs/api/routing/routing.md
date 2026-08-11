# Routing

> Base class for an application's route table, and the matcher and URL generator built from it.

Base class for an application's route table, and the matcher and URL generator built from it.

An application subclasses this and implements [`Routing::build()`](/api/routing/routing/#build), returning the Symfony `RouteCollection` plus the parallel meta array holding the Quiote-specific per-route data (generation pattern, parent linkage, the `cut` flag). Typical implementations return a generated route aggregate's `build()` result, merge `#[Route]`-attributed routes into it with [`AttributeRoutes::mergeInto()`](/api/routing/attribute-routes/#mergeinto), or both. The subclass is named in `factories.xml` (`<routing class="..."/>`) and one instance is created per [`Context`](/api/context/); collaborators take it as a constructor dependency or resolve `Routing::class` from the container instead of constructing one.

build() runs from the constructor, so the table is complete before the object is usable. [`Routing::match()`](/api/routing/routing/#match) prefers a precompiled Symfony matcher dumped by `quiote cache:warmup` and falls back to the dynamic matcher when none exists, when the dump no longer matches the route definitions, or when `core.routing.compiled_matcher` is false. [`Routing::addRoute()`](/api/routing/routing/#addroute) and [`Routing::importRoutes()`](/api/routing/routing/#importroutes) change the table at runtime and invalidate the matcher, which is then rebuilt dynamically on the next match; [`Routing::exportRoutes()`](/api/routing/routing/#exportroutes) round-trips the whole table back out.

URL generation is [`Routing::gen()`](/api/routing/routing/#gen) -- by route name, or a self-referential URL when given null -- and [`Routing::genSelf()`](/api/routing/routing/#genself). [`Routing::getBaseHref()`](/api/routing/routing/#getbasehref) composes the absolute origin those URLs are rooted at from the request and its proxy headers, passing the resulting host through the `core.trusted_hosts` allow-list. During a request [`RoutingMiddleware`](/api/middleware/routing-middleware/) drives the matching and keeps the Symfony `RequestContext` returned by [`Routing::getRequestContext()`](/api/routing/routing/#getrequestcontext) in step with the incoming HTTP method.

## Synopsis

`abstract class Routing implements ContextComponentInterface, ResetInterface`

|  |  |
|---|---|
| Implements | [`ContextComponentInterface`](/api/context-component-interface/), `ResetInterface` |
| Source | `Routing/Routing.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | `?`[`Context`](/api/context/) | _protected._ |
| `$initialized` | `bool` | _protected._ |
| `$input` | `string` | _protected._ |
| `$inputParameters` | `array` | _protected._ |
| `$legacyGenerated` | `array` | _protected._ |
| `$parameters` | `array` | _protected._ |
| `$sources` | `array` | _protected._ |
| `$started` | `bool` | _protected._ |

## Constructor

### __construct()

`public function __construct(?RequestContext $requestContext = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$requestContext` | `?``RequestContext` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`addRoute(string $pattern, array<string, mixed> $opts = [], string|null $parent = null): string`](#addroute) | Add a route dynamically. |
| [`build(): array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>}`](#build) |  |
| [`exportRoutes(): array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>}`](#exportroutes) | Export current routing definition (RouteCollection + meta) so RoutingMiddleware can wire it up for dispatch, and so it can be round-tripped back through importRoutes(). |
| [`gen(string|null $route, array<string, mixed> $params = [], array<string, mixed> $options = []): string`](#gen) | URL generation. |
| [`genSelf(?string $routeName, array<string, mixed> $params = [], array<string, mixed> $currentQuery = []): string`](#genself) |  |
| [`getBaseHref(): string`](#getbasehref) | Return the absolute origin (scheme://host[:port]) without trailing slash. |
| [`getBasePath(): string`](#getbasepath) | Returns the path generated URLs are rooted at. |
| [`getMeta(): array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>`](#getmeta) |  |
| [`getRequestContext(): RequestContext`](#getrequestcontext) | Returns the Symfony request context matching and URL generation run against. |
| [`getRoute(string $name): array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}|null`](#getroute) | Retrieve a single route meta entry or null. |
| [`getRouteCollection(): RouteCollection`](#getroutecollection) | Returns the Symfony route collection the routing matches and generates against. |
| [`importRoutes(array<int, mixed> $spec): void`](#importroutes) | Import an entire RouteCollection + meta array, replacing current state. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Legacy initialize() hook – stores Context & parameters and marks initialized. |
| [`isEnabled(): bool`](#isenabled) | Indicates whether routing should be considered enabled (subclasses override). |
| [`match(string $path): array<string, mixed>`](#match) |  |
| [`parseRouteString(string $routeString): array{0: string, 1: string, 2: array<string, array{name: string, pre: string, val: string, post: string, is_optional: bool}>, 3: int}`](#parseroutestring) |  |
| [`reset(): void`](#reset) | Reset state for worker reuse (FrankenPHP etc). |
| [`startup(): void`](#startup) | Legacy startup() hook. |

### addRoute()

`public function addRoute(string $pattern, array<string, mixed> $opts = [], string|null $parent = null): string`

Add a route dynamically.

Parent route name for hierarchy.

| Parameter | Type | Description |
|---|---|---|
| `$pattern` | `string` | Raw pattern (may be relative if parent provided) |
| `$opts` | `array``<``string``, ``mixed``>` | Route options: name (optional), module, action, defaults[] etc. |
| `$parent` | `string``|``null` | Parent route name for hierarchy. |

Returns `string` — Final route name.

| Throws | When |
|---|---|
| `QuioteException` | on conflicting duplicate name with different parent. |

### build()

`abstract protected function build(): array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>}`

Returns `array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>}`

### exportRoutes()

`public function exportRoutes(): array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>}`

Export current routing definition (RouteCollection + meta) so RoutingMiddleware can wire it up for dispatch, and so it can be round-tripped back through importRoutes().

Returns `array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>}`

### gen()

`public function gen(string|null $route, array<string, mixed> $params = [], array<string, mixed> $options = []): string`

URL generation.

| Parameter | Type | Description |
|---|---|---|
| `$route` | `string``|``null` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |
| `$options` | `array``<``string``, ``mixed``>` |  |

Returns `string`

### genSelf()

`public function genSelf(?string $routeName, array<string, mixed> $params = [], array<string, mixed> $currentQuery = []): string`

| Parameter | Type | Description |
|---|---|---|
| `$routeName` | `?``string` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |
| `$currentQuery` | `array``<``string``, ``mixed``>` |  |

Returns `string`

### getBaseHref()

`public function getBaseHref(): string`

Return the absolute origin (scheme://host[:port]) without trailing slash.

Historically this returned just '/', but modern usage (templates, redirects) expects a fully qualified origin for constructing absolute URLs.

Returns `string`

### getBasePath()

`public function getBasePath(): string`

Returns the path generated URLs are rooted at.

Always `/`. Use [`Routing::getBaseHref()`](/api/routing/routing/#getbasehref) for the absolute origin (scheme, host and port) needed to build a fully qualified URL.

Returns `string`

### getMeta()

`public function getMeta(): array<string, array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}>`

Returns `array``<``string``, ``array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}``>`

### getRequestContext()

`public function getRequestContext(): RequestContext`

Returns the Symfony request context matching and URL generation run against.

The same instance the routing keeps, so mutating it (scheme, host, base URL, path info) changes how subsequent matches and generated URLs resolve.

Returns `RequestContext`

### getRoute()

`public function getRoute(string $name): array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}|null`

Retrieve a single route meta entry or null.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `array{gen_path: string, cut: bool, path: string, opt?: array{parent: (string | null), action: mixed}, pattern?: string, match_full?: string, match_partial?: string}``|``null`

### getRouteCollection()

`public function getRouteCollection(): RouteCollection`

Returns the Symfony route collection the routing matches and generates against.

Returns `RouteCollection`

### importRoutes()

`public function importRoutes(array<int, mixed> $spec): void`

Import an entire RouteCollection + meta array, replacing current state.

| Parameter | Type | Description |
|---|---|---|
| `$spec` | `array``<``int``, ``mixed``>` |  |

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Legacy initialize() hook – stores Context & parameters and marks initialized.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

### isEnabled()

`public function isEnabled(): bool`

Indicates whether routing should be considered enabled (subclasses override).

Returns `bool`

### match()

`public function match(string $path): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `array``<``string``, ``mixed``>`

### parseRouteString()

`public function parseRouteString(string $routeString): array{0: string, 1: string, 2: array<string, array{name: string, pre: string, val: string, post: string, is_optional: bool}>, 3: int}`

| Parameter | Type | Description |
|---|---|---|
| `$routeString` | `string` |  |

Returns `array{0: string, 1: string, 2: array<string, array{name: string, pre: string, val: string, post: string, is_optional: bool}>, 3: int}`

### reset()

`public function reset(): void`

Reset state for worker reuse (FrankenPHP etc).

### startup()

`public function startup(): void`

Legacy startup() hook.

Marks started, no heavy logic needed.
