# Console

> The Quiote\\Queue\\Console namespace — 5 documented types.

Everything under `Quiote\Queue\Console`.

## Classes

| Class | Description |
|---|---|
| [`AbstractQueueFailedCommand`](/api/queue/console/abstract-queue-failed-command/) | Shared plumbing for the `queue:failed:*` commands. |
| [`QueueFailedForgetCommand`](/api/queue/console/queue-failed-forget-command/) | Deletes a dead-lettered job without retrying it. |
| [`QueueFailedListCommand`](/api/queue/console/queue-failed-list-command/) | Lists jobs that exhausted their retries (see [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/)). |
| [`QueueFailedRetryCommand`](/api/queue/console/queue-failed-retry-command/) | Re-pushes a dead-lettered job and removes it from the failed store. |
| [`QueueWorkCommand`](/api/queue/console/queue-work-command/) | Polls a persistent [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) and processes jobs one at a time via [`QueueWorker`](/api/queue/queue-worker/). |
