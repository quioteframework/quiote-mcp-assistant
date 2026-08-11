# ILegacyConfigHandler

> ILegacyConfigHandler is the interface that all old-style config handlers which deal with ConfigValueHolders and parse configs themselves implement.

ILegacyConfigHandler is the interface that all old-style config handlers which deal with ConfigValueHolders and parse configs themselves implement.

## Synopsis

`interface ILegacyConfigHandler`

|  |  |
|---|---|
| Implemented by | [`ConfigHandler`](/api/config/config-handler/) |
| Since | `1.0.0` |
| Source | `Config/ILegacyConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`execute(string $config, ?string $context = null): mixed`](#execute) | Execute this configuration handler. |
| [`initialize(?string $validationFile = null, ?string $parser = null, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this ConfigHandler. |

### execute()

`abstract public function execute(string $config, ?string $context = null): mixed`

Execute this configuration handler.

Name of the executing context (if any).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `string` | An absolute filesystem path to a configuration file. |
| `$context` | `?``string` | Name of the executing context (if any). |

Returns `mixed` — The declaration to be cached.

| Throws | When |
|---|---|
| `UnreadableException` | If a requested configuration file does not exist or is not readable. |
| `ParseException` | If a requested configuration file is improperly formatted. |

### initialize()

`abstract public function initialize(?string $validationFile = null, ?string $parser = null, array<string, mixed> $parameters = []): void`

Initialize this ConfigHandler.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$validationFile` | `?``string` | The path to a validation file for this config handler. |
| `$parser` | `?``string` | The parser class to use. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing the ConfigHandler |
