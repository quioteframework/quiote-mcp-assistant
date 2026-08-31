# PluginRegistrar

> The fluent contribution API handed to PluginInterface::register().

The fluent contribution API handed to [`PluginInterface::register()`](/api/plugin/plugin-interface/#register).

Every method routes to a seam that already exists in the framework — this class adds no new low-level mechanism, it just gives plugins one coherent, discoverable surface for the contribution kinds core itself knows about. A plugin package that owns its own registry (e.g. MCP's [`McpCatalog`](/api/mcp/mcp-catalog/)) is registered by calling that registry directly from [`PluginInterface::register()`](/api/plugin/plugin-interface/#register) instead of gaining a bespoke method here — this class must not grow a method per plugin package, or every package would force a core release to gain a contribution seam. Contributions to *static* seams (config, middleware, events) are applied immediately; contributions that need a per-[`Context`](/api/context/) object (DI services, named HTTP clients) are recorded on [`PluginManager`](/api/plugin/plugin-manager/) and applied when that object is built. Route/command contributions are recorded and consulted by the route scanner / console.

Override rules: config defaults and container services are *set-if-absent*, so app settings/bindings (loaded before plugins) always win, and among plugins the first to contribute a given key/id wins.

## Synopsis

`final class PluginRegistrar`

|  |  |
|---|---|
| Source | `Plugin/PluginRegistrar.php` |

## Constructor

### __construct()

`public function __construct(string $pluginName): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pluginName` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`attributedMiddleware(string $fqcn, ?callable(\Quiote\Context): \Psr\Http\Server\MiddlewareInterface $factory = null): PluginRegistrar`](#attributedmiddleware) | Add an app/plugin middleware class to `#[Middleware]` attribute scanning — ordering comes from the class's own attribute. |
| [`command(string $fqcn): PluginRegistrar`](#command) | Contribute a console command class (see PluginManager::contributedCommands()). |
| [`configDefault(string $key, mixed $value): PluginRegistrar`](#configdefault) | A config default (set-if-absent: app `settings.*` and earlier plugins win). |
| [`databaseDriver(string $alias, class-string<Database> $adapterClass): PluginRegistrar`](#databasedriver) | Register a database driver alias, so `databases.xml` can reference the adapter by a short name (`class="eloquent"`) instead of a fully-qualified class name. |
| [`developerExceptionRenderer(callable(): \Quiote\Exception\Rendering\ExceptionRenderer $factory): PluginRegistrar`](#developerexceptionrenderer) | Register the "developer" exception renderer used by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) when `core.developer_exceptions` is true. |
| [`httpClient(string $name, callable $configurator): PluginRegistrar`](#httpclient) | Configure a named HTTP client (applied to the container's [`HttpClientFactory`](/api/http/client/http-client-factory/)). |
| [`listen(string $eventClass, callable $listener, int $priority = 0): PluginRegistrar`](#listen) | Register an event listener (routes to [`Events::listen()`](/api/event/events/#listen)). |
| [`middleware(string $fqcn, callable $factory, ?string $after = null, ?string $before = null, int $priority = 0): PluginRegistrar`](#middleware) | Insert a middleware at a position (routes to [`MiddlewareCatalog::register()`](/api/middleware/middleware-catalog/#register)). |
| [`moduleDirectory(string $dir): PluginRegistrar`](#moduledirectory) | Contribute a module directory. |
| [`pluginName(): string`](#pluginname) | Returns the name of the plugin whose contributions this registrar records. |
| [`safeExceptionRenderer(callable(): \Quiote\Exception\Rendering\ExceptionRenderer $factory): PluginRegistrar`](#safeexceptionrenderer) | Register the "safe" exception renderer used by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) when `core.developer_exceptions` is false (the default, i.e. |
| [`service(string $id, mixed $concrete, ?string $scope = null, string ...$aliases): PluginRegistrar`](#service) | A DI service default, applied to each context's container when built, and only if that id isn't already bound (app/core win; first plugin wins). |
| [`stateReset(string $label, \Closure(): void $reset): PluginRegistrar`](#statereset) | Contribute a callback that clears a plugin-owned static registry, invoked by [`PluginManager::reset()`](/api/plugin/plugin-manager/#reset). |

### attributedMiddleware()

`public function attributedMiddleware(string $fqcn, ?callable(\Quiote\Context): \Psr\Http\Server\MiddlewareInterface $factory = null): PluginRegistrar`

Add an app/plugin middleware class to `#[Middleware]` attribute scanning — ordering comes from the class's own attribute.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |
| `$factory` | `?``callable(\Quiote\Context): \Psr\Http\Server\MiddlewareInterface` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### command()

`public function command(string $fqcn): PluginRegistrar`

Contribute a console command class (see PluginManager::contributedCommands()).

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### configDefault()

`public function configDefault(string $key, mixed $value): PluginRegistrar`

A config default (set-if-absent: app `settings.*` and earlier plugins win).

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### databaseDriver()

`public function databaseDriver(string $alias, class-string<Database> $adapterClass): PluginRegistrar`

Register a database driver alias, so `databases.xml` can reference the adapter by a short name (`class="eloquent"`) instead of a fully-qualified class name.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |
| `$adapterClass` | `class-string``<`[`Database`](/api/database/database/)`>` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### developerExceptionRenderer()

`public function developerExceptionRenderer(callable(): \Quiote\Exception\Rendering\ExceptionRenderer $factory): PluginRegistrar`

Register the "developer" exception renderer used by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) when `core.developer_exceptions` is true.

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `callable(): \Quiote\Exception\Rendering\ExceptionRenderer` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### httpClient()

`public function httpClient(string $name, callable $configurator): PluginRegistrar`

Configure a named HTTP client (applied to the container's [`HttpClientFactory`](/api/http/client/http-client-factory/)).

Same signature as [`HttpClientFactory::configure()`](/api/http/client/http-client-factory/#configure).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$configurator` | `callable` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### listen()

`public function listen(string $eventClass, callable $listener, int $priority = 0): PluginRegistrar`

Register an event listener (routes to [`Events::listen()`](/api/event/events/#listen)).

| Parameter | Type | Description |
|---|---|---|
| `$eventClass` | `string` |  |
| `$listener` | `callable` |  |
| `$priority` | `int` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### middleware()

`public function middleware(string $fqcn, callable $factory, ?string $after = null, ?string $before = null, int $priority = 0): PluginRegistrar`

Insert a middleware at a position (routes to [`MiddlewareCatalog::register()`](/api/middleware/middleware-catalog/#register)).

$factory is called with the building pipeline's [`Context`](/api/context/) as its argument (ignore it if unneeded — e.g. a single-context feature like MCP captures a fixed context name instead; see `Quiote\Mcp\McpPlugin`).

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |
| `$factory` | `callable` |  |
| `$after` | `?``string` |  |
| `$before` | `?``string` |  |
| `$priority` | `int` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### moduleDirectory()

`public function moduleDirectory(string $dir): PluginRegistrar`

Contribute a module directory.

Its `#[Route]` action classes are then discovered by the attribute route scanner alongside the app's own modules.

| Parameter | Type | Description |
|---|---|---|
| `$dir` | `string` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### pluginName()

`public function pluginName(): string`

Returns the name of the plugin whose contributions this registrar records.

Returns `string`

### safeExceptionRenderer()

`public function safeExceptionRenderer(callable(): \Quiote\Exception\Rendering\ExceptionRenderer $factory): PluginRegistrar`

Register the "safe" exception renderer used by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) when `core.developer_exceptions` is false (the default, i.e.

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `callable(): \Quiote\Exception\Rendering\ExceptionRenderer` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### service()

`public function service(string $id, mixed $concrete, ?string $scope = null, string ...$aliases): PluginRegistrar`

A DI service default, applied to each context's container when built, and only if that id isn't already bound (app/core win; first plugin wins).

$concrete is anything [`Container::set()`](/api/di/container/#set) accepts (instance, class-string, or factory closure). Extra $aliases are bound to $id if not already present.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
| `$concrete` | `mixed` |  |
| `$scope` | `?``string` |  |
| `$aliases` | `string` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)

### stateReset()

`public function stateReset(string $label, \Closure(): void $reset): PluginRegistrar`

Contribute a callback that clears a plugin-owned static registry, invoked by [`PluginManager::reset()`](/api/plugin/plugin-manager/#reset).

| Parameter | Type | Description |
|---|---|---|
| `$label` | `string` |  |
| `$reset` | `\Closure(): void` |  |

Returns [`PluginRegistrar`](/api/plugin/plugin-registrar/)
