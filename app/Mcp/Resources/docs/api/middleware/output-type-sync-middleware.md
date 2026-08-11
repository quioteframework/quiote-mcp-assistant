# OutputTypeSyncMiddleware

> Synchronizes the Controller's current output type with the PSR request attribute 'output_type' after routing has resolved (and potentially overridden) it.

Synchronizes the Controller's current output type with the PSR request attribute 'output_type' after routing has resolved (and potentially overridden) it.

Ensures downstream code relying on $controller->getOutputType() sees the correct routed/negotiated value.

## Synopsis

`class OutputTypeSyncMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/OutputTypeSyncMiddleware.php` |

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
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Selects the request's `output_type` on the Controller. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Selects the request's `output_type` on the Controller.

Ordered after RoutingMiddleware and before SecurityMiddleware, so the value it applies is the one routing settled on rather than the raw negotiated one. Nothing happens when the attribute is absent or empty. A name the application does not define is logged at debug and otherwise ignored, leaving the controller's current selection in place.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
