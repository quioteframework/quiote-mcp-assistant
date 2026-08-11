# OutputTypeConfigHandler

> OutputTypeConfigHandler handles output type configuration files.

OutputTypeConfigHandler handles output type configuration files.

Migrated to IArrayConfigHandler (phase 2). Canonical schema: ['default' => 'output_type_name', 'output_types' => ['name' => ['parameters' => [...], 'default_renderer' => ..., 'renderers' => [...], 'layouts' => [...], 'default_layout' => ..., 'exception_template' => ...|null]]] All keys in the output-type, renderer, layout, layer, and slot sub-arrays are optional when using PHP/YAML format — executeArray() applies the same defaults that XML provides via getAttribute($name, $default), so terse configs work. The duplicate-name and missing-default checks are inherently tied to the order <ae:configuration> blocks are walked in (the last block's `default` attribute wins), so they stay in toCanonicalArray() exactly as before; only the final "undefined default output type" check -- a pure function of the finished canonical array -- moved to executeArray().

## Synopsis

`class OutputTypeConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/OutputTypeConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/output_types/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array{default?: (string | null), output_types?: array<string, array<string, mixed>>} $config, string|null $sourceRef = null): mixed`](#executearray) |  |
| [`schema(): Rule`](#schema) | Returns the structural rule for the output-type configuration. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array{default: (string | null), output_types: array<string, array<string, mixed>>}`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array{default: ?string, output_types: array<string, array<string, mixed>>}, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) | Positions are only tracked for each output type's own line (via its "parameters" key, always present) -- a reasonable top-level anchor without mirroring the full recursive renderers/layouts/layers/slots walk above (output_types.xml also has legacy-upgrade <transformation> stylesheets configured by default, so positions come back empty in practice anyway -- see OutputTypeConfigHandlerPositionTest). |

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

`public function executeArray(array{default?: (string | null), output_types?: array<string, array<string, mixed>>} $config, string|null $sourceRef = null): mixed`

Origin reference for the compiled
                   cache file's header comment (a file path for any
                   format; XML's is $document->documentURI).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array{default?: (string | null), output_types?: array<string, array<string, mixed>>}` | The canonical config array, matching the shape returned by toCanonicalArray(). |
| `$sourceRef` | `string``|``null` | Origin reference for the compiled cache file's header comment (a file path for any format; XML's is $document->documentURI). |

Returns `mixed` — The declaration to be cached, exactly as IXmlConfigHandler::execute() returns.

### schema()

`public function schema(): Rule`

Returns the structural rule for the output-type configuration.

Describes a top-level `default` output-type name plus an `output_types` map, each entry carrying its parameters, renderers, layouts and their layers and slots. Every key inside those sub-structures is required in the canonical array because the compilation step fills in the same defaults XML attributes supply, so a terse PHP or YAML source still arrives here complete.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array{default: (string | null), output_types: array<string, array<string, mixed>>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array{default: (string | null), output_types: array<string, array<string, mixed>>}`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array{default: ?string, output_types: array<string, array<string, mixed>>}, positions: array<string, array{file: string, line: int}>}`

Positions are only tracked for each output type's own line (via its "parameters" key, always present) -- a reasonable top-level anchor without mirroring the full recursive renderers/layouts/layers/slots walk above (output_types.xml also has legacy-upgrade <transformation> stylesheets configured by default, so positions come back empty in practice anyway -- see OutputTypeConfigHandlerPositionTest).

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: array{default: ?string, output_types: array<string, array<string, mixed>>}, positions: array<string, array{file: string, line: int}>}`

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
