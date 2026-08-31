# Rendering

> The Quiote\\Exception\\Rendering namespace — 6 documented types.

Everything under `Quiote\Exception\Rendering`.

## Classes

| Class | Description |
|---|---|
| [`ExceptionRendererRegistry`](/api/exception/rendering/exception-renderer-registry/) | Process-global slot for the "developer" and "safe" exception renderers (the ones [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) uses when `core.developer_exceptions` is true or false, respectively), mirroring the static, worker-lifetime pattern of [`DatabaseDriverRegistry`](/api/database/database-driver-registry/) / [`MiddlewareCatalog`](/api/middleware/middleware-catalog/). |
| [`SafeRenderer`](/api/exception/rendering/safe-renderer/) | Default renderer: never leaks exception internals. |

## Interfaces

| Interface | Description |
|---|---|
| [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/) | Turns a caught Throwable into a client-facing PSR-7 response. |

## Traits

| Trait | Description |
|---|---|
| [`NegotiatesContent`](/api/exception/rendering/negotiates-content/) | Shared Accept-header negotiation for exception renderers. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Whoops`](/api/exception/rendering/whoops/) | 2 types |
