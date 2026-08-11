# ExceptionRendererRegistry

> Process-global slot for the \"developer\" exception renderer (the one ErrorHandlingMiddleware uses when `core.developer_exceptions` is true), mirroring the static, worker-lifetime pattern of DatabaseDriverRegistry / MiddlewareCatalog.

Process-global slot for the "developer" exception renderer (the one [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) uses when `core.developer_exceptions` is true), mirroring the static, worker-lifetime pattern of [`DatabaseDriverRegistry`](/api/database/database-driver-registry/) / [`MiddlewareCatalog`](/api/middleware/middleware-catalog/).

This exists so core never hard-references a concrete renderer class (e.g. `WhoopsRenderer`) directly. A plugin contributes a renderer via [`PluginRegistrar::developerExceptionRenderer()`](/api/plugin/plugin-registrar/#developerexceptionrenderer); first registration wins (set-if-absent), matching the override rule every other plugin seam uses. If nothing is registered — or `core.developer_exceptions` is off — [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) falls back to [`SafeRenderer`](/api/exception/rendering/safe-renderer/).

## Synopsis

`final class ExceptionRendererRegistry`

|  |  |
|---|---|
| Source | `Exception/Rendering/ExceptionRendererRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`developerRenderer(): ExceptionRenderer|null`](#developerrenderer) |  |
| [`hasDeveloperRenderer(): bool`](#hasdeveloperrenderer) | Reports whether a developer-renderer factory has been registered. |
| [`reset(): void`](#reset) | Test isolation. |
| [`setDeveloperRenderer(callable $factory): void`](#setdeveloperrenderer) | Register the developer-renderer factory. |

### developerRenderer()

`public static function developerRenderer(): ExceptionRenderer|null`

Returns [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/)`|``null` — Null if nothing has registered a developer renderer.

### hasDeveloperRenderer()

`public static function hasDeveloperRenderer(): bool`

Reports whether a developer-renderer factory has been registered.

Answers from the stored factory without invoking it, so asking the question never constructs a renderer.

Returns `bool`

### reset()

`public static function reset(): void`

Test isolation.

### setDeveloperRenderer()

`public static function setDeveloperRenderer(callable $factory): void`

Register the developer-renderer factory.

Set-if-absent: first caller wins.

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `callable` |  |
