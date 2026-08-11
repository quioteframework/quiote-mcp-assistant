# FormPopulationMiddleware

> Applies the modernized form population engine to PSR-7 responses so container-less requests still receive automatic form value and error message population.

Applies the modernized form population engine to PSR-7 responses so container-less requests still receive automatic form value and error message population.

## Synopsis

`class FormPopulationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/FormPopulationMiddleware.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller, ?FormPopulationEngine $engine = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$engine` | `?`[`FormPopulationEngine`](/api/util/form-population-engine/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Repopulates form fields and error messages in the rendered HTML response. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Repopulates form fields and error messages in the rendered HTML response.

On the way in, the canonical WebRequest is resolved (from the `quiote.request_data` attribute, else from the container), given the merged query, parsed-body and route parameters — later sources winning on key conflicts — seeded with the engine's default configuration, then published to RequestState and re-attached to the request.

On the way out the response is returned untouched unless every gate passes: the Content-Type must look like HTML (a missing Content-Type is treated as HTML), the body must be non-empty, the controller's global response must still allow content mutation, and the body must actually contain a `<form` — the last check skips the DOM round-trip for the common form-free page. When population does run and changes the markup, a new body is installed and any stale `Content-Length` header is removed. The engine is reset even if population throws.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `RuntimeException` | If no canonical WebRequest can be resolved. |
