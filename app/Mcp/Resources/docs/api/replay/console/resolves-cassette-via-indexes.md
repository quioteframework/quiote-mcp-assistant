# ResolvesCassetteViaIndexes

> Resolves a bare cassette id the way `quiote replay`/`quiote cassette:fetch` both promise: the local cache first (no network), then whichever store `replay.store` names, then -- only if still missing -- the contributed CassetteIndexInterface chain using whatever `--key`/`--date`/`--hour` hints were given.

Resolves a bare cassette id the way `quiote replay`/`quiote cassette:fetch` both promise: the local cache first (no network), then whichever store `replay.store` names, then -- only if still missing -- the contributed [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) chain using whatever `--key`/`--date`/`--hour` hints were given.

A cassette resolved via the store or an index is written into the local cache before returning, so a repeat lookup for the same id needs no network at all.

The local cache is deliberately a *different* directory concern from `replay.store.path` (the file store's own path, when `replay.store = file`): `replay.local_path` exists specifically so a remote-store deployment (`replay.store = azure-blob`) still gets a fast, offline-capable local copy once fetched, per `replay.local_path`'s own config default.

## Synopsis

`trait ResolvesCassetteViaIndexes`

|  |  |
|---|---|
| Uses | [`ResolvesCassetteStore`](/api/replay/console/resolves-cassette-store/) |
| Source | `Console/ResolvesCassetteViaIndexes.php` |
