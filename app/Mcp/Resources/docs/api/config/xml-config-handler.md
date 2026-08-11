# XmlConfigHandler

> XmlConfigHandler is the base config handler that deals with DOMDocuments

XmlConfigHandler is the base config handler that deals with DOMDocuments

## Synopsis

`abstract class XmlConfigHandler extends BaseConfigHandler implements IXmlConfigHandler`

|  |  |
|---|---|
| Extends | [`BaseConfigHandler`](/api/config/base-config-handler/) |
| Implements | [`IXmlConfigHandler`](/api/config/i-xml-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/XmlConfigHandler.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`initialize(?Context $context = null, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this ConfigHandler. |

### initialize()

`public function initialize(?Context $context = null, array<string, mixed> $parameters = []): void`

Initialize this ConfigHandler.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | `?`[`Context`](/api/context/) | The context to work with (if available). |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing the ConfigHandler |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `execute()` | [`IXmlConfigHandler`](/api/config/i-xml-config-handler/) | Execute this configuration handler. |
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
