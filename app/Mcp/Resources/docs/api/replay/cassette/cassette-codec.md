# CassetteCodec

> Encodes/decodes a Cassette to/from its `.qcast` container: canonical JSON, gzipped by default so bodies and ledgers compress well, with a raw (plain JSON) path for inspection.

Encodes/decodes a [`Cassette`](/api/replay/cassette/cassette/) to/from its `.qcast` container: canonical JSON, gzipped by default so bodies and ledgers compress well, with a raw (plain JSON) path for inspection.

`_schema_version` is checked: this codec understands exactly one version. A newer version is refused outright, naming the version it needs -- no silent best-effort parsing. There is no older version yet, so the "load an * old version through a documented forward-reader" branch has nothing to implement; when a version 2 exists, that branch is added here rather than assumed in advance.

## Synopsis

`final class CassetteCodec`

|  |  |
|---|---|
| Source | `Cassette/CassetteCodec.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CURRENT_SCHEMA_VERSION` | `1` |  |
| `DEFAULT_MAX_DECODED_BYTES` | `33554432` | Ceiling on the inflated size of a `.qcast` payload, well above what `replay.max_bytes`' own 2 MiB default plus a bounded effect ledger can produce, and far below what an unbounded inflate can cost. |

## Constructor

### __construct()

`public function __construct(positive-int $maxDecodedBytes = self::DEFAULT_MAX_DECODED_BYTES): mixed`

Inflated-size ceiling for [`CassetteCodec::decode()`](/api/replay/cassette/cassette-codec/#decode).

| Parameter | Type | Description |
|---|---|---|
| `$maxDecodedBytes` | `positive-int` | Inflated-size ceiling for [`CassetteCodec::decode()`](/api/replay/cassette/cassette-codec/#decode). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`decode(string $payload): Cassette`](#decode) | Decodes a gzip-wrapped `.qcast` payload. |
| [`decodeRaw(string $json): Cassette`](#decoderaw) | Decodes a plain-JSON (`--raw`) payload. |
| [`encode(Cassette $cassette): string`](#encode) | Gzip-wrapped JSON -- the on-disk `.qcast` format. |
| [`encodeRaw(Cassette $cassette): string`](#encoderaw) | Plain JSON, uncompressed -- the `--raw` inspection format. |

### decode()

`public function decode(string $payload): Cassette`

Decodes a gzip-wrapped `.qcast` payload.

Inflated incrementally against `$maxDecodedBytes` rather than through `gzdecode()`, because a cassette is untrusted input and gzip's compression ratio is unbounded: a few hundred kilobytes of highly repetitive `.qcast` inflates to hundreds of megabytes, and exhausting `memory_limit` is a fatal error rather than a catchable one -- so a single oversized cassette in a store would take down `cassette:list`/`cassette:prune` for every cassette, past any `catch (Throwable)` a caller wrapped it in. Checking the budget as the output grows refuses that payload with a normal exception instead, and does so before the allocation rather than after it.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | `string` |  |

Returns [`Cassette`](/api/replay/cassette/cassette/)

### decodeRaw()

`public function decodeRaw(string $json): Cassette`

Decodes a plain-JSON (`--raw`) payload.

| Parameter | Type | Description |
|---|---|---|
| `$json` | `string` |  |

Returns [`Cassette`](/api/replay/cassette/cassette/)

### encode()

`public function encode(Cassette $cassette): string`

Gzip-wrapped JSON -- the on-disk `.qcast` format.

| Parameter | Type | Description |
|---|---|---|
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |

Returns `string`

### encodeRaw()

`public function encodeRaw(Cassette $cassette): string`

Plain JSON, uncompressed -- the `--raw` inspection format.

| Parameter | Type | Description |
|---|---|---|
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |

Returns `string`
