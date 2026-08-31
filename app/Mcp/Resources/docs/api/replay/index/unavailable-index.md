# UnavailableIndex

> Stands in for an index that could not be constructed, so a misconfigured one reports itself through CassetteIndexChain's existing failure aggregation instead of aborting the build of every other index -- see CassetteIndexRegistry::build() for the configuration that made that the common case rather than a corner one.

Stands in for an index that could not be constructed, so a misconfigured one reports itself through [`CassetteIndexChain`](/api/replay/index/cassette-index-chain/)'s existing failure aggregation instead of aborting the build of every other index -- see [`CassetteIndexRegistry::build()`](/api/replay/index/cassette-index-registry/#build) for the configuration that made that the common case rather than a corner one.

Throws rather than returning null, deliberately: a null is a decline ("nothing to find here"), and "this index is misconfigured" is not the same answer. The chain records it as a failure and moves on, and names it in the aggregate error if nothing else resolves -- which is exactly the information a developer needs to fix the configuration.

## Synopsis

`final readonly class UnavailableIndex implements CassetteIndexInterface`

|  |  |
|---|---|
| Implements | [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) |
| Source | `Index/UnavailableIndex.php` |

## Constructor

### __construct()

`public function __construct(Throwable $reason): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$reason` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |

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
