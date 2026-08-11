# AnsiTextStreamSink

> TextStreamSink that colors warning-and-above lines so they stand out in an interactive terminal: yellow = warning red = error bold red = critical/alert/emergency Debug/info/notice are left uncolored — the goal is making problems jump out, not painting every line.

TextStreamSink that colors warning-and-above lines so they stand out in an interactive terminal: yellow   = warning red      = error bold red = critical/alert/emergency Debug/info/notice are left uncolored — the goal is making problems jump out, not painting every line.

Colors are auto-disabled when NO_COLOR is set (see https://no-color.org) or the destination isn't a TTY (e.g. output redirected to a file or piped into another program), so this is safe to use as a default dev-console sink without leaking escape codes into redirected output. Pass $colors explicitly to override the auto-detection.

## Synopsis

`class AnsiTextStreamSink extends TextStreamSink`

|  |  |
|---|---|
| Extends | [`TextStreamSink`](/api/logging/sink/text-stream-sink/) |
| Source | `Logging/Sink/AnsiTextStreamSink.php` |

## Constructor

### __construct()

`public function __construct(string $stream = 'php://stderr', Level $minLevel = Quiote\Logging\Level::Debug, array<string, Level> $categoryOverrides = [], mixed $streamResource = null, ?bool $colors = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$stream` | `string` |  |
| `$minLevel` | [`Level`](/api/logging/level/) |  |
| `$categoryOverrides` | `array``<``string``, `[`Level`](/api/logging/level/)`>` |  |
| `$streamResource` | `mixed` |  |
| `$colors` | `?``bool` |  |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `emit()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Renders the event through the subclass [`AnsiTextStreamSink::format()`](/api/logging/sink/ansi-text-stream-sink/#format) and writes it as one newline-terminated line. |
| `flush()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Flushes the underlying stream if one has been opened. |
| `isEnabled()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Whether this sink accepts an event at $level for $category. |
