# PluginConfigHandler

> PluginConfigHandler reads a `plugins.{xml,php,yaml,yml}` file -- the correct, documented way to register plugins -- a flat, ordered enable/disable list of plugin classes -- and appends the enabled ones to the `plugins` config key that PluginManager::bootFromConfig() already reads.

PluginConfigHandler reads a `plugins.{xml,php,yaml,yml}` file -- the correct, documented way to register plugins -- a flat, ordered enable/disable list of plugin classes -- and appends the enabled ones to the `plugins` config key that [`PluginManager::bootFromConfig()`](/api/plugin/plugin-manager/#bootfromconfig) already reads.

A `'plugins' => [...]` entry written directly into `settings.*` happens to work too, since it shares the same key, but that's an incidental consequence of the storage, not a supported interface -- don't document or rely on it. Per-plugin options are NOT part of this schema; they stay in `settings.*`, contributed by the plugin itself via [`PluginRegistrar::configDefault()`](/api/plugin/plugin-registrar/#configdefault).

Multiple plugin config files can contribute (the app's own `%core.config_dir%/plugins.xml` plus any module's `%core.module_dir%/<name>/Config/plugins.xml`). Each compiled artifact returns just the classes it declares; [`PluginConfigHandler::apply()`](/api/config/plugin-config-handler/#apply) reads the `plugins` key's current value and appends only classes not already present, so declared order across files is preserved and the first occurrence of a class (across all contributing files, applied in bootstrap order) wins if the same class is listed more than once.

Canonical schema: list<array{class: string, enabled: bool}>, in document order.

## Synopsis

`class PluginConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IDeclarationConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IDeclarationConfigHandler`](/api/config/i-declaration-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/PluginConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/plugins/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`apply(mixed $declaration, string $sourceRef): void`](#apply) | Append the declared plugin classes to the `plugins` config key. |
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) | Execute this configuration handler. |
| [`executeArray(list<array{class: string, enabled?: bool}> $config, ?string $sourceRef = null): mixed`](#executearray) |  |
| [`merge(list<string> $declared, array<int|string, mixed> $existing): list<mixed>`](#merge) | Merge declared plugin classes into the classes already registered, appending only what is not there yet. |
| [`schema(): Rule`](#schema) | "enabled" is not required: hand-authored PHP/YAML may omit it, defaulting to true, matching the XSD's own default. |
| [`toCanonicalArray(XmlConfigDomDocument $document): list<array{class: string, enabled: bool}>`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: list<array{class: string, enabled: bool}>, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) |  |

### apply()

`public function apply(mixed $declaration, string $sourceRef): void`

Append the declared plugin classes to the `plugins` config key.

The enabled classes, in declared order, that [`PluginConfigHandler::executeArray()`](/api/config/plugin-config-handler/#executearray)
                   compiles.

| Parameter | Type | Description |
|---|---|---|
| `$declaration` | `mixed` | The enabled classes, in declared order, that [`PluginConfigHandler::executeArray()`](/api/config/plugin-config-handler/#executearray) compiles. |
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

`public function executeArray(list<array{class: string, enabled?: bool}> $config, ?string $sourceRef = null): mixed`

Hand-authored
       PHP/YAML sources may omit `enabled` (defaults to true), matching
       the XSD's own default.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `list``<``array{class: string, enabled?: bool}``>` | Hand-authored PHP/YAML sources may omit `enabled` (defaults to true), matching the XSD's own default. |
| `$sourceRef` | `?``string` |  |

Returns `mixed`

### merge()

`public static function merge(list<string> $declared, array<int|string, mixed> $existing): list<mixed>`

Merge declared plugin classes into the classes already registered, appending only what is not there yet.

The current `plugins` config value.

| Parameter | Type | Description |
|---|---|---|
| `$declared` | `list``<``string``>` | Class names to append, in declared order. |
| `$existing` | `array``<``int``|``string``, ``mixed``>` | The current `plugins` config value. |

Returns `list``<``mixed``>` — The merged list.

### schema()

`public function schema(): Rule`

"enabled" is not required: hand-authored PHP/YAML may omit it, defaulting to true, matching the XSD's own default.

Returns [`Rule`](/api/config/schema/rule/)

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): list<array{class: string, enabled: bool}>`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `list``<``array{class: string, enabled: bool}``>`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: list<array{class: string, enabled: bool}>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: list<array{class: string, enabled: bool}>, positions: array<string, array{file: string, line: int}>}`

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
