# Queue

> The Quiote\\Replay\\Queue namespace — 2 documented types.

Everything under `Quiote\Replay\Queue`.

## Classes

| Class | Description |
|---|---|
| [`QueueFingerprint`](/api/replay/queue/queue-fingerprint/) | The fingerprint scheme shared by [`RecordingQueueDriver`](/api/replay/queue/recording-queue-driver/) and [`AssertingQueueDriver`](/api/replay/replay/asserting-queue-driver/): `"push:{jobClass}:{json of params}"`. |
| [`RecordingQueueDriver`](/api/replay/queue/recording-queue-driver/) | A decorating queue driver: wraps a real inner [`QueueDriverInterface`](/api/queue/queue-driver-interface/) and appends one [`EffectKind::Queue`](/api/replay/cassette/effect-kind/#queue) entry per [`RecordingQueueDriver::push()`](/api/replay/queue/recording-queue-driver/#push) to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), then returns exactly as the real driver did. |
