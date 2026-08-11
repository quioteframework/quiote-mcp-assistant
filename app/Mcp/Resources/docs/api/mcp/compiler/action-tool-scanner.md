# ActionToolScanner

> Discovers `#[Route]` action classes that are also decorated with the SDK's own `#[McpTool]` attribute -- \"add one attribute to an existing action\" is the headline feature.

Discovers `#[Route]` action classes that are also decorated with the SDK's own `#[McpTool]` attribute -- "add one attribute to an existing action" is the headline feature.

Modeled on [`AttributeRouteScanner`](/api/routing/compiler/attribute-route-scanner/): reuses it to find every `#[Route]` action, then resolves each one's class the same way [`Controller::createActionInstance()`](/api/controller/controller/#createactioninstance) does and inspects it for `#[McpTool]`.

A no-op (empty result) when `mcp/sdk` isn't installed -- guarded the same way the ORM adapters guard on their optional dependency.

## Synopsis

`final class ActionToolScanner`

|  |  |
|---|---|
| Source | `Compiler/ActionToolScanner.php` |

## Methods

| Method | Description |
|---|---|
| [`scan(Controller $controller, iterable<string>|null $moduleDirs = null): list<ActionToolDefinition>`](#scan) |  |

### scan()

`public function scan(Controller $controller, iterable<string>|null $moduleDirs = null): list<ActionToolDefinition>`

Defaults to [`AttributeRouteScanner`](/api/routing/compiler/attribute-route-scanner/)'s own default.

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$moduleDirs` | `iterable``<``string``>``|``null` | Defaults to [`AttributeRouteScanner`](/api/routing/compiler/attribute-route-scanner/)'s own default. |

Returns `list``<`[`ActionToolDefinition`](/api/mcp/compiler/action-tool-definition/)`>`
