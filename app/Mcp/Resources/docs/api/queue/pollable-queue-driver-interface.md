# PollableQueueDriverInterface

> A queue driver with a persistent backlog that an out-of-process worker (`queue:work`, see QueueWorker) can poll.

A queue driver with a persistent backlog that an out-of-process worker (`queue:work`, see [`QueueWorker`](/api/queue/queue-worker/)) can poll.

Implemented by `quioteframework/queue-db`'s `DbQueueDriver`, deliberately not by [`SyncQueueDriver`](/api/queue/sync-queue-driver/) (nothing to poll).

## Synopsis

`interface PollableQueueDriverInterface extends QueueDriverInterface`

|  |  |
|---|---|
| Implements | [`QueueDriverInterface`](/api/queue/queue-driver-interface/) |
| Implemented by | [`DbQueueDriver`](/api/queue/db/db-queue-driver/), [`RedisQueueDriver`](/api/queue/redis/redis-queue-driver/) |
| Source | `PollableQueueDriverInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`ack(ReservedJob $job): void`](#ack) | Mark a reserved job as successfully processed; removes it permanently. |
| [`discard(ReservedJob $job): void`](#discard) | Remove a reserved job permanently after retries are exhausted. |
| [`release(ReservedJob $job, int $delaySeconds): void`](#release) | Return a reserved job to the backlog, available again after $delaySeconds. |
| [`reserve(): ?ReservedJob`](#reserve) | Claim and return the next due job, or null if the queue is empty. |

### ack()

`abstract public function ack(ReservedJob $job): void`

Mark a reserved job as successfully processed; removes it permanently.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |

### discard()

`abstract public function discard(ReservedJob $job): void`

Remove a reserved job permanently after retries are exhausted.

Dead-letter recording itself already happened via [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) inside [`JobExecutor`](/api/queue/job-executor/) — this only stops the driver from serving it again.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |

### release()

`abstract public function release(ReservedJob $job, int $delaySeconds): void`

Return a reserved job to the backlog, available again after $delaySeconds.

| Parameter | Type | Description |
|---|---|---|
| `$job` | [`ReservedJob`](/api/queue/reserved-job/) |  |
| `$delaySeconds` | `int` |  |

### reserve()

`abstract public function reserve(): ?ReservedJob`

Claim and return the next due job, or null if the queue is empty.

Returns `?`[`ReservedJob`](/api/queue/reserved-job/)

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `push()` | [`QueueDriverInterface`](/api/queue/queue-driver-interface/) | Hands a job off to the driver's backend. |
