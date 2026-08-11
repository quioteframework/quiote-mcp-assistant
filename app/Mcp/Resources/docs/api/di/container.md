# Container

> Small scope-aware DI container: supports definitions as closures, class names, or instances.

Small scope-aware DI container: supports definitions as closures, class names, or instances.

## Synopsis

`class Container implements ContainerInterface`

|  |  |
|---|---|
| Implements | [`ContainerInterface`](https://www.php-fig.org/psr/psr-11/) |
| Source | `DI/Container.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `SCOPE_REQUEST` | `'request'` |  |
| `SCOPE_SINGLETON` | `'singleton'` |  |
| `SCOPE_TRANSIENT` | `'transient'` |  |

## Methods

| Method | Description |
|---|---|
| [`alias(string $abstract, string $concrete): void`](#alias) | Point one id at another, so resolving $abstract resolves $concrete's binding. |
| [`forgetResolved(string $id): void`](#forgetresolved) | Forget an instance already resolved for $id, keeping the binding that produced it. |
| [`get(string $id): mixed`](#get) | Resolve a service. |
| [`has(string $id): bool`](#has) | PSR-11 has(): reflects only explicitly registered entries (definitions/aliases), not autowireable classes. |
| [`make(class-string<T> $class, array<string, mixed> $extraParams = []): T`](#make) | Build a fresh, never-cached instance of $class. |
| [`reset(): void`](#reset) | Drops request-scoped resolved instances (called on worker-mode request boundaries). |
| [`set(string $id, mixed $concrete, ?string $scope = null, array<string, mixed> $params = []): void`](#set) | Bind something under an id. |
| [`setFactory(string $id, callable $factory, ?string $scope = null): void`](#setfactory) | Bind a factory under an id. |
| [`tryGet(string $id): mixed`](#tryget) | Resolve $id, or null when it cannot be resolved. |
| [`unset(string $id): void`](#unset) | Forget a binding, and any instance already resolved from it. |

### alias()

`public function alias(string $abstract, string $concrete): void`

Point one id at another, so resolving $abstract resolves $concrete's binding.

The alias is followed on every lookup -- resolution, instance forgetting and [`Container::has()`](/api/di/container/#has) -- and one alias per abstract id is kept, so calling this again for the same abstract replaces the previous target. The target does not have to be bound yet.

| Parameter | Type | Description |
|---|---|---|
| `$abstract` | `string` |  |
| `$concrete` | `string` |  |

### forgetResolved()

`public function forgetResolved(string $id): void`

Forget an instance already resolved for $id, keeping the binding that produced it.

The narrow counterpart to [`Container::unset()`](/api/di/container/#unset), for a factory-backed service whose answer has changed underneath the container. Publishing a replacement request is the case it exists for: the request is request-scoped so the captive-dependency guard refuses a singleton that captures it, which means the container *does* memoize it -- and the memo has to be dropped, not the binding, or the factory would be replaced by whatever was published and the rebuild path would be gone.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

### get()

`public function get(string $id): mixed`

Resolve a service.

A class name, an interface name, or a role alias.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` | A class name, an interface name, or a role alias. |

Returns `mixed` — The resolved service.

### has()

`public function has(string $id): bool`

PSR-11 has(): reflects only explicitly registered entries (definitions/aliases), not autowireable classes.

Use canAutowire() for the internal autowiring path.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

Returns `bool`

### make()

`public function make(class-string<T> $class, array<string, mixed> $extraParams = []): T`

Build a fresh, never-cached instance of $class.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `class-string``<``T``>` |  |
| `$extraParams` | `array``<``string``, ``mixed``>` |  |

Returns `T`

### reset()

`public function reset(): void`

Drops request-scoped resolved instances (called on worker-mode request boundaries).

Singletons and definitions are untouched.

### set()

`public function set(string $id, mixed $concrete, ?string $scope = null, array<string, mixed> $params = []): void`

Bind something under an id.

Constructor parameters, for a class name.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
| `$concrete` | `mixed` | An instance, a class name to autowire, or a factory callable. |
| `$scope` | `?``string` | One of the SCOPE_* constants, or null to let the binding decide. |
| `$params` | `array``<``string``, ``mixed``>` | Constructor parameters, for a class name. |

### setFactory()

`public function setFactory(string $id, callable $factory, ?string $scope = null): void`

Bind a factory under an id.

One of the SCOPE_* constants, or null for the default.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
| `$factory` | `callable` |  |
| `$scope` | `?``string` | One of the SCOPE_* constants, or null for the default. |

### tryGet()

`public function tryGet(string $id): mixed`

Resolve $id, or null when it cannot be resolved.

A class name, an interface name, or a role alias.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` | A class name, an interface name, or a role alias. |

Returns `mixed` — The resolved service, or null.

### unset()

`public function unset(string $id): void`

Forget a binding, and any instance already resolved from it.

The counterpart to [`Container::set()`](/api/di/container/#set), and needed because binding null is not the same thing: an id naming a class promises an instance of it, so `set($id, null)` is refused on the way out rather than quietly answering null. "There is no session manager configured" has to be the *absence* of a binding, which is what [`Container::tryGet()`](/api/di/container/#tryget) answers null for.

Mostly a test concern -- `Context::setSessionManager(null)` used to be how a suite dropped one -- but it is the honest primitive for it either way.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
