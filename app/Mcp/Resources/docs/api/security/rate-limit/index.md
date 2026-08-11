# RateLimit

> The Quiote\\Security\\RateLimit namespace — 4 documented types.

Everything under `Quiote\Security\RateLimit`.

## Classes

| Class | Description |
|---|---|
| [`LoginThrottle`](/api/security/rate-limit/login-throttle/) | A small login/auth throttle on top of symfony/rate-limiter. |
| [`PdoRateLimiterStorage`](/api/security/rate-limit/pdo-rate-limiter-storage/) | A symfony/rate-limiter StorageInterface backed by a relational database via PDO. |
| [`RateLimitMiddleware`](/api/security/rate-limit/rate-limit-middleware/) | General-purpose per-client HTTP rate limiting, built on the same symfony/rate-limiter primitives as [`LoginThrottle`](/api/security/rate-limit/login-throttle/) but keyed by client IP rather than a login identifier. |
| [`RateLimitPlugin`](/api/security/rate-limit/rate-limit-plugin/) | Registers [`RateLimitMiddleware`](/api/security/rate-limit/rate-limit-middleware/) through the generic plugin seam, opt-in via `ratelimit.http.enabled`. |
