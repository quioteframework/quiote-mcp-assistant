# Index

> The Quiote\\Replay\\Index namespace — 6 documented types.

Everything under `Quiote\Replay\Index`.

## Classes

| Class | Description |
|---|---|
| [`CassetteIndexChain`](/api/replay/index/cassette-index-chain/) | Tries each [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) in order and answers the first cassette resolved, the same "try each, fall through on decline, aggregate on total failure" shape `Quiote\Storage\Azure\ChainedTokenProvider` already uses for token providers. |
| [`CassetteIndexException`](/api/replay/index/cassette-index-exception/) | Thrown by a [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) for a genuine failure -- a malformed hint, a broken query, an auth error, or a pointer that resolved to a key whose object has already expired. |
| [`CassetteIndexRegistry`](/api/replay/index/cassette-index-registry/) | The ordered list of [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) factories a driver package (today, only `quioteframework/replay-azure`) contributes -- unlike [`CassetteStoreRegistry`](/api/replay/store/cassette-store-registry/)'s alias-to-class map, resolving a bare id is a *chain* to try in order, not a single named choice, so this registry holds factories, appended in registration order, rather than named aliases. |
| [`IndexHints`](/api/replay/index/index-hints/) | The developer-supplied resolution hints from `quiote cassette:fetch`/`quiote replay --save`: a key pasted straight out of a log line, or a date/hour narrowing a prefix scan. |
| [`UnavailableIndex`](/api/replay/index/unavailable-index/) | Stands in for an index that could not be constructed, so a misconfigured one reports itself through [`CassetteIndexChain`](/api/replay/index/cassette-index-chain/)'s existing failure aggregation instead of aborting the build of every other index -- see [`CassetteIndexRegistry::build()`](/api/replay/index/cassette-index-registry/#build) for the configuration that made that the common case rather than a corner one. |

## Interfaces

| Interface | Description |
|---|---|
| [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) | Resolves a bare cassette id (plus whatever hints the developer gave on the command line) to a decoded [`Cassette`](/api/replay/cassette/cassette/) -- the "id from a log line to a cassette on disk" chain, tried in order: an explicit `--key`, then `log-analytics`, then a date-hinted `prefix-scan`. |
