# CacheManager

> The framework's process-wide PSR-16 cache, and the namespace versioning that cached output is invalidated through.

The framework's process-wide PSR-16 cache, and the namespace versioning that cached output is invalidated through.

Entirely static, with no instance to inject: [`CacheManager::getCache()`](/api/cache/cache-manager/#getcache) returns the shared `CacheInterface`, built once per process from `core.cache_backend` -- APCu when the extension is usable, Redis through `core.redis_dsn`, otherwise a filesystem pool under `core.cache_dir`. [`CacheManager::setCache()`](/api/cache/cache-manager/#setcache) installs any other PSR-16 implementation in its place, and [`CacheManager::getBackend()`](/api/cache/cache-manager/#getbackend) reports which one is in force. Compose keys with [`CacheManager::key()`](/api/cache/cache-manager/#key) rather than by concatenation: PSR-16 reserves characters -- colon among them -- that symfony/cache refuses.

Invalidation never deletes anything. Action, view and slot cache keys embed the current version of a namespace, so bumping that version ([`CacheManager::invalidateModule()`](/api/cache/cache-manager/#invalidatemodule), [`CacheManager::invalidateAction()`](/api/cache/cache-manager/#invalidateaction), [`CacheManager::invalidateSlotTag()`](/api/cache/cache-manager/#invalidateslottag), or [`CacheManager::bumpNamespace()`](/api/cache/cache-manager/#bumpnamespace) directly) makes every key written under the old version unreachable and leaves the backend to evict the orphans in its own time. Versions are derived from the clock rather than counted, so a version key evicted under memory pressure reseeds above every version that namespace has already issued instead of replaying old ones.

Versions are memoized for the duration of a request. [`CacheManager::resetRequestState()`](/api/cache/cache-manager/#resetrequeststate) drops that memo at the request boundary, which is what lets a persistent worker observe invalidations performed by another request or another process. [`CacheManager::reset()`](/api/cache/cache-manager/#reset) is the heavier, test-oriented clear: it drops the instance, the memo and the recorded backend name, and purges the filesystem pool's directory.

## Synopsis

`class CacheManager`

|  |  |
|---|---|
| Source | `Cache/CacheManager.php` |

## Methods

| Method | Description |
|---|---|
| [`bumpNamespace(string $namespace): int`](#bumpnamespace) | Invalidate a namespace by moving its version forward. |
| [`getBackend(): string`](#getbackend) | The name of the backend currently in use process-wide: `filesystem`, `apcu`, `redis`, or whatever name [`CacheManager::setCache()`](/api/cache/cache-manager/#setcache) was given. |
| [`getCache(): CacheInterface`](#getcache) | The process-wide PSR-16 cache, built on first use from `core.cache_backend`. |
| [`getNamespaceVersion(string $namespace): int`](#getnamespaceversion) | The current version of a cache namespace, seeding one if the backend has none. |
| [`invalidateAction(string $moduleName, string $actionName): void`](#invalidateaction) | Invalidates the cache entries of a single action by bumping a namespace combining the module and action names. |
| [`invalidateModule(string $moduleName): void`](#invalidatemodule) | Invalidates every action/view cache entry belonging to a module by bumping that module's namespace version. |
| [`invalidateSlotTag(string $tag): void`](#invalidateslottag) | Invalidates every slot cache entry carrying $tag by bumping the tag's namespace version. |
| [`key(string ...$parts): string`](#key) | PSR-16 §1.3 reserves `{}()/\@:` in cache keys: a conforming implementation may reject any key containing one, and symfony/cache does — either by throwing (`zend.assertions=1`) or, with assertions compiled out in production, by letting a key through that another backend would refuse. |
| [`reset(): void`](#reset) | Drops all process-wide cache state and purges the filesystem pool's directory. |
| [`resetRequestState(): void`](#resetrequeststate) | Request-boundary clear for a persistent worker: drops the per-request namespace-version memo so the next request re-reads versions from the shared backend and therefore observes invalidations performed elsewhere. |
| [`setCache(CacheInterface $cache, string $backendName = 'custom'): void`](#setcache) | Installs a cache instance process-wide, replacing whatever [`CacheManager::getCache()`](/api/cache/cache-manager/#getcache) would otherwise build, and records $backendName as the value [`CacheManager::getBackend()`](/api/cache/cache-manager/#getbackend) reports. |
| [`slotTagNamespace(string $tag): string`](#slottagnamespace) | The namespace whose version invalidates every slot cache entry carrying `$tag`. |

### bumpNamespace()

`public static function bumpNamespace(string $namespace): int`

Invalidate a namespace by moving its version forward.

The new version is the later of "one past the current one" and the current clock reading. The +1 keeps the strict increase a bump has to guarantee even when several bumps land inside the same millisecond; the clock floor is what keeps the version from drifting below a future reseed after an eviction (see [`CacheManager::freshNamespaceVersion()`](/api/cache/cache-manager/#freshnamespaceversion)).

| Parameter | Type | Description |
|---|---|---|
| `$namespace` | `string` |  |

Returns `int`

### getBackend()

`public static function getBackend(): string`

The name of the backend currently in use process-wide: `filesystem`, `apcu`, `redis`, or whatever name [`CacheManager::setCache()`](/api/cache/cache-manager/#setcache) was given.

Reports `filesystem` until the cache is first built or overridden, since the backend is only decided when [`CacheManager::getCache()`](/api/cache/cache-manager/#getcache) runs.

Returns `string`

### getCache()

`public static function getCache(): CacheInterface`

The process-wide PSR-16 cache, built on first use from `core.cache_backend`.

The instance is a static memo held for the lifetime of the process, so the backend choice is made once: `apcu` when the extension is loaded and enabled, `redis` via `core.redis_dsn`, otherwise a filesystem pool under `core.cache_dir` (falling back to a `quiote_cache` directory in the system temp dir when that setting is empty). An `apcu` request on a host without a usable APCu silently falls through to the filesystem pool.

Returns [`CacheInterface`](https://www.php-fig.org/psr/psr-16/)

| Throws | When |
|---|---|
| `RuntimeException` | If the backend is `redis` and no Redis client (ext-redis, ext-relay, predis/predis) is installed. |

### getNamespaceVersion()

`public static function getNamespaceVersion(string $namespace): int`

The current version of a cache namespace, seeding one if the backend has none.

Read through a per-request memo (see [`CacheManager::resetRequestState()`](/api/cache/cache-manager/#resetrequeststate)); on a miss the version is fetched from the cache backend, and if it is absent or not a positive integer — the namespace is new, or the backend evicted the version key — a fresh clock-derived version is generated and written back, which invalidates every entry previously stored under that namespace.

| Parameter | Type | Description |
|---|---|---|
| `$namespace` | `string` |  |

Returns `int`

### invalidateAction()

`public static function invalidateAction(string $moduleName, string $actionName): void`

Invalidates the cache entries of a single action by bumping a namespace combining the module and action names.

Narrower than [`CacheManager::invalidateModule()`](/api/cache/cache-manager/#invalidatemodule), which retires the whole module: the two use different namespaces, so bumping one does not affect the other.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |
| `$actionName` | `string` |  |

### invalidateModule()

`public static function invalidateModule(string $moduleName): void`

Invalidates every action/view cache entry belonging to a module by bumping that module's namespace version.

Nothing is deleted: the entries stay in the backend until it evicts them, but their keys are no longer reachable. The bump is written to the shared backend and to this process's namespace-version memo.

| Parameter | Type | Description |
|---|---|---|
| `$moduleName` | `string` |  |

### invalidateSlotTag()

`public static function invalidateSlotTag(string $tag): void`

Invalidates every slot cache entry carrying $tag by bumping the tag's namespace version.

The tag is normalized through [`CacheManager::slotTagNamespace()`](/api/cache/cache-manager/#slottagnamespace), so tags differing only in characters that normalization replaces share one namespace and are invalidated together.

| Parameter | Type | Description |
|---|---|---|
| `$tag` | `string` |  |

### key()

`public static function key(string ...$parts): string`

PSR-16 §1.3 reserves `{}()/\@:` in cache keys: a conforming implementation may reject any key containing one, and symfony/cache does — either by throwing (`zend.assertions=1`) or, with assertions compiled out in production, by letting a key through that another backend would refuse.

The key segments, outermost namespace first.

| Parameter | Type | Description |
|---|---|---|
| `$parts` | `string` | The key segments, outermost namespace first. |

Returns `string` — A key legal for any PSR-16 implementation.

### reset()

`public static function reset(): void`

Drops all process-wide cache state and purges the filesystem pool's directory.

Clears the memoized instance, the namespace-version memo and the recorded backend name (back to `filesystem`), so the next [`CacheManager::getCache()`](/api/cache/cache-manager/#getcache) rebuilds from configuration. The on-disk purge is best effort: a path that vanishes mid-sweep is logged at debug and the sweep continues, and any failure to locate or traverse the directory at all is ignored — the in-memory reset has already happened either way.

Intended for test isolation and reconfiguration, not the request path; see [`CacheManager::resetRequestState()`](/api/cache/cache-manager/#resetrequeststate) for the per-request boundary.

### resetRequestState()

`public static function resetRequestState(): void`

Request-boundary clear for a persistent worker: drops the per-request namespace-version memo so the next request re-reads versions from the shared backend and therefore observes invalidations performed elsewhere.

Deliberately narrower than [`CacheManager::reset()`](/api/cache/cache-manager/#reset): the configured cache instance and the selected backend survive (rebuilding the pool per request would throw away exactly the connection reuse worker mode exists for), and nothing on disk is touched.

### setCache()

`public static function setCache(CacheInterface $cache, string $backendName = 'custom'): void`

Installs a cache instance process-wide, replacing whatever [`CacheManager::getCache()`](/api/cache/cache-manager/#getcache) would otherwise build, and records $backendName as the value [`CacheManager::getBackend()`](/api/cache/cache-manager/#getbackend) reports.

The override is static state and outlives the request that set it; it stays in force until another call replaces it or [`CacheManager::reset()`](/api/cache/cache-manager/#reset) drops it.

| Parameter | Type | Description |
|---|---|---|
| `$cache` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) |  |
| `$backendName` | `string` |  |

### slotTagNamespace()

`public static function slotTagNamespace(string $tag): string`

The namespace whose version invalidates every slot cache entry carrying `$tag`.

The slot cache tag.

| Parameter | Type | Description |
|---|---|---|
| `$tag` | `string` | The slot cache tag. |

Returns `string` — The namespace name to pass to [`CacheManager::getNamespaceVersion()`](/api/cache/cache-manager/#getnamespaceversion).
