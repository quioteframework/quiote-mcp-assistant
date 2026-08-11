# AttributeRouting

> Opt-in Routing implementation: builds its RouteCollection + meta by scanning #[Route] attributes on action classes instead of a committed Routing/Generated/ tree.

Opt-in Routing implementation: builds its RouteCollection + meta by scanning #[Route] attributes on action classes instead of a committed Routing/Generated/ tree.

An app switches to attribute routing by extending this (or using it directly) in place of its own generated-routes subclass. A future `routes:compile` artifact is expected to supersede the live scan done here for production, with this remaining the always-correct fallback.

## Synopsis

`class AttributeRouting extends Routing`

|  |  |
|---|---|
| Extends | [`Routing`](/api/routing/routing/) |
| Since | `1.0.0` |
| Source | `Routing/AttributeRouting.php` |

## Methods

| Method | Description |
|---|---|
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded while scanning for routes.

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
