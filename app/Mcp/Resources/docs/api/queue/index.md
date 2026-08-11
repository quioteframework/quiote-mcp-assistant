# Queue

> The Quiote\\Queue namespace — 29 documented types.

Everything under `Quiote\Queue`.

## Classes

| Class | Description |
|---|---|
| [`ExecutionFailure`](/api/queue/execution-failure/) | Outcome of a failed [`JobExecutor::attempt()`](/api/queue/job-executor/#attempt) call: retry, or give up. |
| [`FailedJob`](/api/queue/failed-job/) | A job whose retries were exhausted, handed to a [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/). |
| [`FailedJobRecord`](/api/queue/failed-job-record/) | A stored dead-letter row, as returned by [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/). |
| [`JobExecutor`](/api/queue/job-executor/) | Shared retry/backoff decision logic used by both [`SyncQueueDriver`](/api/queue/sync-queue-driver/) (in-process blocking retry loop) and [`QueueWorker`](/api/queue/queue-worker/) (one attempt per poll, deferred retry via the driver), so the policy is not duplicated per driver. |
| [`JobPayload`](/api/queue/job-payload/) | A queued job identified by class + constructor params, not a serialized object — on execution the class is rebuilt via [`Container::make()`](/api/di/container/#make), so constructor-injected services autowire normally. |
| [`LogFailedJobStore`](/api/queue/log-failed-job-store/) | Default [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/): logs the failure and drops it. |
| [`QueueConfig`](/api/queue/queue-config/) | Typed snapshot of the `queue.*` settings family. |
| [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) | Process-global registry mapping short driver aliases (e.g. |
| [`QueueManager`](/api/queue/queue-manager/) | App-facing entry point: `$container->get(QueueManager::class)->push(SendWelcomeEmail::class, ['userId' => 5])`. |
| [`QueuePlugin`](/api/queue/queue-plugin/) | Registers the queue subsystem: `queue.*` setting defaults (`sync` driver, out of the box), a default [`LogFailedJobStore`](/api/queue/log-failed-job-store/), the [`QueueManager`](/api/queue/queue-manager/)/[`QueueWorker`](/api/queue/queue-worker/) services, `queue:work`, and the `queue:failed:*` dead-letter inspection commands (a no-op error, not a crash, against the default store — see [`AbstractQueueFailedCommand::resolveInspectableStore()`](/api/queue/console/abstract-queue-failed-command/#resolveinspectablestore)). |
| [`QueueWorker`](/api/queue/queue-worker/) | Drives a [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/)'s backlog one job at a time; used by `queue:work`. |
| [`ReservedJob`](/api/queue/reserved-job/) | A [`JobPayload`](/api/queue/job-payload/) claimed off a [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) by `reserve()`. |
| [`SyncQueueDriver`](/api/queue/sync-queue-driver/) | The always-available default driver (`queue.default_driver = sync`): `push()` executes the job inline, in-process, with blocking retries via [`JobExecutor::executeWithRetries()`](/api/queue/job-executor/#executewithretries). |

## Interfaces

| Interface | Description |
|---|---|
| [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) | Dead-letter sink for jobs that exhausted their retries. |
| [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/) | A [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) whose dead-letter records can be listed, looked up, and removed — the query side needed by `queue:failed:list`/`queue:failed:retry`/`queue:failed:forget` (see [`QueueFailedListCommand`](/api/queue/console/queue-failed-list-command/) and friends). |
| [`Job`](/api/queue/job/) | A unit of background work. |
| [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) | A queue driver with a persistent backlog that an out-of-process worker (`queue:work`, see [`QueueWorker`](/api/queue/queue-worker/)) can poll. |
| [`QueueDriverInterface`](/api/queue/queue-driver-interface/) | Minimal contract every queue driver implements. |
| [`RetryableJob`](/api/queue/retryable-job/) | Opt-in per-job retry policy. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Console`](/api/queue/console/) | 5 types |
| [`Db`](/api/queue/db/) | 3 types |
| [`Redis`](/api/queue/redis/) | 2 types |
