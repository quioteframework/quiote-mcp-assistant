# CacheInterface

> Framework-facing cache interface; extends PSR-16 for flexibility.

Framework-facing cache interface; extends PSR-16 for flexibility.

## Synopsis

`interface CacheInterface extends CacheInterface`

|  |  |
|---|---|
| Implements | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) |
| Source | `Cache/CacheInterface.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `clear()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Wipes clean the entire cache's keys. |
| `delete()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Delete an item from the cache by its unique key. |
| `deleteMultiple()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Deletes multiple cache items in a single operation. |
| `get()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Fetches a value from the cache. |
| `getMultiple()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Obtains multiple cache items by their unique keys. |
| `has()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Determines whether an item is present in the cache. |
| `set()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time. |
| `setMultiple()` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) | Persists a set of key => value pairs in the cache, with an optional TTL. |
