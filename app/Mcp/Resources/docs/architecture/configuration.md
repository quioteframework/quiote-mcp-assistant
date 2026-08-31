# Configuration

> Quiote's multi-format config system — PHP, YAML, or XML, mixed per file.

Configuration is how you tell Quiote about your application — its name, which subsystems to switch on, which class fills each core role, and how to reach your database. Every config file lives in your app's `Config/` directory, and you choose the format of each one: **PHP, YAML, or XML**. This page explains the format system and the core config types; for an exhaustive list of individual keys, see the [Settings reference](/architecture/settings-reference/).

Agavi's configuration was XML-only. Quiote keeps the same conceptual config *types* — `settings`, `factories`, `databases`, `output_types`, and so on — but lets you write each one as PHP, YAML, or XML, chosen per file. This is a direct expression of Quiote's unopinionated stance: the framework does not decide what your config looks like on disk.

## The formats

Each format is a driver under `Quiote\Config\Format`:

| Format | Extensions | Driver | Notes |
|---|---|---|---|
| PHP array | `.php` | `PhpArrayFormatDriver` | Recommended default — zero parse cost beyond opcache, full IDE support |
| YAML | `.yaml`, `.yml` | `YamlFormatDriver` | Concise; good for flat manifests |
| XML | `.xml` | `XmlFormatDriver` | The legacy format; still fully supported |

You can mix formats across files in one application — `settings.php` alongside `factories.yaml` alongside `databases.xml` is a supported, tested combination.

## Format resolution

When Quiote needs a config, it looks for the base name (e.g. `settings`) and resolves the extension in this priority order: **PHP, then YAML, then XML** (`FormatDriverRegistry::locate()`). The first match wins. So if both `settings.php` and `settings.xml` exist, the PHP file is used.

You do not usually configure this — autodetection by extension is the default. Where you need to force a format, `core.config_format` overrides the choice.

## Inheritance: `parent` and `imports`

Config files compose. A file can name a **parent** (whose values it overrides) and **imports** (files merged in). These cross references resolve *through the format registry*, so a PHP config can extend a YAML parent, and YAML can import values that originated in XML. Format and inheritance are orthogonal.

## The core config types

An application typically has these, in `Config/`:

| Type | What it declares |
|---|---|
| `settings` | Application-wide flags and paths (`core.*` keys) |
| `factories` | Which class fills each core role (controller, request, routing, user, …) |
| `databases` | Database connections and their parameters |
| `output_types` | Output types, their renderers, layouts, and headers |
| `validators` | (Per module/action) input validators |
| `routing` | Routes — though a `Routing` subclass is the supported way today |
| `middleware` | Extra middleware to register declaratively — see [Declarative middleware.xml](/advanced/custom-middleware/#declarative-middlewarexml) |
| `plugins` | Which plugins run and in what order — see [Plugins: Registering a plugin](/architecture/plugins/#registering-a-plugin) |

### settings

`settings` holds `core.*` keys read across the framework. The same settings, in each format:

#### PHP

```php
// Config/settings.php
return [
    'core.app_name'         => 'MyApp',
    'core.namespace_prefix' => 'MyApp',
    'core.available'        => true,   // false = maintenance mode
    'core.debug'            => false,
    'core.use_database'     => true,
    'core.use_logging'      => true,
    'core.use_security'     => true,
    'core.use_translation'  => false,
    'core.default_context'  => 'web',
];
```

#### YAML

```yaml
# Config/settings.yaml
core.app_name: MyApp
core.namespace_prefix: MyApp
core.available: true        # false = maintenance mode
core.debug: false
core.use_database: true
core.use_logging: true
core.use_security: true
core.use_translation: false
core.default_context: web
```

#### XML

```xml
<!-- Config/settings.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                   xmlns="http://quiote.dev/quiote/config/parts/settings/1.1">
    <ae:configuration>
        <settings>
            <setting name="app_name">MyApp</setting>
            <setting name="namespace_prefix">MyApp</setting>
            <setting name="available">true</setting>
            <setting name="debug">false</setting>
            <setting name="use_database">true</setting>
            <setting name="use_logging">true</setting>
            <setting name="use_security">true</setting>
            <setting name="use_translation">false</setting>
            <setting name="default_context">web</setting>
        </settings>
    </ae:configuration>
</ae:configurations>
```

The `core.use_*` switches turn whole subsystems on or off. `core.use_database => false`, for instance, means the database manager is still created (it is a required role) but no connection is ever opened.

Note how the formats differ in shape: **PHP and YAML use the full dotted key directly** (`core.debug`), while **XML nests `<setting>` elements** and derives the prefix from the wrapper (below). All three compile to the same flat, dotted key space. XML text values are literalized — `true` / `false` become booleans, matching the PHP and YAML values.

#### The XML `prefix` attribute

Each XML `<setting>` compiles to a **`core.`-prefixed** key by default — `<setting name="debug">` becomes `core.debug`. The prefix lives on the enclosing `<settings>` element, not the individual setting, as an optional `prefix` attribute. To land a setting under a different namespace (say `routing.*`), set the prefix there. The same `routing.http_method_map` setting in each format:

#### PHP

```php
// Config/settings.php
'routing.http_method_map' => [
    'PATCH' => 'write',
    'LOCK'  => 'lock',
],
```

#### YAML

```yaml
# Config/settings.yaml
routing.http_method_map:
  PATCH: write
  LOCK: lock
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="routing.">
  <setting name="http_method_map">
    <ae:parameter name="PATCH">write</ae:parameter>
    <ae:parameter name="LOCK">lock</ae:parameter>
  </setting>
</settings>
```

All three compile to `['routing.http_method_map' => ['PATCH' => 'write', 'LOCK' => 'lock']]`. In XML, nested `<ae:parameter>` elements under a `<setting>` become an associative array keyed by their `name` attribute (applied recursively) — that is how an XML setting carries a map instead of a scalar. **PHP and YAML have no prefix mechanism**: you write `'routing.http_method_map'` as the key directly.

### factories

`factories` is Quiote's service manifest — it names the class for each of the standard roles, and optional constructor `params` for each:

#### PHP

```php
// Config/factories.php
return [
    'controller'         => ['class' => \Quiote\Controller\Controller::class,      'params' => []],
    'response'           => ['class' => \Quiote\Response\WebResponse::class,        'params' => []],
    'routing'            => ['class' => \MyApp\Routing\AppRouting::class,           'params' => []],
    'request'            => ['class' => \Quiote\Request\WebRequest::class,          'params' => []],
    'session'            => ['class' => \Quiote\Session\FileSessionFactory::class,  'params' => ['dir' => '%core.app_dir%/cache/sessions']],
    'user'               => ['class' => \Quiote\User\RbacSecurityUser::class,       'params' => []],
    'database_manager'   => ['class' => \Quiote\Database\DatabaseManager::class,    'params' => []],
    'validation_manager' => ['class' => \Quiote\Validator\ValidationManager::class, 'params' => []],
];
```

#### YAML

```yaml
# Config/factories.yaml
controller:
  class: Quiote\Controller\Controller
  params: []
response:
  class: Quiote\Response\WebResponse
  params: []
routing:
  class: MyApp\Routing\AppRouting
  params: []
request:
  class: Quiote\Request\WebRequest
  params: []
session:
  class: Quiote\Session\FileSessionFactory
  params:
    dir: '%core.app_dir%/cache/sessions'
user:
  class: Quiote\User\RbacSecurityUser
  params: []
database_manager:
  class: Quiote\Database\DatabaseManager
  params: []
validation_manager:
  class: Quiote\Validator\ValidationManager
  params: []
```

#### XML

```xml
<!-- Config/factories.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                   xmlns="http://quiote.dev/quiote/config/parts/factories/1.1">
    <ae:configuration>
        <controller class="Quiote\Controller\Controller"/>
        <response class="Quiote\Response\WebResponse"/>
        <routing class="MyApp\Routing\AppRouting"/>
        <request class="Quiote\Request\WebRequest"/>
        <session class="Quiote\Session\FileSessionFactory">
            <ae:parameter name="dir">%core.app_dir%/cache/sessions</ae:parameter>
        </session>
        <user class="Quiote\User\RbacSecurityUser"/>
        <database_manager class="Quiote\Database\DatabaseManager"/>
        <validation_manager class="Quiote\Validator\ValidationManager"/>
    </ae:configuration>
</ae:configurations>
```

In PHP and YAML, include `params` for every role — an empty `[]` is fine, but the key must be present (it is passed to each role's constructor). In XML, role elements are direct children of `<ae:configuration>`, and params are `<ae:parameter>` children of a role element (omit them for none). You swap a role's implementation by changing its `class` — e.g. pointing `user` at your own `RbacSecurityUser` subclass, or `routing` at your app's `Routing` subclass. This is the primary extension seam for the framework's core objects.

The `session` role is the one exception to "every role needs an entry": it is **optional**. Omit it and the context answers a `NullSessionBag` — reads return their default, writes are discarded — which is the right shape for a console command, a queue worker or a stateless API. It also means no session cookie is ever sent, which silently disables CSRF protection app-wide, so read [Sessions](/basics/sessions/#the-slot-is-optional) before omitting it from a web app. Unlike the other roles, `session` names a *factory* (`Quiote\Session\SessionFactoryInterface`) rather than the object itself; see [Sessions: available backends](/basics/sessions/#available-backends) for the full list.

## Reading config at runtime

Config values are a flat, dotted key space accessed through the static `Quiote\Config\Config` registry:

```php
use Quiote\Config\Config;

$name  = Config::get('core.app_name');
$debug = Config::get('core.debug', false); // with a default
if (Config::has('core.custom_flag')) {
    // ...
}
```

Keys are always the dotted strings you see in `settings` — the format you wrote them in does not change how you read them.

Alongside `get()`/`has()` there are typed accessors that save you a cast and fail loudly on a value of the wrong shape: `getString()`, `getNullableString()`, `getInt()`, `getFloat()`, `getBool()`, `getArray()` and `getStringList()`. `set()`, `remove()`, `fromArray()`, `toArray()` and `clear()` complete the API.

### The repository behind the facade

`Config` is a facade over `Quiote\Config\ConfigRepository`, an ordinary object holding the same behaviour. The static API is unchanged, but the underlying array is **private** — there is no `Config::$config` to read or write:

| Instead of | Use |
|---|---|
| `Config::$config['k'] = $v` | `Config::set('k', $v)` |
| `unset(Config::$config['k'])` | `Config::remove('k')` |
| `Config::$config['k'] ?? $d` | `Config::getString('k', $d)` (or the matching typed accessor) |
| `isset(Config::$config['k'])` | `Config::has('k')` |
| `foreach (Config::$config as ...)` | `foreach (Config::toArray() as ...)` |

Two things the object buys you. A service can [declare the dependency](/architecture/container/#type-hinting-a-contract-instead-of-a-class) instead of reaching for the facade — the container binds the repository under `config` and its class name. And a test can install a configuration of its own and put back what was there:

```php
$previous = Config::useRepository(new ConfigRepository(['core.debug' => true]));
try {
    // ...
} finally {
    Config::useRepository($previous);
}
```

`fromArray()`'s precedence, while we're here: a read-only directive wins first, then the imported data, then an existing directive the import doesn't mention.

## Environments and contexts

`Quiote::bootstrap('production')` sets the environment, which lands in `core.environment` as a **read-only** directive before any config file is compiled. Every compiled cache name embeds the environment, so each environment keeps its own compiled copy of every config and they never bleed into one another.

How you make a config *vary* by environment depends on the format, and this is the one place the three formats are not equivalent.

### XML: `environment` on `<ae:configuration>`

An XML config may repeat its `<ae:configuration>` envelope, each carrying an `environment` (and/or `context`) attribute. Only the blocks matching the active environment are kept, and the survivors merge in document order over the unscoped block:

```xml
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                   xmlns="http://quiote.dev/quiote/config/parts/databases/1.1">
  <ae:configuration>
    <databases default="main">
      <database name="main" class="pdo">
        <ae:parameter name="dsn">pgsql:host=localhost;dbname=app</ae:parameter>
      </database>
    </databases>
  </ae:configuration>
  <ae:configuration environment="test.*">
    <databases default="main">
      <database name="main" class="pdo">
        <ae:parameter name="dsn">sqlite::memory:</ae:parameter>
      </database>
    </databases>
  </ae:configuration>
</ae:configurations>
```

The attribute is a **regular expression**, not a glob: `XmlConfigParser` anchors it as `#^(pattern)$#`, so `test.*` matches `test`, `testing` and `test.local` alike (the `.` is "any character", not a literal separator). Space-separated values are alternatives — `environment="development test"` matches either name exactly.

### PHP and YAML: branch in the file

Array-shaped formats have **no envelope equivalent**. `AbstractArrayFormatDriver` deliberately never applies the environment to the array it returns — a documented scope limit, on the grounds that a PHP file can already express the condition directly and more clearly than an attribute could. Two patterns cover it.

Branch inside the file. `Config` is readable here because `core.environment` is set before configs compile:

```php
// Config/databases.php
use Quiote\Config\Config;

$isTest = str_starts_with((string) Config::getNullableString('core.environment'), 'test');

return [
    'default'   => 'main',
    'databases' => [
        'main' => [
            'class'      => 'pdo',
            'parameters' => [
                'dsn' => $isTest ? 'sqlite::memory:' : 'pgsql:host=localhost;dbname=app',
            ],
        ],
    ],
];
```

Or name the environment in a path, since `%…%` directives expand inside array configs exactly as they do in XML — `%core.environment%` included:

```php
// Config/databases.php — one file per environment, selected by directive
return [
    'parent'    => '%core.config_dir%/databases.%core.environment%.php',
    'default'   => 'main',
];
```

`parent` and `imports` resolve *through* the format registry and carry the active environment with them, so the per-environment file may itself be PHP, YAML or XML.

:::tip[Which to reach for]
Branching keeps one file and reads well for a single differing value. A `parent` chain keeps environments in separate files, which is the better shape once production and development diverge in more than a line or two — and it is the only one of the two that lets a PHP config inherit from an XML one.
:::

## Env placeholders: deciding a value at load time

A `%core.app_dir%`-style directive resolves while the config file is being *compiled* — `Toolkit::expandDirectives()` bakes the result into the cache, so it's the build machine's value that ends up on disk. A `%env(NAME)%` placeholder is different: it stays a placeholder through compilation and is resolved when the compiled artifact is *loaded*, by `Quiote\Config\EnvPlaceholder`. That's the whole point — a cache baked into a container image carries the placeholder rather than whatever environment happened to exist at build time, so a secret never lands in a file on disk, and changing the variable only needs a restart, not a recompile:

```yaml
filesystem.disks.azure.account_key: '%env(AZURE_ACCOUNT_KEY)%'
```

`%env(NAME, fallback)%` supplies a fallback used when the variable is unset. A placeholder standing alone as the whole value is literalized the same way a config file's own literals are, so `Config::getBool()`/`getInt()` still work on it — `%env(DEBUG, false)%` reads back as a real bool, not the string `"false"`.

The `HTTP_` namespace is refused outright: under CGI/FastCGI, every request header arrives in the environment as `HTTP_<NAME>`, and resolving one would let a client steer configuration.

## Caching

Config is compiled and cached so it is not re-parsed on every request. Under persistent workers (FrankenPHP), an APCu-backed cache is used when the extension is enabled; otherwise a file cache. PHP-array configs are already opcache-friendly, so the format that needs the least caching machinery is also the fastest.

### A framework upgrade invalidates the cache

Freshness used to be decided purely by comparing the source config file's mtime against the cache file's. A framework upgrade changes neither, so a cache compiled by an older version was reused indefinitely — even when the handler that produced it now generates a completely different shape. The failure landed at boot and reported whatever the stale contents happened to break first, rather than the staleness.

Every cache key — both `ConfigCache`'s filenames and `APCuConfigCache`'s keys — now includes a short **framework fingerprint**, derived from `quiote.version` plus Composer's installed reference for `quioteframework/quiote`. That reference is the dist reference for a released install and the **commit hash** for a `dev-` install, so it changes on every framework commit — which is what covers developing against an unreleased framework, something a version string alone does not. A framework upgrade therefore recompiles automatically. Old cache files are left on disk unused — harmless, and cleared by deleting the cache directory whenever you care to.

`core.config_cache_fingerprint` is mixed in when set, so a build pipeline can force a rebuild without touching a config file. One layout isn't covered automatically: a framework installed under a different package name — a path repository, a vendor-less checkout — where Composer can't be asked for a reference. Set `core.config_cache_fingerprint` yourself in that case.

:::note[Upgrading from before this existed]
The fingerprint cannot retroactively invalidate a cache compiled before it existed. Delete the cache directory (`core.cache_dir`, plus the system-temp fallback if that's unset) or run `cache:warmup` once. From then on it's automatic.
:::

### Compiled configuration is data, not code

Every config handler — `settings`, `factories`, `databases`, `output_types`, `translation`, `module`, `plugins`, `middleware`, `validators`, and any handler you write yourself — compiles to a **declaration**: plain data, not executable PHP. Nothing in the configuration cache runs a cached file's statements to apply it; a class shipped with the framework or your package reads the data back and acts on it.

That distinction used to matter in an unpleasant way for the handlers that mutate global state. A compiled `factories` file used to be executable PHP `include`d *inside* `Context::initialize()`, and included code takes on the scope it's included into — so it had full private access to the context and assigned directly to its properties, with nothing declaring which ones it was allowed to touch. Renaming or retyping any of them broke a *cached* file at runtime, in the boot path, with an error naming the property rather than the stale cache. And a poisoned cache entry that is code is remote code execution; APCu made that worse, since a poisoned shared-memory entry never touches disk, so no file-integrity monitoring or audit trail observes it.

**The source formats are untouched** — `factories.{xml,yaml,php}`, `settings.xml`, `validators.xml`, and friends are written exactly as they always were. This section only matters if you read a compiled file directly, or if you write your own config handler.

### Reading a compiled value: two paths

Every handler's compiled artifact is available through `Quiote\Config\CompiledConfig::value($path, $context = null)`, which returns the declaration itself — a fetch from shared memory under APCu, or an `include` of the compiled file otherwise, with the choice made once at bootstrap so a read can't disagree with itself mid-request. This is how `DatabaseManager`, `TranslationManager`, `ValidationService`, `RbacSecurityUser`, and `Controller`'s module/output-type handling all read their configuration: each builds its own runtime objects straight from the array, so there's nothing generic to "apply".

A handler that instead needs to **mutate framework-global state** — `settings` writing into `Config`, `plugins` and `middleware` registering themselves, `module` flipping `modules.*.enabled` — goes through `Quiote\Config\ConfigCache::load($path)`, which reads the value the same way and then calls `apply($declaration, $sourceRef)` on the handler. That method comes from `Quiote\Config\IDeclarationConfigHandler`:

```php
interface IDeclarationConfigHandler
{
    public function apply(mixed $declaration, string $sourceRef): void;
}
```

`apply()` is a trust boundary as much as an application step: the declaration arrives from a cache entry or a hand-authored source file, so implementations validate its shape and throw `Quiote\Exception\ConfigurationException` rather than assuming what the compiler produced.

### Writing your own config handler

A handler you write implements `IXmlConfigHandler`, `IArrayConfigHandler`, or the legacy `ILegacyConfigHandler` exactly as before, but its `execute()`/`executeArray()` method now **returns the declaration** — `mixed`, not a string of generated PHP. `Quiote\Config\BaseConfigHandler::generate()`, which used to wrap a handler's `var_export()`ed data in cache-file boilerplate, is gone; return the value and let the cache serialize it.

- If your handler will be read with `CompiledConfig::value()` — because the caller builds its own objects from the array, the way `SecurityConfigHandler` does for `FirewallFactory` — that's the whole change. Return data instead of a string.
- If your handler will be registered for `ConfigCache::load($path)` — because it needs to mutate global state itself — it must also implement `IDeclarationConfigHandler` and move whatever the old generated statements did into `apply()`. `load()` rejects a handler that doesn't implement the interface, naming it.

:::caution[Clear the config cache when upgrading to this]
An artifact compiled by an older version of the framework emits PHP statements — the format `load()` no longer executes. The [config-cache framework fingerprint](#a-framework-upgrade-invalidates-the-cache) recompiles it automatically going forward, but a cache compiled *before* the fingerprint existed needs the one-time clear described there.
:::
