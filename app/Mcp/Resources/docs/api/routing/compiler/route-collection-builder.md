# RouteCollectionBuilder

> Runtime back-end: turns a RoutePlan into the [RouteCollection, meta] pair Routing::build() already expects (the same pair the committed Routing/Generated/*Routes::addRoutes() files produce).

Runtime back-end: turns a RoutePlan into the [RouteCollection, meta] pair Routing::build() already expects (the same pair the committed Routing/Generated/*Routes::addRoutes() files produce).

Neither Routing nor the Symfony UrlMatcher built from its output care that these routes came from #[Route] attributes instead of hand-generated PHP.

## Synopsis

`final class RouteCollectionBuilder`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/RouteCollectionBuilder.php` |

## Methods

| Method | Description |
|---|---|
| [`build(RoutePlan $plan): array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string}>}`](#build) |  |
| [`mergeInto(RouteCollection $routes, array<string, array{gen_path: string, cut: bool, path: string}> &$meta, RoutePlan $plan): void`](#mergeinto) | Adds a RoutePlan's routes into an already-populated RouteCollection + meta pair, instead of building a fresh one. |

### build()

`public function build(RoutePlan $plan): array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string}>}`

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`RoutePlan`](/api/routing/compiler/route-plan/) |  |

Returns `array{0: RouteCollection, 1: array<string, array{gen_path: string, cut: bool, path: string}>}`

### mergeInto()

`public function mergeInto(RouteCollection $routes, array<string, array{gen_path: string, cut: bool, path: string}> &$meta, RoutePlan $plan): void`

Adds a RoutePlan's routes into an already-populated RouteCollection + meta pair, instead of building a fresh one.

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `RouteCollection` |  |
| `$meta` | `array``<``string``, ``array{gen_path: string, cut: bool, path: string}``>` |  |
| `$plan` | [`RoutePlan`](/api/routing/compiler/route-plan/) |  |
