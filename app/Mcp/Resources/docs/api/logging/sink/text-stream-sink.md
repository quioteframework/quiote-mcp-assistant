# TextStreamSink

> Human-readable single-line sink for local development.

Human-readable single-line sink for local development.

Writes to any stream (stderr by default). Not intended for structured log aggregation — use [`JsonStdoutSink`](/api/logging/sink/json-stdout-sink/) in containers. 2026-07-01T08:02:55.123Z WARNING Quiote.Routing: no route matched /foo {rid=abc}

## Synopsis

`class TextStreamSink extends AbstractStreamSink`

|  |  |
|---|---|
| Extends | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) |
| Source | `Logging/Sink/TextStreamSink.php` |

## Constructor

### __construct()

`public function __construct(string $stream = 'php://stderr', Level $minLevel = Quiote\Logging\Level::Debug, array<string, Level> $categoryOverrides = [], resource|null $streamResource = null): mixed`

An already-open writable resource
       (e.g. for tests), used instead of opening $stream lazily.

| Parameter | Type | Description |
|---|---|---|
| `$stream` | `string` | A stream path (opened lazily, append). |
| `$minLevel` | [`Level`](/api/logging/level/) | Minimum level this sink accepts by default. |
| `$categoryOverrides` | `array``<``string``, `[`Level`](/api/logging/level/)`>` | category-prefix => min level. |
| `$streamResource` | `resource``|``null` | An already-open writable resource (e.g. for tests), used instead of opening $stream lazily. |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `emit()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Renders the event through the subclass [`TextStreamSink::format()`](/api/logging/sink/text-stream-sink/#format) and writes it as one newline-terminated line. |
| `flush()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Flushes the underlying stream if one has been opened. |
| `isEnabled()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Whether this sink accepts an event at $level for $category. |
