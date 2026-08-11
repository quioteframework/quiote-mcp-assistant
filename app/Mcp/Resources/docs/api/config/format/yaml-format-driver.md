# YamlFormatDriver

> Loads a config source written in YAML, via symfony/yaml.

Loads a config source written in YAML, via symfony/yaml.

Same `parent`/`imports` resolution as PhpArrayFormatDriver (see AbstractArrayFormatDriver) -- a `parent:` key can point at a YAML file, a PHP-array file, or (for a strangler migration) an XML one.

## Synopsis

`final class YamlFormatDriver extends AbstractArrayFormatDriver implements PositionAwareFormatDriverInterface`

|  |  |
|---|---|
| Extends | [`AbstractArrayFormatDriver`](/api/config/format/abstract-array-format-driver/) |
| Implements | [`PositionAwareFormatDriverInterface`](/api/config/format/position-aware-format-driver-interface/) |
| Since | `1.0.0` |
| Source | `Config/Format/YamlFormatDriver.php` |

## Methods

| Method | Description |
|---|---|
| [`loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<string, mixed>, positions: array<string, array{file: string, line: int}>}`](#loadwithpositions) |  |
| [`supports(string $path): bool`](#supports) | Whether the path names a YAML file, matched case-insensitively. |

### loadWithPositions()

`public function loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<string, mixed>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `?``string` |  |
| `$context` | `?``string` |  |

Returns `array{data: array<string, mixed>, positions: array<string, array{file: string, line: int}>}`

### supports()

`public function supports(string $path): bool`

Whether the path names a YAML file, matched case-insensitively.

Both the `.yaml` and `.yml` spellings are accepted.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `load()` | [`AbstractArrayFormatDriver`](/api/config/format/abstract-array-format-driver/) |  |
| `setRegistry()` | [`AbstractArrayFormatDriver`](/api/config/format/abstract-array-format-driver/) | Called by FormatDriverRegistry when this driver is registered, so `parent`/`imports` references can be resolved through any registered format, not just this driver's own. |
