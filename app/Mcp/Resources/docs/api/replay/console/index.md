# Console

> The Quiote\\Replay\\Console namespace — 8 documented types.

Everything under `Quiote\Replay\Console`.

## Classes

| Class | Description |
|---|---|
| [`CassetteFetchCommand`](/api/replay/console/cassette-fetch-command/) | `quiote cassette:fetch <id>` -- the explicit fetch-only verb: resolve $id to a cassette (local cache, then the configured store, then the cassette-index chain) and keep it in the local cache without replaying it. |
| [`CassetteListCommand`](/api/replay/console/cassette-list-command/) | `cassette:list` -- enumerates the configured store, via whichever [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) `replay.store` resolves to (see [`ResolvesCassetteStore`](/api/replay/console/resolves-cassette-store/)) -- the file store's own directory listing, or `quioteframework/replay-pdo`'s table, today; an object-store-backed one would use its own `listObjects()` instead, not this interface. |
| [`CassettePruneCommand`](/api/replay/console/cassette-prune-command/) | `cassette:prune [--older-than=30d] [--keep=500]` -- unnecessary on Azure (a blob lifecycle rule does it without anything running in the cluster), so this exists for the file and PDO stores instead, via whichever [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) `replay.store` resolves to. |
| [`CassetteShowCommand`](/api/replay/console/cassette-show-command/) | `cassette:show <id>` -- decodes one cassette and prints the requested projection. |
| [`ReplayCommand`](/api/replay/console/replay-command/) | `quiote replay <id>` -- re-runs a recorded cassette and reports drift, and, with `--as-test`, emits a committed regression test from it. |

## Traits

| Trait | Description |
|---|---|
| [`CollectsCassetteRows`](/api/replay/console/collects-cassette-rows/) | Decodes every cassette a [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) holds into the small summary shape `cassette:list` and `cassette:prune` both filter and sort in PHP -- shared so the two commands never disagree about what a "row" is or how an unreadable cassette is reported. |
| [`ResolvesCassetteStore`](/api/replay/console/resolves-cassette-store/) | Resolves whichever [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) `replay.store` actually names, via the app's own DI container -- the same seam `Quiote\Replay\Recording\RecorderMiddleware`'s factory already resolves it through (`ReplayPlugin::register()`'s `attributedMiddleware` closure). |
| [`ResolvesCassetteViaIndexes`](/api/replay/console/resolves-cassette-via-indexes/) | Resolves a bare cassette id the way `quiote replay`/`quiote cassette:fetch` both promise: the local cache first (no network), then whichever store `replay.store` names, then -- only if still missing -- the contributed [`CassetteIndexInterface`](/api/replay/index/cassette-index-interface/) chain using whatever `--key`/`--date`/`--hour` hints were given. |
