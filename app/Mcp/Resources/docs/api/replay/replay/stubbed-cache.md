# StubbedCache

> The isolated-replay counterpart to RecordingCache: never touches a real cache backend, answering every call from an injected EffectLedger matched on the same CacheFingerprint scheme the recorder used.

The isolated-replay counterpart to [`RecordingCache`](/api/replay/cache/recording-cache/): never touches a real cache backend, answering every call from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) matched on the same [`CacheFingerprint`](/api/replay/cache/cache-fingerprint/) scheme the recorder used.

Each recorded `get()` call already carries its own hit/miss state, so replaying it needs no simulation of intervening writes -- the ledger captured exactly what the backend held at the moment of that specific call in the original request. A read (`get()`, `has()`) with no matching recorded effect returns the caller's `$default` and is reported through [`StubbedCache::unrecordedReads()`](/api/replay/replay/stubbed-cache/#unrecordedreads) -- not thrown, because PSR-16 requires exactly that return, and not silently either, because an isolated replay answering a read it has no recording for fabricates a passing test. `StubbedPdo` and `StubbedHttpTransport` do throw for the same situation, and correctly: `\PDO` and PSR-18 both allow it where PSR-16 does not.

A write (`set()`, `delete()`, `clear()`) is different in kind: its return value is a bare success flag with no data a caller could act on incorrectly, and isolated replay has no real backend for the write to fail against. When a matching recorded write effect exists, its recorded boolean is reproduced (so a request that observed `set()` returning `false` -- e.g. a full backend -- still sees that on replay); when none exists, the write silently succeeds (`true`) rather than throwing, since an isolated-replay write inherently cannot affect anything and refusing it would make replay brittle for code paths that write to the cache without the original recording having captured every such write.

## Synopsis

`final class StubbedCache implements CacheInterface`

|  |  |
|---|---|
| Implements | [`CacheInterface`](/api/cache/cache-interface/) |
| Source | `Replay/StubbedCache.php` |

## Constructor

### __construct()

`public function __construct(EffectLedger $ledger): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

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
| [`unrecordedReads(): list<string>`](#unrecordedreads) | Reads this replay could not answer from the ledger. |

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

### unrecordedReads()

`public function unrecordedReads(): list<string>`

Reads this replay could not answer from the ledger.

Reported rather than thrown, because `Quiote\Cache\CacheInterface` extends PSR-16, whose `get()` must return `$default` on a miss and may only throw for an invalid key. Throwing from a read broke that contract in exactly the way a substituted implementation must not: a caller written against the interface could not survive the swap.

The intent behind the throw was right -- an isolated replay must not quietly answer a read it has no recording for, because that fabricates a passing test -- so the information is kept and moved somewhere a test can assert on it. A test that cares checks this is empty; the interface keeps its guarantees either way. [`EffectLedger::misses()`](/api/replay/replay/effect-ledger/#misses) records the same calls from the ledger's side.

Returns `list``<``string``>`
