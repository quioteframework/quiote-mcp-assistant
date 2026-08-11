# FailedJob

> A job whose retries were exhausted, handed to a FailedJobStoreInterface.

A job whose retries were exhausted, handed to a [`FailedJobStoreInterface`](/api/queue/failed-job-store-interface/).

## Synopsis

`final readonly class FailedJob`

|  |  |
|---|---|
| Source | `FailedJob.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attempts` | `int` | _readonly._ |
| `$exceptionClass` | `string` | _readonly._ |
| `$exceptionMessage` | `string` | _readonly._ |
| `$exceptionTrace` | `string` | _readonly._ |
| `$jobClass` | `string` | _readonly._ |
| `$params` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(class-string<Job> $jobClass, array<string, mixed> $params, string $exceptionClass, string $exceptionMessage, string $exceptionTrace, int $attempts): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$jobClass` | `class-string``<`[`Job`](/api/queue/job/)`>` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |
| `$exceptionClass` | `string` |  |
| `$exceptionMessage` | `string` |  |
| `$exceptionTrace` | `string` |  |
| `$attempts` | `int` |  |

Returns `mixed`
