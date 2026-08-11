# ConfigParser

> ConfigParser parses XML files using XmlConfigParser, but returns old-style ConfigValueHolders.

ConfigParser parses XML files using XmlConfigParser, but returns old-style ConfigValueHolders.

:::caution[Deprecated]
This class is deprecated. Superseded by XmlConfigParser, will be removed in Quiote 1.1
:::

## Synopsis

`class ConfigParser`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/ConfigParser.php` |

## Methods

| Method | Description |
|---|---|
| [`parse(string $config, ?string $validationFile = null): ConfigValueHolder`](#parse) |  |

### parse()

`public function parse(string $config, ?string $validationFile = null): ConfigValueHolder`

An associative array of validation information.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute filesystem path to a configuration file. |
| `$validationFile` | `?``string` | An associative array of validation information. |

Returns [`ConfigValueHolder`](/api/config/config-value-holder/) — The data handlers use to perform tasks.
