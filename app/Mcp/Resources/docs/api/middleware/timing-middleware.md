# TimingMiddleware

> Records timing spans for downstream middleware execution.

Records timing spans for downstream middleware execution.

## Synopsis

`class TimingMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/TimingMiddleware.php` |

## Constructor

### __construct()

`public function __construct(bool $emitHeader = false, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$emitHeader` | `bool` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Measures total pipeline time into the request's ExecutionState metrics. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Measures total pipeline time into the request's ExecutionState metrics.

Runs at the head of the `bootstrap` phase so the measurement spans essentially the whole stack. Reuses the ExecutionState already on the request, or creates one and attaches it, then writes `total_ms` into its metrics after the downstream handler returns. The `X-Quiote-Timing` header is added only when the constructor enabled it, and is skipped without complaint if the metrics cannot be JSON-encoded.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
