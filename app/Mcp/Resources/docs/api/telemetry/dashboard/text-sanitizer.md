# TextSanitizer

> Strips terminal-escape introducer bytes from telemetry-derived strings (span names, status messages, route labels, attribute values) before they reach a `TextWidget`.

Strips terminal-escape introducer bytes from telemetry-derived strings (span names, status messages, route labels, attribute values) before they reach a `TextWidget`.

`symfony/tui`'s `TextWidget` renders its text ANSI-passthrough and unsanitized by design (see that class's own docblock) -- fine for developer-authored UI strings, but every string this dashboard displays ultimately comes from an instrumented app's telemetry export, which the dashboard does not control. A hostile or buggy app could otherwise inject ESC/CSI/OSC sequences via, e.g., a span attribute value, to corrupt or hijack the terminal display.

Deliberately not reusing `Symfony\Component\Tui\Widget\Util\StringUtils` (which does the same thing) -- that class is marked `@internal` to the `symfony/tui` package.

## Synopsis

`final class TextSanitizer`

|  |  |
|---|---|
| Source | `TextSanitizer.php` |

## Methods

| Method | Description |
|---|---|
| [`sanitize(string $value): string`](#sanitize) | Removes C0 controls (except tab/newline), DEL, and the UTF-8 encoding of C1 controls -- the same set `symfony/tui`'s internal sanitizer strips, so behavior matches widgets that do sanitize their own input (e.g. |

### sanitize()

`public static function sanitize(string $value): string`

Removes C0 controls (except tab/newline), DEL, and the UTF-8 encoding of C1 controls -- the same set `symfony/tui`'s internal sanitizer strips, so behavior matches widgets that do sanitize their own input (e.g.

`InputWidget`).

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |

Returns `string`
