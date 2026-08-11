# LogFailedJobStore

> Default FailedJobStoreInterface: logs the failure and drops it.

Default [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/): logs the failure and drops it.

Enough for `sync`/dev usage; an app wanting inspectable dead-letter storage binds `quioteframework/queue-db`'s `DbFailedJobStore` instead (see [`PluginRegistrar::service()`](/api/plugin/plugin-registrar/#service)'s set-if-absent rule).

## Synopsis

`final readonly class LogFailedJobStore implements FailedJobStoreInterface`

|  |  |
|---|---|
| Implements | [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/) |
| Source | `LogFailedJobStore.php` |

## Constructor

### __construct()

`public function __construct(LoggerInterface $logger = new NullLogger(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$logger` | [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`record(FailedJob $failedJob): void`](#record) | Logs the failure at `error` level and keeps nothing. |

### record()

`public function record(FailedJob $failedJob): void`

Logs the failure at `error` level and keeps nothing.

The message names the job class, attempt count and exception; the job's params and the exception trace travel in the log context. Nothing is stored, so the failure cannot be listed or retried afterwards.

| Parameter | Type | Description |
|---|---|---|
| `$failedJob` | [`FailedJob`](/api/queue/failed-job/) |  |
