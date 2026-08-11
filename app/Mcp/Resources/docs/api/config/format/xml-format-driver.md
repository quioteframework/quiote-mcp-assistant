# XmlFormatDriver

> Wraps the existing XmlConfigParser pipeline (XInclude, XSD validation, XSL normalization, parent-chain merge -- all untouched, see phase 1's \"what this is NOT\") and converts its output to the canonical array via the bound handler's toCanonicalArray().

Wraps the existing XmlConfigParser pipeline (XInclude, XSD validation, XSL normalization, parent-chain merge -- all untouched, see phase 1's "what this is NOT") and converts its output to the canonical array via the bound handler's toCanonicalArray().

This is what lets a FormatDriverRegistry treat an existing validators.xml/settings.xml exactly like a PHP-array or YAML source of the same canonical shape.

Bound to one handler (and therefore one config type) at construction time -- see FormatDriverRegistry's class docs for why a registry can't mix config types through a single XML driver.

## Synopsis

`final class XmlFormatDriver implements FormatDriverInterface, PositionAwareFormatDriverInterface`

|  |  |
|---|---|
| Implements | [`FormatDriverInterface`](/api/config/format/format-driver-interface/), [`PositionAwareFormatDriverInterface`](/api/config/format/position-aware-format-driver-interface/) |
| Since | `1.0.0` |
| Source | `Config/Format/XmlFormatDriver.php` |

## Constructor

### __construct()

`public function __construct(IArrayConfigHandler&IXmlConfigHandler $handler, array<string> $transformations = [], array<string, mixed> $validations = []): mixed`

The handler's declared XSD /
       RelaxNG / Schematron validations, in the same
       STAGE_SINGLE / STAGE_COMPILATION -> STEP_* shape config_handlers.xml
       produces and the DOM path already receives. Threaded through to
       XmlConfigParser::run() so XML reached via the FormatDriver path
       (e.g. as a `parent`/`imports` reference of a PHP/YAML config) is
       validated against the same schemas as a primary XML file.

| Parameter | Type | Description |
|---|---|---|
| `$handler` | [`IArrayConfigHandler`](/api/config/i-array-config-handler/)`&`[`IXmlConfigHandler`](/api/config/i-xml-config-handler/) |  |
| `$transformations` | `array``<``string``>` | XSL stylesheet paths applied in the single-file parse stage, in order (matching how config_handlers.xml lists <transformation> entries for this config type today). |
| `$validations` | `array``<``string``, ``mixed``>` | The handler's declared XSD / RelaxNG / Schematron validations, in the same STAGE_SINGLE / STAGE_COMPILATION -> STEP_* shape config_handlers.xml produces and the DOM path already receives. Threaded through to XmlConfigParser::run() so XML reached via the FormatDriver path (e.g. as a `parent`/`imports` reference of a PHP/YAML config) is validated against the same schemas as a primary XML file. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`load(string $path, string $environment, string|null $context = null): array<string, mixed>`](#load) |  |
| [`loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<mixed>, positions: array<string, array{file: string, line: int}>}`](#loadwithpositions) | Extension-agnostic "locating" parse mode (see VSCODE_EXTENSION_INTEGRATION.md's config validator work item 3): same canonical array as load(), plus a key-path -> {file, line} index for whichever keys the bound handler could correlate back to a source element. |
| [`supports(string $path): bool`](#supports) | Whether the path names an `.xml` file, matched case-insensitively. |

### load()

`public function load(string $path, string $environment, string|null $context = null): array<string, mixed>`

The active context name, if any.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `string` | The active environment name (only meaningful to drivers whose format has a native environment-filtering concept, e.g. XmlFormatDriver; array/YAML drivers ignore it today -- see class docs). |
| `$context` | `string``|``null` | The active context name, if any. |

Returns `array``<``string``, ``mixed``>` — The resolved, parent-chain-merged, directive-expanded config data.

### loadWithPositions()

`public function loadWithPositions(string $path, ?string $environment, ?string $context = null): array{data: array<mixed>, positions: array<string, array{file: string, line: int}>}`

Extension-agnostic "locating" parse mode (see VSCODE_EXTENSION_INTEGRATION.md's config validator work item 3): same canonical array as load(), plus a key-path -> {file, line} index for whichever keys the bound handler could correlate back to a source element.

Falls back to an empty positions map for a handler that hasn't implemented IPositionAwareConfigHandler yet.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$environment` | `?``string` |  |
| `$context` | `?``string` |  |

Returns `array{data: array<mixed>, positions: array<string, array{file: string, line: int}>}`

### supports()

`public function supports(string $path): bool`

Whether the path names an `.xml` file, matched case-insensitively.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`
