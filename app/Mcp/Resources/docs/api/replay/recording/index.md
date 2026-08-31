# Recording

> The Quiote\\Replay\\Recording namespace — 10 documented types.

Everything under `Quiote\Replay\Recording`.

## Classes

| Class | Description |
|---|---|
| [`ActiveEffectLedger`](/api/replay/recording/active-effect-ledger/) | The single currently-active [`EffectLedger`](/api/replay/replay/effect-ledger/), for a driver whose recorder is a decorator wrapped once around a specific connection (the Doctrine/Eloquent/Cycle shape) rather than a process-scoped observer (Propulsion's shape, which needs [`EffectLedgerRegistry`](/api/replay/recording/effect-ledger-registry/)'s correlation-id map instead -- see that class's own docblock). |
| [`EffectLedgerRegistry`](/api/replay/recording/effect-ledger-registry/) | Routes a driver observation back to the request it belongs to, by correlation id. |
| [`EffectRedactor`](/api/replay/recording/effect-redactor/) | Scrubs an effect's `call` and `result` on their way into [`EffectLedger`](/api/replay/replay/effect-ledger/), so redaction covers the effect ledger and not only the request envelope. |
| [`EffectSourceRegistry`](/api/replay/recording/effect-source-registry/) | Every registered [`EffectSource`](/api/replay/recording/effect-source/), for [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) to activate/deactivate around one request. |
| [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) | Captures the request/response/resolved/session/exception detail for a request and writes a [`Cassette`](/api/replay/cassette/cassette/) for whichever requests [`SamplingPolicy`](/api/replay/recording/sampling-policy/) keeps. |
| [`RecordingSession`](/api/replay/recording/recording-session/) | The in-flight buffer for one request: bounded by `replay.max_bytes` and `replay.max_effects`, so a request with an unusually large body or an unusually long effect ledger produces a cassette that says it was truncated rather than growing without bound. |
| [`Redactor`](/api/replay/recording/redactor/) | Header/cookie/param/session/body scrubbing. |

## Interfaces

| Interface | Description |
|---|---|
| [`EffectSource`](/api/replay/recording/effect-source/) | A driver-specific package's hook into [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/)'s recording lifecycle, for an ORM/driver whose own instrumentation seam is process-scoped rather than per-connection -- Propulsion's `addQueryObserver()` being the motivating case (see `quioteframework/replay-propulsion`'s own `PropulsionEffectSource`): a single observer is registered once at boot, and needs telling, for the duration of one request, which correlation id's queries belong to which [`EffectLedger`](/api/replay/replay/effect-ledger/). |

## Enums

| Enum | Description |
|---|---|
| [`RedactionMode`](/api/replay/recording/redaction-mode/) | How [`Redactor`](/api/replay/recording/redactor/) replaces a value matched against a denylist. |
| [`SamplingPolicy`](/api/replay/recording/sampling-policy/) | Which requests [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) keeps a cassette for. |
