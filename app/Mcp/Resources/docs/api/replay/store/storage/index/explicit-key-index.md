# ExplicitKeyIndex

> The zero-dependency, always-works fallback: a key pasted straight out of a pointer log line, fetched from the object store directly.

The zero-dependency, always-works fallback: a key pasted straight out of a pointer log line, fetched from the object store directly.

Declines (returns null) when `--key` was not given -- this index has nothing to try without one -- but a given key that does not resolve to a real object is a genuine failure, since the developer pointed at a specific location expecting it to exist.

## Synopsis

`final readonly class ExplicitKeyIndex implements CassetteIndexInterface`

|  |  |
|---|---|
| Implements | [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) |
| Source | `Index/ExplicitKeyIndex.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, CassetteCodec $codec = new CassetteCodec(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) |  |
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
