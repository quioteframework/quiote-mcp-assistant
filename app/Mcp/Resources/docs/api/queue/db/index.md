# Db

> The Quiote\\Queue\\Db namespace — 3 documented types.

Everything under `Quiote\Queue\Db`.

## Classes

| Class | Description |
|---|---|
| [`DbFailedJobStore`](/api/queue/db/db-failed-job-store/) | Persistent [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) — an inspectable dead-letter table, alternative to the default [`LogFailedJobStore`](/api/queue/log-failed-job-store/). |
| [`DbQueueDriver`](/api/queue/db/db-queue-driver/) | PDO-backed [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/). |
| [`QueueDbPlugin`](/api/queue/db/queue-db-plugin/) | Registers the `db` queue driver alias and publishes `queue.db.*` config defaults. |
