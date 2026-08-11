# Job

> A unit of background work.

A unit of background work.

Instantiated fresh per attempt via [`Container::make()`](/api/di/container/#make) — the same fresh-per-call autowiring actions/views already get — so constructor-injected services autowire normally and only the job's own arguments need to travel through the queue as [`JobPayload::$params`](/api/queue/job-payload/#params).

## Synopsis

`interface Job`

|  |  |
|---|---|
| Implemented by | [`RetryableJob`](/api/queue/retryable-job/) |
| Source | `Job.php` |

## Methods

| Method | Description |
|---|---|
| [`handle(): void`](#handle) | Performs the job's work. |

### handle()

`abstract public function handle(): void`

Performs the job's work.

Called once per attempt on a freshly built instance. Throwing signals failure: [`JobExecutor`](/api/queue/job-executor/) retries the job up to `queue.retry.max_attempts` and then records it with the configured [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/). Returning normally marks the attempt successful.
