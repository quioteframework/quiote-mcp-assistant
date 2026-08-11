# ActionToolAdapter

> The actions-as-tools bridge (the headline feature): maps one `tools/call` to a specific `#[Route]` action's own execution path.

The actions-as-tools bridge (the headline feature): maps one `tools/call` to a specific `#[Route]` action's own execution path.

Rather than reaching into `ActionExecutor` directly -- which requires preconditions (a canonical WebRequest, a validation decision) that only `Context::handle()`'s own middleware pipeline satisfies -- this builds a synthetic PSR-7 request and drives it through that exact same pipeline, so the action gets the real DI, verb dispatch, and validation a normal HTTP call would get, for free.

One instance is registered per discovered action-tool (see [`ActionToolScanner`](/api/mcp/compiler/action-tool-scanner/)), each bound to its own route name and primary HTTP method at construction time -- unlike a `[class, method]` catalog handler, which mcp/sdk always re-resolves fresh per call and so can't carry per-registration configuration like this.

## Synopsis

`final class ActionToolAdapter implements ToolHandlerInterface`

|  |  |
|---|---|
| Implements | `ToolHandlerInterface` |
| Source | `Bridge/ActionToolAdapter.php` |

## Constructor

### __construct()

`public function __construct(string $contextName, string $routeName, string $httpMethod): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$contextName` | `string` |  |
| `$routeName` | `string` |  |
| `$httpMethod` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`execute(array<string, mixed> $arguments, ClientGateway $gateway): mixed`](#execute) |  |

### execute()

`public function execute(array<string, mixed> $arguments, ClientGateway $gateway): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$arguments` | `array``<``string``, ``mixed``>` |  |
| `$gateway` | `ClientGateway` |  |

Returns `mixed`
