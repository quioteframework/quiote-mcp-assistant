# FactoryConfigHandler

> FactoryConfigHandler allows you to specify which factory implementation the system will use.

FactoryConfigHandler allows you to specify which factory implementation the system will use.

The factory ordering/startup-sequence/must_implement logic in getFactoryDefinitions() is pure PHP with no XML-specific content at all, so it lives in code rather than in the configuration. The canonical array is exactly the per-factory `class`/`params` pairs declared in the source (XML, PHP, or YAML): [ 'validation_manager' => ['class' => 'Some\Class', 'params' => [...]], 'response' => ['class' => '...', 'params' => [...]], // one entry per <factory-name> child element the XML configuration // (or, for a PHP/YAML file, top-level key) actually declares. ] Every factory getFactoryDefinitions() names is read, so the canonical array is a faithful reading of the source and does not depend on any runtime setting; whether a declared factory is then built is decided in executeArray(). A PHP-array/YAML factories file is simply this same map written directly, e.g. `return ['database_manager' => ['class' => ..., 'params' => [...]], ...];`.

## Synopsis

`class FactoryConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/FactoryConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/factories/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array<string, array{class: (string | null), params: array<mixed>}> $config, string|null $sourceRef = null): mixed`](#executearray) |  |
| [`schema(): Rule`](#schema) | No required list: which factories must be present depends on runtime settings (translation_manager on core.use_translation), so that is a semantic check in executeArray() rather than a static array shape. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array<string, array{class: (string | null), params: array<mixed>}>`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<string, array{class: (string | null), params: array<mixed>}>, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) |  |

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

`public function executeArray(array<string, array{class: (string | null), params: array<mixed>}> $config, string|null $sourceRef = null): mixed`

Origin reference for the compiled
                   cache file's header comment (a file path for any
                   format; XML's is $document->documentURI).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``string``, ``array{class: (string | null), params: array<mixed>}``>` | The canonical config array, matching the shape returned by toCanonicalArray(). |
| `$sourceRef` | `string``|``null` | Origin reference for the compiled cache file's header comment (a file path for any format; XML's is $document->documentURI). |

Returns `mixed` — The declaration to be cached, exactly as IXmlConfigHandler::execute() returns.

### schema()

`public function schema(): Rule`

No required list: which factories must be present depends on runtime settings (translation_manager on core.use_translation), so that is a semantic check in executeArray() rather than a static array shape.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array<string, array{class: (string | null), params: array<mixed>}>`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array``<``string``, ``array{class: (string | null), params: array<mixed>}``>`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<string, array{class: (string | null), params: array<mixed>}>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: array<string, array{class: (string | null), params: array<mixed>}>, positions: array<string, array{file: string, line: int}>}`

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
