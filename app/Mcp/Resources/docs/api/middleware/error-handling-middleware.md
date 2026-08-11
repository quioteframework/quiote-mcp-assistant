# ErrorHandlingMiddleware

> Catches unhandled throwables from downstream middleware/action dispatch and produces a generic 500 (or mapped) response.

Catches unhandled throwables from downstream middleware/action dispatch and produces a generic 500 (or mapped) response.

Currently minimal; can be extended to perform content negotiation (HTML/JSON) and structured logging.

## Synopsis

`class ErrorHandlingMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/ErrorHandlingMiddleware.php` |

## Constructor

### __construct()

`public function __construct(callable(Throwable $e, ServerRequestInterface $r): void|null $logger = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$logger` | `callable(Throwable $e, ServerRequestInterface $r): void``|``null` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Catches any throwable escaping the rest of the stack and renders it as a response. |
| [`renderExceptionResponse(ServerRequestInterface $request, Throwable $e): ResponseInterface`](#renderexceptionresponse) | Public helper so Kernel (or other bootstrap code) can render a unified exception response. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Catches any throwable escaping the rest of the stack and renders it as a response.

Logs a single diagnostic line carrying the exception class, message, throw site, the triggering request, the cause chain and the trace, then hands the exception to [`ErrorHandlingMiddleware::renderExceptionResponse()`](/api/middleware/error-handling-middleware/#renderexceptionresponse) for the actual body and status. Nothing propagates out of here, which is the point of its high `bootstrap` priority: everything ordered inside it is covered.

Middleware that must see error and 404 responses has to be ordered *outside* this one; `after: ErrorHandlingMiddleware` places it within the try and it will be skipped whenever an exception is thrown.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### renderExceptionResponse()

`public function renderExceptionResponse(ServerRequestInterface $request, Throwable $e): ResponseInterface`

Public helper so Kernel (or other bootstrap code) can render a unified exception response.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
