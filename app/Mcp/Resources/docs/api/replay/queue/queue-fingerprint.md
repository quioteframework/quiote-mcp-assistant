# QueueFingerprint

> The fingerprint scheme shared by RecordingQueueDriver and AssertingQueueDriver: `\"push:{jobClass}:{json of params}\"`.

The fingerprint scheme shared by [`RecordingQueueDriver`](/api/replay/queue/recording-queue-driver/) and [`AssertingQueueDriver`](/api/replay/replay/asserting-queue-driver/): `"push:{jobClass}:{json of params}"`.

Prefixed by operation (mirroring [`CacheFingerprint`](/api/replay/cache/cache-fingerprint/) and [`HttpFingerprint`](/api/replay/http/http-fingerprint/)) so a future queue operation recorded under the same [`EffectKind::Queue`](/api/replay/cassette/effect-kind/#queue) (e.g. a poll-side `reserve()`) cannot collide with a `push()` fingerprint.

Two pushes of the identically-shaped job (same class and params) fingerprint identically on purpose -- [`LedgerMatcher`](/api/replay/replay/ledger-matcher/)'s sequence fallback is what keeps repeated identical pushes distinguishable and ordered, exactly as it already does for two identical queries or cache reads.

## Synopsis

`final class QueueFingerprint`

|  |  |
|---|---|
| Source | `Queue/QueueFingerprint.php` |

## Methods

| Method | Description |
|---|---|
| [`ofPush(JobPayload $payload): string`](#ofpush) |  |

### ofPush()

`public static function ofPush(JobPayload $payload): string`

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

Returns `string`
