# RecordingCache

> A decorating PSR-16 cache: wraps a real inner `CacheInterface` and appends one EffectKind::Cache entry per call to an injected EffectLedger, returning the real result completely untouched to the caller.

A decorating PSR-16 cache: wraps a real inner `CacheInterface` and appends one [`EffectKind::Cache`](/api/replay/cassette/effect-kind/#cache) entry per call to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), returning the real result completely untouched to the caller.

Fingerprint is `"{op}:{key}"` (e.g. `"get:orders.42"`, `"set:orders.42"`), not the bare key -- a bare-key fingerprint would let [`LedgerMatcher`](/api/replay/replay/ledger-matcher/)'s sequence fallback hand a `get()` call the recorded result of a `set()`/`has()` on the same key if replay ever asked for that key's operations in a different order than recording did (a real, if narrow, risk once cache traffic for one key interleaves several operation kinds). Scoping the fingerprint by operation keeps each operation's own recorded sequence independent, matching how the HTTP recorder scopes its fingerprint by method for the same reason.

`get()`'s hit/miss distinction is recorded explicitly (`['hit' => bool, 'value' => mixed]`), not inferred from comparing the returned value to the caller's `$default` -- PSR-16 cannot otherwise tell a stored `null` apart from a miss, and collapsing that distinction would let replay silently turn a real stored `null` into a miss or vice versa. The caller's own `$default` at replay time is honored for a recorded miss, not whatever default happened to be passed when recording -- callers are free to pass a different default across runs, and only the backend's actual hit/miss state is this decorator's business to reproduce.

`getMultiple()`/`setMultiple()`/`deleteMultiple()` are implemented as repeated calls to this class's own `get()`/`set()`/`delete()` rather than delegating to the inner cache's native multi-key methods: this reuses the single-key recording/hit-miss logic exactly instead of duplicating it under a second fingerprint scheme, at the cost of the inner backend's own multi-key round-trip optimization -- an acceptable trade for a recording decorator, whose job is observing traffic, not minimizing it.

A real-cache exception is never swallowed: no effect is recorded for a failed call, and the exception propagates exactly as it would through the undecorated cache, matching the same rule `Quiote\Replay\Db\RecordingPdo` and `Quiote\Replay\Http\RecordingHttpTransport` already follow.

## Synopsis

`final class RecordingCache implements CacheInterface`

|  |  |
|---|---|
| Implements | [`CacheInterface`](/api/cache/cache-interface/) |
| Source | `Cache/RecordingCache.php` |

## Constructor

### __construct()

`public function __construct(CacheInterface $cache, EffectLedger $ledger, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$cache` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`clear(): bool`](#clear) | Wipes clean the entire cache's keys. |
| [`delete(string $key): bool`](#delete) | Delete an item from the cache by its unique key. |
| [`deleteMultiple(iterable<mixed, array-key> $keys): bool`](#deletemultiple) | Deletes multiple cache items in a single operation. |
| [`get(string $key, mixed $default = null): mixed`](#get) | Fetches a value from the cache. |
| [`getMultiple(iterable<mixed, array-key> $keys, mixed $default = null): iterable<string, mixed>`](#getmultiple) | Obtains multiple cache items by their unique keys. |
| [`has(string $key): bool`](#has) | Determines whether an item is present in the cache. |
| [`set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool`](#set) | Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time. |
| [`setMultiple(iterable<array-key, mixed> $values, null|int|DateInterval $ttl = null): bool`](#setmultiple) | Persists a set of key => value pairs in the cache, with an optional TTL. |

### clear()

`public function clear(): bool`

Wipes clean the entire cache's keys.

Returns `bool` — True on success and false on failure.

### delete()

`public function delete(string $key): bool`

Delete an item from the cache by its unique key.

The unique cache key of the item to delete.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` | The unique cache key of the item to delete. |

Returns `bool` — True if the item was successfully removed. False if there was an error.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if the $key string is not a legal value. |

### deleteMultiple()

`public function deleteMultiple(iterable<mixed, array-key> $keys): bool`

Deletes multiple cache items in a single operation.

A list of string-based keys to be deleted.

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `iterable``<``mixed``, ``array-key``>` | A list of string-based keys to be deleted. |

Returns `bool` — True if the items were successfully removed. False if there was an error.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value. |

### get()

`public function get(string $key, mixed $default = null): mixed`

Fetches a value from the cache.

Default value to return if the key does not exist.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` | The unique key of this item in the cache. |
| `$default` | `mixed` | Default value to return if the key does not exist. |

Returns `mixed` — The value of the item from the cache, or $default in case of cache miss.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if the $key string is not a legal value. |

### getMultiple()

`public function getMultiple(iterable<mixed, array-key> $keys, mixed $default = null): iterable<string, mixed>`

Obtains multiple cache items by their unique keys.

Default value to return for keys that do not exist.

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `iterable``<``mixed``, ``array-key``>` | A list of keys that can be obtained in a single operation. |
| `$default` | `mixed` | Default value to return for keys that do not exist. |

Returns `iterable``<``string``, ``mixed``>` — A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value. |

### has()

`public function has(string $key): bool`

Determines whether an item is present in the cache.

The cache item key.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` | The cache item key. |

Returns `bool`

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if the $key string is not a legal value. |

### set()

`public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool`

Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.

Optional. The TTL value of this item. If no value is sent and
                                     the driver supports TTL then the library may set a default value
                                     for it or let the driver take care of that.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` | The key of the item to store. |
| `$value` | `mixed` | The value of the item to store, must be serializable. |
| `$ttl` | `null``|``int``|``DateInterval` | Optional. The TTL value of this item. If no value is sent and the driver supports TTL then the library may set a default value for it or let the driver take care of that. |

Returns `bool` — True on success and false on failure.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if the $key string is not a legal value. |

### setMultiple()

`public function setMultiple(iterable<array-key, mixed> $values, null|int|DateInterval $ttl = null): bool`

Persists a set of key => value pairs in the cache, with an optional TTL.

Optional. The TTL value of this item. If no value is sent and
                                      the driver supports TTL then the library may set a default value
                                      for it or let the driver take care of that.

| Parameter | Type | Description |
|---|---|---|
| `$values` | `iterable``<``array-key``, ``mixed``>` | A list of key => value pairs for a multiple-set operation. |
| `$ttl` | `null``|``int``|``DateInterval` | Optional. The TTL value of this item. If no value is sent and the driver supports TTL then the library may set a default value for it or let the driver take care of that. |

Returns `bool` — True on success and false on failure.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if $values is neither an array nor a Traversable, or if any of the $values are not a legal value. |
