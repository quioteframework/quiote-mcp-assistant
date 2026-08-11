# ReservedJob

> A JobPayload claimed off a PollableQueueDriverInterface by `reserve()`.

A [`JobPayload`](/api/queue/job-payload/) claimed off a [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/) by `reserve()`.

`$id` is driver-specific (e.g. a row id) and is only meaningful back to the same driver via `ack()`/`release()`/`discard()`.

## Synopsis

`final readonly class ReservedJob`

|  |  |
|---|---|
| Source | `ReservedJob.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$id` | `string` | _readonly._ |
| `$payload` | [`JobPayload`](/api/queue/job-payload/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $id, JobPayload $payload): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |
| `$payload` | [`JobPayload`](/api/queue/job-payload/) |  |

Returns `mixed`
