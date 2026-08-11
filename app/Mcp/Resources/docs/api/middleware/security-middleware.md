# SecurityMiddleware

> Security middleware: evaluates action security requirements and forwards unauthenticated/unauthorized requests to login/secure system actions.

Security middleware: evaluates action security requirements and forwards unauthenticated/unauthorized requests to login/secure system actions.

## Synopsis

`class SecurityMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Uses | [`RequestDiagnostics`](/api/middleware/request-diagnostics/) |
| Source | `Middleware/SecurityMiddleware.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller, ?SecurityService $securityService = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$securityService` | `?`[`SecurityService`](/api/execution/security-service/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Evaluates the routed action's security requirements and forwards when they are not met. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Evaluates the routed action's security requirements and forwards when they are not met.

Requires an ActionDescriptor attribute; without one the request passes straight through unexamined. Ensures a `quiote.rid` correlation attribute exists, then builds and initializes the action instance so its `isSecure()`/`getCredentials()` can be consulted, caching it on the request as `quiote.preinstantiated_action` for DispatchMiddleware to reuse.

With `core.use_security` off, everything is allowed. If the action could not be instantiated the decision fails closed rather than falling back to "authenticated is good enough": an anonymous caller is sent to the login forward, an authenticated one to the secure forward. The decision is recorded on the request's ExecutionState either way.

A non-allow decision swaps in a system login/secure ActionDescriptor, preserves the original as `quiote.original_action`, clears the preinstantiated action so the forwarded action gets a fresh instance, and resets the execution state's view/attribute/validation fields. More than five forwards on one request yields a 508. If the forward descriptor itself cannot be built, a 403 is returned rather than letting the original action run.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
