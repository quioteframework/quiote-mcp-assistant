# FormatDriverInterface

> A FormatDriver turns one config source file, in whatever format it understands, into a normalized PHP array -- the same canonical shape a given config handler's array-based execute() method consumes regardless of which driver produced it (see Quiote\\Config\\IArrayConfigHandler).

A FormatDriver turns one config source file, in whatever format it understands, into a normalized PHP array -- the same canonical shape a given config handler's array-based execute() method consumes regardless of which driver produced it (see Quiote\Config\IArrayConfigHandler).

## Synopsis

`interface FormatDriverInterface`

|  |  |
|---|---|
| Implemented by | [`AbstractArrayFormatDriver`](/api/config/format/abstract-array-format-driver/), [`XmlFormatDriver`](/api/config/format/xml-format-driver/) |
| Since | `1.0.0` |
| Source | `Config/Format/FormatDriverInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`load(string $path, string $environment, string|null $context = null): array<string, mixed>`](#load) |  |
| [`supports(string $path): bool`](#supports) | Whether this driver can handle the given path, based on its extension. |

### load()

`abstract public function load(string $path, string $environment, string|null $context = null): array<string, mixed>`

The active context name, if any.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `string` | The active environment name (only meaningful to drivers whose format has a native environment-filtering concept, e.g. XmlFormatDriver; array/YAML drivers ignore it today -- see class docs). |
| `$context` | `string``|``null` | The active context name, if any. |

Returns `array``<``string``, ``mixed``>` — The resolved, parent-chain-merged, directive-expanded config data.

### supports()

`abstract public function supports(string $path): bool`

Whether this driver can handle the given path, based on its extension.

Used by FormatDriverRegistry to pick a driver.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`
