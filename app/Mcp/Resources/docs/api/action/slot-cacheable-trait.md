# SlotCacheableTrait

> Optional trait for actions that want to customize slot caching TTL and tags.

Optional trait for actions that want to customize slot caching TTL and tags.

## Synopsis

`trait SlotCacheableTrait`

|  |  |
|---|---|
| Source | `Action/SlotCacheableTrait.php` |

## Methods

| Method | Description |
|---|---|
| [`slotCacheTags(array<string, mixed> $parameters = []): array<int, string>`](#slotcachetags) | Return an array of tag identifiers (strings) used for versioned slot cache keys. |
| [`slotCacheTtlSeconds(): ?int`](#slotcachettlseconds) | Return TTL in seconds (null or <=0 for default/no explicit TTL). |

### slotCacheTags()

`public function slotCacheTags(array<string, mixed> $parameters = []): array<int, string>`

Return an array of tag identifiers (strings) used for versioned slot cache keys.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns `array``<``int``, ``string``>`

### slotCacheTtlSeconds()

`public function slotCacheTtlSeconds(): ?int`

Return TTL in seconds (null or <=0 for default/no explicit TTL).

Returns `?``int`
