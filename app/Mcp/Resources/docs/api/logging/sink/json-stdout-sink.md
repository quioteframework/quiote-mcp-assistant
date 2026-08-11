# JsonStdoutSink

> Default container sink: one compact JSON object per line to stdout.

Default container sink: one compact JSON object per line to stdout.

Designed for FrankenPHP/Caddy → AKS → Azure Log Analytics: - Compact encoding (never JSON_PRETTY_PRINT) so embedded newlines in a value (e.g. a stack trace) are escaped and each event stays on ONE physical line = one Log Analytics record. - Written straight to php://stdout as bare JSON — NOT via error_log() — so Caddy's own JSON logger does not wrap it into a "msg" string ("double JSON"). - A "src":"app" discriminator distinguishes app events from Caddy access logs. Field schema (flat, KQL-friendly). Reserved keys always win over user properties on a name collision: ts, level, category, message, template?, src, exception?  + flattened scope/properties.

## Synopsis

`final class JsonStdoutSink extends AbstractStreamSink`

|  |  |
|---|---|
| Extends | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) |
| Source | `Logging/Sink/JsonStdoutSink.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `emit()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Renders the event through the subclass [`JsonStdoutSink::format()`](/api/logging/sink/json-stdout-sink/#format) and writes it as one newline-terminated line. |
| `flush()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Flushes the underlying stream if one has been opened. |
| `isEnabled()` | [`AbstractStreamSink`](/api/logging/sink/abstract-stream-sink/) | Whether this sink accepts an event at $level for $category. |
