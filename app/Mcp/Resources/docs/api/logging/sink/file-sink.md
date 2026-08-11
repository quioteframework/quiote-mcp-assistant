# FileSink

> Plain-text sink that appends one line per event to a file on disk, creating the parent directory if it doesn't exist yet (AbstractStreamSink's lazy fopen() would otherwise fail silently against a missing directory).

Plain-text sink that appends one line per event to a file on disk, creating the parent directory if it doesn't exist yet (AbstractStreamSink's lazy fopen() would otherwise fail silently against a missing directory).

Same line format as [`TextStreamSink`](/api/logging/sink/text-stream-sink/) — deliberately never colorized, since a log file is read by more than terminals (tail | grep, log shippers, etc.) and ANSI escape codes would just be noise there. For a colorized terminal sink use [`AnsiTextStreamSink`](/api/logging/sink/ansi-text-stream-sink/).

## Synopsis

`final class FileSink extends AbstractStreamSink`

|  |  |
|---|---|
| Extends | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) |
| Source | `Logging/Sink/FileSink.php` |

## Constructor

### __construct()

`public function __construct(string $path, Level $minLevel = Quiote\Logging\Level::Debug, array<string, Level> $categoryOverrides = [], resource|null $streamResource = null): mixed`

Pre-opened resource, for tests —
       when supplied, $path is never touched and no directory is created.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | Filesystem path to append to. |
| `$minLevel` | [`Level`](/api/logging/level/) |  |
| `$categoryOverrides` | `array``<``string``, `[`Level`](/api/logging/level/)`>` |  |
| `$streamResource` | `resource``|``null` | Pre-opened resource, for tests — when supplied, $path is never touched and no directory is created. |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `emit()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Renders the event through the subclass [`FileSink::format()`](/api/logging/sink/file-sink/#format) and writes it as one newline-terminated line. |
| `flush()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Flushes the underlying stream if one has been opened. |
| `isEnabled()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Whether this sink accepts an event at $level for $category. |
