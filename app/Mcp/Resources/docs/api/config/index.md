# Config

> The Quiote\\Config namespace — 68 documented types.

Everything under `Quiote\Config`.

## Classes

| Class | Description |
|---|---|
| [`APCuConfigCache`](/api/config/apcu-config-cache/) | APCu-based configuration cache with warmup for Kubernetes/FrankenPHP deployments This class provides both warmup functionality and drop-in replacement methods for ConfigCache. |
| [`BaseConfigHandler`](/api/config/base-config-handler/) | BaseConfigHandler allows a developer to create a custom formatted configuration file pertaining to any information they like. |
| [`CachingConfigHandler`](/api/config/caching-config-handler/) | CachingConfigHandler compiles the per-action configuration files placed in the "cache" subfolder of a module directory. |
| [`CompileConfigHandler`](/api/config/compile-config-handler/) | CompileConfigHandler gathers multiple files and puts them into a single file. |
| [`CompiledArtifact`](/api/config/compiled-artifact/) | Serializes a config handler's declaration into the PHP file the on-disk cache holds. |
| [`CompiledConfig`](/api/config/compiled-config/) | Reads the value of a compiled configuration through whichever cache implementation is active. |
| [`Config`](/api/config/config/) | Static facade over the application's configuration. |
| [`ConfigCache`](/api/config/config-cache/) | ConfigCache allows you to customize the format of a configuration file to make it easy-to-use, yet still provide a PHP formatted result for direct inclusion into your modules. |
| [`ConfigHandler`](/api/config/config-handler/) | ConfigHandler allows a developer to create a custom formatted configuration file pertaining to any information they like and still have it auto-generate PHP code. |
| [`ConfigHandlersConfigHandler`](/api/config/config-handlers-config-handler/) | ConfigHandlersConfigHandler allows you to specify configuration handlers for the application or on a module level. |
| [`ConfigParser`](/api/config/config-parser/) | ConfigParser parses XML files using XmlConfigParser, but returns old-style ConfigValueHolders. |
| [`ConfigRepository`](/api/config/config-repository/) | An instance-backed store of configuration directives, with typed accessors that fail loudly when a directive does not hold the shape the caller asked for. |
| [`ConfigValueHolder`](/api/config/config-value-holder/) | ConfigValueHolder is the storage class for the XmlConfigHandler |
| [`DatabaseConfigHandler`](/api/config/database-config-handler/) | DatabaseConfigHandler allows you to setup database connections in a configuration file that will be created for you automatically upon first request. |
| [`EnvPlaceholder`](/api/config/env-placeholder/) | The `%env(NAME)%` / `%env(NAME, fallback)%` placeholder: a configuration value that comes from the process environment. |
| [`FactoryConfigHandler`](/api/config/factory-config-handler/) | FactoryConfigHandler allows you to specify which factory implementation the system will use. |
| [`MiddlewareConfigHandler`](/api/config/middleware-config-handler/) | MiddlewareConfigHandler reads a `middleware.{xml,php,yaml,yml}` file -- a flat list of `<use>` entries that register app/plugin middleware and/or override the placement or enabled state of any middleware (framework or app) known to `#[Quiote\Middleware\Attribute\Middleware]` scanning. |
| [`ModuleConfigHandler`](/api/config/module-config-handler/) | ModuleConfigHandler reads module configuration files to determine the status of a module. |
| [`OutputTypeConfigHandler`](/api/config/output-type-config-handler/) | OutputTypeConfigHandler handles output type configuration files. |
| [`PluginConfigHandler`](/api/config/plugin-config-handler/) | PluginConfigHandler reads a `plugins.{xml,php,yaml,yml}` file -- the correct, documented way to register plugins -- a flat, ordered enable/disable list of plugin classes -- and appends the enabled ones to the `plugins` config key that [`PluginManager::bootFromConfig()`](/api/plugin/plugin-manager/#bootfromconfig) already reads. |
| [`RbacDefinitionConfigHandler`](/api/config/rbac-definition-config-handler/) | RbacDefinitionConfigHandler handles RBAC role and permission definition files. |
| [`ReturnArrayConfigHandler`](/api/config/return-array-config-handler/) | ReturnArrayConfigHandler allows you to retrieve the contents of a config file as an array. |
| [`SettingConfigHandler`](/api/config/setting-config-handler/) | SettingConfigHandler handles the settings.xml file. |
| [`TestSuitesConfigHandler`](/api/config/test-suites-config-handler/) | TestSuitesConfigHandler reads the testsuites configuration files to determine the available suites and their tests. |
| [`TranslationConfigHandler`](/api/config/translation-config-handler/) | TranslationConfigHandler allows you to define translator implementations for different domains. |
| [`ValidatorConfigHandler`](/api/config/validator-config-handler/) | Compiles a validators.xml document into a compiled Quiote configuration file: a declaration of the validators to build, which [`ValidatorDeclarationApplier`](/api/validator/compiler/runtime/validator-declaration-applier/) registers onto a validation manager. |
| [`XmlConfigHandler`](/api/config/xml-config-handler/) | XmlConfigHandler is the base config handler that deals with DOMDocuments |
| [`XmlConfigParser`](/api/config/xml-config-parser/) | XmlConfigParser handles both Quiote and foreign XML configuration files, deals with XIncludes, XSL transformations and validation as well as filtering and ordering of configuration blocks and parent file resolution and parsing. |

## Interfaces

| Interface | Description |
|---|---|
| [`IArrayConfigHandler`](/api/config/i-array-config-handler/) | A ConfigHandler on the array-based contract: its compilation logic (executeArray()) consumes a plain, canonical array instead of walking a DOM, so the same logic works whether that array came from XML, a PHP-array file, or YAML. |
| [`IDeclarationConfigHandler`](/api/config/i-declaration-config-handler/) | A config handler whose compiled artifact is a declaration -- data -- plus the code that applies that data to runtime state. |
| [`ILegacyConfigHandler`](/api/config/i-legacy-config-handler/) | ILegacyConfigHandler is the interface that all old-style config handlers which deal with ConfigValueHolders and parse configs themselves implement. |
| [`IPositionAwareConfigHandler`](/api/config/i-position-aware-config-handler/) | Opt-in, like ISchemaAwareConfigHandler: a handler implements this once it knows how to correlate its own canonical-array key paths back to the elements it read them from. |
| [`ISchemaAwareConfigHandler`](/api/config/i-schema-aware-config-handler/) | Opt-in: a handler implements this once its canonical array shape has a meaningful, hand-authored structural schema. |
| [`IXmlConfigHandler`](/api/config/i-xml-config-handler/) | IXmlConfigHandler is the interface that config handlers may implement to indicate that they wish to process a DOMDocument directly. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Factory`](/api/config/factory/) | 3 types |
| [`Format`](/api/config/format/) | 13 types |
| [`Schema`](/api/config/schema/) | 5 types |
| [`Util`](/api/config/util/) | 13 types |
