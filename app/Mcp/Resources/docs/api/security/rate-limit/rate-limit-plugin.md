# RateLimitPlugin

> Registers RateLimitMiddleware through the generic plugin seam, opt-in via `ratelimit.http.enabled`.

Registers [`RateLimitMiddleware`](/api/security/rate-limit/rate-limit-middleware/) through the generic plugin seam, opt-in via `ratelimit.http.enabled`.

Binds a default `StorageInterface` (set-if-absent) selected by `ratelimit.storage`: `memory` (default, `InMemoryStorage`), `redis` (`CacheStorage` wrapping a `RedisAdapter` built from `ratelimit.redis.dsn`), or `pdo` ([`PdoRateLimiterStorage`](/api/security/rate-limit/pdo-rate-limiter-storage/) on the `ratelimit.pdo.connection` database), for state that survives across worker/process restarts without a Redis dependency. An unrecognised value is an error rather than a fallback: `memory` counts per process, so silently substituting it for a misspelled backend multiplies the effective limit by the worker count.

## Synopsis

`final class RateLimitPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `RateLimitPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers the rate-limiting configuration defaults, the storage binding and the middleware. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers the rate-limiting configuration defaults, the storage binding and the middleware.

`ratelimit.http.enabled` defaults to false, so installing the package alone does not throttle anything. The `StorageInterface` binding is a singleton because the in-memory backend counts per process — a request-scoped one would reset every counter each request. The middleware is registered with a factory that hands it that binding from the context's own container.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
