# ISchemaAwareConfigHandler

> Opt-in: a handler implements this once its canonical array shape has a meaningful, hand-authored structural schema.

Opt-in: a handler implements this once its canonical array shape has a meaningful, hand-authored structural schema.

Handlers that don't implement it (e.g. SettingConfigHandler, whose canonical shape is an open, dynamically-keyed flat dot-map with no fixed key set) simply have no array-level schema check available yet -- callers should treat that as "nothing to check", not an error.

## Synopsis

`interface ISchemaAwareConfigHandler`

|  |  |
|---|---|
| Implemented by | [`CachingConfigHandler`](/api/config/caching-config-handler/), [`CompileConfigHandler`](/api/config/compile-config-handler/), [`ConfigHandlersConfigHandler`](/api/config/config-handlers-config-handler/), [`DatabaseConfigHandler`](/api/config/database-config-handler/), [`FactoryConfigHandler`](/api/config/factory-config-handler/), [`MiddlewareConfigHandler`](/api/config/middleware-config-handler/), [`ModuleConfigHandler`](/api/config/module-config-handler/), [`OutputTypeConfigHandler`](/api/config/output-type-config-handler/), [`PluginConfigHandler`](/api/config/plugin-config-handler/), [`RbacDefinitionConfigHandler`](/api/config/rbac-definition-config-handler/), [`TestSuitesConfigHandler`](/api/config/test-suites-config-handler/), [`TranslationConfigHandler`](/api/config/translation-config-handler/), [`SecurityConfigHandler`](/api/security/auth/config/security-config-handler/) |
| Since | `1.0.0` |
| Source | `Config/ISchemaAwareConfigHandler.php` |

## Methods

| Method | Description |
|---|---|
| [`schema(): Rule`](#schema) | Returns the structural rule the handler's canonical array must satisfy. |

### schema()

`abstract public function schema(): Rule`

Returns the structural rule the handler's canonical array must satisfy.

The rule describes the shape produced by the handler's `toCanonicalArray()`, whatever source format that array came from, so a PHP-array or YAML config is checked against exactly the same structure as the XML one.

Returns [`Rule`](/api/config/schema/rule/)
