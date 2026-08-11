# ContentNegotiationMiddleware

> Minimal wrapper over middlewares/content-type.

Minimal wrapper over middlewares/content-type.

Runs BEFORE routing so routing can overwrite the attribute. If Accept absent, library falls back to its first default format; we still set that. We disable nosniff header and save negotiated format name into 'output_type'.

## Synopsis

`class ContentNegotiationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/ContentNegotiationMiddleware.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Negotiates the output format from the Accept header onto the request. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Negotiates the output format from the Accept header onto the request.

Returns immediately without touching anything if `output_type` is already set to a string, so an earlier decision wins. Otherwise the Accept header is matched against MimeTypeRegistry's negotiable types and the resulting format list is attached as `output_formats`, with its first entry as `output_type`. A request with no Accept header, or one matching nothing, falls back to `html`.

Runs in the `pre` phase, ahead of routing, so a route may override the attribute afterwards.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
