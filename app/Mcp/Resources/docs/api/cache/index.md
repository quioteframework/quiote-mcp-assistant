# Cache

> The Quiote\\Cache namespace — 5 documented types.

Everything under `Quiote\Cache`.

## Classes

| Class | Description |
|---|---|
| [`ActionViewCache`](/api/cache/action-view-cache/) | Minimal action+view result cache. |
| [`CacheManager`](/api/cache/cache-manager/) | The framework's process-wide PSR-16 cache, and the namespace versioning that cached output is invalidated through. |
| [`FileCache`](/api/cache/file-cache/) | Very small file-system PSR-16 cache (not for high concurrency, but fine as default replacement of legacy action/view cache). |
| [`InvalidCacheKeyException`](/api/cache/invalid-cache-key-exception/) | Thrown for a cache key PSR-16 does not permit: empty, or containing one of the characters reserved by PSR-16 §1.3 (`{}()/\@:`). |

## Interfaces

| Interface | Description |
|---|---|
| [`CacheInterface`](/api/cache/cache-interface/) | Framework-facing cache interface; extends PSR-16 for flexibility. |
