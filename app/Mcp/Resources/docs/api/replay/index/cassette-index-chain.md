# CassetteIndexChain

> Tries each CassetteIndexInterface in order and answers the first cassette resolved, the same \"try each, fall through on decline, aggregate on total failure\" shape `Quiote\\Storage\\Azure\\ChainedTokenProvider` already uses for token providers.

Tries each [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) in order and answers the first cassette resolved, the same "try each, fall through on decline, aggregate on total failure" shape `Quiote\Storage\Azure\ChainedTokenProvider` already uses for token providers.

A `null` from an index is a decline (try the next); a [`CassetteIndexException`](/api/replay/index/cassette-index-exception/) is recorded and also falls through, so one broken/unconfigured index never blocks the others -- but if every index either declines or fails, the aggregate exception names every failure, not just "not found."

## Synopsis

`final class CassetteIndexChain`

|  |  |
|---|---|
| Source | `Index/CassetteIndexChain.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(list<CassetteIndexInterface> $indexes, CassetteId $id, IndexHints $hints): Cassette`](#resolve) |  |

### resolve()

`public static function resolve(list<CassetteIndexInterface> $indexes, CassetteId $id, IndexHints $hints): Cassette`

| Parameter | Type | Description |
|---|---|---|
| `$indexes` | `list``<`[`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/)`>` |  |
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$hints` | [`IndexHints`](/api/replay/index/index-hints/) |  |

Returns [`Cassette`](/api/replay/cassette/cassette/)

| Throws | When |
|---|---|
| `CassetteIndexException` | If no index in the chain resolved the id. |
