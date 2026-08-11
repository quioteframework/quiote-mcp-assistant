# SafeRenderer

> Default renderer: never leaks exception internals.

Default renderer: never leaks exception internals.

No message, no class name, no trace, no `X-Quiote-Error-Type` header -- just a generic body plus the correlation id, so an operator can find the real detail in the logs without a client ever seeing it. Used whenever core.developer_exceptions is off (the default).

## Synopsis

`final class SafeRenderer implements ExceptionRenderer`

|  |  |
|---|---|
| Implements | [`ExceptionRenderer`](/api/exception/rendering/exception-renderer/) |
| Uses | [`NegotiatesContent`](/api/exception/rendering/negotiates-content/) |
| Since | `1.0.0` |
| Source | `Exception/Rendering/SafeRenderer.php` |

## Methods

| Method | Description |
|---|---|
| [`render(Throwable $e, ServerRequestInterface $request, int $status, ?string $correlationId): ResponseInterface`](#render) | Renders a generic error response that reveals nothing about the exception. |

### render()

`public function render(Throwable $e, ServerRequestInterface $request, int $status, ?string $correlationId): ResponseInterface`

Renders a generic error response that reveals nothing about the exception.

The media type is negotiated from the request: a JSON object, a plain-text body or a minimal HTML page. All three carry only "Internal Server Error" (5xx) or "Request Error" (anything else) plus the correlation id when one is known. The Throwable itself is never read.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$status` | `int` |  |
| `$correlationId` | `?``string` |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
