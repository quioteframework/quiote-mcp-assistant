# SchedulerLock

> Best-effort overlap-prevention lock for ScheduledTaskDefinition::withoutOverlapping(), built on the app's existing PSR-16 CacheInterface rather than a new lock subsystem.

Best-effort overlap-prevention lock for [`ScheduledTaskDefinition::withoutOverlapping()`](/api/scheduler/scheduled-task-definition/#withoutoverlapping), built on the app's existing PSR-16 `CacheInterface` rather than a new lock subsystem.

PSR-16 has no atomic add-if-absent, so there is a narrow TOCTOU race between concurrent `schedule:run` invocations' `has()` check and `set()` call — acceptable for the common "still running past the next * minute" case this guards against, not a hardened distributed lock.

## Synopsis

`final readonly class SchedulerLock`

|  |  |
|---|---|
| Source | `SchedulerLock.php` |

## Constructor

### __construct()

`public function __construct(CacheInterface $cache): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$cache` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`acquire(string $key, int $ttlSeconds): bool`](#acquire) | Attempts to take the lock, returning false when it is already held. |
| [`release(string $key): void`](#release) | Releases the lock by deleting its cache key. |

### acquire()

`public function acquire(string $key, int $ttlSeconds): bool`

Attempts to take the lock, returning false when it is already held.

On success the key is written to the cache with the given lifetime, so the lock expires by itself if a crashed run never releases it. The check and the write are two separate PSR-16 calls, so two invocations racing on the same key can both succeed.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$ttlSeconds` | `int` |  |

Returns `bool`

### release()

`public function release(string $key): void`

Releases the lock by deleting its cache key.

Deleting a key that is not present is not an error, so releasing a lock that already expired is harmless.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
