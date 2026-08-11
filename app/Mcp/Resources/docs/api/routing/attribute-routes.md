# AttributeRoutes

> Entry point for combining #[Route]-attributed actions with hand-written routes in the same Routing subclass.

Entry point for combining #[Route]-attributed actions with hand-written routes in the same Routing subclass.

Attribute routing (Quiote\Routing\AttributeRouting) and programmatic/file-based routing (a plain Routing::build() like samples/app's AppRouting) are not mutually exclusive: a Routing::build() implementation can add its own routes to a RouteCollection by hand and then call mergeInto() to pull in every #[Route]-attributed action on top, all in one RouteCollection + meta pair.

## Synopsis

`final class AttributeRoutes`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/AttributeRoutes.php` |

## Methods

| Method | Description |
|---|---|
| [`mergeInto(RouteCollection $routes, array<string, array{gen_path: string, cut: bool, path: string}> &$meta, iterable<string>|null $moduleDirs = null): array<Diagnostic>`](#mergeinto) |  |

### mergeInto()

`public static function mergeInto(RouteCollection $routes, array<string, array{gen_path: string, cut: bool, path: string}> &$meta, iterable<string>|null $moduleDirs = null): array<Diagnostic>`

Defaults to [core.module_dir].

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `RouteCollection` |  |
| `$meta` | `array``<``string``, ``array{gen_path: string, cut: bool, path: string}``>` |  |
| `$moduleDirs` | `iterable``<``string``>``|``null` | Defaults to [core.module_dir]. |

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded while scanning (duplicate route names/paths among the attribute routes themselves -- collisions against the hand-written routes already in $routes are not detected here, same as two hand-written addRoute() calls with the same name silently overwriting each other).
