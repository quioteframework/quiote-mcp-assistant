# QueueDriverInterface

> Minimal contract every queue driver implements.

Minimal contract every queue driver implements.

The in-process [`SyncQueueDriver`](/api/queue/sync-queue-driver/) implements only this — there is nothing to poll, `push()` runs the job inline. Persistent drivers additionally implement [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) so `queue:work` can drive them.

## Synopsis

`interface QueueDriverInterface`

|  |  |
|---|---|
| Implemented by | [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/), [`SyncQueueDriver`](/api/queue/sync-queue-driver/) |
| Source | `QueueDriverInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`push(JobPayload $payload): void`](#push) | Hands a job off to the driver's backend. |

### push()

`abstract public function push(JobPayload $payload): void`

Hands a job off to the driver's backend.

Implementors either enqueue the payload for later execution or, for the in-process [`SyncQueueDriver`](/api/queue/sync-queue-driver/), run it inline and block until it succeeds or exhausts its retries. A payload carrying a non-null [`JobPayload::$availableAt`](/api/queue/job-payload/#availableat) must not become visible to a worker before that moment.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |
