# RetryableJob

> Opt-in per-job retry policy.

Opt-in per-job retry policy.

A [`Job`](/api/queue/job/) that does not implement this gets the config-level defaults instead (`queue.retry.max_attempts`, `queue.retry.backoff_seconds`) — see [`JobExecutor`](/api/queue/job-executor/).

## Synopsis

`interface RetryableJob extends Job`

|  |  |
|---|---|
| Implements | [`Job`](/api/queue/job/) |
| Source | `RetryableJob.php` |

## Methods

| Method | Description |
|---|---|
| [`backoffSeconds(int $attempt): int`](#backoffseconds) | Delay before the given (1-based) retry attempt. |
| [`maxAttempts(): int`](#maxattempts) | Total attempts allowed, including the first. |

### backoffSeconds()

`abstract public function backoffSeconds(int $attempt): int`

Delay before the given (1-based) retry attempt.

| Parameter | Type | Description |
|---|---|---|
| `$attempt` | `int` |  |

Returns `int`

### maxAttempts()

`abstract public function maxAttempts(): int`

Total attempts allowed, including the first.

Returns `int`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `handle()` | [`Job`](/api/queue/job/) | Performs the job's work. |
