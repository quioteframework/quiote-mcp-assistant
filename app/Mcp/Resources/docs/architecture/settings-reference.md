# Settings reference

> The configuration settings Quiote reads — core.* keys, factory parameters, environment variables, and where each is set.

**Settings** are the individual configuration values Quiote reads to shape your application's behaviour — the app name, the debug flag, which subsystems are switched on, cache and header options, and so on. Most of them are dotted `core.*` keys you write in your app's settings file, `Config/settings.{php,yaml,xml}`.

This page is the catalog: every setting Quiote actually reads, its default, and its effect. Use it as a lookup table — the tables below are grouped by topic so you can scan to the area you need. For *how* config files work (formats, resolution, inheritance), see [Configuration](/architecture/configuration/). For per-middleware settings in pipeline context, see the [Middleware reference](/architecture/middleware-reference/).

## The four configuration surfaces

Quiote configuration comes from four distinct places. Each setting below states which applies:

1. **`Config` settings** — dotted keys (`core.*`, and a few `routing.*` / `validation.*`) read via `Config::get()`, set in your [`settings` config](/architecture/configuration/) (PHP/YAML/XML).
2. **Factory parameters** — `<ae:parameter>` children on a `factories` or `databases` entry, passed to a class's `initialize()`. Used by the session, response, database, user, and translation roles.
3. **Environment variables / PHP constants** — a handful of `QUIOTE_*` vars and constants read directly, mostly for bootstrap and worker mode.
4. **Programmatic** — logging and the DI container have no config-file surface at all; they are wired in PHP (see [Logging](/architecture/logging/) and [The DI container](/architecture/container/)).

## Core application settings

The settings you set most often. They all live under `core.` and can be written in any format. Many are consumed by a specific middleware — the [Middleware reference](/architecture/middleware-reference/) documents each in pipeline context, with the exact setting-to-middleware mapping.

#### PHP

```php
// Config/settings.php
return [
    'core.app_name'             => 'MyApp',
    'core.namespace_prefix'     => 'MyApp',
    'core.available'            => true,
    'core.debug'                => false,
    'core.developer_exceptions' => false,
    'core.default_context'      => 'web',
    'core.use_database'         => true,
    'core.use_logging'          => true,
    'core.use_security'         => true,
    'core.use_translation'      => false,
];
```

#### YAML

```yaml
# Config/settings.yaml
core.app_name: MyApp
core.namespace_prefix: MyApp
core.available: true
core.debug: false
core.developer_exceptions: false
core.default_context: web
core.use_database: true
core.use_logging: true
core.use_security: true
core.use_translation: false
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
            <setting name="developer_exceptions">false</setting>
            <setting name="default_context">web</setting>
            <setting name="use_database">true</setting>
            <setting name="use_logging">true</setting>
            <setting name="use_security">true</setting>
            <setting name="use_translation">false</setting>
        </settings>
    </ae:configuration>
</ae:configurations>
```

### Identity and mode

| Key | Default | Effect |
|---|---|---|
| `core.app_name` | — | Application name. |
| `core.namespace_prefix` | `'App'` | Base PHP namespace for resolving models, modules, and attribute-routed actions. |
| `core.available` | `true` | Application availability flag. |
| `core.debug` | `false` | Debug mode. When true, config is recompiled from source on each load rather than trusting a stale compiled cache. |
| `core.developer_exceptions` | `false` | `true` selects the detailed Whoops error page; `false` the safe generic response. Independent of `core.debug`. See [ErrorHandlingMiddleware](/architecture/middleware-reference/#errorhandlingmiddleware). |
| `core.environment` | — (required) | Environment name; supplied via the kernel (`env`) or bootstrap. Becomes readonly once set. |
| `core.default_context` | `'web'` | Default context/profile name (falls back to the `QUIOTE_CONTEXT` env var). |
| `core.context_implementation` | `Context` | A `Context` subclass to instantiate instead of the base class. |

### Subsystem switches

| Key | Default | Effect |
|---|---|---|
| `core.use_database` | `false` | Enables the database layer. When false, `DatabaseManager` still exists but opens no connection. |
| `core.use_security` | `true` | When false, all security checks are bypassed (`SecurityDecision::Allow` forced). See [SecurityMiddleware](/architecture/middleware-reference/#securitymiddleware) and [Authentication & authorization](/advanced/authentication-authorization/). |
| `core.use_translation` | `false` | Gates whether the translation manager is returned. |

Scaffolded apps also carry `core.use_logging`; logging itself is configured programmatically (see [Logging](/architecture/logging/)), not by this flag.

### Caching

| Key | Default | Effect |
|---|---|---|
| `core.cache_enabled` | `false` | Master switch for action/view caching. |
| `core.use_cache` | `false` | Whether a cache instance is built for the request. **Caching needs both this and `core.cache_enabled`.** |
| `core.cache_backend` | `'filesystem'` | Set to `'apcu'` to use APCu (only if `apcu_enabled()` at runtime; otherwise silently falls back to filesystem), or `'redis'` to use a Redis pool. |
| `core.redis_dsn` | `'redis://127.0.0.1:6379'` | Connection DSN used when `core.cache_backend` is `'redis'`. See [Redis backends](/plugins/official-packages/#redis-backends). |
| `core.config_check_freshness` | `true` | When `false`, trusts a compiled config cache file unconditionally instead of stat-checking the source against it. Set `false` in production **after `quiote cache:warmup`** — mirrors Symfony's `debug=false` ConfigCache. Leave `true` in development so edited config/validators/routes are picked up without a manual warmup. |
| `core.routing.trust_compiled_ir` | `false` | With attribute-based routing (`AttributeRouting`), skips the live `#[Route]` attribute scan and loads a pre-compiled routing IR dumped by `quiote cache:warmup` instead. Only takes effect when the routing subclass hasn't overridden `moduleDirs()` to something custom (the compiled artifact only covers the scanner's own default module-dir inputs) — falls back to a live scan otherwise. Requires re-running `cache:warmup` after adding, removing or moving any `#[Route]`-attributed action. |

`core.cache_enabled` and `core.use_cache` are read by [DispatchMiddleware](/architecture/middleware-reference/#dispatchmiddleware). This is the general-purpose PSR-16 cache — separate from the APCu *config-cache* prewarm (`core.apcu_prewarm` / `QUIOTE_APCU_PREWARM`), which caches compiled config.

#### Trusting compiled artifacts in production

The last two keys are production-only build-time trust switches. Both trade "always correct" for "never re-check", and both are only safe when a build step runs on every deploy.

Every config resolution (settings, factories, output_types, each module's `module.xml`, each action's `validators.xml`, databases, translation) normally stat-checks its source file against the compiled cache on every request — cheap once memoized per worker, but a stat-per-config-per-request cost under classic PHP-FPM, where there is no persistent worker to memoize across. Setting `core.config_check_freshness` to `false` skips that stat pair entirely once a cache file exists. Only do this after running `quiote cache:warmup`, and only in an environment where config genuinely doesn't change without a redeploy.

`AttributeRouting::build()` likewise scans every module's `Actions/` tree on each (re)build — a recursive directory walk plus reflection-based attribute reads per action class. `cache:warmup` can dump that scan's result (the *routing IR*) as a PHP artifact; setting `core.routing.trust_compiled_ir` to `true` loads it instead of re-scanning. The stale-artifact risk is the same shape: this is a build-time snapshot, so a route added or removed after the last `cache:warmup` run won't be seen until the next warmup. Don't enable it unless `cache:warmup` runs on every deploy. See [`cache:warmup`](/getting-started/cli/#cachewarmup--precompiling-config-and-routing).

### HTTP and response headers

| Key | Default | Effect |
|---|---|---|
| `core.disable-framework-headers` | `false` | If truthy, skips the framework response-header block entirely. |
| `core.cache-hit-header` | `'X-Quiote-Cache-Hit'` | Header sent (value `1`) on a cache hit; empty value suppresses it. |
| `core.send-nosniff-header` | `true` | Whether `X-Content-Type-Options: nosniff` is added when absent. |
| `core.expose_quiote_version` | `ini_get('expose_php')` | If truthy, `X-Powered-By` includes the framework version; otherwise just the name. |
| `core.stealth_mode` | `false` | When true, framework-identifying headers are stripped off every response — any `X-Quiote-*` header plus the names in `core.stealth_additional_headers`. See [StealthMiddleware](/architecture/middleware-reference/#stealthmiddleware). |
| `core.stealth_additional_headers` | `['X-Powered-By']` | Header names to strip in addition to the `X-Quiote-*` prefix (array value). Replaces the default list rather than adding to it. |
| `core.trusted_hosts` | `[]` (no restriction) | Host-header allowlist (array value). Entries wrapped in `/…/` are regexes; others match case-insensitively. A non-matching `Host` is replaced with the first literal entry. |
| `core.correlation_id.header` | `'X-Correlation-Id'` | Inbound header adopted as the request's correlation id (sanitized, length-capped); if absent, one is generated. Echoed back on the response. See [Logging: Correlation IDs](/architecture/logging/#correlation-ids). |
| `core.correlation_id.expose` | `true` | Whether the correlation id is echoed back on the response under the same header. |

The response-header keys (`disable-framework-headers`, `cache-hit-header`, `send-nosniff-header`) are read by [DispatchMiddleware](/architecture/middleware-reference/#dispatchmiddleware); the two `stealth` keys by [StealthMiddleware](/architecture/middleware-reference/#stealthmiddleware), which runs outermost and removes headers on the way out rather than suppressing them at the source.

### Worker runtime

Which runtime hosts the app, and how it behaves once it does. Full context — the runtime comparison matrix, and what changes when you leave the SAPI — is on [Deployment](/architecture/deployment/).

| Key | Default | Effect |
|---|---|---|
| `core.worker_runtime` | `'auto'` | Which worker runtime hosts the app: `auto` (detect), `sapi`, `frankenphp`, or an alias a package registered (`roadrunner`, `swoole`). Also settable via `$QUIOTE_WORKER_RUNTIME`, or the `worker_runtime` option to `Kernel::create()`, which take precedence in that order. An explicitly named runtime that isn't hosting the process is a startup error, not a silent fallback. |
| `core.worker.max_requests` | `0` | Requests one worker process handles before the loop stops and lets the supervisor start a fresh one. `0` disables the budget, which is what RoadRunner and Swoole want — they recycle workers themselves (`pool.max_jobs`, `worker.swoole.max_request`), and a PHP-side stop mid-pool looks to them like a crashed worker. |
| `core.worker.cleanup_interval` | `1000` | How often `WorkerManager` runs its deep-cleanup pass. `$QUIOTE_MAX_REQUESTS` overrides it (and has always driven this rather than terminating the loop). |
| `core.worker.stray_output` | `'append'` | What to do with output the app writes outside the response body, on a runtime with no SAPI output channel: `append` it to the body (what a SAPI would have done), `discard` it with a log line, or `throw`. |
| `core.proxy.trust_forwarded_headers` | `true` | Whether `X-Forwarded-Proto`/`-Host`/`-Port`, `X-Original-Host` and RFC 7239 `Forwarded` are applied to the request. Set `false` when the app is reachable directly from the internet — there is no trusted-proxy allowlist, so these headers are otherwise trusted unconditionally. |

The two off-SAPI runtimes ship as packages and add their own settings: `worker.roadrunner.chunk_size`, and the `worker.swoole.*` family. Both are documented on their package pages — [`worker-roadrunner`](/plugins/official-packages/#quioteframeworkworker-roadrunner) and [`worker-swoole`](/plugins/official-packages/#quioteframeworkworker-swoole).

### OpenAPI generation

Read by `quiote openapi:generate` (see [OpenAPI generation](/advanced/openapi/)). They only affect the generated document — nothing here changes runtime behaviour.

| Key | Default | Effect |
|---|---|---|
| `core.openapi.title` | `core.app_name`, else `API` | `info.title` of the generated document. |
| `core.openapi.version` | `'1.0.0'` | `info.version` — your API's version, not the framework's. |
| `core.openapi.description` | *(unset)* | `info.description`. |
| `core.openapi.servers` | `[]` | Server URLs. Either a bare list of URLs or a list of `{url, description}` maps. |
| `core.openapi.exclude_routes` | `[]` | `fnmatch()` patterns of route names to leave out (e.g. `internal.*`). |
| `core.openapi.modules` | `[]` | Only describe these modules (case-insensitive). Empty means all. |
| `core.openapi.problem_responses` | `true` | Emit the RFC 9457 error responses the pipeline actually returns (400 where an action declares validators, 500 always) plus the `ProblemDetails` component schema. |
| `core.openapi.use_action_docblocks` | `true` | Use each action class's docblock as its operation summary/description. Turn off if your action docblocks are internal notes. |

### Security and validation

Full documentation for these lives elsewhere — this table is the index:

- **CSRF** — the complete `core.csrf.*` set: [Middleware reference: CsrfValidationMiddleware](/architecture/middleware-reference/#csrfvalidationmiddleware); usage and per-route opt-out: [Authentication & authorization: CSRF](/advanced/authentication-authorization/#csrf-protection).
- **Validation** — how validators run and the error response: [Middleware reference: ValidationMiddleware](/architecture/middleware-reference/#validationmiddleware) and [Input validation](/basics/validation/).

| Key | Default | Effect |
|---|---|---|
| `core.csrf.enabled` | `true` | Master CSRF switch. Full `core.csrf.*` set: [Middleware reference](/architecture/middleware-reference/#csrfvalidationmiddleware); usage: [Authentication & authorization](/advanced/authentication-authorization/#csrf-protection). |
| `core.expose_validation_errors_header` | `false` | If true, attaches validator errors as `X-Quiote-Validation-Errors` on a 400 — leaks internal structure; dev/test only. See [ValidationMiddleware](/architecture/middleware-reference/#validationmiddleware) and [Input validation](/basics/validation/). |

### Keys under other prefixes

A few settings deliberately live outside `core.` — in XML they need a `<settings prefix="…">` wrapper (see [Configuration: The XML `prefix` attribute](/architecture/configuration/#the-xml-prefix-attribute)):

| Key | Default | Effect |
|---|---|---|
| `routing.http_method_map` | `[]` | Overrides the HTTP-verb-to-action-method map. See [Routing](/basics/routing/#customising-the-http-verb-mapping). |
| `validation.reject_unknown_parameters` | `'throw'` | Compile-time handling of an unknown validator parameter: `'throw'`, `'warn'`, or `'off'`. See [Input validation](/basics/validation/) and [Advanced validation](/advanced/advanced-validation/). |
| `telemetry.*` | off | OpenTelemetry tracing/metrics — `telemetry.enabled`, `telemetry.exporter`, `telemetry.sampling.*`, `telemetry.spans.*`, and more. The full table is on the [Telemetry](/architecture/telemetry/) page. |
| `mcp.*` | off | Expose the app as a Model Context Protocol server — `mcp.enabled`, `mcp.transports`, `mcp.expose_actions`, `mcp.auth`/`mcp.auth_token`, and more (requires `quioteframework/mcp`). The full table is on [Exposing your app as an MCP server](/advanced/mcp-server/#settings-reference). |
| `filesystem.*` | `local` disk | [File storage](/basics/filesystem/#settings-reference) — `filesystem.default_disk`, `filesystem.disks.local.root`, plus `filesystem.disks.{s3,gcs,azure}.*` published by the corresponding packages. Requires `quioteframework/filesystem` and its `FilesystemPlugin`. |
| `replay.*` | off | Record real requests as cassettes, replay them, emit regression tests — `replay.enabled`, `replay.record`, `replay.store`, the `replay.redact.*` family, and more (requires `quioteframework/replay`). The full table is on [Record, replay & regression tests](/advanced/record-replay/#settings-reference). |
| `plugins` | `[]` | The registry `Config/plugins.*` and `PluginManager::add()` write to at boot. Not a supported `settings.*` key to write directly — declare plugins in `Config/plugins.php`/`.xml`/`.yaml` instead. See [Plugins and extensibility](/architecture/plugins/). |

### Telemetry

Telemetry is off by default; enable it and choose an exporter under the `telemetry.` prefix (full settings table: [Telemetry](/architecture/telemetry/)):

#### PHP

```php
// Config/settings.php
'telemetry.enabled'  => true,
'telemetry.exporter' => 'otlp',
```

#### YAML

```yaml
# Config/settings.yaml
telemetry.enabled: true
telemetry.exporter: otlp
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="telemetry.">
  <setting name="enabled">true</setting>
  <setting name="exporter">otlp</setting>
</settings>
```

## Framework paths

Set during bootstrap. `core.app_dir` is **required** (supplied by the front controller / `Kernel`); the rest are derived from it and marked **readonly** — you cannot override them from `settings`.

| Key | Default | Notes |
|---|---|---|
| `core.app_dir` | — (required) | Application root. Set by the front controller before bootstrap. |
| `core.config_dir` | `` `{app_dir}/Config` `` | readonly |
| `core.cache_dir` | `` `{app_dir}/cache` `` | readonly |
| `core.module_dir` | `` `{app_dir}/Modules` `` | readonly |
| `core.model_dir` | `` `{app_dir}/Models` `` | readonly |
| `core.template_dir` | `` `{app_dir}/Templates` `` | readonly |
| `core.lib_dir` | `` `{app_dir}/Lib` `` | readonly |
| `core.quiote_dir` | framework source dir | readonly |
| `core.system_config_dir` | `` `{quiote_dir}/Config/defaults` `` | readonly |

## Factory parameters

These are `<ae:parameter>` children on a `factories` (or `databases`) entry — not `core.*` keys. See [Configuration: factories](/architecture/configuration/#factories).

### Session (`session` role)

The role is **optional** — omit it and the context answers a `NullSessionBag`. There is no setting that turns sessions on or off; configuring the slot *is* the switch. Its parameters reach both the cookie layer and the chosen backend, so both live in one place.

Cookie parameters, honoured by every backend:

| Parameter | Default | Effect |
|---|---|---|
| `cookie_name` | `'QSID'` | Session cookie name. |
| `session_cookie_lifetime` | `0` | Cookie lifetime in seconds. `0` is a browser-session cookie. |
| `session_cookie_secure` | `true` | HTTPS-only cookie. |
| `session_cookie_httponly` | `true` | HttpOnly flag. |
| `session_cookie_samesite` | `'Lax'` | SameSite attribute; `null` omits it. |
| `session_migration_grace_seconds` | `5` | How long a rotated-away session id keeps resolving to its replacement. See [Sessions: session fixation](/basics/sessions/#session-fixation-and-regeneration). |

Backend parameters, by factory:

| Factory | Parameters |
|---|---|
| `FileSessionFactory` | `dir` (`%core.app_dir%/cache/sessions`), `idle_ttl` (`1440`), `gc_probability` (`1`), `gc_divisor` (`100`) |
| `PdoSessionFactory` | `database` (the default connection), `table` (`'session'`) |
| `RedisSessionFactory` | `dsn` (`redis://127.0.0.1:6379`), `prefix` (`'session:'`), `ttl` (`1440`) |
| `S3SessionFactory` | `region` (`us-east-1`), `bucket`, `access_key_id`, `secret_access_key`, `key_prefix` (`'sessions/'`), `endpoint` |
| `GcsSessionFactory` | `bucket`, `access_key`, `secret_key`, `object_prefix` (`'sessions/'`), `endpoint` |
| `AzureBlobSessionFactory` | `account_name`, `account_key`, `container` (`'quiote-sessions'`), `endpoint` |
| `AzureTableSessionFactory` | `account_name`, `account_key`, `table` (`'sessions'`), `endpoint` |

See [Sessions](/basics/sessions/) for the full treatment.

### Database (`databases` entries)

`PdoDatabase`:

| Parameter | Default | Effect |
|---|---|---|
| `dsn` | — (required) | PDO DSN string. |
| `username` / `password` | — | Credentials. |
| `options` | `[]` | PDO constructor options (`::`-constants are resolved). |
| `attributes` | `ERRMODE_EXCEPTION` | `setAttribute()` calls; the exception error-mode default cannot be turned off, only added to. |
| `init_queries` | `[]` | SQL run immediately after connecting. |
| `warn_mysql_charset` | `true` | Rejects unsafe `SET NAMES` in `init_queries` for MySQL DSNs. |

The Doctrine (`DoctrineDatabase`, `Doctrine2*`) and `PropelDatabase` connectors have their own parameter sets — see the framework's `Quiote/Database/` classes.

### Response (`response` role)

`WebResponse` cookie/output parameters include `cookie_lifetime` (`0`), `cookie_path`, `cookie_domain`, `cookie_secure`, `cookie_httponly` (`true`), `cookie_samesite` (`'Lax'`), `send_content_length` (`true`), `send_redirect_content` (`false`), `expose_quiote` (`true`), and `use_sendfile_header` (`false`) / `sendfile_header_name` (`'X-Sendfile'`).

### User (`user` role)

| Parameter | Default | Effect |
|---|---|---|
| `definitions_file` | `` `{config_dir}/rbac_definitions.xml` `` | RBAC role/permission definitions file. |
| `storage_namespace` | `'org.quiote.user.User'` | Namespace under which user attributes are keyed in the session bag. |

## Environment variables and PHP constants

| Name | Default | Effect |
|---|---|---|
| `QUIOTE_ENV` | `'prod'` | Environment name, read into `core.environment`. Note: the scaffolded `pub/index.php` passes `'development'` explicitly, so the effective default depends on your front controller. |
| `QUIOTE_CONTEXT` | `'web'` | Primary context to create/prime. |
| `QUIOTE_MAX_REQUESTS` | `1000` | Worker requests before a deep cleanup (overrides `core.worker.cleanup_interval`). |
| `QUIOTE_WORKER_RUNTIME` | unset | Forces a worker runtime (`sapi`, `frankenphp`, `roadrunner`, `swoole`), overriding `core.worker_runtime`. **Required** to select Swoole — it is the one runtime that is never auto-detected. |
| `QUIOTE_JSON_STRICT` | strict on | Set to `0` to tolerate malformed JSON bodies instead of returning 400. See [PayloadParsingMiddleware](/architecture/middleware-reference/#payloadparsingmiddleware). |
| `QUIOTE_APCU_PREWARM` | unset | With APCu config-cache active, forces config prewarm (`1`/`true`/`yes`/`on`). |
| `QUIOTE_APP_DIR` | — | CLI app-dir fallback when `--app-dir` is not passed. |
| `QUIOTE_USE_APCU_CONFIG_CACHE` (PHP constant) | — | If defined truthy, compiled config is cached in APCu instead of on disk. |
| `NO_COLOR` | — | Standard no-color signal honoured by `AnsiTextStreamSink`. |

Worker mode *is* configurable — see [Worker runtime](#worker-runtime) above and [Deployment](/architecture/deployment/) for how a runtime is selected.

## The Config API

Settings resolve at runtime through the static `Quiote\Config\Config` store:

| Method | Behaviour |
|---|---|
| `Config::get($name, $default = null)` | Read a value, or the default if unset. |
| `Config::has($name)` | Whether the key is set (even to `null`). |
| `Config::set($name, $value, $overwrite = true, $readonly = false)` | Set a value; readonly keys reject further writes. |
| `Config::isReadonly($name)` | Whether the key is locked (the derived path keys are). |
| `Config::remove($name)` | Unset a key, unless readonly. |
| `Config::fromArray($data)` | Bulk-import a flat dotted map (what compiled `settings` files call). |
| `Config::resetWorkerState($preserveKeys = [])` | Worker-mode reset: keeps readonly keys plus named keys, drops the rest. |

## Configured elsewhere (not `settings`)

- **Logging** — levels and sinks are programmatic, set before `Kernel::run()`. See [Logging](/architecture/logging/).
- **Telemetry category filtering** — the per-category span on/off map is programmatic (`Trace::setCategories()` in `index.php`), like logging; the rest of telemetry is `telemetry.*` settings. See [Telemetry](/architecture/telemetry/#category-filtering).
- **DI container** — wired entirely in PHP (attributes + `Container::set()`); no config-file surface. See [The DI container](/architecture/container/).
- **Translation** — a separate `translation.xml` (locales, domains, formatters), not `settings`.
- **Per-middleware behaviour** — see the [Middleware reference](/architecture/middleware-reference/).
- **Event listeners** — registered programmatically via `Events::listen()` (or a plugin's `listen()`), not `settings`. See [Events](/architecture/events/).
- **HTTP clients** — named clients are configured programmatically on `HttpClientFactory` (or a plugin's `httpClient()`), not `settings`. See [HTTP client](/basics/http-client/).
- **Plugins** — *which* plugins load is the `plugins` setting (above); what each contributes is code. See [Plugins and extensibility](/architecture/plugins/).
- **Output types, routes, validators** — their own config files; see [Output types](/basics/output-types-and-content-negotiation/), [Routing](/basics/routing/), [Validation](/basics/validation/).
