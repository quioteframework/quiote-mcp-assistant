# ExceptionRendererRegistry

> Process-global slot for the \"developer\" and \"safe\" exception renderers (the ones ErrorHandlingMiddleware uses when `core.developer_exceptions` is true or false, respectively), mirroring the static, worker-lifetime pattern of DatabaseDriverRegistry / MiddlewareCatalog.

Process-global slot for the "developer" and "safe" exception renderers (the ones [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) uses when `core.developer_exceptions` is true or false, respectively), mirroring the static, worker-lifetime pattern of [`DatabaseDriverRegistry`](/api/database/database-driver-registry/) / [`MiddlewareCatalog`](/api/middleware/middleware-catalog/).

This exists so core never hard-references a concrete renderer class (e.g. `WhoopsRenderer`) directly. A plugin contributes a developer renderer via [`PluginRegistrar::developerExceptionRenderer()`](/api/plugin/plugin-registrar/#developerexceptionrenderer) and a safe/production renderer via [`PluginRegistrar::safeExceptionRenderer()`](/api/plugin/plugin-registrar/#safeexceptionrenderer); first registration wins for each (set-if-absent), matching the override rule every other plugin seam uses. If nothing is registered for the relevant slot, [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) falls back to [`SafeRenderer`](/api/exception/rendering/safe-renderer/).

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
| [`hasSafeRenderer(): bool`](#hassaferenderer) | Reports whether a safe-renderer factory has been registered. |
| [`reset(): void`](#reset) | Test isolation. |
| [`safeRenderer(): ExceptionRenderer|null`](#saferenderer) |  |
| [`setDeveloperRenderer(callable $factory): void`](#setdeveloperrenderer) | Register the developer-renderer factory. |
| [`setSafeRenderer(callable $factory): void`](#setsaferenderer) | Register the safe/production-renderer factory. |

### developerRenderer()

`public static function developerRenderer(): ExceptionRenderer|null`

Returns [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/)`|``null` — Null if nothing has registered a developer renderer.

### hasDeveloperRenderer()

`public static function hasDeveloperRenderer(): bool`

Reports whether a developer-renderer factory has been registered.

Answers from the stored factory without invoking it, so asking the question never constructs a renderer.

Returns `bool`

### hasSafeRenderer()

`public static function hasSafeRenderer(): bool`

Reports whether a safe-renderer factory has been registered.

Answers from the stored factory without invoking it, so asking the question never constructs a renderer.

Returns `bool`

### reset()

`public static function reset(): void`

Test isolation.

### safeRenderer()

`public static function safeRenderer(): ExceptionRenderer|null`

Returns [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/)`|``null` — Null if nothing has registered a safe renderer.

### setDeveloperRenderer()

`public static function setDeveloperRenderer(callable $factory): void`

Register the developer-renderer factory.

Set-if-absent: first caller wins.

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `callable` |  |

### setSafeRenderer()

`public static function setSafeRenderer(callable $factory): void`

Register the safe/production-renderer factory.

Set-if-absent: first caller wins.

| Parameter | Type | Description |
|---|---|---|
| `$factory` | `callable` |  |
