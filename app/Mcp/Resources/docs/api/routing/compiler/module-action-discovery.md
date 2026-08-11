# ModuleActionDiscovery

> Filesystem discovery of every `{Module}/Actions/**\\/*Action.php` file under one or more module directories, independent of whether the action carries a #[Route] attribute.

Filesystem discovery of every `{Module}/Actions/**\/*Action.php` file under one or more module directories, independent of whether the action carries a #[Route] attribute.

`AttributeRouteScanner` only surfaces actions that declare a route; introspection consumers (the `cache/introspection/app.json` artifact, triad diagnostics) need the full action inventory per module, so this is a sibling front-end over the same `Actions/` convention rather than a route-scoped one.

## Synopsis

`final class ModuleActionDiscovery`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/ModuleActionDiscovery.php` |

## Methods

| Method | Description |
|---|---|
| [`discover(iterable<string> $moduleDirs, string $namespacePrefix): list<ModuleActionEntry>`](#discover) |  |

### discover()

`public function discover(iterable<string> $moduleDirs, string $namespacePrefix): list<ModuleActionEntry>`

| Parameter | Type | Description |
|---|---|---|
| `$moduleDirs` | `iterable``<``string``>` |  |
| `$namespacePrefix` | `string` |  |

Returns `list``<`[`ModuleActionEntry`](/api/routing/compiler/module-action-entry/)`>`
