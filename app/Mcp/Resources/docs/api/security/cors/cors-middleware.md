# CorsMiddleware

> Cross-Origin Resource Sharing (CORS) handling.

Cross-Origin Resource Sharing (CORS) handling.

Preflight (`OPTIONS` with an `Access-Control-Request-Method` header) requests are answered directly with a 204 and the negotiated CORS headers, without dispatching to the action. Actual cross-origin requests are dispatched as normal, then get their response decorated with the negotiated headers. Requests without an `Origin` header are not cross-origin and pass through untouched. Runs after RoutingMiddleware (so route-level overrides could be added later) and before DispatchMiddleware (so preflight never reaches an action).

## Synopsis

`class CorsMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `CorsMiddleware.php` |

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Answers CORS preflights and decorates cross-origin responses. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Answers CORS preflights and decorates cross-origin responses.

Passes the request straight through when `cors.enabled` is off or the request carries no `Origin` header. Otherwise a preflight (an `OPTIONS` carrying `Access-Control-Request-Method`) is answered here with a bare 204 plus the negotiated headers and never reaches the action; any other cross-origin request is dispatched normally and its response decorated afterwards. A response for an origin that is not allowed still gains a `Vary: Origin`, so a shared cache cannot serve it to an allowed origin.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `ConfigurationException` | if `cors.allowed_origins` contains `*` while `cors.allow_credentials` is on. |
