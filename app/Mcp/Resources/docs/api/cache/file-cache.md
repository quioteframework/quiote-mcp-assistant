# FileCache

> Very small file-system PSR-16 cache (not for high concurrency, but fine as default replacement of legacy action/view cache).

Very small file-system PSR-16 cache (not for high concurrency, but fine as default replacement of legacy action/view cache).

Users can swap in a different implementation via DI later.

The framework's own cache is [`CacheManager`](/api/cache/cache-manager/), which wraps symfony/cache; this is a dependency-free fallback for an application that wants one.

## Synopsis

`class FileCache implements CacheInterface`

|  |  |
|---|---|
| Implements | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) |
| Source | `Cache/FileCache.php` |

## Constructor

### __construct()

`public function __construct(string $directory, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$directory` | `string` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`clear(): bool`](#clear) | Unlinks every `*.cache` file in the cache directory. |
| [`delete(string $key): bool`](#delete) | Removes the cache file for $key. |
| [`deleteMultiple(iterable<string> $keys): bool`](#deletemultiple) | Deletes every given key. |
| [`get(string $key, mixed $default = null): mixed`](#get) | Returns the cached value for $key, or $default. |
| [`getMultiple(iterable<string> $keys, mixed $default = null): iterable<string, mixed>`](#getmultiple) | Yields each requested key paired with its cached value, or $default. |
| [`has(string $key): bool`](#has) | Reports whether a live entry exists for $key. |
| [`set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool`](#set) | Writes $value to the cache file for $key. |
| [`setMultiple(iterable<string, mixed> $values, null|int|DateInterval $ttl = null): bool`](#setmultiple) | Persists a set of key => value pairs in the cache, with an optional TTL. |

### clear()

`public function clear(): bool`

Unlinks every `*.cache` file in the cache directory.

Only files this cache wrote are matched, so other content in the directory is left alone. Returns false if any one file could not be removed; the remaining files are still attempted.

Returns `bool`

### delete()

`public function delete(string $key): bool`

Removes the cache file for $key.

Reports success both when the file was unlinked and when no file was there to begin with, so deleting a missing key is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

| Throws | When |
|---|---|
| `InvalidCacheKeyException` | When $key is not a legal PSR-16 key. |

### deleteMultiple()

`public function deleteMultiple(iterable<string> $keys): bool`

Deletes every given key.

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `iterable``<``string``>` |  |

Returns `bool`

| Throws | When |
|---|---|
| `InvalidCacheKeyException` | When one of the keys is not a legal PSR-16 key. |

### get()

`public function get(string $key, mixed $default = null): mixed`

Returns the cached value for $key, or $default.

$default is returned when no file exists for the key, when the file cannot be read, when the stored expiry has passed, or when the payload fails to decode. A value that was genuinely stored as null is returned as null rather than as $default.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `InvalidCacheKeyException` | When $key is not a legal PSR-16 key. |

### getMultiple()

`public function getMultiple(iterable<string> $keys, mixed $default = null): iterable<string, mixed>`

Yields each requested key paired with its cached value, or $default.

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `iterable``<``string``>` |  |
| `$default` | `mixed` |  |

Returns `iterable``<``string``, ``mixed``>`

| Throws | When |
|---|---|
| `InvalidCacheKeyException` | When one of the keys is not a legal PSR-16 key. |

### has()

`public function has(string $key): bool`

Reports whether a live entry exists for $key.

An entry whose file exists but is unreadable, expired or undecodable counts as absent, so has() and get() can never disagree.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

| Throws | When |
|---|---|
| `InvalidCacheKeyException` | When $key is not a legal PSR-16 key. |

### set()

`public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool`

Writes $value to the cache file for $key.

A \DateInterval TTL is converted to a number of seconds from now. A null TTL stores the entry with no expiry; a zero or negative TTL deletes any existing entry and reports success without writing anything. Returns false if the file could not be written.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |
| `$ttl` | `DateInterval``|``int``|``null` |  |

Returns `bool`

| Throws | When |
|---|---|
| `InvalidCacheKeyException` | When $key is not a legal PSR-16 key. |

### setMultiple()

`public function setMultiple(iterable<string, mixed> $values, null|int|DateInterval $ttl = null): bool`

Persists a set of key => value pairs in the cache, with an optional TTL.

Optional. The TTL value of this item. If no value is sent and
                                      the driver supports TTL then the library may set a default value
                                      for it or let the driver take care of that.

| Parameter | Type | Description |
|---|---|---|
| `$values` | `iterable``<``string``, ``mixed``>` | A list of key => value pairs for a multiple-set operation. |
| `$ttl` | `null``|``int``|``DateInterval` | Optional. The TTL value of this item. If no value is sent and the driver supports TTL then the library may set a default value for it or let the driver take care of that. |

Returns `bool` — True on success and false on failure.

| Throws | When |
|---|---|
| `InvalidArgumentException` | MUST be thrown if $values is neither an array nor a Traversable, or if any of the $values are not a legal value. |
