# ErrorResponseFactory

> Turns a throwable that escaped the middleware pipeline into a response.

Turns a throwable that escaped the middleware pipeline into a response.

This is the backstop for a *pre-pipeline* failure -- TelemetryMiddleware and ErrorHandlingMiddleware never got a chance to run, so the exception is recorded on whatever span is active here and then rendered by borrowing ErrorHandlingMiddleware's own renderer, so a request that dies during bootstrap still produces the same RFC 9457 output as one that dies inside an action.

It always returns a ResponseInterface and never writes to the SAPI itself. That is what lets a CLI-hosted runtime (RoadRunner, Swoole) emit the error through its own channel; the previous inline version in Kernel fell back to header()+echo, which off-SAPI meant the client got nothing at all.

## Synopsis

`final class ErrorResponseFactory`

|  |  |
|---|---|
| Source | `Runtime/ErrorResponseFactory.php` |

## Constructor

### __construct()

`public function __construct(Psr17Factory $psr17 = new Psr17Factory(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$psr17` | `Psr17Factory` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromThrowable(Throwable $e, ?ServerRequestInterface $request = null): ResponseInterface`](#fromthrowable) | Renders a throwable as an RFC 9457 error response. |

### fromThrowable()

`public function fromThrowable(Throwable $e, ?ServerRequestInterface $request = null): ResponseInterface`

Renders a throwable as an RFC 9457 error response.

The exception is logged at debug level and recorded on the active span, then rendered by [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/)'s own renderer so the output matches a failure caught inside the pipeline. When no request is supplied — a failure predating request construction — a synthetic `GET /error` stands in. If the renderer itself throws, a plain text/plain 500 is returned instead and the render failure is logged.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$request` | `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
