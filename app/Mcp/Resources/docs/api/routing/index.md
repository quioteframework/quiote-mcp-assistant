# Routing

> The Quiote\\Routing namespace — 27 documented types.

Everything under `Quiote\Routing`.

## Classes

| Class | Description |
|---|---|
| [`AttributeRoutes`](/api/routing/attribute-routes/) | Entry point for combining #[Route]-attributed actions with hand-written routes in the same Routing subclass. |
| [`AttributeRouting`](/api/routing/attribute-routing/) | Opt-in Routing implementation: builds its RouteCollection + meta by scanning #[Route] attributes on action classes instead of a committed Routing/Generated/ tree. |
| [`CompatRouter`](/api/routing/compat-router/) |  |
| [`HttpRedirectRoutingCallback`](/api/routing/http-redirect-routing-callback/) | HttpRedirectRoutingCallback allows redirection of a matched route to a route or URL. |
| [`Routes`](/api/routing/routes/) | Contract for a class that supplies a complete route table. |
| [`Routing`](/api/routing/routing/) | Base class for an application's route table, and the matcher and URL generator built from it. |
| [`RoutingArraySource`](/api/routing/routing-array-source/) | RoutingArraySource allows you to provide array sources for the routing |
| [`RoutingCallback`](/api/routing/routing-callback/) | RoutingCallback allows you to provide callbacks into the routing |
| [`RoutingCallbackPool`](/api/routing/routing-callback-pool/) | Quiote Routing Callback Pool - Reuses callback instances for performance This class maintains a pool of callback instances to avoid the overhead of creating new instances for each route match. |
| [`RoutingResult`](/api/routing/routing-result/) | Immutable routing result facade providing legacy-like getters. |
| [`RoutingUserSource`](/api/routing/routing-user-source/) | RoutingUserSource allows you to provide an user source for the routing |
| [`RoutingValue`](/api/routing/routing-value/) | Routing values are used internally and, optionally, by users in gen() calls and callbacks to have more control over encoding behavior and values in pre- and postfixes |

## Interfaces

| Interface | Description |
|---|---|
| [`ILegacyRoutingCallback`](/api/routing/i-legacy-routing-callback/) | ILegacyRoutingCallback |
| [`IRoutingSource`](/api/routing/i-routing-source/) | IRoutingSource allows you to provide sources for the routing |
| [`IRoutingValue`](/api/routing/i-routing-value/) | Routing values are used internally and, optionally, by users in gen() calls and callbacks to have more control over encoding behavior and values in pre- and postfixes |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Attribute`](/api/routing/attribute/) | 1 type |
| [`Compiler`](/api/routing/compiler/) | 11 types |
