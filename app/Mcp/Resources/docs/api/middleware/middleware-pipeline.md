# MiddlewarePipeline

> MiddlewarePipeline builds and caches the PSR-15 middleware chain; safe for worker reuse.

MiddlewarePipeline builds and caches the PSR-15 middleware chain; safe for worker reuse.

Worker reuse is the part with teeth for anyone writing a middleware: the stack is built once per worker process and every instance in it then serves every request that worker handles, however many users those come from. A middleware is therefore process-scoped, not request-scoped, whatever the usual PSR-15 mental model suggests -- so a `$this->currentUser = $request-> getAttribute(...)`, or a `$this->cached ??= lookup()` memo of anything user-specific, is read back by the next request on that worker and hands one caller another caller's data.

Keep request-scoped values on the request's attribute bag or resolve them per call from the container; reserve instance properties for what is genuinely process-wide (config, a shared connection, a compiled table). A middleware that must hold per-request state anyway can implement `ResetInterface`, and [`MiddlewarePipeline::resetInstances()`](/api/middleware/middleware-pipeline/#resetinstances) clears it at every request boundary.

## Synopsis

`class MiddlewarePipeline implements RequestHandlerInterface`

|  |  |
|---|---|
| Implements | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/MiddlewarePipeline.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`coreMiddlewareClasses(): list<class-string<MiddlewareInterface>>`](#coremiddlewareclasses) | The framework's own shipped middleware classes. |
| [`debugStack(): list<string>`](#debugstack) |  |
| [`guardedMiddlewareClasses(): list<string>`](#guardedmiddlewareclasses) | The full set [`MiddlewareConfigRegistry`](/api/middleware/config/middleware-config-registry/) guards against silent config-driven reordering or disabling. |
| [`handle(ServerRequestInterface $request): ResponseInterface`](#handle) | Runs the request through the middleware stack, building the stack first if needed. |
| [`protectedPackageMiddlewareClasses(): list<string>`](#protectedpackagemiddlewareclasses) | First-party middleware that ships in its own package rather than being built by core. |
| [`reset(): void`](#reset) | Discards the cached stack so the next [`MiddlewarePipeline::handle()`](/api/middleware/middleware-pipeline/#handle) rebuilds it. |
| [`resetInstances(): void`](#resetinstances) | Clears the per-request state of every middleware in the built stack that declares any, by calling `ResetInterface::reset()` on it. |

### coreMiddlewareClasses()

`public static function coreMiddlewareClasses(): list<class-string<MiddlewareInterface>>`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Read [`CoreMiddlewareRegistry::CORE`](/api/middleware/core-middleware-registry/#core) instead.
:::

The framework's own shipped middleware classes.

Returns `list``<``class-string``<`[`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/)`>``>`

### debugStack()

`public function debugStack(): list<string>`

Returns `list``<``string``>`

### guardedMiddlewareClasses()

`public static function guardedMiddlewareClasses(): list<string>`

The full set [`MiddlewareConfigRegistry`](/api/middleware/config/middleware-config-registry/) guards against silent config-driven reordering or disabling.

Returns `list``<``string``>`

### handle()

`public function handle(ServerRequestInterface $request): ResponseInterface`

Runs the request through the middleware stack, building the stack first if needed.

The built stack is cached on the instance for the life of the worker, so only the first request pays for attribute scanning and order resolution; call [`MiddlewarePipeline::reset()`](/api/middleware/middleware-pipeline/#reset) to force a rebuild.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `QuioteException` | If building the stack produced no handler. |

### protectedPackageMiddlewareClasses()

`public static function protectedPackageMiddlewareClasses(): list<string>`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use [`CoreMiddlewareRegistry::pluginProvidedClasses()`](/api/middleware/core-middleware-registry/#pluginprovidedclasses) instead.
:::

First-party middleware that ships in its own package rather than being built by core.

Returns `list``<``string``>`

### reset()

`public function reset(): void`

Discards the cached stack so the next [`MiddlewarePipeline::handle()`](/api/middleware/middleware-pipeline/#handle) rebuilds it.

Needed whenever the inputs to the build have changed — a catalog registration, a middleware config entry, an enable/disable override — since the stack is otherwise kept for the worker's lifetime. The middleware instances themselves are dropped, not reset.

### resetInstances()

`public function resetInstances(): void`

Clears the per-request state of every middleware in the built stack that declares any, by calling `ResetInterface::reset()` on it.

The stack itself is kept -- this is the request boundary, not a rebuild.

Run for each request in a persistent worker, where the instances outlive the request that populated them. A middleware that keeps nothing between calls (the norm, and what [`MiddlewarePipeline`](/api/middleware/middleware-pipeline/) asks for) implements nothing and is skipped.
