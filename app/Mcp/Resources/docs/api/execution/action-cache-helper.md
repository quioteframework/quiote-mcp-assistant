# ActionCacheHelper

> Static helpers for the action/view cache round trip used by DispatchMiddleware.

Static helpers for the action/view cache round trip used by DispatchMiddleware.

Reads and writes go through [`ActionViewCache`](/api/cache/action-view-cache/), keyed by the module, action and output type of an [`ActionDescriptor`](/api/execution/action-descriptor/) and optionally partitioned by user fingerprint and locale. Both [`ActionCacheHelper::store()`](/api/execution/action-cache-helper/#store) and [`ActionCacheHelper::read()`](/api/execution/action-cache-helper/#read) are no-ops when `core.cache_enabled` is off (the default) and swallow backend errors, so a failing cache degrades to a miss rather than to a failed request.

[`ActionCacheHelper::buildContextFromPayload()`](/api/execution/action-cache-helper/#buildcontextfrompayload) is the other direction: it validates a stored payload, writes the view selection and validation/security decisions back onto an [`ExecutionState`](/api/execution/execution-state/), and assembles the [`ActionExecutionContext`](/api/execution/action-execution-context/) that a cache hit is served from. No view instance is reconstructed on replay.

## Synopsis

`final class ActionCacheHelper`

|  |  |
|---|---|
| Source | `Execution/ActionCacheHelper.php` |

## Methods

| Method | Description |
|---|---|
| [`buildContextFromPayload(array<string, mixed> $payload, ActionDescriptor $desc, ExecutionState $state, ?Action $actionInstance, WebRequest $request, ?string $contentOverride = null): ActionExecutionContext`](#buildcontextfrompayload) | Hydrate ExecutionState and build an ActionExecutionContext from a payload. |
| [`read(ActionViewCache $cache, ActionDescriptor $desc, ?string $userFingerprint = null, ?string $locale = null): array<string, mixed>|null`](#read) | Raw read of cached payload (no hydration) – returns array payload or null. |
| [`store(ActionViewCache $cache, ActionDescriptor $desc, ExecutionState $state, string $content, array<string, mixed> $actionAttributes, bool $isSimple, ?int $ttl = null, ?string $userFingerprint = null, ?string $locale = null): void`](#store) | Unified cache payload write. |

### buildContextFromPayload()

`public static function buildContextFromPayload(array<string, mixed> $payload, ActionDescriptor $desc, ExecutionState $state, ?Action $actionInstance, WebRequest $request, ?string $contentOverride = null): ActionExecutionContext`

Hydrate ExecutionState and build an ActionExecutionContext from a payload.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | `array``<``string``, ``mixed``>` |  |
| `$desc` | [`ActionDescriptor`](/api/execution/action-descriptor/) |  |
| `$state` | [`ExecutionState`](/api/execution/execution-state/) |  |
| `$actionInstance` | `?`[`Action`](/api/action/action/) |  |
| `$request` | [`WebRequest`](/api/request/web-request/) |  |
| `$contentOverride` | `?``string` |  |

Returns [`ActionExecutionContext`](/api/execution/action-execution-context/)

### read()

`public static function read(ActionViewCache $cache, ActionDescriptor $desc, ?string $userFingerprint = null, ?string $locale = null): array<string, mixed>|null`

Raw read of cached payload (no hydration) – returns array payload or null.

Reads exactly the partition it was asked for. There used to be a fallback to the unpartitioned entry when the per-user lookup missed, which meant a partitioned read could still be answered with content rendered for a different identity -- defeating the partitioning on every cold miss. A miss in a partition is a miss.

| Parameter | Type | Description |
|---|---|---|
| `$cache` | [`ActionViewCache`](/api/cache/action-view-cache/) |  |
| `$desc` | [`ActionDescriptor`](/api/execution/action-descriptor/) |  |
| `$userFingerprint` | `?``string` |  |
| `$locale` | `?``string` |  |

Returns `array``<``string``, ``mixed``>``|``null`

### store()

`public static function store(ActionViewCache $cache, ActionDescriptor $desc, ExecutionState $state, string $content, array<string, mixed> $actionAttributes, bool $isSimple, ?int $ttl = null, ?string $userFingerprint = null, ?string $locale = null): void`

Unified cache payload write.

| Parameter | Type | Description |
|---|---|---|
| `$cache` | [`ActionViewCache`](/api/cache/action-view-cache/) |  |
| `$desc` | [`ActionDescriptor`](/api/execution/action-descriptor/) |  |
| `$state` | [`ExecutionState`](/api/execution/execution-state/) |  |
| `$content` | `string` |  |
| `$actionAttributes` | `array``<``string``, ``mixed``>` |  |
| `$isSimple` | `bool` |  |
| `$ttl` | `?``int` |  |
| `$userFingerprint` | `?``string` |  |
| `$locale` | `?``string` |  |
