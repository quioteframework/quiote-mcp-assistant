# EmojiTextStreamSink

> AnsiTextStreamSink with an emoji prefix per level, for local dev consoles where a quick visual scan matters more than a clean tail | grep.

AnsiTextStreamSink with an emoji prefix per level, for local dev consoles where a quick visual scan matters more than a clean tail | grep.

Not meant for anything that parses log output — use TextStreamSink/FileSink/ JsonStdoutSink for that. 🔍 2026-07-01T08:02:55.123Z DEBUG ... ⚠️ 2026-07-01T08:02:55.123Z WARNING ... 🔥 2026-07-01T08:02:55.123Z ERROR ...

## Synopsis

`final class EmojiTextStreamSink extends AnsiTextStreamSink`

|  |  |
|---|---|
| Extends | [`AnsiTextStreamSink`](/api/logging/sink/ansi-text-stream-sink/) |
| Source | `Logging/Sink/EmojiTextStreamSink.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `emit()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Renders the event through the subclass [`EmojiTextStreamSink::format()`](/api/logging/sink/emoji-text-stream-sink/#format) and writes it as one newline-terminated line. |
| `flush()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Flushes the underlying stream if one has been opened. |
| `isEnabled()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Whether this sink accepts an event at $level for $category. |
