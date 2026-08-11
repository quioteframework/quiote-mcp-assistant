# ValidationMiddleware

> Runs validation before the action executes, and enforces that only validated parameters are reachable afterwards.

Runs validation before the action executes, and enforces that only validated parameters are reachable afterwards.

A failure is turned into the action's handle*Error() view, rendered here rather than by dispatch.

## Synopsis

`class ValidationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Uses | [`RequestDiagnostics`](/api/middleware/request-diagnostics/) |
| Source | `Middleware/ValidationMiddleware.php` |

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
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Validates the request for the routed action and prunes it to the validated parameters. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Validates the request for the routed action and prunes it to the validated parameters.

Requires an ActionDescriptor; without one the request passes through untouched. An ExecutionState is guaranteed on the request. A simple action takes a shortened path that skips validator registration. A decision already recorded on the ExecutionState means validation ran earlier in this request and is not repeated — SecurityMiddleware resets it to pending when it forwards, so a forwarded action is revalidated.

After validation, the canonical WebRequest — possibly replaced by ValidationManager with a pruned instance — becomes the request carried downstream, and the result is stored as `quiote.request_data`. When no validators ran at all, every parameter is cleared rather than passed through: nothing was vetted, so nothing is exposed. This is why reading raw parameters from middleware ordered before this one sees data that later disappears.

On failure the decision carries the errors and the action's `handle*Error()` view is rendered here rather than by DispatchMiddleware.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
