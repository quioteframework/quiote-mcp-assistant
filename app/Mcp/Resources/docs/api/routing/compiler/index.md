# Compiler

> The Quiote\\Routing\\Compiler namespace — 11 documented types.

Everything under `Quiote\Routing\Compiler`.

## Classes

| Class | Description |
|---|---|
| [`AttributeRouteScanner`](/api/routing/compiler/attribute-route-scanner/) | Discovers #[Route] attributes on action classes under one or more module directories and builds a RoutePlan from them. |
| [`CompiledMatcherDumper`](/api/routing/compiler/compiled-matcher-dumper/) | Back-end that dumps a RouteCollection to a Symfony CompiledUrlMatcher blob (the same technique Symfony's own router uses: a static-prefix tree + merged regexes emitted as plain PHP, so matching is opcache-native instead of iterating/compiling the collection at runtime). |
| [`ModuleActionDiscovery`](/api/routing/compiler/module-action-discovery/) | Filesystem discovery of every `{Module}/Actions/**\/*Action.php` file under one or more module directories, independent of whether the action carries a #[Route] attribute. |
| [`ModuleActionEntry`](/api/routing/compiler/module-action-entry/) | One `{Module}/Actions/...Action.php` file found by [`ModuleActionDiscovery`](/api/routing/compiler/module-action-discovery/), before any attempt to load or reflect it. |
| [`RouteCollectionBuilder`](/api/routing/compiler/route-collection-builder/) | Runtime back-end: turns a RoutePlan into the [RouteCollection, meta] pair Routing::build() already expects (the same pair the committed Routing/Generated/*Routes::addRoutes() files produce). |
| [`RouteCollectionIntrospector`](/api/routing/compiler/route-collection-introspector/) | The inverse of [`RouteCollectionBuilder`](/api/routing/compiler/route-collection-builder/): lifts the live RouteCollection a configured Routing service exposes back into the routing IR. |
| [`RouteDefinition`](/api/routing/compiler/route-definition/) | Format-independent description of one route, whatever front-end produced it (today: a #[Route] attribute; later, possibly routing.xml or a programmatic builder). |
| [`RoutePlan`](/api/routing/compiler/route-plan/) | The routing IR: an ordered set of RouteDefinitions gathered from one or more sources (today: an AttributeRouteScanner pass). |
| [`RoutingIrDumper`](/api/routing/compiler/routing-ir-dumper/) | Dumps/loads the routing IR (a RoutePlan's RouteDefinitions) as an opcache-friendly `return [...]` PHP artifact, so AttributeRouting::build() can skip AttributeRouteScanner's live scan (recursive glob() per module Actions/ tree, require_once + ReflectionClass per action class) on every Routing construction -- a per-request cost under classic PHP-FPM. |
| [`TriadDiagnosticsScanner`](/api/routing/compiler/triad-diagnostics-scanner/) | Diagnoses the Action/View/Template triad convention (`Actions/{Action}Action.php` <-> `Views/{Action}{ViewName}View.php` <-> `Templates/{Action}{ViewName}.php`) for every action [`ModuleActionDiscovery`](/api/routing/compiler/module-action-discovery/) finds, independent of whether the action is ever actually routed to. |
| [`TriadViewResolver`](/api/routing/compiler/triad-view-resolver/) | Shared Action -> View -> Template resolution for the triad convention (`Actions/{Action}Action.php` <-> `Views/{Action}{ViewName}View.php` <-> `Templates/{Action}{ViewName}.php`), used by both [`TriadDiagnosticsScanner`](/api/routing/compiler/triad-diagnostics-scanner/) (which only needs existence) and `Quiote\Introspection\AppIntrospectionCompiler` (which needs the resolved file paths for the introspection artifact), so the naming convention is decoded in exactly one place. |
