# JobExecutor

> Shared retry/backoff decision logic used by both SyncQueueDriver (in-process blocking retry loop) and QueueWorker (one attempt per poll, deferred retry via the driver), so the policy is not duplicated per driver.

Shared retry/backoff decision logic used by both [`SyncQueueDriver`](/api/queue/sync-queue-driver/) (in-process blocking retry loop) and [`QueueWorker`](/api/queue/queue-worker/) (one attempt per poll, deferred retry via the driver), so the policy is not duplicated per driver.

Jobs are rebuilt per attempt via [`Container::make()`](/api/di/container/#make) — the same fresh-per-call autowiring actions/views already get.

## Synopsis

`final readonly class JobExecutor`

|  |  |
|---|---|
| Source | `JobExecutor.php` |

## Constructor

### __construct()

`public function __construct(Container $container, FailedJobStoreInterface $failedJobStore, int $defaultMaxAttempts = 3, int $defaultBackoffSeconds = 5): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
| `$failedJobStore` | [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) |  |
| `$defaultMaxAttempts` | `int` |  |
| `$defaultBackoffSeconds` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`attempt(JobPayload $payload): ?ExecutionFailure`](#attempt) | Construct and run the job once. |
| [`executeWithRetries(JobPayload $payload): void`](#executewithretries) | Run a job to completion in-process, blocking (with `usleep`) between retries. |

### attempt()

`public function attempt(JobPayload $payload): ?ExecutionFailure`

Construct and run the job once.

Returns null on success, or an [`ExecutionFailure`](/api/queue/execution-failure/) describing whether to retry (with delay) or give up (already recorded to the failed-job store in that case).

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

Returns `?`[`ExecutionFailure`](/api/queue/execution-failure/)

### executeWithRetries()

`public function executeWithRetries(JobPayload $payload): void`

Run a job to completion in-process, blocking (with `usleep`) between retries.

Used by [`SyncQueueDriver`](/api/queue/sync-queue-driver/) only — a persistent driver's worker loop instead defers retries via `release()` (see [`QueueWorker`](/api/queue/queue-worker/)).

| Parameter | Type | Description |
|---|---|---|
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |
