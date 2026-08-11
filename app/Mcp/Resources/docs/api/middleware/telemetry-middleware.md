# TelemetryMiddleware

> Opens the root OpenTelemetry span for the request and records the headline resource measurements — wall time, CPU, memory — as both span attributes and OTel metrics.

Opens the root OpenTelemetry span for the request and records the headline resource measurements — wall time, CPU, memory — as both span attributes and OTel metrics.

Also carries the force-sample signal into the span's creation-time attributes, since a sampler can only see attributes present when the span is created.

Extracts an inbound W3C `traceparent`/`tracestate` so this request joins an upstream distributed trace instead of always starting a new one, and enriches [`LogContext`](/api/logging/log-context/) with the root span's trace/span IDs so every log line during the request is cross-navigable with the trace — this works even for a sampled-out span, since IDs exist independent of the sampling decision.

A no-op (just calls `$handler->handle($request)`) whenever [`Trace::enabled()`](/api/telemetry/trace/#enabled) is false, so this middleware is always safe to leave in the default pipeline regardless of whether telemetry is on.

Positioned just inside ErrorHandlingMiddleware (priority 1000 vs this class's 950 — higher priority runs more outward, see `MiddlewareOrderResolver`) so an uncaught exception passes through this middleware's own try/catch first (recording it on the root span, then re-throwing) before ErrorHandlingMiddleware renders the error response further out.

Deliberately does NOT attempt route/action attribution (`http.route`, `module`/`action`) here: that information is only known to inner middleware (RoutingMiddleware/DispatchMiddleware) operating on their own PSR-7 request clone, which this outer middleware never sees back per PSR-7 immutability. Enriching the root span with route/action dimensions is left to the middleware that already touches RoutingMiddleware directly.

## Synopsis

`class TelemetryMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/TelemetryMiddleware.php` |

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Opens the request's root span and records its resource measurements. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Opens the request's root span and records its resource measurements.

Returns immediately, having done nothing, when [`Trace::enabled()`](/api/telemetry/trace/#enabled) is false, so the middleware is safe to leave in the pipeline with telemetry off. Otherwise it guarantees an ExecutionState on the request, joins any inbound W3C `traceparent`/`tracestate` so the request continues an upstream trace, and opens a server span named `METHOD /path`. The force-sample flag is set as a creation-time attribute, since a sampler cannot see attributes added later. The span's trace and span IDs are pushed into LogContext so log lines from this request are cross-navigable.

Wall time is measured from `REQUEST_TIME_FLOAT` when available; in worker mode the peak-memory counter is reset first so the figure is this request's peak rather than the process's all-time peak.

An exception is recorded on the span and its status set to error, then rethrown for ErrorHandlingMiddleware — which sits further out — to render. The span is ended and the propagation scope detached on every path.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
