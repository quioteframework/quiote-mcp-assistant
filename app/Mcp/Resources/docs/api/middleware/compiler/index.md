# Compiler

> The Quiote\\Middleware\\Compiler namespace — 5 documented types.

Everything under `Quiote\Middleware\Compiler`.

## Classes

| Class | Description |
|---|---|
| [`MiddlewareAttributeScanner`](/api/middleware/compiler/middleware-attribute-scanner/) | Reflects a list of candidate classes for `#[Middleware]` attributes and builds the `MiddlewareDefinition`s that `MiddlewareOrderResolver` sorts into a pipeline order. |
| [`MiddlewareDefinition`](/api/middleware/compiler/middleware-definition/) | The scanned contents of one `#[Middleware]` attribute, plus the class it was found on and where it was discovered — mirrors `Quiote\Routing\Compiler\RouteDefinition`'s role for `#[Route]`. |
| [`MiddlewareOrderException`](/api/middleware/compiler/middleware-order-exception/) | Thrown by MiddlewareOrderResolver when a `#[Middleware]` ordering constraint cannot be honoured and there is no safe fallback: either the `before`/`after` constraints form a cycle, or a *guarded* (framework) middleware's constraint names something that isn't there. |
| [`MiddlewareOrderResolver`](/api/middleware/compiler/middleware-order-resolver/) | Turns scanned `MiddlewareDefinition`s into a single pipeline order. |
| [`MiddlewarePhase`](/api/middleware/compiler/middleware-phase/) | Canonical ordering of the `phase` values accepted by `Quiote\Middleware\Attribute\Middleware`. |
