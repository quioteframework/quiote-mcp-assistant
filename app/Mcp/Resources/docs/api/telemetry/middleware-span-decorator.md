# MiddlewareSpanDecorator

> Wraps a single pipeline middleware in a child span named by its FQCN.

Wraps a single pipeline middleware in a child span named by its FQCN.

Reproduces, as real spans, what `TraceMiddleware` already records as a flat name list.

High cardinality/overhead — opt-in only via `telemetry.spans.middleware` (default `false`). `MiddlewarePipeline::doBuild()` only constructs this decorator at all when that setting is on, so a disabled pipeline pays zero cost for this feature, not even an extra object per middleware.

## Synopsis

`final class MiddlewareSpanDecorator implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Telemetry/MiddlewareSpanDecorator.php` |

## Constructor

### __construct()

`public function __construct(MiddlewareInterface $inner, string $label): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$inner` | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |  |
| `$label` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Runs the wrapped middleware inside a `Quiote.Middleware` span named after it. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Runs the wrapped middleware inside a `Quiote.Middleware` span named after it.

The span is ended in a `finally` block, so it closes on both the normal and the exceptional path. A throwable is recorded on the span and its status set to error before being rethrown unchanged — this decorator never swallows a failure.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
