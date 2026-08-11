# ViewFactory

> ViewFactory: creates and initializes a view using ImmutableViewInitContext.

ViewFactory: creates and initializes a view using ImmutableViewInitContext.

Thin wrapper to allow future injection of decorators, instrumentation, or pooling.

## Synopsis

`class ViewFactory`

|  |  |
|---|---|
| Source | `Execution/ViewFactory.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`create(string $viewModule, string $viewName, string $actionModule, string $actionName, string $outputType, ?WebRequest $request, array<string, mixed> $actionAttributeSnapshot, ?object $validationManager = null): ?View`](#create) | Create and initialize a view. |

### create()

`public function create(string $viewModule, string $viewName, string $actionModule, string $actionName, string $outputType, ?WebRequest $request, array<string, mixed> $actionAttributeSnapshot, ?object $validationManager = null): ?View`

Create and initialize a view.

Attributes snapshot from action exec

| Parameter | Type | Description |
|---|---|---|
| `$viewModule` | `string` | Resolved module for the view |
| `$viewName` | `string` | Canonical view name |
| `$actionModule` | `string` | Original action module |
| `$actionName` | `string` | Original action name |
| `$outputType` | `string` | Output type name (lowercase) |
| `$request` | `?`[`WebRequest`](/api/request/web-request/) | Request data snapshot |
| `$actionAttributeSnapshot` | `array``<``string``, ``mixed``>` | Attributes snapshot from action exec |
| `$validationManager` | `?``object` |  |

Returns `?`[`View`](/api/view/view/)
