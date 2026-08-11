# YamlPositionParser

> Best-effort key-path -> {file, line} index for a YAML config file, built by a block-style line scanner rather than a full YAML implementation.

Best-effort key-path -> {file, line} index for a YAML config file, built by a block-style line scanner rather than a full YAML implementation.

The real data always comes from YamlFormatDriver's unchanged Symfony\Component\Yaml\Yaml::parseFile() call -- this is a separate, parallel pass purely for diagnostic positions, and a failure here must never affect that real parse.

Scoped to what this framework's own config files actually use: block mappings, block sequences (both "key: then indented dashes" and the one YAML exception where a sequence sits at the SAME indent as its key), and dash-items that are themselves inline mappings (`- class: ...` then `  enabled: ...`). Flow collections (`{...}`/`[...]`) and multi-line block scalars (`|`/`>`) are recorded as opaque leaves at their key's own line, never descended into -- a documented limitation, not a silent gap, matching how the PHP-array slice treats an arbitrary expression value.

## Synopsis

`final class YamlPositionParser`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/Yaml/YamlPositionParser.php` |

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
