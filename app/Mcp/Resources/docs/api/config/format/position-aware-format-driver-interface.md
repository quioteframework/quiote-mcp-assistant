# PositionAwareFormatDriverInterface

> Opt-in \"locating\" parse mode (see VSCODE_EXTENSION_INTEGRATION.md's config validator work item 3): same canonical array a plain load() would produce, plus a key-path -> {file, line} index for whichever keys the driver could trace back to a source position.

Opt-in "locating" parse mode (see VSCODE_EXTENSION_INTEGRATION.md's config validator work item 3): same canonical array a plain load() would produce, plus a key-path -> {file, line} index for whichever keys the driver could trace back to a source position.

Formalizes the shape XmlFormatDriver::loadWithPositions() already has, so a caller (e.g. a future validate_config probe capability) can use it generically regardless of which format actually produced the config.

## Synopsis

`interface PositionAwareFormatDriverInterface`

|  |  |
|---|---|
| Implemented by | [`PhpArrayFormatDriver`](/api/config/format/php-array-format-driver/), [`XmlFormatDriver`](/api/config/format/xml-format-driver/), [`YamlFormatDriver`](/api/config/format/yaml-format-driver/) |
| Since | `1.0.0` |
| Source | `Config/Format/PositionAwareFormatDriverInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<string, mixed>, positions: array<string, array{file: string, line: int}>}`](#loadwithpositions) |  |

### loadWithPositions()

`abstract public function loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<string, mixed>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `?``string` |  |
| `$context` | `?``string` |  |

Returns `array{data: array<string, mixed>, positions: array<string, array{file: string, line: int}>}`
