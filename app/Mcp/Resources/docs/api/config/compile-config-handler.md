# CompileConfigHandler

> CompileConfigHandler gathers multiple files and puts them into a single file.

CompileConfigHandler gathers multiple files and puts them into a single file.

Upon creation of the new file, all comments and blank lines are removed.

Migrated to IArrayConfigHandler (phase 2). Canonical schema: ['resolved_file_path' => 'code_to_embed'], exactly the map execute() used to build inline and hand straight to generate() (which concatenates the values). Gathering/reading/ formatting the referenced files still happens in toCanonicalArray() -- unlike other handlers' extraction step, this one is inherently about resolving and reading files the config points at, not just walking the DOM, so there's little left for executeArray() to do but hand the already-built map to generate().

## Synopsis

`class CompileConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/CompileConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/compile/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array $config, ?string $sourceRef = null): mixed`](#executearray) | Returns the canonical map unchanged as the declaration to cache. |
| [`schema(): Rule`](#schema) | Keyed by resolved file path (dynamic, not a fixed key set) -- an open map like SettingConfigHandler's, but the value type (embedded code string) is fixed. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array`](#tocanonicalarray) | Resolves every file the document's `compiles` elements name and returns the map of resolved path to the code to embed for it. |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<string, string>, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) |  |

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

Returns the canonical map unchanged as the declaration to cache.

All the work for this config type — resolving, reading and formatting the referenced files — already happened in [`CompileConfigHandler::toCanonicalArray()`](/api/config/compile-config-handler/#tocanonicalarray), so there is nothing left to compile here.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array` |  |
| `$sourceRef` | `?``string` |  |

Returns `mixed`

### schema()

`public function schema(): Rule`

Keyed by resolved file path (dynamic, not a fixed key set) -- an open map like SettingConfigHandler's, but the value type (embedded code string) is fixed.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array`

Resolves every file the document's `compiles` elements name and returns the map of resolved path to the code to embed for it.

Each entry's path is directive-expanded and resolved against the filesystem. In debug mode the embedded code is a `require()` of the file, so stack traces still point at the original; otherwise the file's contents are read and stripped of comments, PHP tags and redundant whitespace by [`CompileConfigHandler::formatFile()`](/api/config/compile-config-handler/#formatfile).

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array`

| Throws | When |
|---|---|
| `ParseException` | if a named file does not exist, is unreadable, or cannot be read. |

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<string, string>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: array<string, string>, positions: array<string, array{file: string, line: int}>}`

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
