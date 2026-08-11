# ActionExecutionContext

> Lightweight DTO for container-less slot execution path.

Lightweight DTO for container-less slot execution path.

## Synopsis

`class ActionExecutionContext`

|  |  |
|---|---|
| Source | `Execution/ActionExecutionContext.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) | _readonly._ |
| `$actionAttributes` | `array` | _readonly._ |
| `$actionName` | `string` | _readonly._ |
| `$attributeBag` | `?`[`AttributeBag`](/api/execution/attribute-bag/) | _readonly._ |
| `$content` | `string` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$outputType` | `string` | _readonly._ |
| `$redirect` | `?``array` | _readonly._ |
| `$request` | [`WebRequest`](/api/request/web-request/) | _readonly._ |
| `$responseHandle` | `?`[`ResponseHandle`](/api/execution/response-handle/) | _readonly._ |
| `$view` | `?`[`View`](/api/view/view/) |  |
| `$viewModuleName` | `?``string` | _readonly._ |
| `$viewName` | `?``string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(Action $action, ?View $view, string $module, string $actionName, string $outputType, WebRequest $request, string $content, ?string $viewModuleName = null, ?string $viewName = null, array<string, mixed> $actionAttributes = [], ?AttributeBag $attributeBag = null, ?ResponseHandle $responseHandle = null, array<string, mixed>|null $redirect = null): mixed`

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
| `$attributeBag` | `?`[`AttributeBag`](/api/execution/attribute-bag/) |  |
| `$responseHandle` | `?`[`ResponseHandle`](/api/execution/response-handle/) |  |
| `$redirect` | `array``<``string``, ``mixed``>``|``null` |  |

Returns `mixed`
