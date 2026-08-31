# AssertingQueueDriver

> The isolated-replay counterpart to RecordingQueueDriver: never pushes to a real backend -- isolated replay has none -- and instead captures every AssertingQueueDriver::push() call so an emitted test can assert against it afterward -- \"this request enqueued exactly this job.\

The isolated-replay counterpart to [`RecordingQueueDriver`](/api/replay/queue/recording-queue-driver/): never pushes to a real backend -- isolated replay has none -- and instead captures every [`AssertingQueueDriver::push()`](/api/replay/replay/asserting-queue-driver/#push) call so an emitted test can assert against it afterward -- "this request enqueued exactly this job."

Deliberately exposes a plain, non-throwing [`AssertingQueueDriver::wasJobPushed()`](/api/replay/replay/asserting-queue-driver/#wasjobpushed) query and a raw [`AssertingQueueDriver::pushedJobs()`](/api/replay/replay/asserting-queue-driver/#pushedjobs) accessor rather than a throwing `assert*()` method of its own: making assertions is a test's job (via its own `self::assertTrue()`/`self::assertSame()`), not this driver's -- it only needs to answer "what was pushed", accurately and in order.

Also appends to an (optional) [`EffectLedger`](/api/replay/replay/effect-ledger/), using the same [`QueueFingerprint`](/api/replay/queue/queue-fingerprint/) scheme [`RecordingQueueDriver`](/api/replay/queue/recording-queue-driver/) recorded with, so a push asked for during replay is comparable against what was originally recorded -- e.g. a future drift report could show "this replay * enqueued a job the original recording did not, or vice versa." The ledger is optional because, unlike a read-side stub, there is no recorded answer this class needs the ledger for -- it works perfectly well with none.

## Synopsis

`final class AssertingQueueDriver implements QueueDriverInterface`

|  |  |
|---|---|
| Implements | [`QueueDriverInterface`](/api/queue/queue-driver-interface/) |
| Source | `Replay/AssertingQueueDriver.php` |

## Constructor

### __construct()

`public function __construct(?EffectLedger $ledger = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ledger` | `?`[`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`push(JobPayload $payload): void`](#push) | Hands a job off to the driver's backend. |
| [`pushedJobs(): list<JobPayload>`](#pushedjobs) |  |
| [`wasJobPushed(string $jobClass, array<string, mixed>|null $params = null): bool`](#wasjobpushed) | Whether a job of $jobClass -- with $params too, when given -- was pushed during this replay. |

### push()

`public function push(JobPayload $payload): void`

Hands a job off to the driver's backend.

Implementors either enqueue the payload for later execution or, for the in-process `SyncQueueDriver`, run it inline and block until it succeeds or exhausts its retries. A payload carrying a non-null [`JobPayload::$availableAt`](/api/queue/job-payload/#availableat) must not become visible to a worker before that moment.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

### pushedJobs()

`public function pushedJobs(): list<JobPayload>`

Returns `list``<`[`JobPayload`](/api/queue/job-payload/)`>` — Every job pushed during this replay, in the order it was pushed.

### wasJobPushed()

`public function wasJobPushed(string $jobClass, array<string, mixed>|null $params = null): bool`

Whether a job of $jobClass -- with $params too, when given -- was pushed during this replay.

| Parameter | Type | Description |
|---|---|---|
| `$jobClass` | `string` |  |
| `$params` | `array``<``string``, ``mixed``>``|``null` |  |

Returns `bool`
