# XmlConfigParser

> XmlConfigParser handles both Quiote and foreign XML configuration files, deals with XIncludes, XSL transformations and validation as well as filtering and ordering of configuration blocks and parent file resolution and parsing.

XmlConfigParser handles both Quiote and foreign XML configuration files, deals with XIncludes, XSL transformations and validation as well as filtering and ordering of configuration blocks and parent file resolution and parsing.

## Synopsis

`class XmlConfigParser`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/XmlConfigParser.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `NAMESPACE_QUIOTE_ANNOTATIONS_1_0` | `'http://quiote.dev/quiote/config/global/annotations/1.0'` |  |
| `NAMESPACE_QUIOTE_ANNOTATIONS_LATEST` | `'http://quiote.dev/quiote/config/global/annotations/1.0'` |  |
| `NAMESPACE_QUIOTE_ENVELOPE_1_1` | `'http://quiote.dev/quiote/config/global/envelope/1.1'` |  |
| `NAMESPACE_QUIOTE_ENVELOPE_LATEST` | `'http://quiote.dev/quiote/config/global/envelope/1.1'` |  |
| `NAMESPACE_SCHEMATRON_ISO` | `'http://purl.oclc.org/dsdl/schematron'` |  |
| `NAMESPACE_SVRL_ISO` | `'http://purl.oclc.org/dsdl/svrl'` |  |
| `NAMESPACE_XINCLUDE_2001` | `'http://www.w3.org/2001/XInclude'` |  |
| `NAMESPACE_XMLNS_2000` | `'http://www.w3.org/2000/xmlns/'` |  |
| `NAMESPACE_XML_1998` | `'http://www.w3.org/XML/1998/namespace'` |  |
| `NAMESPACE_XSL_1999` | `'http://www.w3.org/1999/XSL/Transform'` |  |
| `STAGE_COMPILATION` | `'compilation'` |  |
| `STAGE_SINGLE` | `'single'` |  |
| `STEP_TRANSFORMATIONS_AFTER` | `'transformations_after'` |  |
| `STEP_TRANSFORMATIONS_BEFORE` | `'transformations_before'` |  |
| `VALIDATION_TYPE_RELAXNG` | `'relax_ng'` |  |
| `VALIDATION_TYPE_SCHEMATRON` | `'schematron'` |  |
| `VALIDATION_TYPE_XMLSCHEMA` | `'xml_schema'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$quioteEnvelopeNamespaces` | `mixed` | _static._ |
| `$quioteNamespaces` | `mixed` | _static._ |

## Constructor

### __construct()

`public function __construct(string $path, ?string $environment = null, ?string $context = null): mixed`

The constructor.

The optional name of the current context.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The path to the configuration file. |
| `$environment` | `?``string` | The optional name of the current environment. |
| `$context` | `?``string` | The optional name of the current context. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__destruct(): mixed`](#destruct) | Destructor to do the cleaning up. |
| [`cleanup(XmlConfigDomDocument $document): void`](#cleanup) | Clean up a given document. |
| [`execute(array<int, string> $transformationInfo = [], array<string, mixed> $validationInfo = []): XmlConfigDomDocument`](#execute) |  |
| [`executeCompilation(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<int, string> $transformationInfo = [], array<string, mixed> $validationInfo = []): XmlConfigDomDocument`](#executecompilation) | Executes the parser for a compilation document. |
| [`getQuioteNamespacePrefix(string $namespaceUri): ?string`](#getquiotenamespaceprefix) | Retrieves an XPath namespace prefix based on a given namespace URI. |
| [`isLegacyEnvelopeNamespace(string $namespaceUri): bool`](#islegacyenvelopenamespace) | Check if the given namespace URI is a Quiote envelope namespace that used to be supported (pre-1.1) but has since been dropped. |
| [`isQuioteConfigurationDocument(XmlConfigDomDocument $doc): bool`](#isquioteconfigurationdocument) | Test if the given document looks like an Quiote config file. |
| [`isQuioteEnvelopeNamespace(string $namespaceUri): bool`](#isquioteenvelopenamespace) | Check if the given namespace URI is a valid Quiote envelope namespace. |
| [`isQuioteNamespace(string $namespaceUri): bool`](#isquiotenamespace) | Check if a given namespace URI is a valid Quiote namespace. |
| [`match(XmlConfigDomDocument $document, ?string $environment, ?string $context): void`](#match) | Annotate the document with matched attributes against each configuration element that matches the given context and environment. |
| [`registerQuioteNamespaces(XmlConfigDomDocument $document): void`](#registerquiotenamespaces) | Register Quiote namespace prefixes in a given document. |
| [`run(string $path, ?string $environment, ?string $context = null, array<string, array<int, string>> $transformationInfo = [], array<string, mixed> $validationInfo = [], ?ElementPositionIndex $positions = null): XmlConfigDomDocument`](#run) |  |
| [`testPattern(mixed $pattern, mixed $subject): bool`](#testpattern) | Builds a proper regular expression from the input pattern to test against the given subject. |
| [`transform(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<int, string> $transformationInfo = [], array<int, XmlConfigDomDocument> $transformations = []): XmlConfigDomDocument`](#transform) | Transform the document using info from embedded processing instructions and given stylesheets. |
| [`transformProcessingInstructions(XmlConfigDomDocument $document, ?string $environment, ?string $context): XmlConfigDomDocument`](#transformprocessinginstructions) | Transforms a given document according to xml-stylesheet processing instructions |
| [`validate(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<string, mixed> $validationInfo = []): void`](#validate) | Perform validation on a given document. |
| [`validateRelaxng(XmlConfigDomDocument $document, array<int, string> $validationFiles = []): void`](#validaterelaxng) | Validate the document against the given list of RELAX NG files. |
| [`validateSchematron(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<int, string> $validationFiles = []): void`](#validateschematron) | Validate the document against the given list of Schematron files. |
| [`validateXmlschema(XmlConfigDomDocument $document, array<int, string> $validationFiles = []): void`](#validatexmlschema) | Validate the document against the given list of XML Schema files. |
| [`validateXmlschemaSource(XmlConfigDomDocument $document, array<int, string> $validationSources = []): void`](#validatexmlschemasource) | Validate the document against the given list of XML Schema documents. |
| [`validateXsi(XmlConfigDomDocument $document): void`](#validatexsi) | Validate a given document according to XMLSchema-instance (xsi) declarations. |
| [`xinclude(XmlConfigDomDocument $document): void`](#xinclude) | Resolve xinclude directives on a given document. |

### __destruct()

`public function __destruct(): mixed`

Destructor to do the cleaning up.

Returns `mixed`

### cleanup()

`public static function cleanup(XmlConfigDomDocument $document): void`

Clean up a given document.

The document to clean up.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to clean up. |

### execute()

`public function execute(array<int, string> $transformationInfo = [], array<string, mixed> $validationInfo = []): XmlConfigDomDocument`

An associative array of validation information.

| Parameter | Type | Description |
|---|---|---|
| `$transformationInfo` | `array``<``int``, ``string``>` | An array of XSL paths for transformation. |
| `$validationInfo` | `array``<``string``, ``mixed``>` | An associative array of validation information. |

Returns [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) — Our DOMDocument.

### executeCompilation()

`public static function executeCompilation(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<int, string> $transformationInfo = [], array<string, mixed> $validationInfo = []): XmlConfigDomDocument`

Executes the parser for a compilation document.

An associative array of validation information.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$environment` | `?``string` | The environment name, or null if none is configured. |
| `$context` | `?``string` | The context name, or null if none is configured. |
| `$transformationInfo` | `array``<``int``, ``string``>` | An array of XSL paths for transformation. |
| `$validationInfo` | `array``<``string``, ``mixed``>` | An associative array of validation information. |

Returns [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) — The compiled document.

### getQuioteNamespacePrefix()

`public static function getQuioteNamespacePrefix(string $namespaceUri): ?string`

Retrieves an XPath namespace prefix based on a given namespace URI.

The namespace URI.

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | The namespace URI. |

Returns `?``string` — The prefix for the namespace URI, or null if none exists.

### isLegacyEnvelopeNamespace()

`public static function isLegacyEnvelopeNamespace(string $namespaceUri): bool`

Check if the given namespace URI is a Quiote envelope namespace that used to be supported (pre-1.1) but has since been dropped.

The namespace URI.

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | The namespace URI. |

Returns `bool` — True, if the given URI is a legacy envelope namespace, false otherwise.

### isQuioteConfigurationDocument()

`public static function isQuioteConfigurationDocument(XmlConfigDomDocument $doc): bool`

Test if the given document looks like an Quiote config file.

The document to test.

| Parameter | Type | Description |
|---|---|---|
| `$doc` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to test. |

Returns `bool` — True, if it is an Quiote config document, false otherwise.

### isQuioteEnvelopeNamespace()

`public static function isQuioteEnvelopeNamespace(string $namespaceUri): bool`

Check if the given namespace URI is a valid Quiote envelope namespace.

The namespace URI.

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | The namespace URI. |

Returns `bool` — True, if the given URI is a valid namespace URI, or false.

### isQuioteNamespace()

`public static function isQuioteNamespace(string $namespaceUri): bool`

Check if a given namespace URI is a valid Quiote namespace.

The namespace URI.

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | The namespace URI. |

Returns `bool` — True if the given URI is a valid namespace URI, false otherwise.

### match()

`public static function match(XmlConfigDomDocument $document, ?string $environment, ?string $context): void`

Annotate the document with matched attributes against each configuration element that matches the given context and environment.

The context name, or null if none is configured.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$environment` | `?``string` | The environment name, or null if none is configured. |
| `$context` | `?``string` | The context name, or null if none is configured. |

### registerQuioteNamespaces()

`public static function registerQuioteNamespaces(XmlConfigDomDocument $document): void`

Register Quiote namespace prefixes in a given document.

The document.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document. |

### run()

`public static function run(string $path, ?string $environment, ?string $context = null, array<string, array<int, string>> $transformationInfo = [], array<string, mixed> $validationInfo = [], ?ElementPositionIndex $positions = null): XmlConfigDomDocument`

When given, populated with a
                   {file, line} entry for every merged <configuration>
                   element (and its descendants) whose pre-merge source
                   node still had a real line number -- i.e. it survived
                   to the merge step without being cloned/transformed
                   away first. Left untouched (and this is a no-op) when
                   null, which is the default for every existing caller.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | An absolute filesystem path to a configuration file. |
| `$environment` | `?``string` | The environment name, or null to resolve it from core.environment (which may itself be unset -- see the constructor). |
| `$context` | `?``string` | The optional context name. |
| `$transformationInfo` | `array``<``string``, ``array``<``int``, ``string``>``>` | An associative array of transformation information. |
| `$validationInfo` | `array``<``string``, ``mixed``>` | An associative array of validation information. |
| `$positions` | `?`[`ElementPositionIndex`](/api/config/format/xml/element-position-index/) | When given, populated with a {file, line} entry for every merged <configuration> element (and its descendants) whose pre-merge source node still had a real line number -- i.e. it survived to the merge step without being cloned/transformed away first. Left untouched (and this is a no-op) when null, which is the default for every existing caller. |

Returns [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) — A properly merged DOMDocument.

### testPattern()

`public static function testPattern(mixed $pattern, mixed $subject): bool`

Builds a proper regular expression from the input pattern to test against the given subject.

The subject to test against the pattern.

| Parameter | Type | Description |
|---|---|---|
| `$pattern` | `mixed` | A regular expression chunk without delimiters/anchors. |
| `$subject` | `mixed` | The subject to test against the pattern. |

Returns `bool` — Whether or not the subject matched the pattern.

### transform()

`public static function transform(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<int, string> $transformationInfo = [], array<int, XmlConfigDomDocument> $transformations = []): XmlConfigDomDocument`

Transform the document using info from embedded processing instructions and given stylesheets.

An array of XSL stylesheets in DOMDocument instances.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$environment` | `?``string` | The environment name, or null if none is configured. |
| `$context` | `?``string` | The context name, or null if none is configured. |
| `$transformationInfo` | `array``<``int``, ``string``>` | An array of transformation information. |
| `$transformations` | `array``<``int``, `[`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/)`>` | An array of XSL stylesheets in DOMDocument instances. |

Returns [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) — The transformed document.

### transformProcessingInstructions()

`public static function transformProcessingInstructions(XmlConfigDomDocument $document, ?string $environment, ?string $context): XmlConfigDomDocument`

Transforms a given document according to xml-stylesheet processing instructions

The context name, or null if none is configured.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$environment` | `?``string` | The environment name, or null if none is configured. |
| `$context` | `?``string` | The context name, or null if none is configured. |

Returns [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) — The transformed document.

### validate()

`public static function validate(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<string, mixed> $validationInfo = []): void`

Perform validation on a given document.

An array of validation information.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$environment` | `?``string` | The environment name, or null if none is configured. |
| `$context` | `?``string` | The context name, or null if none is configured. |
| `$validationInfo` | `array``<``string``, ``mixed``>` | An array of validation information. |

### validateRelaxng()

`public static function validateRelaxng(XmlConfigDomDocument $document, array<int, string> $validationFiles = []): void`

Validate the document against the given list of RELAX NG files.

An array of file names to validate against.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$validationFiles` | `array``<``int``, ``string``>` | An array of file names to validate against. |

### validateSchematron()

`public static function validateSchematron(XmlConfigDomDocument $document, ?string $environment, ?string $context, array<int, string> $validationFiles = []): void`

Validate the document against the given list of Schematron files.

An array of file names to validate against.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$environment` | `?``string` | The environment name, or null if none is configured. |
| `$context` | `?``string` | The context name, or null if none is configured. |
| `$validationFiles` | `array``<``int``, ``string``>` | An array of file names to validate against. |

### validateXmlschema()

`public static function validateXmlschema(XmlConfigDomDocument $document, array<int, string> $validationFiles = []): void`

Validate the document against the given list of XML Schema files.

An array of file names to validate against.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$validationFiles` | `array``<``int``, ``string``>` | An array of file names to validate against. |

### validateXmlschemaSource()

`public static function validateXmlschemaSource(XmlConfigDomDocument $document, array<int, string> $validationSources = []): void`

Validate the document against the given list of XML Schema documents.

An array of schema documents to validate against.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
| `$validationSources` | `array``<``int``, ``string``>` | An array of schema documents to validate against. |

### validateXsi()

`public static function validateXsi(XmlConfigDomDocument $document): void`

Validate a given document according to XMLSchema-instance (xsi) declarations.

The document to act upon.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |

### xinclude()

`public static function xinclude(XmlConfigDomDocument $document): void`

Resolve xinclude directives on a given document.

The document to act upon.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The document to act upon. |
