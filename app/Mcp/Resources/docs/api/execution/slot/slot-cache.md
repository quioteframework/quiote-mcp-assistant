# SlotCache

> Reading and writing a slot's rendered content to the shared cache.

Reading and writing a slot's rendered content to the shared cache.

Two things here are not a plain get/set.

The key has to change whenever anything the render depended on changes, so it folds in the module, action, output type, a digest of the slot's arguments, and -- when the action declares cache tags -- the current version of each tag's namespace. Bumping a tag's version therefore invalidates every slot carrying it without touching the cache itself.

The payload carries its own monotonic expiry stamp, checked independently of the backend's wall-clock expiry, so a cache whose clock disagrees with this process cannot serve content the slot already considers stale.

A cache that cannot be read or written is a miss, never an error: the page is still correct, only slower, and that is not worth failing a request over. It is reported, because a cache silently doing nothing is a performance cliff nobody notices.

## Synopsis

`final readonly class SlotCache`

|  |  |
|---|---|
| Source | `Execution/Slot/SlotCache.php` |

## Constructor

### __construct()

`public function __construct(CategoryLogger $logger, string $slotKey): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$logger` | [`CategoryLogger`](/api/logging/category-logger/) |  |
| `$slotKey` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`decode(mixed $cached): ?string`](#decode) | Unwraps a stored payload, or null when it is a miss or has expired. |
| [`encode(string $content, ?int $ttl): string`](#encode) | Wraps content with its expiry stamp when an explicit TTL is given. |
| [`keyFor(string $module, string $action, string $outputType, array<string, mixed> $parameters, array<int, mixed> $tags): string`](#keyfor) | Composes the cache key for one slot render. |
| [`read(string $cacheKey): ?string`](#read) | The cached content, or null on a miss, an expired stamp, or an unreadable cache. |
| [`write(string $cacheKey, string $content, ?int $ttl): void`](#write) | Stores the rendered content. |

### decode()

`public function decode(mixed $cached): ?string`

Unwraps a stored payload, or null when it is a miss or has expired.

An unwrapped string is always a hit: it was stored without a TTL, so its freshness is the backend's business.

| Parameter | Type | Description |
|---|---|---|
| `$cached` | `mixed` |  |

Returns `?``string`

### encode()

`public function encode(string $content, ?int $ttl): string`

Wraps content with its expiry stamp when an explicit TTL is given.

Without one the backend's own default expiry governs and the content is stored raw. Content that will not survive json_encode is also stored raw rather than dropped: losing the entry is worse than losing its stamp.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `string` |  |
| `$ttl` | `?``int` |  |

Returns `string`

### keyFor()

`public function keyFor(string $module, string $action, string $outputType, array<string, mixed> $parameters, array<int, mixed> $tags): string`

Composes the cache key for one slot render.

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$outputType` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$tags` | `array``<``int``, ``mixed``>` |  |

Returns `string`

### read()

`public function read(string $cacheKey): ?string`

The cached content, or null on a miss, an expired stamp, or an unreadable cache.

| Parameter | Type | Description |
|---|---|---|
| `$cacheKey` | `string` |  |

Returns `?``string`

### write()

`public function write(string $cacheKey, string $content, ?int $ttl): void`

Stores the rendered content.

A failure leaves the page correct and only slower.

| Parameter | Type | Description |
|---|---|---|
| `$cacheKey` | `string` |  |
| `$content` | `string` |  |
| `$ttl` | `?``int` |  |
