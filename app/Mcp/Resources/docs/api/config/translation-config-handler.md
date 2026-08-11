# TranslationConfigHandler

> TranslationConfigHandler allows you to define translator implementations for different domains.

TranslationConfigHandler allows you to define translator implementations for different domains.

Migrated to IArrayConfigHandler (phase 2). Canonical schema: ['default_domain' => string, 'default_locale' => string|null, 'default_timezone' => string|null, 'locales' => ['identifier' => ['name' => ..., 'params' => [...], 'fallback' => ..., 'ldml_file' => ...]], 'translators' => ['domain' => ['msg'|'num'|'cur'|'date' => ['class' => ..., 'filters' => [...], 'params' => [...]]]]] getFilters()/getTranslators() are DOM-walking helpers used only by toCanonicalArray(); the translator-class existence check (a pure function of the finished canonical array) moved to executeArray().

## Synopsis

`class TranslationConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/TranslationConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/translation/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array{default_domain?: string, default_locale?: ?string, default_timezone?: ?string, locales?: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators?: array<string, mixed>} $config, string|null $sourceRef = null): mixed`](#executearray) |  |
| [`schema(): Rule`](#schema) | Returns the structural rule for the translation configuration. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array{default_domain: string, default_locale: ?string, default_timezone: ?string, locales: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators: array<string, mixed>}`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array{default_domain: string, default_locale: ?string, default_timezone: ?string, locales: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators: array<string, mixed>}, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) | Positions are only tracked for "locales" -- a flat, single-level walk. |

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

`public function executeArray(array{default_domain?: string, default_locale?: ?string, default_timezone?: ?string, locales?: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators?: array<string, mixed>} $config, string|null $sourceRef = null): mixed`

Origin reference for the compiled
                   cache file's header comment (a file path for any
                   format; XML's is $document->documentURI).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array{default_domain?: string, default_locale?: ?string, default_timezone?: ?string, locales?: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators?: array<string, mixed>}` | The canonical config array, matching the shape returned by toCanonicalArray(). |
| `$sourceRef` | `string``|``null` | Origin reference for the compiled cache file's header comment (a file path for any format; XML's is $document->documentURI). |

Returns `mixed` — The declaration to be cached, exactly as IXmlConfigHandler::execute() returns.

### schema()

`public function schema(): Rule`

Returns the structural rule for the translation configuration.

Describes the default domain, locale and timezone, the `locales` map (each with its name, parameters, fallback and LDML file) and the `translators` map, which holds a message, number, currency and date translator entry per domain.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array{default_domain: string, default_locale: ?string, default_timezone: ?string, locales: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators: array<string, mixed>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array{default_domain: string, default_locale: ?string, default_timezone: ?string, locales: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators: array<string, mixed>}`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array{default_domain: string, default_locale: ?string, default_timezone: ?string, locales: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators: array<string, mixed>}, positions: array<string, array{file: string, line: int}>}`

Positions are only tracked for "locales" -- a flat, single-level walk.

"translators" builds a recursive, potentially deeply-nested domain hierarchy via getTranslators(); mirroring that faithfully for position purposes isn't attempted here (translation.xml also has legacy-upgrade <transformation> stylesheets configured by default, so positions come back empty in practice anyway -- see TranslationConfigHandlerPositionTest).

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: array{default_domain: string, default_locale: ?string, default_timezone: ?string, locales: array<string, array{name: string, params: mixed, fallback: ?string, ldml_file: ?string}>, translators: array<string, mixed>}, positions: array<string, array{file: string, line: int}>}`

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
