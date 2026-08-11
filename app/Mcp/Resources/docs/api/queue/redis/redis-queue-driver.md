# RedisQueueDriver

> Redis-backed PollableQueueDriverInterface.

Redis-backed [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/).

Ready jobs live in a Redis LIST (`{prefix}:ready`); `reserve()` atomically moves one into a `{prefix}:processing` LIST via `RPOPLPUSH` (the classic reliable-queue pattern) so a crashed worker's in-flight jobs are still recoverable from that list rather than lost. Delayed/released jobs live in a ZSET (`{prefix}:delayed`) scored by their `available_at` unix timestamp; `reserve()` first promotes any due members back onto the ready list.

`ReservedJob::$id` is the exact JSON-encoded list entry (each entry embeds a random `uid` so two otherwise-identical jobs remain distinct strings) — driver-specific per [`ReservedJob`](/api/queue/reserved-job/)'s contract, used as the `LREM` target in `ack()`/`release()`/`discard()`.

## Synopsis

`final readonly class RedisQueueDriver implements PollableQueueDriverInterface`

|  |  |
|---|---|
| Implements | [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) |
| Source | `RedisQueueDriver.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $redis, string $prefix = 'quiote_queue'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$redis` | `ClientInterface` |  |
| `$prefix` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`ack(ReservedJob $job): void`](#ack) | Removes the job's entry from the processing list, completing the reservation. |
| [`discard(ReservedJob $job): void`](#discard) | Drops the job's entry from the processing list without re-queueing it. |
| [`push(JobPayload $payload): void`](#push) | Encodes the job as a JSON entry and files it on the ready or delayed key. |
| [`release(ReservedJob $job, int $delaySeconds): void`](#release) | Removes the job from the processing list and re-files it for another run. |
| [`reserve(): ?ReservedJob`](#reserve) | Promotes any due delayed jobs, then atomically claims the next ready one. |

### ack()

`public function ack(ReservedJob $job): void`

Removes the job's entry from the processing list, completing the reservation.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |

### discard()

`public function discard(ReservedJob $job): void`

Drops the job's entry from the processing list without re-queueing it.

Called once retries are exhausted; the dead-letter record has already been written by [`JobExecutor`](/api/queue/job-executor/).

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |

### push()

`public function push(JobPayload $payload): void`

Encodes the job as a JSON entry and files it on the ready or delayed key.

A job that is already due is `LPUSH`ed onto `{prefix}:ready`; one with a future [`JobPayload::$availableAt`](/api/queue/job-payload/#availableat) is added to the `{prefix}:delayed` ZSET scored by that timestamp, from where [`RedisQueueDriver::reserve()`](/api/queue/redis/redis-queue-driver/#reserve) promotes it once due. The entry carries a fresh random `uid` so two identical jobs stay distinguishable as list members.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

| Throws | When |
|---|---|
| `JsonException` | if the payload params cannot be encoded. |

### release()

`public function release(ReservedJob $job, int $delaySeconds): void`

Removes the job from the processing list and re-files it for another run.

The re-filed entry keeps the original `uid` but carries an incremented attempt count, and goes onto the ready list when the delay is zero or negative, otherwise onto the delayed ZSET.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |
| `$delaySeconds` | `int` |  |

| Throws | When |
|---|---|
| `JsonException` | if the payload params cannot be re-encoded. |

### reserve()

`public function reserve(): ?ReservedJob`

Promotes any due delayed jobs, then atomically claims the next ready one.

The claim is a single `RPOPLPUSH` from `{prefix}:ready` to `{prefix}:processing`, so a job is never in neither list. Returns null when the ready list is empty after promotion.

Returns `?`[`ReservedJob`](/api/queue/reserved-job/)

| Throws | When |
|---|---|
| `RuntimeException` | if the claimed entry is not a JSON object or its `job_class`/`params`/`attempts` fields have the wrong type. |
| `JsonException` | if the claimed entry is not valid JSON. |
