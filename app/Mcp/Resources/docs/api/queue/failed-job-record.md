# FailedJobRecord

> A stored dead-letter row, as returned by InspectableFailedJobStoreInterface.

A stored dead-letter row, as returned by [`InspectableFailedJobStoreInterface`](/api/queue/inspectable-failed-job-store-interface/).

`$jobClass` is plain `string`, not `class-string<Job>`, for the same reason as [`JobPayload::$jobClass`](/api/queue/job-payload/#jobclass): it comes from stored data that hasn't been validated yet — a caller re-pushing it (`queue:failed:retry`) narrows it at that point instead.

## Synopsis

`final readonly class FailedJobRecord`

|  |  |
|---|---|
| Source | `FailedJobRecord.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attempts` | `int` | _readonly._ |
| `$exceptionClass` | `string` | _readonly._ |
| `$exceptionMessage` | `string` | _readonly._ |
| `$exceptionTrace` | `string` | _readonly._ |
| `$failedAt` | [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) | _readonly._ |
| `$id` | `string` | _readonly._ |
| `$jobClass` | `string` | _readonly._ |
| `$params` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $id, string $jobClass, array<string, mixed> $params, string $exceptionClass, string $exceptionMessage, string $exceptionTrace, int $attempts, DateTimeImmutable $failedAt): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
| `$jobClass` | `string` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |
| `$exceptionClass` | `string` |  |
| `$exceptionMessage` | `string` |  |
| `$exceptionTrace` | `string` |  |
| `$attempts` | `int` |  |
| `$failedAt` | [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |

Returns `mixed`
