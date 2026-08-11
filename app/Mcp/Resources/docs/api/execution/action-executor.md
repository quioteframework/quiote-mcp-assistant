# ActionExecutor

> ActionExecutor: container-less execution of an action+view producing ActionExecutionContext.

ActionExecutor: container-less execution of an action+view producing ActionExecutionContext.

Current scope (incremental): - Security + validation (optional) via services when enabled. - Simple actions: execute() method. - Non-simple actions: use ActionResolver for method dispatch. - View resolution via ViewNameResolver (pure). - View initialization via legacy container (temporary) if needed until ViewFactory extracted. Future work will remove any dependency on containers entirely.

## Synopsis

`final class ActionExecutor`

|  |  |
|---|---|
| Source | `Execution/ActionExecutor.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller, ?ActionResolver $actionResolver = null, ?ValidationService $validationService = null, ?SecurityService $securityService = null, ?ViewFactory $viewFactory = null, ?ViewNameResolver $viewNameResolver = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$actionResolver` | `?`[`ActionResolver`](/api/execution/action-resolver/) |  |
| `$validationService` | `?`[`ValidationService`](/api/execution/validation-service/) |  |
| `$securityService` | `?`[`SecurityService`](/api/execution/security-service/) |  |
| `$viewFactory` | `?`[`ViewFactory`](/api/execution/view-factory/) |  |
| `$viewNameResolver` | `?`[`ViewNameResolver`](/api/execution/view-name-resolver/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`buildRequestDataFromPsr(ServerRequestInterface $psr, ?Context $context = null): WebRequest`](#buildrequestdatafrompsr) | Build an WebRequest (preferred) from a PSR-7 ServerRequest. |
| [`execute(ActionDescriptor $desc, ServerRequestInterface $request, ExecutionState $state, array<string, mixed> $parameters = [], ?Action $preInstantiatedAction = null): ActionExecutionContext`](#execute) | Execute an action given its descriptor and request data, mutating ExecutionState accordingly. |

### buildRequestDataFromPsr()

`public static function buildRequestDataFromPsr(ServerRequestInterface $psr, ?Context $context = null): WebRequest`

Build an WebRequest (preferred) from a PSR-7 ServerRequest.

The Context actually handling this request (e.g.
       `$this->controller->getContext()` from a middleware that has a Controller).
       Its existing canonical WebRequest is reused when present (avoids rebuilding
       one already created earlier in the same request's pipeline). Previously this
       always reused `Context::getInstance('web')`'s request regardless of which
       context was actually dispatching -- harmless for single-context apps, but for
       any app using more than one named Context, every dispatch after "web" had
       handled its first request would silently reuse "web"'s stale WebRequest (wrong
       parameter whitelist, wrong prior values) instead of the current request's own.
       Omitting $context always builds a fresh WebRequest from $psr -- correct, if
       slightly less optimized, rather than guessing a context that might be wrong.

| Parameter | Type | Description |
|---|---|---|
| `$psr` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$context` | `?`[`Context`](/api/context/) | The Context actually handling this request (e.g. `$this->controller->getContext()` from a middleware that has a Controller). Its existing canonical WebRequest is reused when present (avoids rebuilding one already created earlier in the same request's pipeline). Previously this always reused `Context::getInstance('web')`'s request regardless of which context was actually dispatching -- harmless for single-context apps, but for any app using more than one named Context, every dispatch after "web" had handled its first request would silently reuse "web"'s stale WebRequest (wrong parameter whitelist, wrong prior values) instead of the current request's own. Omitting $context always builds a fresh WebRequest from $psr -- correct, if slightly less optimized, rather than guessing a context that might be wrong. |

Returns [`WebRequest`](/api/request/web-request/)

### execute()

`public function execute(ActionDescriptor $desc, ServerRequestInterface $request, ExecutionState $state, array<string, mixed> $parameters = [], ?Action $preInstantiatedAction = null): ActionExecutionContext`

Execute an action given its descriptor and request data, mutating ExecutionState accordingly.

| Parameter | Type | Description |
|---|---|---|
| `$desc` | [`ActionDescriptor`](/api/execution/action-descriptor/) |  |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$state` | [`ExecutionState`](/api/execution/execution-state/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$preInstantiatedAction` | `?`[`Action`](/api/action/action/) |  |

Returns [`ActionExecutionContext`](/api/execution/action-execution-context/)
