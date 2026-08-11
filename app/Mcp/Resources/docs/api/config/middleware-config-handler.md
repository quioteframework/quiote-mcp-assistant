# MiddlewareConfigHandler

> MiddlewareConfigHandler reads a `middleware.{xml,php,yaml,yml}` file -- a flat list of `<use>` entries that register app/plugin middleware and/or override the placement or enabled state of any middleware (framework or app) known to `#[Quiote\\Middleware\\Attribute\\Middleware]` scanning.

MiddlewareConfigHandler reads a `middleware.{xml,php,yaml,yml}` file -- a flat list of `<use>` entries that register app/plugin middleware and/or override the placement or enabled state of any middleware (framework or app) known to `#[Quiote\Middleware\Attribute\Middleware]` scanning.

The compiled artifact returns the entry list; [`MiddlewareConfigHandler::apply()`](/api/config/middleware-config-handler/#apply) records it as a contribution on [`MiddlewareConfigRegistry`](/api/middleware/config/middleware-config-registry/), which [`MiddlewarePipeline::doBuild()`](/api/middleware/middleware-pipeline/#dobuild) merges with attribute-scanned definitions before ordering the pipeline. Fields left unset in an entry (represented as null in the canonical array) don't override anything -- they fall back to the class's own `#[Middleware]` attribute, or framework defaults for a class with none.

Canonical schema: list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}>, in document order.

## Synopsis

`class MiddlewareConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IDeclarationConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IDeclarationConfigHandler`](/api/config/i-declaration-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/MiddlewareConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/middleware/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`apply(mixed $declaration, string $sourceRef): void`](#apply) | Record the declared entries as contributions on the registry the pipeline builder reads. |
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(list<array{class: string, phase?: ?string, priority?: ?int, before?: ?string, after?: ?string, enabled?: ?bool, override_framework?: bool}> $config, ?string $sourceRef = null): mixed`](#executearray) |  |
| [`schema(): Rule`](#schema) | "phase" values per middleware.xsd's enum. |
| [`toCanonicalArray(XmlConfigDomDocument $document): list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}>`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}>, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) |  |

### apply()

`public function apply(mixed $declaration, string $sourceRef): void`

Record the declared entries as contributions on the registry the pipeline builder reads.

The normalized entry list [`MiddlewareConfigHandler::executeArray()`](/api/config/middleware-config-handler/#executearray) compiles.

| Parameter | Type | Description |
|---|---|---|
| `$declaration` | `mixed` | The normalized entry list [`MiddlewareConfigHandler::executeArray()`](/api/config/middleware-config-handler/#executearray) compiles. |
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
| `ParseException` | If a requested configuration file is improperly formatted. |

### executeArray()

`public function executeArray(list<array{class: string, phase?: ?string, priority?: ?int, before?: ?string, after?: ?string, enabled?: ?bool, override_framework?: bool}> $config, ?string $sourceRef = null): mixed`

Hand-authored PHP/YAML sources may omit any field but `class`;
       omitted fields normalize to "don't override" (null), matching
       the XSD's own optional attributes.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `list``<``array{class: string, phase?: ?string, priority?: ?int, before?: ?string, after?: ?string, enabled?: ?bool, override_framework?: bool}``>` | Hand-authored PHP/YAML sources may omit any field but `class`; omitted fields normalize to "don't override" (null), matching the XSD's own optional attributes. |
| `$sourceRef` | `?``string` |  |

Returns `mixed`

### schema()

`public function schema(): Rule`

"phase" values per middleware.xsd's enum.

Only "class" is required -- everything else means "don't override" when omitted, matching the XSD's own optional attributes.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}>`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `list``<``array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}``>`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}>, positions: array<string, array{file: string, line: int}>}`

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
