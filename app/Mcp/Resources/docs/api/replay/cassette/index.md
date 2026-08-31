# Cassette

> The Quiote\\Replay\\Cassette namespace — 9 documented types.

Everything under `Quiote\Replay\Cassette`.

## Classes

| Class | Description |
|---|---|
| [`Cassette`](/api/replay/cassette/cassette/) | The full record of one request. |
| [`CassetteCodec`](/api/replay/cassette/cassette-codec/) | Encodes/decodes a [`Cassette`](/api/replay/cassette/cassette/) to/from its `.qcast` container: canonical JSON, gzipped by default so bodies and ledgers compress well, with a raw (plain JSON) path for inspection. |
| [`CassetteCodecException`](/api/replay/cassette/cassette-codec-exception/) | A cassette payload could not be decoded: corrupt/truncated gzip, invalid JSON, a missing required section, or a schema version this codec does not understand. |
| [`CassetteId`](/api/replay/cassette/cassette-id/) | A cassette's id, and the safe filesystem/object-store key derived from it. |
| [`CassetteProjector`](/api/replay/cassette/cassette-projector/) | Turns a decoded [`Cassette`](/api/replay/cassette/cassette/) into the flat, section-keyed shape both `cassette:show` and any other reader (an MCP capability, a future web view) present: request/response bodies excerpted to length + sha256 by default, and an effect's captured rows excerpted to a count, so a 2 MiB cassette or a query returning thousands of rows doesn't become that much output by accident. |
| [`DbResult`](/api/replay/cassette/db-result/) | The one shape an [`EffectKind::Db`](/api/replay/cassette/effect-kind/#db) effect's `result` takes, so a consumer does not have to guess which recorder wrote the cassette it is reading. |
| [`Effect`](/api/replay/cassette/effect/) | One entry in a request's effect ledger: a single observed side effect (a query, an HTTP call, a cache read, ...), recorded in the order it happened. |
| [`RecordedAt`](/api/replay/cassette/recorded-at/) | Reads a cassette's `recorded_at` as an instant. |

## Enums

| Enum | Description |
|---|---|
| [`EffectKind`](/api/replay/cassette/effect-kind/) | The kind of side effect one [`Effect`](/api/replay/cassette/effect/) ledger entry records. |
