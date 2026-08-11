# SseEvent

> A single Server-Sent Events wire-format message.

A single Server-Sent Events wire-format message.

## Synopsis

`final class SseEvent`

|  |  |
|---|---|
| Source | `Http/Sse/SseEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$data` | `string` | _readonly._ |
| `$event` | `?``string` | _readonly._ |
| `$id` | `?``string` | _readonly._ |
| `$retryMs` | `?``int` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $data, ?string $event = null, ?string $id = null, ?int $retryMs = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$data` | `string` |  |
| `$event` | `?``string` |  |
| `$id` | `?``string` |  |
| `$retryMs` | `?``int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`format(): string`](#format) | Renders the event as its `text/event-stream` representation. |
| [`of(string|array<mixed> $data, ?string $event = null, ?string $id = null, ?int $retryMs = null): SseEvent`](#of) |  |

### format()

`public function format(): string`

Renders the event as its `text/event-stream` representation.

The optional `event`, `id` and `retry` fields are emitted first and only when set, then the data, split into one `data:` line per embedded newline as the wire format requires. The result ends with the blank line that terminates the message.

Returns `string`

### of()

`public static function of(string|array<mixed> $data, ?string $event = null, ?string $id = null, ?int $retryMs = null): SseEvent`

Arrays are JSON-encoded.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `string``|``array``<``mixed``>` | Arrays are JSON-encoded. |
| `$event` | `?``string` |  |
| `$id` | `?``string` |  |
| `$retryMs` | `?``int` |  |

Returns [`SseEvent`](/api/http/sse/sse-event/)
