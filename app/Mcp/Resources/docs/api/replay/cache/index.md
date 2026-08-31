# Cache

> The Quiote\\Replay\\Cache namespace — 2 documented types.

Everything under `Quiote\Replay\Cache`.

## Classes

| Class | Description |
|---|---|
| [`CacheFingerprint`](/api/replay/cache/cache-fingerprint/) | The fingerprint scheme shared by [`RecordingCache`](/api/replay/cache/recording-cache/) and [`StubbedCache`](/api/replay/replay/stubbed-cache/): `"{op}:{key}"` for a single-key operation, a fixed literal for `clear()`. |
| [`RecordingCache`](/api/replay/cache/recording-cache/) | A decorating PSR-16 cache: wraps a real inner `CacheInterface` and appends one [`EffectKind::Cache`](/api/replay/cassette/effect-kind/#cache) entry per call to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), returning the real result completely untouched to the caller. |
