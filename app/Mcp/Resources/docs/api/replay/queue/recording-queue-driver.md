# RecordingQueueDriver

> A decorating queue driver: wraps a real inner QueueDriverInterface and appends one EffectKind::Queue entry per RecordingQueueDriver::push() to an injected EffectLedger, then returns exactly as the real driver did.

A decorating queue driver: wraps a real inner [`QueueDriverInterface`](/api/queue/queue-driver-interface/) and appends one [`EffectKind::Queue`](/api/replay/cassette/effect-kind/#queue) entry per [`RecordingQueueDriver::push()`](/api/replay/queue/recording-queue-driver/#push) to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), then returns exactly as the real driver did.

Scoped to `push()` only: `reserve()`/`ack()`/`release()`/`discard()` on [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) belong to an out-of-process worker polling the backlog later, not to the request that enqueued the job, and are not observed here.

`push()` returns `void`, and no driver hands back an id or other value a caller could observe from the call itself (see e.g. `Quiote\Queue\Db\DbQueueDriver`/`Quiote\Queue\Redis\RedisQueueDriver`, whose generated ids are internal to the backend) -- so the effect's `result` is `null`; there is nothing else genuine to record.

A real driver exception is never swallowed: no effect is recorded for a failed push, and the exception propagates exactly as it would through the undecorated driver, matching every other recorder in this package.

## Synopsis

`final class RecordingQueueDriver implements QueueDriverInterface`

|  |  |
|---|---|
| Implements | [`QueueDriverInterface`](/api/queue/queue-driver-interface/) |
| Source | `Queue/RecordingQueueDriver.php` |

## Constructor

### __construct()

`public function __construct(QueueDriverInterface $driver, EffectLedger $ledger, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$driver` | [`QueueDriverInterface`](/api/queue/queue-driver-interface/) |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`describe(JobPayload $payload): array<string, mixed>`](#describe) |  |
| [`push(JobPayload $payload): void`](#push) | Hands a job off to the driver's backend. |

### describe()

`public static function describe(JobPayload $payload): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

Returns `array``<``string``, ``mixed``>`

### push()

`public function push(JobPayload $payload): void`

Hands a job off to the driver's backend.

Implementors either enqueue the payload for later execution or, for the in-process `SyncQueueDriver`, run it inline and block until it succeeds or exhausts its retries. A payload carrying a non-null [`JobPayload::$availableAt`](/api/queue/job-payload/#availableat) must not become visible to a worker before that moment.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |
