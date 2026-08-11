# SlotExecutionContext

> Immutable context returned by SlotDispatcher for container-less execution.

Immutable context returned by SlotDispatcher for container-less execution.

Mirrors ActionExecutionContext but focused on slot semantics.

## Synopsis

`final readonly class SlotExecutionContext`

|  |  |
|---|---|
| Source | `Execution/SlotExecutionContext.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) | _readonly._ |
| `$actionAttributes` | `array` | _readonly._ |
| `$actionName` | `string` | _readonly._ |
| `$content` | `string` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$outputType` | `string` | _readonly._ |
| `$parameters` | `array` | _readonly._ |
| `$request` | [`WebRequest`](/api/request/web-request/) | _readonly._ |
| `$view` | `?`[`View`](/api/view/view/) | _readonly._ |
| `$viewModuleName` | `?``string` | _readonly._ |
| `$viewName` | `?``string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(Action $action, ?View $view, string $module, string $actionName, string $outputType, WebRequest $request, string $content, ?string $viewModuleName = null, ?string $viewName = null, array<string, mixed> $actionAttributes = [], array<string, mixed> $parameters = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) |  |
| `$view` | `?`[`View`](/api/view/view/) |  |
| `$module` | `string` |  |
| `$actionName` | `string` |  |
| `$outputType` | `string` |  |
| `$request` | [`WebRequest`](/api/request/web-request/) |  |
| `$content` | `string` |  |
| `$viewModuleName` | `?``string` |  |
| `$viewName` | `?``string` |  |
| `$actionAttributes` | `array``<``string``, ``mixed``>` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`
