# TraceMiddleware

> Captures names of executed middleware for debugging.

Captures names of executed middleware for debugging.

## Synopsis

`class TraceMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/TraceMiddleware.php` |

## Constructor

### __construct()

`public function __construct(bool $emitHeader = false, string $headerName = 'X-Quiote-Trace'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$emitHeader` | `bool` |  |
| `$headerName` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Appends this middleware's class name to the ExecutionState trace. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Appends this middleware's class name to the ExecutionState trace.

Reuses the ExecutionState already on the request, or creates one and attaches it, and records `static::class` so a subclass traces under its own name. When the constructor enabled the header, the trace is re-read from the shared ExecutionState after the downstream handler returns, so entries appended by middleware further down the stack are included; non-scalar entries are rendered as their debug type.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
