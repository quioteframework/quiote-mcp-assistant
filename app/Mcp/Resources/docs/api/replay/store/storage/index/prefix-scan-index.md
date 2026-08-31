# PrefixScanIndex

> Reconstructs a key prefix from a `--date` (and, optionally, `--hour`) hint and enumerates it with `listObjects()`, needing no index service or Log Analytics access -- only blob read, which makes it the right fallback for a developer who has a storage RBAC grant but not a workspace one.

Reconstructs a key prefix from a `--date` (and, optionally, `--hour`) hint and enumerates it with `listObjects()`, needing no index service or Log Analytics access -- only blob read, which makes it the right fallback for a developer who has a storage RBAC grant but not a workspace one.

Declines (returns null) when no `--date` hint was given; a date/hour that parses but matches nothing is also a decline, since "not recorded that day" is a legitimate outcome, not a broken index.

With only `--date`, the day's hour buckets are discovered first via a delimited listing (one request returns one common prefix per hour, per [`CassetteKeyScheme::dayPrefix()`](/api/replay/store/storage/cassette-key-scheme/#dayprefix)), then each hour is scanned for a matching slug -- the same "browse what happened this day" technique `cassette:list` itself could use against an object store, just narrowed to one id.

## Synopsis

`final readonly class PrefixScanIndex implements CassetteIndexInterface`

|  |  |
|---|---|
| Implements | [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) |
| Source | `Index/PrefixScanIndex.php` |

## Constructor

### __construct()

`public function __construct(ListableObjectStoreClientInterface $client, CassetteKeyScheme $keyScheme, CassetteCodec $codec = new CassetteCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) |  |
| `$keyScheme` | [`CassetteKeyScheme`](/api/replay/store/storage/cassette-key-scheme/) |  |
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
