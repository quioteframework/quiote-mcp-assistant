# PhpArrayFormatDriver

> Loads a config source that is itself a plain PHP file returning an array -- the recommended primary format (zero parsing cost beyond opcache, full IDE support, native `parent`/`imports` path resolution via AbstractArrayFormatDriver).

Loads a config source that is itself a plain PHP file returning an array -- the recommended primary format (zero parsing cost beyond opcache, full IDE support, native `parent`/`imports` path resolution via AbstractArrayFormatDriver).

## Synopsis

`final class PhpArrayFormatDriver extends AbstractArrayFormatDriver implements PositionAwareFormatDriverInterface`

|  |  |
|---|---|
| Extends | [`AbstractArrayFormatDriver`](/api/config/format/abstract-array-format-driver/) |
| Implements | [`PositionAwareFormatDriverInterface`](/api/config/format/position-aware-format-driver-interface/) |
| Since | `1.0.0` |
| Source | `Config/Format/PhpArrayFormatDriver.php` |

## Methods

| Method | Description |
|---|---|
| [`loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<(int | string), mixed>, positions: array<string, array{file: string, line: int}>}`](#loadwithpositions) |  |
| [`supports(string $path): bool`](#supports) | Whether the path names a `.php` file, matched case-insensitively. |

### loadWithPositions()

`public function loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<(int | string), mixed>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `?``string` |  |
| `$context` | `?``string` |  |

Returns `array{data: array<(int | string), mixed>, positions: array<string, array{file: string, line: int}>}`

### supports()

`public function supports(string $path): bool`

Whether the path names a `.php` file, matched case-insensitively.

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
