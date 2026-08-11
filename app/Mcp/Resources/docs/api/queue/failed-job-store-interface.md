# FailedJobStoreInterface

> Dead-letter sink for jobs that exhausted their retries.

Dead-letter sink for jobs that exhausted their retries.

Independent of the queue driver in use — [`QueuePlugin`](/api/queue/queue-plugin/) binds a default [`LogFailedJobStore`](/api/queue/log-failed-job-store/); `quioteframework/queue-db` offers a persistent `DbFailedJobStore` an app can bind instead, regardless of which [`QueueDriverInterface`](/api/queue/queue-driver-interface/) it queues jobs through.

## Synopsis

`interface FailedJobStoreInterface`

|  |  |
|---|---|
| Implemented by | [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/), [`LogFailedJobStore`](/api/queue/log-failed-job-store/) |
| Source | `FailedJobStoreInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`record(FailedJob $failedJob): void`](#record) | Takes delivery of a job that has permanently failed. |

### record()

`abstract public function record(FailedJob $failedJob): void`

Takes delivery of a job that has permanently failed.

Called by [`JobExecutor`](/api/queue/job-executor/) once retries are exhausted, before the driver is told to discard the job. Implementors decide whether the record is kept (a queryable store) or merely reported and dropped ([`LogFailedJobStore`](/api/queue/log-failed-job-store/)).

| Parameter | Type | Description |
|---|---|---|
| `$failedJob` | [`FailedJob`](/api/queue/failed-job/) |  |
