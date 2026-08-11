# JobPayload

> A queued job identified by class + constructor params, not a serialized object — on execution the class is rebuilt via Container::make(), so constructor-injected services autowire normally.

A queued job identified by class + constructor params, not a serialized object — on execution the class is rebuilt via [`Container::make()`](/api/di/container/#make), so constructor-injected services autowire normally.

`$params` must be JSON-serializable for persistent drivers (e.g. `quioteframework/queue-db`); the in-process sync driver has no such restriction.

`$jobClass` is deliberately typed as plain `string`, not `class-string<Job>`: a persistent driver builds this DTO from stored data (e.g. a DB row) that hasn't been validated yet — the guarantee is established at the point of use instead ([`JobExecutor::attempt()`](/api/queue/job-executor/#attempt)'s `instanceof Job` check), not at construction.

## Synopsis

`final readonly class JobPayload`

|  |  |
|---|---|
| Source | `JobPayload.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$attempts` | `int` | _readonly._ |
| `$availableAt` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) | _readonly._ |
| `$jobClass` | `string` | _readonly._ |
| `$params` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $jobClass, array<string, mixed> $params = [], int $attempts = 0, ?DateTimeImmutable $availableAt = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$jobClass` | `string` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |
| `$attempts` | `int` |  |
| `$availableAt` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`withAttempts(int $attempts): JobPayload`](#withattempts) | Returns a copy with the attempt counter replaced. |

### withAttempts()

`public function withAttempts(int $attempts): JobPayload`

Returns a copy with the attempt counter replaced.

Job class, params and availability time are carried over unchanged; the receiver is not modified.

| Parameter | Type | Description |
|---|---|---|
| `$attempts` | `int` |  |

Returns [`JobPayload`](/api/queue/job-payload/)
