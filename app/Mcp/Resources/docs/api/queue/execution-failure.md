# ExecutionFailure

> Outcome of a failed JobExecutor::attempt() call: retry, or give up.

Outcome of a failed [`JobExecutor::attempt()`](/api/queue/job-executor/#attempt) call: retry, or give up.

## Synopsis

`final readonly class ExecutionFailure`

|  |  |
|---|---|
| Source | `ExecutionFailure.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attempts` | `int` | _readonly._ |
| `$backoffSeconds` | `int` | _readonly._ |
| `$exception` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) | _readonly._ |
| `$shouldRetry` | `bool` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`exhausted(Throwable $exception, int $attempts): ExecutionFailure`](#exhausted) | Retries exhausted; the caller has already recorded this to a [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/). |
| [`retry(Throwable $exception, int $attempts, int $backoffSeconds): ExecutionFailure`](#retry) | A failure the caller should retry: carries the throwable, the attempt count so far, and how many seconds to wait before the next attempt. |

### exhausted()

`public static function exhausted(Throwable $exception, int $attempts): ExecutionFailure`

Retries exhausted; the caller has already recorded this to a [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/).

| Parameter | Type | Description |
|---|---|---|
| `$exception` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$attempts` | `int` |  |

Returns [`ExecutionFailure`](/api/queue/execution-failure/)

### retry()

`public static function retry(Throwable $exception, int $attempts, int $backoffSeconds): ExecutionFailure`

A failure the caller should retry: carries the throwable, the attempt count so far, and how many seconds to wait before the next attempt.

| Parameter | Type | Description |
|---|---|---|
| `$exception` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$attempts` | `int` |  |
| `$backoffSeconds` | `int` |  |

Returns [`ExecutionFailure`](/api/queue/execution-failure/)
