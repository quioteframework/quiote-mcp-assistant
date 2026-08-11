# ReturnArrayConfigHandler

> ReturnArrayConfigHandler allows you to retrieve the contents of a config file as an array.

ReturnArrayConfigHandler allows you to retrieve the contents of a config file as an array.

Assumes that the content elements are in no XML namespace; if you want to use an XML namespace for your elements, define the namespace URI using the "namespace_uri" parameter.

Migrated to IArrayConfigHandler (phase 2). This handler's whole purpose is "turn a config file into a * plain array" -- for XML that means the recursive convertToArray() walk below; for a PHP/YAML source the canonical array *is* the source (there is nothing left to convert), so toCanonicalArray() and executeArray() are a near-trivial split here.

Deliberately does not implement ISchemaAwareConfigHandler: its whole point is arbitrary, app-defined XML-to-array conversion driven by caller-supplied parameters (id_attribute/value_key/force_array_values/ attribute_prefix), so there is no fixed canonical shape to describe -- same reasoning as SettingConfigHandler's open, dynamically-keyed shape.

## Synopsis

`class ReturnArrayConfigHandler extends XmlConfigHandler implements IArrayConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/ReturnArrayConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array $config, ?string $sourceRef = null): mixed`](#executearray) | Returns the canonical array unchanged as the declaration to cache. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array`](#tocanonicalarray) | Converts the document's configuration elements into a plain array. |

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
| `ParseException` | If a requested configuration file is improperly formatted. |

### executeArray()

`public function executeArray(array $config, ?string $sourceRef = null): mixed`

Returns the canonical array unchanged as the declaration to cache.

This handler's purpose is to surface a config file as a plain array, so once the array exists there is nothing further to compile.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array` |  |
| `$sourceRef` | `?``string` |  |

Returns `mixed`

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array`

Converts the document's configuration elements into a plain array.

Elements are read from the namespace named by the `namespace_uri` parameter, which defaults to none. Each top-level configuration block is converted recursively and merged into one array, so a later block's keys win over an earlier one's. The conversion itself is driven by the handler's `id_attribute`, `value_key`, `force_array_values`, `attribute_prefix` and `literalize` parameters.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array`

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
