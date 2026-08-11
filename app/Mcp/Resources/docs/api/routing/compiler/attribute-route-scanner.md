# AttributeRouteScanner

> Discovers #[Route] attributes on action classes under one or more module directories and builds a RoutePlan from them.

Discovers #[Route] attributes on action classes under one or more module directories and builds a RoutePlan from them.

This is the first front-end for the routing IR -- a future RoutingConfigHandler (XML) or programmatic builder would feed the same RoutePlan shape without either back-end (RouteCollectionBuilder, the compiled-matcher emitter) needing to change.

module/action are derived from a class's location, mirroring Controller::createActionInstance()'s reverse mapping: {namespace_prefix}\Modules\{Module}\Actions\{Namespaced\Action}Action <-> %core.module_dir%/{Module}/Actions/{Namespaced/Action}Action.php A nested action file (Actions/Index/AddAction.php) yields the dotted action name "Index.Add", matching Toolkit::canonicalName()'s '.' <-> '/' convention used throughout the rest of routing/dispatch.

## Synopsis

`final class AttributeRouteScanner`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/AttributeRouteScanner.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CODE_DUPLICATE_ROUTE_NAME` | `'DUPLICATE_ROUTE_NAME'` |  |
| `CODE_DUPLICATE_ROUTE_PATH` | `'DUPLICATE_ROUTE_PATH'` |  |

## Methods

| Method | Description |
|---|---|
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |
| [`scan(iterable<string>|null $moduleDirs = null): RoutePlan`](#scan) |  |

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded during the last scan().

### scan()

`public function scan(iterable<string>|null $moduleDirs = null): RoutePlan`

Directories each containing
       `{Module}/Actions/**\/*Action.php` subtrees; defaults to
       [core.module_dir].

| Parameter | Type | Description |
|---|---|---|
| `$moduleDirs` | `iterable``<``string``>``|``null` | Directories each containing `{Module}/Actions/**\/*Action.php` subtrees; defaults to [core.module_dir]. |

Returns [`RoutePlan`](/api/routing/compiler/route-plan/)
