# SlotDispatcher

> Dynamic optional action extension points used via method_exists():

Dynamic optional action extension points used via method_exists():

## Synopsis

`class SlotDispatcher`

|  |  |
|---|---|
| Source | `Execution/SlotDispatcher.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `RECURSION_LIMIT` | `10` |  |

## Constructor

### __construct()

`public function __construct(Controller $controller, ?ActionResolver $actionResolver = null, ?SlotExecutionGuard $executionGuard = null, ?ViewNameResolver $viewNameResolver = null, ?ForwardService $forwardService = null, ?ViewFactory $viewFactory = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$actionResolver` | `?`[`ActionResolver`](/api/execution/action-resolver/) |  |
| `$executionGuard` | `?`[`SlotExecutionGuard`](/api/execution/slot-execution-guard/) |  |
| `$viewNameResolver` | `?`[`ViewNameResolver`](/api/execution/view-name-resolver/) |  |
| `$forwardService` | `?`[`ForwardService`](/api/execution/forward-service/) |  |
| `$viewFactory` | `?`[`ViewFactory`](/api/execution/view-factory/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`dispatch(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): string`](#dispatch) | Dispatch a slot (sub-action) and return its response content. |
| [`dispatchSlotContent(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): SlotContent`](#dispatchslotcontent) | New API: dispatch and return SlotContent value object instead of raw string. |
| [`dispatchSlotContext(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): SlotExecutionContext`](#dispatchslotcontext) | Experimental: dispatch slot and return SlotExecutionContext (immutable) for richer metadata. |
| [`dispatchWithContext(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): ActionExecutionContext`](#dispatchwithcontext) | Experimental API: identical to dispatch() but returns ActionExecutionContext alongside content. |

### dispatch()

`public function dispatch(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): string`

Dispatch a slot (sub-action) and return its response content.

Optional output type override.

| Parameter | Type | Description |
|---|---|---|
| `$parentRequest` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The parent PSR request containing SlotStack attribute. |
| `$module` | `string` | Module name. |
| `$action` | `string` | Action name. |
| `$parameters` | `array``<``string``, ``mixed``>` | Optional associative array of request parameters for the slot. |
| `$outputType` | `?``string` | Optional output type override. |

Returns `string`

### dispatchSlotContent()

`public function dispatchSlotContent(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): SlotContent`

New API: dispatch and return SlotContent value object instead of raw string.

| Parameter | Type | Description |
|---|---|---|
| `$parentRequest` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$outputType` | `?``string` |  |

Returns [`SlotContent`](/api/execution/slot-content/)

### dispatchSlotContext()

`public function dispatchSlotContext(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): SlotExecutionContext`

Experimental: dispatch slot and return SlotExecutionContext (immutable) for richer metadata.

| Parameter | Type | Description |
|---|---|---|
| `$parentRequest` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$outputType` | `?``string` |  |

Returns [`SlotExecutionContext`](/api/execution/slot-execution-context/)

### dispatchWithContext()

`public function dispatchWithContext(ServerRequestInterface $parentRequest, string $module, string $action, array<string, mixed> $parameters = [], ?string $outputType = null): ActionExecutionContext`

Experimental API: identical to dispatch() but returns ActionExecutionContext alongside content.

| Parameter | Type | Description |
|---|---|---|
| `$parentRequest` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$outputType` | `?``string` |  |

Returns [`ActionExecutionContext`](/api/execution/action-execution-context/)
