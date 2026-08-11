# CachingConfigHandler

> CachingConfigHandler compiles the per-action configuration files placed in the \"cache\" subfolder of a module directory.

CachingConfigHandler compiles the per-action configuration files placed in the "cache" subfolder of a module directory.

Canonical schema: request method (or '*') => ['lifetime' => ..., 'groups' => [...], 'views' => ..., 'action_attributes' => [...], 'output_types' => [...]].

## Synopsis

`class CachingConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/CachingConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/caching/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(array<string, mixed> $config, ?string $sourceRef = null): mixed`](#executearray) | The declaration is the canonical map itself: the caching entries keyed by request method (or '*'), for a caller to pick the matching one from. |
| [`schema(): Rule`](#schema) | "layers" is a polymorphic per-layer-name map (true, or a list of slot names) not modeled key-by-key here -- structural parity stops at the known, fixed keys of a caching entry and an output-type entry; the dynamic method/output-type/layer-name keys themselves are, correctly, unconstrained (Dict), same as SettingConfigHandler's open shape. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array<string, array<string, mixed>>`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<string, array<string, mixed>>, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) | Positions are only tracked for each caching entry's own "lifetime" key, at the <caching> element's line -- a reasonable top-level anchor without mirroring the full recursive output_types/layers/slots walk above, which polymorphic "layers" values (true\|list<string>) don't cleanly reduce to a single leaf position anyway. |

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

`public function executeArray(array<string, mixed> $config, ?string $sourceRef = null): mixed`

The declaration is the canonical map itself: the caching entries keyed by request method (or '*'), for a caller to pick the matching one from.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``string``, ``mixed``>` |  |
| `$sourceRef` | `?``string` |  |

Returns `mixed`

### schema()

`public function schema(): Rule`

"layers" is a polymorphic per-layer-name map (true, or a list of slot names) not modeled key-by-key here -- structural parity stops at the known, fixed keys of a caching entry and an output-type entry; the dynamic method/output-type/layer-name keys themselves are, correctly, unconstrained (Dict), same as SettingConfigHandler's open shape.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array<string, array<string, mixed>>`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array``<``string``, ``array``<``string``, ``mixed``>``>`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<string, array<string, mixed>>, positions: array<string, array{file: string, line: int}>}`

Positions are only tracked for each caching entry's own "lifetime" key, at the <caching> element's line -- a reasonable top-level anchor without mirroring the full recursive output_types/layers/slots walk above, which polymorphic "layers" values (true|list<string>) don't cleanly reduce to a single leaf position anyway.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: array<string, array<string, mixed>>, positions: array<string, array{file: string, line: int}>}`

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
