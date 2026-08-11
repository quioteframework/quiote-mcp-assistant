# DispatchMiddleware

> DispatchMiddleware runs the requested action.

DispatchMiddleware runs the requested action.

Simple and non-simple actions alike go through ActionExecutor, and caching operates on executor output.

## Synopsis

`class DispatchMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Uses | [`RequestDiagnostics`](/api/middleware/request-diagnostics/) |
| Source | `Middleware/DispatchMiddleware.php` |

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
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Runs the routed action and turns its output into the response. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Runs the routed action and turns its output into the response.

Terminal: `$handler` is never called, so the request stops here and every middleware ordered inside this one is unreachable. Anything that must see the finished response has to be ordered outside it.

Clears the shared global response first, so a status or header left by the previous request in a persistent worker is not read back as this one's; a failure to clear is logged as a warning and dispatch continues. Ensures `quiote.rid` and an ExecutionState on the request. Without an ActionDescriptor the answer is a plain 404.

A non-simple action must have been validated: a pending or absent decision that did not come from a forward yields a 500 saying the validation middleware is missing, and a failed decision renders the action's error view. Simple actions skip that gate. Non-simple responses carry an `X-Quiote-Validation-State` header describing the decision.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
