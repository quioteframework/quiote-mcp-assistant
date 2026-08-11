# IArrayConfigHandler

> A ConfigHandler on the array-based contract: its compilation logic (executeArray()) consumes a plain, canonical array instead of walking a DOM, so the same logic works whether that array came from XML, a PHP-array file, or YAML.

A ConfigHandler on the array-based contract: its compilation logic (executeArray()) consumes a plain, canonical array instead of walking a DOM, so the same logic works whether that array came from XML, a PHP-array file, or YAML.

toCanonicalArray() is the one XML-specific piece every implementation needs: the DOM-walking logic that produces the canonical array. XmlConfigHandler's execute() calls it and feeds the result into executeArray(); XmlFormatDriver calls it too, for non-legacy XML loading through a FormatDriverRegistry.

## Synopsis

`interface IArrayConfigHandler`

|  |  |
|---|---|
| Implemented by | [`CachingConfigHandler`](/api/config/caching-config-handler/), [`CompileConfigHandler`](/api/config/compile-config-handler/), [`ConfigHandlersConfigHandler`](/api/config/config-handlers-config-handler/), [`DatabaseConfigHandler`](/api/config/database-config-handler/), [`FactoryConfigHandler`](/api/config/factory-config-handler/), [`MiddlewareConfigHandler`](/api/config/middleware-config-handler/), [`ModuleConfigHandler`](/api/config/module-config-handler/), [`OutputTypeConfigHandler`](/api/config/output-type-config-handler/), [`PluginConfigHandler`](/api/config/plugin-config-handler/), [`RbacDefinitionConfigHandler`](/api/config/rbac-definition-config-handler/), [`ReturnArrayConfigHandler`](/api/config/return-array-config-handler/), [`SettingConfigHandler`](/api/config/setting-config-handler/), [`TestSuitesConfigHandler`](/api/config/test-suites-config-handler/), [`TranslationConfigHandler`](/api/config/translation-config-handler/), [`SecurityConfigHandler`](/api/security/auth/config/security-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/IArrayConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`executeArray(array<mixed> $config, string|null $sourceRef = null): mixed`](#executearray) |  |
| [`toCanonicalArray(XmlConfigDomDocument $document): array<mixed>`](#tocanonicalarray) |  |

### executeArray()

`abstract public function executeArray(array<mixed> $config, string|null $sourceRef = null): mixed`

Origin reference for the compiled
                   cache file's header comment (a file path for any
                   format; XML's is $document->documentURI).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``mixed``>` | The canonical config array, matching the shape returned by toCanonicalArray(). |
| `$sourceRef` | `string``|``null` | Origin reference for the compiled cache file's header comment (a file path for any format; XML's is $document->documentURI). |

Returns `mixed` — The declaration to be cached, exactly as IXmlConfigHandler::execute() returns.

### toCanonicalArray()

`abstract public function toCanonicalArray(XmlConfigDomDocument $document): array<mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |

Returns `array``<``mixed``>` — The canonical array shape this handler's config type uses -- see the concrete handler's own docblock (e.g. SettingConfigHandler) for exactly what that shape is.
