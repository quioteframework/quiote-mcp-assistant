# RouteCollectionIntrospector

> The inverse of RouteCollectionBuilder: lifts the live RouteCollection a configured Routing service exposes back into the routing IR.

The inverse of [`RouteCollectionBuilder`](/api/routing/compiler/route-collection-builder/): lifts the live RouteCollection a configured Routing service exposes back into the routing IR.

That matters for anything that wants to describe *every* route the app actually serves -- OpenAPI generation, say -- rather than only the `#[Route]`-attributed subset an [`AttributeRouteScanner`](/api/routing/compiler/attribute-route-scanner/) pass finds: a hand-written `Routing::build()`, a committed `Routing/Generated/*Routes::addRoutes()` file and merged attribute routes all end up in the same collection, and all come back out as RouteDefinitions here.

`module`/`action`/`outputType` are read back from the `_module`/`_action`/ `_output_type` defaults RouteCollectionBuilder writes (and which Quiote's own dispatch reads), and are dropped from the reported `defaults` so a consumer sees them once, in one place. Nothing that only exists in the source IR -- priority, the source file a route was declared in -- survives a round trip through a RouteCollection, so those come back as 0 and the collection's own source ref.

## Synopsis

`final class RouteCollectionIntrospector`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `Routing/Compiler/RouteCollectionIntrospector.php` |

## Methods

| Method | Description |
|---|---|
| [`toDefinitions(RouteCollection $collection, string $sourceRef = 'RouteCollection'): array<RouteDefinition>`](#todefinitions) |  |

### toDefinitions()

`public function toDefinitions(RouteCollection $collection, string $sourceRef = 'RouteCollection'): array<RouteDefinition>`

| Parameter | Type | Description |
|---|---|---|
| `$collection` | `RouteCollection` |  |
| `$sourceRef` | `string` |  |

Returns `array``<`[`RouteDefinition`](/api/routing/compiler/route-definition/)`>` — In the collection's own (priority-resolved) order.
