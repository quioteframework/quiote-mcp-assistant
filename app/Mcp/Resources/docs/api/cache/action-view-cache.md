# ActionViewCache

> Minimal action+view result cache.

Minimal action+view result cache.

Keyed by module:action:outputType, plus the current locale and per-user fingerprint when given -- a cached response is specific to the locale it was rendered in, so two requests differing only by locale must not collide on the same entry. Stores: view_module, view_name, action_attributes (optional), rendered response content, plus (migration) execution descriptor/state metadata when provided.

## Synopsis

`class ActionViewCache`

|  |  |
|---|---|
| Source | `Cache/ActionViewCache.php` |

## Constructor

### __construct()

`public function __construct(CacheInterface $cache, ?int $defaultTtlSeconds = 300): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$cache` | [`CacheInterface`](https://www.php-fig.org/psr/psr-16/) |  |
| `$defaultTtlSeconds` | `?``int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $module, string $action, string $outputType, ?string $fingerprint = null, ?string $locale = null): void`](#delete) | Drops the single entry matching this exact key combination. |
| [`get(string $module, string $action, string $outputType, ?string $fingerprint = null, ?string $locale = null): array<string, mixed>|null`](#get) |  |
| [`invalidateAction(string $module, string $action): void`](#invalidateaction) | Invalidates every cached entry for one action, across all output types, locales and user fingerprints. |
| [`invalidateModule(string $module): void`](#invalidatemodule) | Invalidates every cached entry belonging to a module. |
| [`set(string $module, string $action, string $outputType, array<string, mixed> $payload, ?int $ttlSeconds = null, ?string $fingerprint = null, ?string $locale = null): void`](#set) |  |

### delete()

`public function delete(string $module, string $action, string $outputType, ?string $fingerprint = null, ?string $locale = null): void`

Drops the single entry matching this exact key combination.

Only the entry for the given fingerprint and locale is removed; variants rendered for another user or another locale survive. Use invalidateAction() to drop them all at once.

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$outputType` | `string` |  |
| `$fingerprint` | `?``string` |  |
| `$locale` | `?``string` |  |

### get()

`public function get(string $module, string $action, string $outputType, ?string $fingerprint = null, ?string $locale = null): array<string, mixed>|null`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$outputType` | `string` |  |
| `$fingerprint` | `?``string` |  |
| `$locale` | `?``string` |  |

Returns `array``<``string``, ``mixed``>``|``null`

### invalidateAction()

`public function invalidateAction(string $module, string $action): void`

Invalidates every cached entry for one action, across all output types, locales and user fingerprints.

Delegates to CacheManager, which bumps that action's namespace version; the module's other actions are unaffected and the stale entries are left to expire rather than being deleted.

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |

### invalidateModule()

`public function invalidateModule(string $module): void`

Invalidates every cached entry belonging to a module.

Delegates to CacheManager, which bumps the module's namespace version so existing entries can no longer be addressed. Nothing is deleted from the underlying pool; the orphaned entries expire on their own TTL.

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |

### set()

`public function set(string $module, string $action, string $outputType, array<string, mixed> $payload, ?int $ttlSeconds = null, ?string $fingerprint = null, ?string $locale = null): void`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$outputType` | `string` |  |
| `$payload` | `array``<``string``, ``mixed``>` |  |
| `$ttlSeconds` | `?``int` |  |
| `$fingerprint` | `?``string` |  |
| `$locale` | `?``string` |  |
