# SinkInterface

> A destination for log events.

A destination for log events.

Each sink decides, per (level, category), whether it will accept an event, and how to render it.

## Synopsis

`interface SinkInterface`

|  |  |
|---|---|
| Implemented by | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) |
| Source | `Logging/Sink/SinkInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(LogEvent $event): void`](#emit) | Write the event to the destination. |
| [`flush(): void`](#flush) | Flush any buffered output (end of request / worker reset). |
| [`isEnabled(Level $level, string $category): bool`](#isenabled) | Whether this sink will emit an event at $level for $category. |

### emit()

`abstract public function emit(LogEvent $event): void`

Write the event to the destination.

Only called when isEnabled() is true.

| Parameter | Type | Description |
|---|---|---|
| `$event` | [`LogEvent`](/api/logging/log-event/) |  |

### flush()

`abstract public function flush(): void`

Flush any buffered output (end of request / worker reset).

### isEnabled()

`abstract public function isEnabled(Level $level, string $category): bool`

Whether this sink will emit an event at $level for $category.

Kept cheap (called on the hot path via CategoryLogger::isEnabled()).

| Parameter | Type | Description |
|---|---|---|
| `$level` | [`Level`](/api/logging/level/) |  |
| `$category` | `string` |  |

Returns `bool`
