# LogAnalyticsIndex

> Upgrades resolution from \"an id plus a date/hour hint\" to a bare id with nothing else: queries the workspace for the pointer log line the recorder itself wrote, reads its `cassette_key` straight off that record, and fetches the object at that key.

Upgrades resolution from "an id plus a date/hour hint" to a bare id with nothing else: queries the workspace for the pointer log line the recorder itself wrote, reads its `cassette_key` straight off that record, and fetches the object at that key.

Declines (returns null) when no workspace is configured, or the query legitimately returns no matching pointer -- both are "nothing to find here", not a broken index. A pointer that *is* found but whose object has since expired throws instead of declining: the pointer outliving the cassette is a designed property (a lifecycle rule can prune the blob long before log retention expires), and "the request failed * and a cassette existed for it, but it is gone now" is a materially different, more useful answer than a plain "not found" -- worth surfacing, not swallowing into a decline.

## Synopsis

`final readonly class LogAnalyticsIndex implements CassetteIndexInterface`

|  |  |
|---|---|
| Implements | [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) |
| Source | `Index/LogAnalyticsIndex.php` |

## Constructor

### __construct()

`public function __construct(AzureMonitorQueryClientInterface|null $queryClient, ObjectStoreClientInterface|null $objectClient = null, int $lookbackHours = 720, CassetteCodec $codec = new CassetteCodec(…)): mixed`

Only ever used to fetch the object a
       pointer names, so it is not required when `$queryClient` is null -- and building one
       for an index that will decline every call means constructing a blob client and its
       credential for nothing, on every resolution attempt.

| Parameter | Type | Description |
|---|---|---|
| `$queryClient` | [`AzureMonitorQueryClientInterface`](/api/storage/azure/azure-monitor-query-client-interface/)`|``null` | Null when no workspace is configured, which makes this index a permanent decline. |
| `$objectClient` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/)`|``null` | Only ever used to fetch the object a pointer names, so it is not required when `$queryClient` is null -- and building one for an index that will decline every call means constructing a blob client and its credential for nothing, on every resolution attempt. |
| `$lookbackHours` | `int` |  |
| `$codec` | [`CassetteCodec`](/api/replay/cassette/cassette-codec/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`resolve(CassetteId $id, IndexHints $hints): ?Cassette`](#resolve) | Returns null when this index has nothing to try for the given id/hints -- not configured, no matching hint present, or a legitimate zero-result lookup. |

### resolve()

`public function resolve(CassetteId $id, IndexHints $hints): ?Cassette`

Returns null when this index has nothing to try for the given id/hints -- not configured, no matching hint present, or a legitimate zero-result lookup.

That is the designed "try the next index in the chain" signal, not an error. A genuine failure (a malformed hint, a broken query, an auth error, or a pointer whose payload has already expired) throws [`CassetteIndexException`](/api/replay/index/cassette-index-exception/) instead, so a misconfigured or broken index never masquerades as "not found here."

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$hints` | [`IndexHints`](/api/replay/index/index-hints/) |  |

Returns `?`[`Cassette`](/api/replay/cassette/cassette/)
