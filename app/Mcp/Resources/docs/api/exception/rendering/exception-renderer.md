# ExceptionRenderer

> Turns a caught Throwable into a client-facing PSR-7 response.

Turns a caught Throwable into a client-facing PSR-7 response.

This is the seam ErrorHandlingMiddleware delegates to -- it is the ONE catch point in the framework; a renderer only decides how to present what was caught, it never does its own catching.

Implementations must be worker-mode safe: no echo, no exit(), no reliance on superglobals (use $request instead -- $_SERVER/$_GET can be stale or empty in a persistent worker), and must return a real PSR-7 response rather than writing output directly.

## Synopsis

`interface ExceptionRenderer`

|  |  |
|---|---|
| Implemented by | [`SafeRenderer`](/api/exception/rendering/safe-renderer/), [`WhoopsRenderer`](/api/exception/rendering/whoops/whoops-renderer/) |
| Since | `1.0.0` |
| Source | `Exception/Rendering/ExceptionRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`render(Throwable $e, ServerRequestInterface $request, int $status, string|null $correlationId): ResponseInterface`](#render) |  |

### render()

`abstract public function render(Throwable $e, ServerRequestInterface $request, int $status, string|null $correlationId): ResponseInterface`

Already-extracted correlation id, if any.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) | The caught exception (top of the chain). |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The request that triggered it. |
| `$status` | `int` | The HTTP status already decided by the middleware (e.g. 400 for InvalidArgumentException, 500 default). |
| `$correlationId` | `string``|``null` | Already-extracted correlation id, if any. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
