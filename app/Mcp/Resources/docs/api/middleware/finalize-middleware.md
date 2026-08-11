# FinalizeMiddleware

> FinalizeMiddleware (scaffold): end-of-request persistence for session/user.

FinalizeMiddleware (scaffold): end-of-request persistence for session/user.

Future: write slim session (user_id, auth flag, versions) & flush metrics.

## Synopsis

`class FinalizeMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/FinalizeMiddleware.php` |

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Passes the request through and returns the response unchanged. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Passes the request through and returns the response unchanged.

The middleware holds the `after_action` slot immediately after DispatchMiddleware, which is where end-of-request persistence and cleanup belong; no such work is performed yet.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
