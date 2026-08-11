# QueueWorker

> Drives a PollableQueueDriverInterface's backlog one job at a time; used by `queue:work`.

Drives a [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/)'s backlog one job at a time; used by `queue:work`.

## Synopsis

`final readonly class QueueWorker`

|  |  |
|---|---|
| Source | `QueueWorker.php` |

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
| [`processNext(PollableQueueDriverInterface $driver): bool`](#processnext) |  |

### processNext()

`public function processNext(PollableQueueDriverInterface $driver): bool`

| Parameter | Type | Description |
|---|---|---|
| `$driver` | [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) |  |

Returns `bool` — True if a job was reserved and processed (success or failure); false if the queue was empty.
