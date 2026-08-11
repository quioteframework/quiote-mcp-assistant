# Sink

> The Quiote\\Logging\\Sink namespace — 7 documented types.

Everything under `Quiote\Logging\Sink`.

## Classes

| Class | Description |
|---|---|
| [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Base for sinks that write one line per event to a stream. |
| [`AnsiTextStreamSink`](/api/logging/sink/ansi-text-stream-sink/) | TextStreamSink that colors warning-and-above lines so they stand out in an interactive terminal: yellow = warning red = error bold red = critical/alert/emergency Debug/info/notice are left uncolored — the goal is making problems jump out, not painting every line. |
| [`EmojiTextStreamSink`](/api/logging/sink/emoji-text-stream-sink/) | AnsiTextStreamSink with an emoji prefix per level, for local dev consoles where a quick visual scan matters more than a clean tail \| grep. |
| [`FileSink`](/api/logging/sink/file-sink/) | Plain-text sink that appends one line per event to a file on disk, creating the parent directory if it doesn't exist yet (AbstractStreamSink's lazy fopen() would otherwise fail silently against a missing directory). |
| [`JsonStdoutSink`](/api/logging/sink/json-stdout-sink/) | Default container sink: one compact JSON object per line to stdout. |
| [`TextStreamSink`](/api/logging/sink/text-stream-sink/) | Human-readable single-line sink for local development. |

## Interfaces

| Interface | Description |
|---|---|
| [`SinkInterface`](/api/logging/sink/sink-interface/) | A destination for log events. |
