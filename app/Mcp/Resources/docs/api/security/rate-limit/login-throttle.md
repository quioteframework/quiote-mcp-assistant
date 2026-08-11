# LoginThrottle

> A small login/auth throttle on top of symfony/rate-limiter.

A small login/auth throttle on top of symfony/rate-limiter.

Intended for the "count failed authentication attempts per key (IP, username, * ...)" pattern: peek before doing expensive auth work, register a failure when auth fails, and reset on success. Backed by any Symfony rate-limiter StorageInterface — use [`PdoRateLimiterStorage`](/api/security/rate-limit/pdo-rate-limiter-storage/) to keep state in the application database (no Redis required). Uses a sliding-window policy. Concurrency: without a LockFactory the window may slightly over/under-count under simultaneous failures, which is harmless for a brute-force throttle; pass a Symfony LockFactory (e.g. backed by a PostgreSqlStore) if you need exactness.

## Synopsis

`final readonly class LoginThrottle`

|  |  |
|---|---|
| Source | `LoginThrottle.php` |

## Constructor

### __construct()

`public function __construct(StorageInterface $storage, int $maxAttempts = 10, string $interval = '15 minutes', string $id = 'quiote_login'): mixed`

Limiter id namespace (keep distinct per use-case).

| Parameter | Type | Description |
|---|---|---|
| `$storage` | `StorageInterface` | Where window state is persisted. |
| `$maxAttempts` | `int` | Allowed attempts within the interval. |
| `$interval` | `string` | Window size, e.g. "15 minutes" / "1 hour". |
| `$id` | `string` | Limiter id namespace (keep distinct per use-case). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`registerFailure(string $key): ?int`](#registerfailure) | Register a single failed attempt for $key. |
| [`reset(string $key): void`](#reset) | Clear the counter for $key. |
| [`retryAfter(string $key): ?int`](#retryafter) | Seconds the caller must wait if $key is currently exhausted, or null if it is still allowed. |

### registerFailure()

`public function registerFailure(string $key): ?int`

Register a single failed attempt for $key.

Returns the seconds to wait if this failure exceeded the limit (request should be rejected), otherwise null (counted, still within the allowance).

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?``int`

### reset()

`public function reset(string $key): void`

Clear the counter for $key.

Call after a successful authentication so a legitimate client is never penalised for earlier typos.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

### retryAfter()

`public function retryAfter(string $key): ?int`

Seconds the caller must wait if $key is currently exhausted, or null if it is still allowed.

Does NOT consume an attempt (peek only) — use this at the start of request handling to reject flooding before doing expensive work. Note: a peek (consume(0)) is always "accepted" by the limiter, so we judge exhaustion by remaining tokens rather than isAccepted().

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?``int`
