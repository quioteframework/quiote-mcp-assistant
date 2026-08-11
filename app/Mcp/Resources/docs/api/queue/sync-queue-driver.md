# SyncQueueDriver

> The always-available default driver (`queue.default_driver = sync`): `push()` executes the job inline, in-process, with blocking retries via JobExecutor::executeWithRetries().

The always-available default driver (`queue.default_driver = sync`): `push()` executes the job inline, in-process, with blocking retries via [`JobExecutor::executeWithRetries()`](/api/queue/job-executor/#executewithretries).

Safe for dev/test; production use should configure a persistent driver (e.g. `quioteframework/queue-db`) so job execution doesn't block the request that pushed it.

## Synopsis

`final readonly class SyncQueueDriver implements QueueDriverInterface`

|  |  |
|---|---|
| Implements | [`QueueDriverInterface`](/api/queue/queue-driver-interface/) |
| Source | `SyncQueueDriver.php` |

## Constructor

### __construct()

`public function __construct(JobExecutor $executor): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$executor` | [`JobExecutor`](/api/queue/job-executor/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`push(JobPayload $payload): void`](#push) | Runs the job immediately, in the calling process. |

### push()

`public function push(JobPayload $payload): void`

Runs the job immediately, in the calling process.

Delegates to [`JobExecutor::executeWithRetries()`](/api/queue/job-executor/#executewithretries), so the caller blocks for the whole attempt-and-backoff cycle and any permanent failure has already been recorded with the [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) by the time this returns. [`JobPayload::$availableAt`](/api/queue/job-payload/#availableat) is not honoured — there is no backlog to defer into.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |
