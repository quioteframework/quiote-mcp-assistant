# CassetteIndexInterface

> Resolves a bare cassette id (plus whatever hints the developer gave on the command line) to a decoded Cassette -- the \"id from a log line to a cassette on disk\" chain, tried in order: an explicit `--key`, then `log-analytics`, then a date-hinted `prefix-scan`.

Resolves a bare cassette id (plus whatever hints the developer gave on the command line) to a decoded [`Cassette`](/api/replay/cassette/cassette/) -- the "id from a log line to a cassette on disk" chain, tried in order: an explicit `--key`, then `log-analytics`, then a date-hinted `prefix-scan`.

## Synopsis

`interface CassetteIndexInterface`

|  |  |
|---|---|
| Implemented by | [`UnavailableIndex`](/api/replay/index/unavailable-index/), [`LogAnalyticsIndex`](/api/replay/store/azure/index/log-analytics-index/), [`ExplicitKeyIndex`](/api/replay/store/storage/index/explicit-key-index/), [`PrefixScanIndex`](/api/replay/store/storage/index/prefix-scan-index/) |
| Source | `Index/CassetteIndexInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(CassetteId $id, IndexHints $hints): ?Cassette`](#resolve) | Returns null when this index has nothing to try for the given id/hints -- not configured, no matching hint present, or a legitimate zero-result lookup. |

### resolve()

`abstract public function resolve(CassetteId $id, IndexHints $hints): ?Cassette`

Returns null when this index has nothing to try for the given id/hints -- not configured, no matching hint present, or a legitimate zero-result lookup.

That is the designed "try the next index in the chain" signal, not an error. A genuine failure (a malformed hint, a broken query, an auth error, or a pointer whose payload has already expired) throws [`CassetteIndexException`](/api/replay/index/cassette-index-exception/) instead, so a misconfigured or broken index never masquerades as "not found here."

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$hints` | [`IndexHints`](/api/replay/index/index-hints/) |  |

Returns `?`[`Cassette`](/api/replay/cassette/cassette/)
