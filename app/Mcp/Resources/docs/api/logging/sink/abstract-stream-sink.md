# AbstractStreamSink

> Base for sinks that write one line per event to a stream.

Base for sinks that write one line per event to a stream.

Handles the per-sink minimum level (+ optional per-category overrides, longest-prefix wins) and lazy stream opening. Subclasses implement [`AbstractStreamSink::format()`](/api/logging/sink/abstract-stream-sink/#format).

## Synopsis

`abstract class AbstractStreamSink implements SinkInterface`

|  |  |
|---|---|
| Implements | [`SinkInterface`](/api/logging/sink/sink-interface/) |
| Source | `Logging/Sink/AbstractStreamSink.php` |

## Constructor

### __construct()

`public function __construct(Level $minLevel = Quiote\Logging\Level::Debug, array<string, Level> $categoryOverrides = [], string $stream = 'php://stdout', resource|null $streamResource = null): mixed`

An already-open writable resource
       (e.g. for tests), used instead of opening $stream lazily.

| Parameter | Type | Description |
|---|---|---|
| `$minLevel` | [`Level`](/api/logging/level/) | Minimum level this sink accepts by default. |
| `$categoryOverrides` | `array``<``string``, `[`Level`](/api/logging/level/)`>` | category-prefix => min level. |
| `$stream` | `string` | A stream path (opened lazily, append). |
| `$streamResource` | `resource``|``null` | An already-open writable resource (e.g. for tests), used instead of opening $stream lazily. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`emit(LogEvent $event): void`](#emit) | Renders the event through the subclass [`AbstractStreamSink::format()`](/api/logging/sink/abstract-stream-sink/#format) and writes it as one newline-terminated line. |
| [`flush(): void`](#flush) | Flushes the underlying stream if one has been opened. |
| [`format(LogEvent $event): string`](#format) | Render an event to a single line (no trailing newline). |
| [`formatPlainLine(LogEvent $event): string`](#formatplainline) | Shared human-readable single-line rendering used by [`TextStreamSink`](/api/logging/sink/text-stream-sink/) and [`FileSink`](/api/logging/sink/file-sink/) (and, via TextStreamSink, [`AnsiTextStreamSink`](/api/logging/sink/ansi-text-stream-sink/)): 2026-07-01T08:02:55.123Z WARNING Quiote.Routing: no route matched /foo {rid=abc} |
| [`formatTimestamp(float $ts): string`](#formattimestamp) | Format a UNIX timestamp (with microseconds) as ISO-8601 UTC with milliseconds, e.g. |
| [`handle(): resource|null`](#handle) |  |
| [`isEnabled(Level $level, string $category): bool`](#isenabled) | Whether this sink accepts an event at $level for $category. |
| [`writeLine(string $line): void`](#writeline) |  |

### emit()

`public function emit(LogEvent $event): void`

Renders the event through the subclass [`AbstractStreamSink::format()`](/api/logging/sink/abstract-stream-sink/#format) and writes it as one newline-terminated line.

The stream is opened on first write when the sink was configured with a path rather than a resource. A stream that cannot be opened, or a write that fails, is silently dropped rather than allowed to break the request that was only trying to log.

| Parameter | Type | Description |
|---|---|---|
| `$event` | [`LogEvent`](/api/logging/log-event/) |  |

### flush()

`public function flush(): void`

Flushes the underlying stream if one has been opened.

A sink that has never emitted anything holds no handle and does nothing here; it does not open the stream just to flush it.

### format()

`abstract protected function format(LogEvent $event): string`

Render an event to a single line (no trailing newline).

| Parameter | Type | Description |
|---|---|---|
| `$event` | [`LogEvent`](/api/logging/log-event/) |  |

Returns `string`

### formatPlainLine()

`protected static function formatPlainLine(LogEvent $event): string`

Shared human-readable single-line rendering used by [`TextStreamSink`](/api/logging/sink/text-stream-sink/) and [`FileSink`](/api/logging/sink/file-sink/) (and, via TextStreamSink, [`AnsiTextStreamSink`](/api/logging/sink/ansi-text-stream-sink/)): 2026-07-01T08:02:55.123Z WARNING Quiote.Routing: no route matched /foo {rid=abc}

| Parameter | Type | Description |
|---|---|---|
| `$event` | [`LogEvent`](/api/logging/log-event/) |  |

Returns `string`

### formatTimestamp()

`protected static function formatTimestamp(float $ts): string`

Format a UNIX timestamp (with microseconds) as ISO-8601 UTC with milliseconds, e.g.

2026-07-01T08:02:55.123Z.

| Parameter | Type | Description |
|---|---|---|
| `$ts` | `float` |  |

Returns `string`

### handle()

`protected function handle(): resource|null`

Returns `resource``|``null`

### isEnabled()

`public function isEnabled(Level $level, string $category): bool`

Whether this sink accepts an event at $level for $category.

The minimum level is the longest category-prefix override that matches (exact name, or a prefix followed by a dot), falling back to the sink's default minimum level when none matches. The resolution is memoized per exact category, so repeated calls on the hot path cost a lookup.

| Parameter | Type | Description |
|---|---|---|
| `$level` | [`Level`](/api/logging/level/) |  |
| `$category` | `string` |  |

Returns `bool`

### writeLine()

`protected function writeLine(string $line): void`

| Parameter | Type | Description |
|---|---|---|
| `$line` | `string` |  |
