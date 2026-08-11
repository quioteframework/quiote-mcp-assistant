# RoutePlan

> The routing IR: an ordered set of RouteDefinitions gathered from one or more sources (today: an AttributeRouteScanner pass).

The routing IR: an ordered set of RouteDefinitions gathered from one or more sources (today: an AttributeRouteScanner pass).

Both back-ends (RouteCollectionBuilder for the runtime, a future compiled-matcher emitter for `routes:compile`) consume this and this alone.

## Synopsis

`final class RoutePlan`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/RoutePlan.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$routes` | `array` | _readonly._ |
| `$sourceRef` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<RouteDefinition> $routes, string $sourceRef): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `array``<`[`RouteDefinition`](/api/routing/compiler/route-definition/)`>` |  |
| `$sourceRef` | `string` |  |

Returns `mixed`
