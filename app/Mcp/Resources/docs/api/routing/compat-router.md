# CompatRouter

> The CompatRouter class in Quiote\\Routing.

The `CompatRouter` class. It carries no description of its own yet.

:::caution[Deprecated]
This class is deprecated. Legacy alias kept temporarily; prefer a Routing subclass (e.g., SandboxRouting). This class will be removed once all factory configs updated.
:::

## Synopsis

`final class CompatRouter extends Routing`

|  |  |
|---|---|
| Extends | [`Routing`](/api/routing/routing/) |
| Source | `Routing/CompatRouter.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addRoute()` | [`Routing`](/api/routing/routing/) | Add a route dynamically. |
| `exportRoutes()` | [`Routing`](/api/routing/routing/) | Export current routing definition (RouteCollection + meta) so RoutingMiddleware can wire it up for dispatch, and so it can be round-tripped back through importRoutes(). |
| `gen()` | [`Routing`](/api/routing/routing/) | URL generation. |
| `genSelf()` | [`Routing`](/api/routing/routing/) |  |
| `getBaseHref()` | [`Routing`](/api/routing/routing/) | Return the absolute origin (scheme://host[:port]) without trailing slash. |
| `getBasePath()` | [`Routing`](/api/routing/routing/) | Returns the path generated URLs are rooted at. |
| `getMeta()` | [`Routing`](/api/routing/routing/) |  |
| `getRequestContext()` | [`Routing`](/api/routing/routing/) | Returns the Symfony request context matching and URL generation run against. |
| `getRoute()` | [`Routing`](/api/routing/routing/) | Retrieve a single route meta entry or null. |
| `getRouteCollection()` | [`Routing`](/api/routing/routing/) | Returns the Symfony route collection the routing matches and generates against. |
| `importRoutes()` | [`Routing`](/api/routing/routing/) | Import an entire RouteCollection + meta array, replacing current state. |
| `initialize()` | [`Routing`](/api/routing/routing/) | Legacy initialize() hook – stores Context & parameters and marks initialized. |
| `isEnabled()` | [`Routing`](/api/routing/routing/) | Indicates whether routing should be considered enabled (subclasses override). |
| `match()` | [`Routing`](/api/routing/routing/) |  |
| `parseRouteString()` | [`Routing`](/api/routing/routing/) |  |
| `reset()` | [`Routing`](/api/routing/routing/) | Reset state for worker reuse (FrankenPHP etc). |
| `startup()` | [`Routing`](/api/routing/routing/) | Legacy startup() hook. |
