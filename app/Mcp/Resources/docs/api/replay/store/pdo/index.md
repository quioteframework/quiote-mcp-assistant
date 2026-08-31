# Pdo

> The Quiote\\Replay\\Store\\Pdo namespace — 2 documented types.

Everything under `Quiote\Replay\Store\Pdo`.

## Classes

| Class | Description |
|---|---|
| [`PdoCassetteStore`](/api/replay/store/pdo/pdo-cassette-store/) | A PDO-backed [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/): a pod's filesystem does not survive a restart/eviction, so a team without an object-store backend keeps cassettes in the database it already has instead. |
| [`ReplayPdoPlugin`](/api/replay/store/pdo/replay-pdo-plugin/) | Registers the `pdo` cassette store alias and its `CassetteStoreInterface` binding, through the same plugin mechanism every other Quiote package uses. |
