# CacheableActionTrait

> Opt-in PSR cache support for actions.

Opt-in PSR cache support for actions.

Usage: use CacheableActionTrait; override cacheTtlSeconds() or isCacheable().

A secure action's cache is partitioned per user by default -- this trait does not touch [`Action::cacheVaryByUser()`](/api/action/action/#cachevarybyuser), so it inherits that safe default. Override it to false only if the output really is identical for every user allowed to reach the action.

## Synopsis

`trait CacheableActionTrait`

|  |  |
|---|---|
| Source | `Action/Traits/CacheableActionTrait.php` |

## Methods

| Method | Description |
|---|---|
| [`cacheTtlSeconds(?string $outputType = null): ?int`](#cachettlseconds) | Returns the lifetime, in seconds, of a cached response for this action. |
| [`isCacheable(?string $outputType = null): bool`](#iscacheable) | Reports that the action's response may be cached. |

### cacheTtlSeconds()

`public function cacheTtlSeconds(?string $outputType = null): ?int`

Returns the lifetime, in seconds, of a cached response for this action.

Five minutes for every output type. Override in the using action to tune the lifetime per output type, or return null to fall back to the framework's own default lifetime handling.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?``string` |  |

Returns `?``int`

### isCacheable()

`public function isCacheable(?string $outputType = null): bool`

Reports that the action's response may be cached.

Returns true for every output type. Override in the using action to restrict caching to particular output types, or to disable it entirely for a request whose result must always be recomputed.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?``string` |  |

Returns `bool`
