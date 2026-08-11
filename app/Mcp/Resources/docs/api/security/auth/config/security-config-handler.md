# SecurityConfigHandler

> Parses a `security.{php,xml,yml,yaml}` file -- `<password_hashers>`, `<providers>`, `<firewalls>` (each `<firewall>` carrying `pattern`, `stateless`, `sessionless`, `entry-point`, `provider`, and an ordered list of `<authenticator ref=\"...\">` elements) -- into a canonical array of password-hasher/provider/firewall definitions.

Parses a `security.{php,xml,yml,yaml}` file -- `<password_hashers>`, `<providers>`, `<firewalls>` (each `<firewall>` carrying `pattern`, `stateless`, `sessionless`, `entry-point`, `provider`, and an ordered list of `<authenticator ref="...">` elements) -- into a canonical array of password-hasher/provider/firewall definitions.

This handler only produces that array -- turning it into live `Firewall`/ `AuthenticatorInterface` objects is `FirewallFactory`'s job, kept separate so apps that assemble firewalls purely in PHP never need this class at all.

Not wired into `Quiote\Config\defaults\config_handlers.xml` (that file is core-only): a consuming app registers a `<handler pattern="..." class="Quiote\Security\Auth\Config\SecurityConfigHandler">` entry in its own `config_handlers.xml`, exactly as any other non-core-default config kind does (see `Quiote\Config\RbacDefinitionConfigHandler` for the identical, core-default case of this same mechanism).

## Synopsis

`class SecurityConfigHandler extends XmlConfigHandler implements IArrayConfigHandler, IPositionAwareConfigHandler, ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Extends | [`XmlConfigHandler`](/api/config/xml-config-handler/) |
| Implements | [`IArrayConfigHandler`](/api/config/i-array-config-handler/), [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/), [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/SecurityConfigHandler.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `XML_NAMESPACE` | `'http://quiote.dev/quiote/config/parts/security/1.1'` |  |

## Methods

| Method | Description |
|---|---|
| [`execute(XmlConfigDomDocument $document): mixed`](#execute) |  |
| [`executeArray(array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>} $config, ?string $sourceRef = null): mixed`](#executearray) |  |
| [`schema(): Rule`](#schema) | Returns the structural rule the handler's canonical array must satisfy. |
| [`toCanonicalArray(XmlConfigDomDocument $document): array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}`](#tocanonicalarray) |  |
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) |  |

### execute()

`public function execute(XmlConfigDomDocument $document): mixed`

The parsed `security.xml` document.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The parsed `security.xml` document. |

Returns `mixed` — The canonical array (see toCanonicalArray()) as the declaration to be cached.

| Throws | When |
|---|---|
| `UnreadableException` | If a requested configuration file does not exist or is not readable. |
| `ParseException` | If a requested configuration file is improperly formatted. |

### executeArray()

`public function executeArray(array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>} $config, ?string $sourceRef = null): mixed`

Origin reference for the compiled cache file's header comment.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}` | The canonical config array, matching the shape returned by toCanonicalArray(). |
| `$sourceRef` | `?``string` | Origin reference for the compiled cache file's header comment. |

Returns `mixed` — The declaration to be cached, exactly as execute() returns.

### schema()

`public function schema(): Rule`

Returns the structural rule the handler's canonical array must satisfy.

The rule describes the shape produced by the handler's `toCanonicalArray()`, whatever source format that array came from, so a PHP-array or YAML config is checked against exactly the same structure as the XML one.

Returns [`Rule`](/api/config/schema/rule/) — The structural schema for the canonical array returned by toCanonicalArray().

### toCanonicalArray()

`public function toCanonicalArray(XmlConfigDomDocument $document): array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}`

The parsed `security.xml` document.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The parsed `security.xml` document. |

Returns `array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}`

### toCanonicalArrayWithPositions()

`public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}, positions: array<string, array{file: string, line: int}>}`

Correlates surviving elements back to their source file/line.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) | The parsed `security.xml` document. |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) | Correlates surviving elements back to their source file/line. |

Returns `array{data: array{password_hasher_algorithm: ?string, providers: array<string, array{type: string, connection: ?string, table: ?string, identifier_column: ?string, password_column: ?string}>, firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}, positions: array<string, array{file: string, line: int}>}`

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
