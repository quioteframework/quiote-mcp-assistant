# RateLimitMiddleware

> General-purpose per-client HTTP rate limiting, built on the same symfony/rate-limiter primitives as LoginThrottle but keyed by client IP rather than a login identifier.

General-purpose per-client HTTP rate limiting, built on the same symfony/rate-limiter primitives as [`LoginThrottle`](/api/security/rate-limit/login-throttle/) but keyed by client IP rather than a login identifier.

Runs in the `pre_routing` phase so an over-limit request is rejected before any route resolution work happens. Opt-in via `ratelimit.http.enabled` — a fresh app has no rate-limit storage configured, so this stays off until an app explicitly turns it on (and, typically, binds a persistent `StorageInterface` such as [`PdoRateLimiterStorage`](/api/security/rate-limit/pdo-rate-limiter-storage/) in place of the in-memory default). The client key is the connecting peer's address (`$_SERVER['REMOTE_ADDR']`), not `X-Forwarded-For`, unless `ratelimit.http.trust_forwarded_for` is explicitly enabled — trusting a client-supplied header by default would let any caller spoof a fresh key and bypass the limit entirely. When it is enabled, the address is read from the right of the header per `ratelimit.http.trusted_proxy_hops` (default 1), which is the part a trusted proxy wrote rather than the part the client did.

## Synopsis

`final class RateLimitMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Source | `RateLimitMiddleware.php` |

## Constructor

### __construct()

`public function __construct(StorageInterface $storage): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$storage` | `StorageInterface` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Consumes one token for the calling client and rejects the request when the limit is exhausted. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Consumes one token for the calling client and rejects the request when the limit is exhausted.

Passes straight through when `ratelimit.http.enabled` is off. Otherwise a limiter is built per request from the configured policy, limit and window over the injected storage, and keyed by the client address. An accepted request continues down the pipeline; a rejected one short-circuits with a 429 problem-details response carrying `Retry-After`, so the route is never resolved.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
