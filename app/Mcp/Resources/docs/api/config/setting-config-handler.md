# SettingConfigHandler

> SettingConfigHandler handles the settings.xml file.

SettingConfigHandler handles the settings.xml file.

The compilation logic (executeArray()) consumes a plain array rather than walking the DOM, so the same logic compiles a settings.php or settings.yaml file (via Quiote\Config\Format\FormatDriverRegistry::forHandler()), not just XML.

The canonical array shape is a flat, dot-keyed map: 'actions.{name}_module'          => string   (from <system_action name="..."><module>) 'actions.{name}_action'          => string   (from <system_action name="..."><action>) '{prefix}{setting_name}'         => mixed    (prefix defaults to 'core.'; a <settings prefix="..."> wrapper overrides it for its children; the value is either a scalar/nested array from <ae:parameters>, or the setting's literal text value)

A PHP-array or YAML settings file is simply this map written directly, e.g. `return ['core.app_name' => 'Demo', 'core.debug' => true];` -- there is no XML-specific concept (system_actions/settings/prefix wrappers) left to represent once you're at this shape.

The compiled artifact returns that map; [`SettingConfigHandler::apply()`](/api/config/setting-config-handler/#apply) is what feeds it to [`Config`](/api/config/config/).

## Synopsis

`class SettingConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IDeclarationConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IDeclarationConfigHandler`](/api/config/i-declaration-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/SettingConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/settings/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`apply(mixed $declaration, string $sourceRef): void`](#apply) | Feed the declared settings into the configuration repository. |
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array $config, ?string $sourceRef = null): mixed`](#executearray) | Returns the flat setting map unchanged as the declaration to cache. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array`](#tocanonicalarray) | Flattens the document's system actions and settings into the dot-keyed map described in this class's summary. |

### apply()

`public function apply(mixed $declaration, string $sourceRef): void`

Feed the declared settings into the configuration repository.

The flat, dot-keyed map described in this class's summary.

| Parameter | Type | Description |
|---|---|---|
| `$declaration` | `mixed` | The flat, dot-keyed map described in this class's summary. |
| `$sourceRef` | `string` |  |

### execute()

`public function execute(XmlConfigDomDocument $document): mixed`

Execute this configuration handler.

The document to parse.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to parse. |

Returns `mixed` — The declaration to be cached.

| Throws | When |
|---|---|
| `UnreadableException` | If a requested configuration file does not exist or is not readable. |
| `ParseException` | If a requested configuration file is improperly formatted. |

### executeArray()

`public function executeArray(array $config, ?string $sourceRef = null): mixed`

Returns the flat setting map unchanged as the declaration to cache.

The map is already the compiled artifact; [`SettingConfigHandler::apply()`](/api/config/setting-config-handler/#apply) is what later feeds it into [`Config`](/api/config/config/).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array` |  |
| `$sourceRef` | `?``string` |  |

Returns `mixed`

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array`

Flattens the document's system actions and settings into the dot-keyed map described in this class's summary.

Each system action contributes an `actions.{name}_module` and an `actions.{name}_action` entry. Each setting is keyed by its name behind a prefix — `core.` unless an enclosing `<settings prefix="...">` overrides it for its children — and takes either its nested parameters or its literalized text value.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array`

| Throws | When |
|---|---|
| `ParseException` | if a system action is missing its `<module>` or `<action>` child. |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`XmlConfigHandler`](/api/config/xml-config-handler/) | Initialize this ConfigHandler. |
| `literalize()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Literalize a string value. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `replaceConstants()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Replace configuration directive identifiers in a string. |
| `replacePath()` | [`BaseConfigHandler`](/api/config/base-config-handler/) | Replace a relative filesystem path with an absolute one. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
