# PhpArrayPositionParser

> Best-effort key-path -> {file, line} index for a PHP-array config file's own `return [...]` literal.

Best-effort key-path -> {file, line} index for a PHP-array config file's own `return [...]` literal.

Unlike XML, no per-handler reconciliation is needed: a hand-authored PHP config file's array literal already IS the canonical array, verbatim (see FactoryConfigHandler/PluginConfigHandler's own docblocks), so the tokenizer's key paths already match the canonical array's key names directly.

Uses \PhpToken::tokenize() rather than the legacy token_get_all(): every token -- including single characters like `[`, `,`, `)` -- carries a real ->line, where token_get_all() only gives line numbers on multi-character tokens.

Only literal nested arrays are descended into; any other value (a function call, a constant, string concatenation, ...) is recorded as a leaf position at its key/item's own line and then skipped as an opaque, balanced-bracket expression -- this is a diagnostic position index, not a second PHP evaluator, and never needs to understand what a value means.

Never throws: a position-tracking failure must not block the real PhpArrayFormatDriver::load() path, which parses the file completely independently via a plain `require`.

## Synopsis

`final class PhpArrayPositionParser`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/Php/PhpArrayPositionParser.php` |

## Methods

| Method | Description |
|---|---|
| [`parse(string $path): array<string, array{file: string, line: int}>`](#parse) |  |

### parse()

`public static function parse(string $path): array<string, array{file: string, line: int}>`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `array``<``string``, ``array{file: string, line: int}``>`
