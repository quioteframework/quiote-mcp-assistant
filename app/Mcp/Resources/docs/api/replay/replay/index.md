# Replay

> The Quiote\\Replay\\Replay namespace — 21 documented types.

Everything under `Quiote\Replay\Replay`.

## Classes

| Class | Description |
|---|---|
| [`AssertingQueueDriver`](/api/replay/replay/asserting-queue-driver/) | The isolated-replay counterpart to [`RecordingQueueDriver`](/api/replay/queue/recording-queue-driver/): never pushes to a real backend -- isolated replay has none -- and instead captures every [`AssertingQueueDriver::push()`](/api/replay/replay/asserting-queue-driver/#push) call so an emitted test can assert against it afterward -- "this request enqueued exactly this job." |
| [`DriftReport`](/api/replay/replay/drift-report/) | The result of [`ResponseDiffer::diff()`](/api/replay/replay/response-differ/#diff) for one replay. |
| [`EffectLedger`](/api/replay/replay/effect-ledger/) | A request's effect ledger: written to by appending during recording, read from by matching during replay. |
| [`IsolatedReplay`](/api/replay/replay/isolated-replay/) | Runs a cassette against stubs built from its own recorded effects, so nothing the original request did is performed again. |
| [`IsolatedReplayResult`](/api/replay/replay/isolated-replay-result/) | What one [`IsolatedReplay::run()`](/api/replay/replay/isolated-replay/#run) produced: the response, the response diff, and what the ledger was asked for. |
| [`LedgerMatch`](/api/replay/replay/ledger-match/) | What [`LedgerMatcher`](/api/replay/replay/ledger-matcher/) found, and how it found it. |
| [`LedgerMatcher`](/api/replay/replay/ledger-matcher/) | The fingerprint-then-sequence matching algorithm: a replayed call is matched against the first not-yet-consumed effect of the same [`EffectKind`](/api/replay/cassette/effect-kind/) whose fingerprint is identical, so two identical queries recorded back to back are still matched in the order they happened. |
| [`ReplayEngine`](/api/replay/replay/replay-engine/) | Drives one cassette through the pipeline and reports drift, in one of two modes. |
| [`ReplayException`](/api/replay/replay/replay-exception/) | A cassette cannot be replayed as given: no request was captured to replay (recorded under `#[NoRecord]`, or with `replay.capture_body` disabled), or a safety guard in [`ReplayEngine`](/api/replay/replay/replay-engine/) refused to run it. |
| [`ReplayResult`](/api/replay/replay/replay-result/) | What one call to [`ReplayEngine::replay()`](/api/replay/replay/replay-engine/#replay) produced. |
| [`RequestReconstructor`](/api/replay/replay/request-reconstructor/) | Rebuilds the PSR-7 request a cassette recorded, so [`ReplayEngine`](/api/replay/replay/replay-engine/) can hand it to the real pipeline. |
| [`ResponseDiffer`](/api/replay/replay/response-differ/) | Diffs a fresh replay response against a cassette's recorded one: drift as a feature -- every difference is reported through [`Diagnostic`](/api/support/compiler/diagnostic/), never silently smoothed over. |
| [`StubbedCache`](/api/replay/replay/stubbed-cache/) | The isolated-replay counterpart to [`RecordingCache`](/api/replay/cache/recording-cache/): never touches a real cache backend, answering every call from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) matched on the same [`CacheFingerprint`](/api/replay/cache/cache-fingerprint/) scheme the recorder used. |
| [`StubbedEnvironmentReader`](/api/replay/replay/stubbed-environment-reader/) | The isolated-replay counterpart to [`RecordingEnvironmentReader`](/api/replay/env/recording-environment-reader/): never reads a real environment variable, answering every call from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) matched on the bare variable name. |
| [`StubbedHttpTransport`](/api/replay/replay/stubbed-http-transport/) | The isolated-replay counterpart to [`RecordingHttpTransport`](/api/replay/http/recording-http-transport/): never opens a socket, never resolves a hostname, never touches the real network under any circumstance -- in isolated mode there is no transport at all. |
| [`StubbedPdo`](/api/replay/replay/stubbed-pdo/) | The isolated-replay counterpart to `Quiote\Replay\Db\RecordingPdo`: never calls `parent::__construct()`, so no real connection is ever attempted, and answers every `exec()`/`query()`/`prepare()->execute()` from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/) via [`StubbedPdoStatement`](/api/replay/replay/stubbed-pdo-statement/). |
| [`StubbedPdoStatement`](/api/replay/replay/stubbed-pdo-statement/) | The isolated-replay counterpart to [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/): never touches a real connection (never calls `parent::__construct()`), and answers `execute()`/`fetch()`/`fetchAll()`/`rowCount()` entirely from an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), matching on the same normalized-SQL fingerprint the recorder used. |
| [`StubbedTransportException`](/api/replay/replay/stubbed-transport-exception/) | What [`StubbedHttpTransport`](/api/replay/replay/stubbed-http-transport/) raises when the ledger has no recorded counterpart for a request. |

## Interfaces

| Interface | Description |
|---|---|
| [`IsolatesFromLedger`](/api/replay/replay/isolates-from-ledger/) | An [`EffectSource`](/api/replay/recording/effect-source/) whose driver answers from a replaying [`EffectLedger`](/api/replay/replay/effect-ledger/) instead of reaching its real connection. |

## Enums

| Enum | Description |
|---|---|
| [`LedgerDirection`](/api/replay/replay/ledger-direction/) | Which way an [`EffectLedger`](/api/replay/replay/effect-ledger/) is being used. |
| [`ReplayMode`](/api/replay/replay/replay-mode/) | How [`ReplayEngine`](/api/replay/replay/replay-engine/) runs a cassette. |
