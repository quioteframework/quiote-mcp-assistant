# StealthMiddleware

> Strips framework-identifying response headers when `core.stealth_mode` is enabled: any `X-Quiote-*` header, plus the names listed in `core.stealth_additional_headers` (covers `X-Powered-By`, which doesn't follow that prefix).

Strips framework-identifying response headers when `core.stealth_mode` is enabled: any `X-Quiote-*` header, plus the names listed in `core.stealth_additional_headers` (covers `X-Powered-By`, which doesn't follow that prefix).

Sits outside ErrorHandlingMiddleware so error/404 responses are stripped too, since DispatchMiddleware is terminal and never calls `$handler->handle()` — only middleware ordered outside it ever sees a response nobody else already returned.

## Synopsis

`class StealthMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/StealthMiddleware.php` |

## Constructor

### __construct()

`public function __construct(bool $enabled = false, array<int, string> $additionalHeaders = ['X-Powered-By']): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$enabled` | `bool` |  |
| `$additionalHeaders` | `array``<``int``, ``string``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Removes framework-identifying headers from the response on the way out. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Removes framework-identifying headers from the response on the way out.

A no-op when stealth mode is disabled. Otherwise every response header whose name starts with `X-Quiote-` (case-insensitively) is dropped, along with each of the explicitly configured additional names that is present. Only the response is touched; the request passes through unchanged.

Its high `bootstrap` priority puts it outside ErrorHandlingMiddleware, so error and 404 responses are stripped as well.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
