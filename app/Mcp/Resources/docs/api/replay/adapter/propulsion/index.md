# Propulsion

> The Quiote\\Replay\\Adapter\\Propulsion namespace — 4 documented types.

Everything under `Quiote\Replay\Adapter\Propulsion`.

## Classes

| Class | Description |
|---|---|
| [`LedgerBackedPropulsionPdo`](/api/replay/adapter/propulsion/ledger-backed-propulsion-pdo/) | A Propulsion connection that answers from a replaying [`EffectLedger`](/api/replay/replay/effect-ledger/) and never opens a database. |
| [`PropulsionEffectSource`](/api/replay/adapter/propulsion/propulsion-effect-source/) | Propulsion's hook into both halves of the replay lifecycle. |
| [`PropulsionQueryRecorder`](/api/replay/adapter/propulsion/propulsion-query-recorder/) | Records every Propulsion query into whichever request's [`EffectLedger`](/api/replay/replay/effect-ledger/) it belongs to, via Propulsion's own observer seam (`RowCapturingQueryObserver`). |
| [`ReplayPropulsionPlugin`](/api/replay/adapter/propulsion/replay-propulsion-plugin/) | Wires Propulsion's own query observer seam into `quioteframework/replay`'s generic effect-recording seam, through the same plugin mechanism every other Quiote package uses. |
