# PdoRateLimiterStorage

> A symfony/rate-limiter StorageInterface backed by a relational database via PDO.

A symfony/rate-limiter StorageInterface backed by a relational database via PDO.

Lets rate-limiter / login-throttle state live in the application database (Postgres) instead of Redis. The workload — a handful of writes per authentication attempt — is well within what Postgres handles comfortably, and it removes a moving part (and its hosting cost). Storage is intentionally portable: the limiter state is serialized and stored base64-encoded in a TEXT column, and expiry is a UNIX timestamp in an INTEGER column, avoiding driver-specific BLOB/TIMESTAMP types. Upserts use `INSERT ... ON CONFLICT` (PostgreSQL and SQLite ≥ 3.24). Schema (see [`PdoRateLimiterStorage::schema()`](/api/security/rate-limit/pdo-rate-limiter-storage/#schema)): CREATE TABLE quiote_rate_limit ( id         VARCHAR(64) PRIMARY KEY, state      TEXT        NOT NULL, expires_at INTEGER     NULL );

## Synopsis

`final readonly class PdoRateLimiterStorage implements StorageInterface`

|  |  |
|---|---|
| Implements | `StorageInterface` |
| Source | `PdoRateLimiterStorage.php` |

## Constructor

### __construct()

`public function __construct(PDO $pdo, string $table = 'quiote_rate_limit', ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pdo` | [`PDO`](https://www.php.net/manual/en/class.pdo.php) |  |
| `$table` | `string` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $limiterStateId): void`](#delete) | Removes the stored state for the given limiter id. |
| [`fetch(string $limiterStateId): ?LimiterStateInterface`](#fetch) | Loads the stored limiter state for the given id, or null when there is none to use. |
| [`purgeExpired(): int`](#purgeexpired) | Remove expired rows. |
| [`save(LimiterStateInterface $limiterState): void`](#save) | Writes the limiter state to the table, inserting or updating in one statement. |
| [`schema(string $table = 'quiote_rate_limit'): string`](#schema) | DDL to create the backing table (PostgreSQL / SQLite compatible). |

### delete()

`public function delete(string $limiterStateId): void`

Removes the stored state for the given limiter id.

Deleting an id with no row is not an error, so this is safe to call for a limiter that has never been saved.

| Parameter | Type | Description |
|---|---|---|
| `$limiterStateId` | `string` |  |

### fetch()

`public function fetch(string $limiterStateId): ?LimiterStateInterface`

Loads the stored limiter state for the given id, or null when there is none to use.

Null covers every unusable case, and the caller treats them all as "no * state yet": no row, a row whose stored expiry has passed (which is also deleted on the way out), an unreadable or non-base64 payload, and a payload that does not deserialize into a `LimiterStateInterface`. Deserialization is restricted to [`PdoRateLimiterStorage::ALLOWED_STATE_CLASSES`](/api/security/rate-limit/pdo-rate-limiter-storage/#allowedstateclasses), so a row written by anything other than [`PdoRateLimiterStorage::save()`](/api/security/rate-limit/pdo-rate-limiter-storage/#save) cannot instantiate arbitrary classes.

| Parameter | Type | Description |
|---|---|---|
| `$limiterStateId` | `string` |  |

Returns `?``LimiterStateInterface`

### purgeExpired()

`public function purgeExpired(): int`

Remove expired rows.

Safe to call from a periodic job; the per-row lazy cleanup in fetch() handles correctness, this just reclaims space.

Returns `int` — Number of rows deleted.

### save()

`public function save(LimiterStateInterface $limiterState): void`

Writes the limiter state to the table, inserting or updating in one statement.

The state is serialized and base64-encoded into the TEXT column, and its expiration time is stored as an absolute UNIX timestamp — a state with no expiration time gets a NULL, which never expires. The row key is the hashed limiter state id, not the id itself.

| Parameter | Type | Description |
|---|---|---|
| `$limiterState` | `LimiterStateInterface` |  |

### schema()

`public static function schema(string $table = 'quiote_rate_limit'): string`

DDL to create the backing table (PostgreSQL / SQLite compatible).

| Parameter | Type | Description |
|---|---|---|
| `$table` | `string` |  |

Returns `string`
