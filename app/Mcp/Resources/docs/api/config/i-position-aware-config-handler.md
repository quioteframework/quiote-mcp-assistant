# IPositionAwareConfigHandler

> Opt-in, like ISchemaAwareConfigHandler: a handler implements this once it knows how to correlate its own canonical-array key paths back to the elements it read them from.

Opt-in, like ISchemaAwareConfigHandler: a handler implements this once it knows how to correlate its own canonical-array key paths back to the elements it read them from.

$positions only ever has entries for elements that survived the merge pipeline untouched (see XmlConfigParser::correlatePosition()) -- a handler whose config type has legacy-upgrade <transformation> stylesheets configured (settings, factories, databases, ...) will, in practice, get an empty positions map back for most/all keys; that's the merge pipeline correctly reporting "no * reliable line available" rather than a bug in the handler.

## Synopsis

`interface IPositionAwareConfigHandler`

|  |  |
|---|---|
| Implemented by | [`CachingConfigHandler`](/api/config/caching-config-handler/), [`CompileConfigHandler`](/api/config/compile-config-handler/), [`ConfigHandlersConfigHandler`](/api/config/config-handlers-config-handler/), [`DatabaseConfigHandler`](/api/config/database-config-handler/), [`FactoryConfigHandler`](/api/config/factory-config-handler/), [`MiddlewareConfigHandler`](/api/config/middleware-config-handler/), [`ModuleConfigHandler`](/api/config/module-config-handler/), [`OutputTypeConfigHandler`](/api/config/output-type-config-handler/), [`PluginConfigHandler`](/api/config/plugin-config-handler/), [`RbacDefinitionConfigHandler`](/api/config/rbac-definition-config-handler/), [`TestSuitesConfigHandler`](/api/config/test-suites-config-handler/), [`TranslationConfigHandler`](/api/config/translation-config-handler/), [`SecurityConfigHandler`](/api/security/auth/config/security-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/IPositionAwareConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<mixed>, positions: array<string, array{file: string, line: int}>}`](#tocanonicalarraywithpositions) |  |

### toCanonicalArrayWithPositions()

`abstract public function toCanonicalArrayWithPositions(XmlConfigDomDocument $document, ElementPositionIndex $positions): array{data: array<mixed>, positions: array<string, array{file: string, line: int}>}`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$positions` | [`ElementPositionIndex`](/api/config/format/xml/element-position-index/) |  |

Returns `array{data: array<mixed>, positions: array<string, array{file: string, line: int}>}`
