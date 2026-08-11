# ConfigHandler

> ConfigHandler allows a developer to create a custom formatted configuration file pertaining to any information they like and still have it auto-generate PHP code.

ConfigHandler allows a developer to create a custom formatted configuration file pertaining to any information they like and still have it auto-generate PHP code.

:::caution[Deprecated]
This class is deprecated. Superseded by XmlConfigHandler, will be removed in Quiote 1.1
:::

## Synopsis

`abstract class ConfigHandler extends BaseConfigHandler implements ILegacyConfigHandler`

|  |  |
|---|---|
| Extends | [`BaseConfigHandler`](/api/config/base-config-handler/) |
| Implements | [`ILegacyConfigHandler`](/api/config/i-legacy-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/ConfigHandler.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$parser` | `mixed` | _protected._ |
| `$validationFile` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`getItemParameters(ConfigValueHolder $itemNode, array<int|string, mixed> $oldValues = [], boolean $literalize = true): array<int|string, mixed>`](#getitemparameters) | Retrieve the parameter node values of the given item's parameters element. |
| [`getValidationFile(): ?string`](#getvalidationfile) | Retrieves the stored validation filename. |
| [`initialize(?string $validationFile = null, ?string $parser = null, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this ConfigHandler. |
| [`orderConfigurations(ConfigValueHolder $configurations, ?string $environment = null, ?string $context = null, bool $autoloadParser = true): array<int, ConfigValueHolder>`](#orderconfigurations) | Returns a properly ordered array of ConfigValueHolder configuration elements for given env and context. |
| [`testPattern(string $pattern, string $subject): bool`](#testpattern) | Builds a proper regular expression from the input pattern to test against the given subject. |

### getItemParameters()

`protected function getItemParameters(ConfigValueHolder $itemNode, array<int|string, mixed> $oldValues = [], boolean $literalize = true): array<int|string, mixed>`

Retrieve the parameter node values of the given item's parameters element.

Whether or not values should be literalized.

| Parameter | Type | Description |
|---|---|---|
| `$itemNode` | [`ConfigValueHolder`](/api/config/config-value-holder/) | The node that contains a parameters child. |
| `$oldValues` | `array``<``int``|``string``, ``mixed``>` | An associative array of parameters that will be overwritten if appropriate. |
| `$literalize` | `boolean` | Whether or not values should be literalized. |

Returns `array``<``int``|``string``, ``mixed``>` — An associative array of parameters

### getValidationFile()

`public function getValidationFile(): ?string`

Retrieves the stored validation filename.

Returns `?``string` — An absolute filesystem path to a validation filename.

### initialize()

`public function initialize(?string $validationFile = null, ?string $parser = null, array<string, mixed> $parameters = []): void`

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

### orderConfigurations()

`public function orderConfigurations(ConfigValueHolder $configurations, ?string $environment = null, ?string $context = null, bool $autoloadParser = true): array<int, ConfigValueHolder>`

Returns a properly ordered array of ConfigValueHolder configuration elements for given env and context.

Whether the parser class should be
                                   autoloaded or not.

| Parameter | Type | Description |
|---|---|---|
| `$configurations` | [`ConfigValueHolder`](/api/config/config-value-holder/) | The root config element |
| `$environment` | `?``string` | An environment name. |
| `$context` | `?``string` | A context name. |
| `$autoloadParser` | `bool` | Whether the parser class should be autoloaded or not. |

Returns `array``<``int``, `[`ConfigValueHolder`](/api/config/config-value-holder/)`>` — An array of ConfigValueHolder configuration elements.

### testPattern()

`public static function testPattern(string $pattern, string $subject): bool`

Builds a proper regular expression from the input pattern to test against the given subject.

The subject string to test the pattern against.

| Parameter | Type | Description |
|---|---|---|
| `$pattern` | `string` | A regular expression chunk without delimiters/anchors. |
| `$subject` | `string` | The subject string to test the pattern against. |

Returns `bool` — Whether or not the subject matched the pattern.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `execute()` | [`ILegacyConfigHandler`](/api/config/i-legacy-config-handler/) | Execute this configuration handler. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `literalize()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Literalize a string value. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `replaceConstants()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Replace configuration directive identifiers in a string. |
| `replacePath()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Replace a relative filesystem path with an absolute one. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
