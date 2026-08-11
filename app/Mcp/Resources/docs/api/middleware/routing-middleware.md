# RoutingMiddleware

> Executes Quiote routing and attaches module/action/outputType to PSR request attributes.

Executes Quiote routing and attaches module/action/outputType to PSR request attributes.

Also owns the route-match span (`telemetry.spans.route`, default true) and, on a successful match, renames whatever telemetry span is currently active (the root request span opened by `TelemetryMiddleware`) to the matched route's low-cardinality identity — this is the only place in the pipeline that knows it, since `TelemetryMiddleware` only ever sees the raw request/response per PSR-7 immutability (its own request clone never reflects attributes set by inner middleware).

## Synopsis

`class RoutingMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `Middleware/RoutingMiddleware.php` |

## Constructor

### __construct()

`public function __construct(Routing $routing, Controller $controller): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$routing` | [`Routing`](/api/routing/routing/) |  |
| `$controller` | [`Controller`](/api/controller/controller/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Matches the request path and attaches the resolved route to the request. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Matches the request path and attaches the resolved route to the request.

Syncs the routing RequestContext to the incoming HTTP method first — nothing else in the framework does, and it otherwise stays on GET and would reject every method-constrained non-GET route. On a match the request gains `module`, `action`, `output_type`, `route_name`, `route_params` and an ActionDescriptor attribute, and a RequestMatchedEvent is emitted. The route's own output type wins; without one the value negotiated earlier is kept, falling back to `html`.

A path that resolves to no module/action, and a ResourceNotFoundException, both leave the attributes unset and let the request continue so downstream middleware can produce a 404. A MethodNotAllowedException returns a 405 carrying an `Allow` header, except for OPTIONS, which is passed on unrouted so a CORS preflight handler still gets its chance.

Owns the route-match span when `telemetry.spans.route` is on, and renames the enclosing root request span to the matched route's low-cardinality identity; the span is always ended, including on the early 405/OPTIONS returns.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
