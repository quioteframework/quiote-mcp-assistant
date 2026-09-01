# Official packages

> The quioteframework/* packages extracted from the kernel — what each provides, what it depends on, and how to install and enable it.

A growing set of subsystems that once lived in the core — or that a batteries-included framework would bake in — now ship as their own `quioteframework/*` packages. Each is optional: install it only when you need it, and the dependency it carries stays out of a bare install. This page is the catalogue — for the model behind it, read [Plugins overview](/plugins/overview/) first.

All of these packages are **MIT-licensed** (the kernel itself is LGPL-2.1+); an MIT package depending on the LGPL kernel is a standard, sound arrangement.

<Aside type="note" title="Installing the packages">
Each package lives in its own `github.com/quioteframework/*` repository and is published to Packagist. Install any one with `composer require quioteframework/<package>`.
</Aside>

<Aside type="caution" title="Package versions are not framework versions">
From 4.0.0 onward each package is **versioned independently** of the framework and of every other package: `quioteframework/db-doctrine` at `4.1.0` alongside a framework at `4.2.0` means nothing more than "these two released at different times". A package's own `CHANGELOG.md` is the one to read for what changed in it, and its `require` constraint on `quioteframework/quiote` is what states compatibility.
</Aside>

## How enabling works

Almost every package follows the **same two steps**: install the code, then activate it.

1. **Install** — `composer require quioteframework/<package>`.
2. **Enable** — add the package's `Plugin` class to your app's `Config/plugins.{php,yaml,yml,xml}`. Listing it there is what actually runs it: at boot, `PluginManager` reads that file and calls each plugin's `register()`, which wires the package into the framework's seams (config, DI, middleware, events, routes, commands). From then on the contribution is present on every request. See [Plugins overview: How a plugin reaches a request](/plugins/overview/#how-a-plugin-reaches-a-request).

A `Plugin` class is only accepted from `plugins.*` because it already carries the mandatory `#[Quiote\Plugin\Attribute\Plugin]` attribute — a class-string named in config without that attribute is silently refused. All official packages carry it already; you only add it yourself when [writing your own plugin](/architecture/plugins/#writing-a-plugin).

A few packages break the pattern — worth knowing before you go looking for a missing `plugins` entry:

- **`quioteframework/csrf`** is on by **default** — it's a required kernel dependency that registers itself at boot; you never add it, you consciously turn it *off*.
- **`quioteframework/ratelimit`** is a plain **library**, not a plugin — you call it from your own code; nothing goes in `plugins.*`.
- **`quioteframework/telemetry-dashboard`** contributes a **console command** that's available as soon as the package is installed — no `plugins` entry.
- **Template renderers** (`phptal`/`xslt`/`twig`) plug into the **config-driven renderer registry** instead — you point an output type's `renderer` at the class rather than adding a plugin.
- **The auth packages** (`auth`/`auth-jwt`/`auth-oauth`) mostly need app-specific secrets, so they register little or nothing automatically — see each entry below.

## At a glance

| Package | Provides | Carries |
|---|---|---|
| `quioteframework/auth` | Form login, HTTP Basic, firewalls, password hashing | — |
| `quioteframework/auth-jwt` | Bearer/JWT resource-server authentication | `firebase/php-jwt` |
| `quioteframework/auth-oauth` | OIDC login + machine-to-machine tokens | `league/oauth2-client` |
| `quioteframework/csrf` | CSRF token injection + validation | `symfony/security-csrf` |
| `quioteframework/ratelimit` | Login throttling / rate limiting | `symfony/rate-limiter` |
| `quioteframework/cors` | CORS preflight handling and response decoration | — |
| `quioteframework/security-headers` | Default security response headers | — |
| `quioteframework/whoops` | The developer exception page | `filp/whoops` |
| `quioteframework/mcp` | Expose the app as an MCP server | `mcp/sdk` |
| `quioteframework/telemetry-otel` | OpenTelemetry tracing + metrics export | `open-telemetry/*` |
| `quioteframework/telemetry-dashboard` | A terminal OTLP dashboard (`telemetry:dashboard`) | `symfony/tui` |
| `quioteframework/exception-notifier` | Teams / webhook notifications on caught exceptions | — |
| `quioteframework/db-eloquent` | Eloquent database adapter | `illuminate/database` |
| `quioteframework/db-doctrine` | Doctrine ORM + DBAL adapters | `doctrine/orm`, `doctrine/dbal` |
| `quioteframework/db-cycle` | Cycle ORM adapter | `cycle/orm`, `cycle/database` |
| `quioteframework/db-propulsion` | Propulsion (Propel-style) ORM adapter | `quioteframework/propulsion` |
| `quioteframework/replay` | Record real requests as cassettes, replay them, emit regression tests | — |
| `quioteframework/replay-pdo` | Database-backed cassette store | — |
| `quioteframework/replay-propulsion` | Records Propulsion queries into a cassette's effect ledger | — |
| `quioteframework/replay-doctrine` | Records Doctrine DBAL queries into a cassette's effect ledger | — |
| `quioteframework/replay-eloquent` | Records Eloquent queries into a cassette's effect ledger | — |
| `quioteframework/replay-cycle` | Records Cycle ORM queries into a cassette's effect ledger | — |
| `quioteframework/replay-storage` | Object-store cassette store over the `storage` contracts | `quioteframework/storage` |
| `quioteframework/replay-azure` | Azure Blob cassette store + Log Analytics cassette index | `quioteframework/cloud-azure` |
| `quioteframework/queue` | Background job/queue abstraction, `sync` driver, `queue:work` | — |
| `quioteframework/queue-db` | DB-backed queue driver + dead-letter store | — |
| `quioteframework/queue-redis` | Redis-backed reliable queue driver | `predis/predis` (or `ext-redis`) |
| `quioteframework/scheduler` | Cron-expression task scheduling, `schedule:run` | `dragonmantank/cron-expression` |
| `quioteframework/worker-roadrunner` | Run the app as a RoadRunner PSR-7 worker | RoadRunner server |
| `quioteframework/worker-swoole` | Serve the app from an embedded Swoole HTTP server | `ext-swoole` |
| `quioteframework/phptal` | PHPTAL template renderer | `phptal/phptal` |
| `quioteframework/xslt` | XSLT template renderer | `ext-xsl` |
| `quioteframework/twig` | Twig template renderer | `twig/twig` |
| `quioteframework/session-pdo` | Database-backed session storage | — |
| `quioteframework/session-azure` | Azure Blob / Table session storage | `quioteframework/cloud-azure` |
| `quioteframework/session-s3` | S3 (and S3-compatible) session storage | `quioteframework/cloud-s3` |
| `quioteframework/session-gcs` | Google Cloud Storage session storage | `quioteframework/cloud-gcs` |
| `quioteframework/session-redis` | Redis-backed session storage | `predis/predis` (or `ext-redis`) |
| `quioteframework/filesystem-s3` | S3 (and S3-compatible) file storage disk | `quioteframework/cloud-s3` |
| `quioteframework/filesystem-gcs` | Google Cloud Storage file storage disk | `quioteframework/cloud-gcs` |
| `quioteframework/filesystem-azure` | Azure Blob file storage disk | `quioteframework/cloud-azure` |
| `quioteframework/cloud-s3` | Signed S3 REST client *(transitive)* | — |
| `quioteframework/cloud-gcs` | Signed GCS REST client *(transitive)* | — |
| `quioteframework/cloud-azure` | Signed Azure Blob/Table/Monitor REST clients *(transitive)* | — |
| `quioteframework/filesystem` | `FilesystemManager`, the disk drivers and the object-store session base | `quioteframework/storage` |
| `quioteframework/storage` | The framework-free object-store contracts (`ObjectStoreClientInterface`, `ObjectMetadata`) | — |

## Security & web

### `quioteframework/auth`

Firewall-based authentication: form login and HTTP Basic, credential providers (`InMemoryUserProvider`, `PdoUserProvider`, `CallableUserProvider`), password hashing (`DefaultPasswordHasher`, argon2id with a bcrypt fallback), and the `Firewall`/`FirewallMap`/`AuthenticationManager` machinery that runs an authenticator chain and applies the result to `SecurityUser`/`RbacSecurityUser`. `AuthPlugin` registers a default `PasswordHasherInterface` and an **empty** `FirewallMap` — both of its middleware (`StatelessAuthenticationMiddleware`, `SessionAuthenticationMiddleware`) are a complete no-op until your app registers a populated `FirewallMap`.

```bash
composer require quioteframework/auth
```

Optionally add a `security.xml`/`.php`/`.yaml` config file (`Config\SecurityConfigHandler` + `Config\FirewallFactory`) instead of wiring `FirewallMap` by hand — see [Authenticating with the auth packages](/advanced/authentication-authorization/#authenticating-with-the-auth-packages).

### `quioteframework/auth-jwt`

Bearer/JWT resource-server authentication on top of `quioteframework/auth`'s contracts: `JwtTokenValidator` (HS256 via a shared secret, or RS256/ES256 via a JWKS-backed `CachedKeySet` with rotation), the default RFC 9068 `ClientTypeResolver` (service vs. user tokens), and `BearerTokenAuthenticator`. `JwtAuthPlugin` registers only the `ClientTypeResolverInterface` default — the validator and authenticator need app-specific secrets, so there's no safe default to wire automatically.

```bash
composer require quioteframework/auth-jwt
```

See [`quioteframework/auth-jwt` — bearer/JWT resource server](/advanced/authentication-authorization/#quioteframeworkauth-jwt--bearerjwt-resource-server).

### `quioteframework/auth-oauth`

Makes Quiote an OAuth/OIDC **client** — never an authorization server. Two distinct flows: sending a human browser to an identity provider like Entra ID, Google, or Okta to log in (`OidcClient` to build the redirect, `OidcAuthenticator` for the callback leg, `OidcStateStorage` for the state round-trip), and fetching Quiote's own outbound access token to call another API with no browser involved (`ClientCredentialsClient`, plus `IntrospectionClient` for RFC 7662 revocation checks). Built on `quioteframework/auth`'s contracts and reuses `auth-jwt`'s `TokenValidatorInterface` for ID token validation rather than a second JWT stack. PKCE S256 is hardcoded (OAuth 2.1 mandates it). No plugin ships with this package — every piece needs app-specific secrets or endpoints, so there's nothing safe to register by default.

```bash
composer require quioteframework/auth-oauth
```

See [`quioteframework/auth-oauth` — Quiote as an OAuth/OIDC client](/advanced/authentication-authorization/#quioteframeworkauth-oauth--quiote-as-an-oauthoidc-client), including the [decision guide](/advanced/authentication-authorization/#which-package-for-which-role--a-decision-guide) for which of the two flows (or `auth-jwt`) actually applies.

### `quioteframework/csrf`

CSRF protection: `CsrfInjectionMiddleware` adds a hidden token field to non-GET HTML forms, a `<meta name="csrf-token">` tag, and a readable `XSRF-TOKEN` cookie; `CsrfValidationMiddleware` rejects unsafe-method requests without a valid token with a 403. Both are placed in the pipeline by `Quiote\Security\Csrf\CsrfPlugin`.

Unlike every other package here, **this one is not opt-in.** `quioteframework/csrf` is a *required* dependency of the kernel, and the kernel registers `CsrfPlugin` automatically at boot — so a fresh app is CSRF-protected without any `plugins` entry, and there's nothing to install:

```php
// Disabling it takes conscious effort (and logs a warning):
'core.csrf.enabled' => false,
```

Configure it with the `core.csrf.*` settings and opt individual routes out with an `_csrf => false` route default rather than disabling protection wholesale. See [Authentication & authorization: CSRF](/advanced/authentication-authorization/#csrf-protection) and the [Middleware reference](/architecture/middleware-reference/#csrfvalidationmiddleware).

### `quioteframework/cors`

`Quiote\Security\Cors\CorsMiddleware`, placed by `Quiote\Security\Cors\CorsPlugin`, answers preflight `OPTIONS` requests and decorates cross-origin responses. It runs in `before_action` after routing and before dispatch, and is **off** until `cors.enabled` is true.

```bash
composer require quioteframework/cors
```

| Key | Default | Meaning |
|---|---|---|
| `cors.enabled` | `false` | Master switch. |
| `cors.allowed_origins` | `[]` | Exact origins, or `['*']` for any. |
| `cors.allow_credentials` | `false` | Whether to send `Access-Control-Allow-Credentials: true`. |
| `cors.allowed_methods` | `GET, POST, PUT, PATCH, DELETE, OPTIONS` | Preflight response only. |
| `cors.allowed_headers` | `[]` | Preflight response only; empty echoes what the caller asked for. |
| `cors.exposed_headers` | `[]` | Response headers JS may read. |
| `cors.max_age` | `0` | Preflight cache lifetime in seconds; `0` omits the header. |

A non-`*` origin always gets `Vary: Origin` alongside it, so a shared cache can't serve one origin's response to another.

:::caution[`allowed_origins: ['*']` with `allow_credentials: true` is refused at boot]
That pair cannot be sent. The fetch specification forbids `Access-Control-Allow-Origin: *` together with `Access-Control-Allow-Credentials: true`, so browsers reject the response and every credentialed cross-origin request fails — while a non-browser client honouring both headers is handed the authenticated response.

The middleware throws a `ConfigurationException` naming both settings rather than papering over it. Reflecting the caller's origin instead would make it *work*, which is worse: it grants every origin on the internet credentialed read access to authenticated responses. Enumerate the origins that need credentialed access, or turn credentials off.

`*` is usually set before credentials are thought about — the two settings tend to be written at different times, by different people — so this fails loudly rather than logging a line someone has to notice.
:::

### `quioteframework/security-headers`

`Quiote\Security\Headers\SecurityHeadersMiddleware`, placed by `Quiote\Security\Headers\SecurityHeadersPlugin`, adds conservative defaults to every response. It runs in the `bootstrap` phase, so the headers are present even on an error response, and it only *defaults* each header — an application or action that set one itself keeps its own value.

```bash
composer require quioteframework/security-headers
```

| Key | Default |
|---|---|
| `security_headers.enabled` | `true` |
| `security_headers.content_type_options` | `nosniff` |
| `security_headers.frame_options` | `DENY` |
| `security_headers.referrer_policy` | `strict-origin-when-cross-origin` |
| `security_headers.csp` | `default-src 'self'` |
| `security_headers.permissions_policy` | `''` (header omitted) |
| `security_headers.hsts` | `true` |
| `security_headers.hsts_max_age` | `15552000` (180 days) |

`Strict-Transport-Security` is emitted only on requests that actually arrived over HTTPS, so it can't pin a plaintext development host.

The default CSP is `default-src 'self'`, which is deliberately strict enough to break an app that loads third-party scripts, styles or fonts — set your own policy rather than removing the header.

### `quioteframework/ratelimit`

Rate limiting, in two independent halves built on the same `symfony/rate-limiter` primitives.

```bash
composer require quioteframework/ratelimit
```

**`Quiote\Security\RateLimit\LoginThrottle`** — slows or blocks repeated failed logins, keyed by login identifier. This half is a plain **library**: nothing to enable, you wire the throttle into your login action yourself. See [Authentication & authorization: Login rate limiting](/advanced/authentication-authorization/#login-rate-limiting).

**`RateLimitMiddleware`** — general-purpose per-client HTTP rate limiting, keyed by client IP. This half needs `RateLimitPlugin` in `plugins`, and is opt-in even then:

| Key | Default | Meaning |
|---|---|---|
| `ratelimit.http.enabled` | `false` | Master switch for HTTP rate limiting. |
| `ratelimit.http.max_requests` | `60` | Requests allowed per window. |
| `ratelimit.http.window` | `1 minute` | Window length. |
| `ratelimit.http.policy` | `sliding_window` | `symfony/rate-limiter` policy. |
| `ratelimit.http.trust_forwarded_for` | `false` | Whether to key on `X-Forwarded-For` instead of the connecting peer. |
| `ratelimit.http.trusted_proxy_hops` | `1` | How many entries to skip from the **right** of `X-Forwarded-For` when the above is on. |
| `ratelimit.storage` | `memory` | Where limiter state lives: `memory` or `redis`. |
| `ratelimit.redis.dsn` | `redis://127.0.0.1:6379` | Connection DSN when `ratelimit.storage` is `redis`. |

It runs in the `pre_routing` phase, so an over-limit request is rejected before any route resolution work happens, and it responds with an RFC 9457 problem document.

Two defaults are deliberately strict. `ratelimit.http.trust_forwarded_for` is **off**: trusting a client-supplied header by default would let any caller spoof a fresh key and bypass the limit entirely, so enable it only behind a proxy you control.

When you do enable it, the address is read from the **right** of `X-Forwarded-For`, skipping `ratelimit.http.trusted_proxy_hops` entries (default 1), falling back to `REMOTE_ADDR` when the header has no usable entry. That matters because a proxy *appends* rather than replaces: the leftmost value is the one the client wrote, so keying on it lets a caller rotate the key per request and buy no throttling at all. Set the hop count to however many proxies of your own sit in front of the application — the entry immediately left of your own trusted hops is the one it wrote, and the one a caller cannot influence.

**`LoginThrottle` keys on both the identifier and `REMOTE_ADDR`**, rejecting if either bucket is exhausted, registering a failure against both and resetting both on success. Keying on the identifier alone bounds vertical brute force against one account but does nothing about horizontal credential stuffing — one attempt each across thousands of accounts — and it hands an attacker a lockout primitive against a known victim. It never keys on a forwarding header: a spoofable key is indistinguishable from no throttling. And storage defaults to `memory`, which is **per-process** — fine for a single-worker dev setup, useless as a limit across a worker pool. For a real deployment either set `ratelimit.storage` to `redis` (see [Redis backends](#redis-backends)) or bind `PdoRateLimiterStorage` yourself, for shared state without a Redis dependency:

```php
$registrar->service(\Symfony\Component\RateLimiter\Storage\StorageInterface::class, static fn() =>
    new \Quiote\Security\RateLimit\PdoRateLimiterStorage(/* ... */)
);
```

The plugin binds its own storage **set-if-absent**, so an app binding of `StorageInterface` wins.

## Developer experience

### `quioteframework/whoops`

The rich developer exception page — full stack trace, source, and request data — used when `core.developer_exceptions` is on. `Quiote\Exception\Rendering\Whoops\WhoopsPlugin` registers it into the kernel's exception-renderer registry. Fully opt-in: without the plugin (or the package), error handling uses the safe renderer.

```bash
composer require quioteframework/whoops
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Exception\Rendering\Whoops\WhoopsPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Exception\Rendering\Whoops\WhoopsPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Exception\Rendering\Whoops\WhoopsPlugin" />
    </ae:configuration>
</ae:configurations>
```

Keep `core.developer_exceptions` **off** in production regardless — the page exposes source and environment. See [Error handling: Developer vs safe rendering](/architecture/error-handling/#developer-vs-safe-rendering).

### `quioteframework/mcp`

Turns a Quiote app into a [Model Context Protocol](https://modelcontextprotocol.io) server — expose tools, resources, and prompts, or turn an existing `#[Route]` action into a tool with one attribute (its validators become the tool's input schema), over stdio or streamable HTTP. Full coverage, including auth and what's not built yet: [Exposing your app as an MCP server](/advanced/mcp-server/).

```bash
composer require quioteframework/mcp
```

Enable the plugin and switch MCP on:

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Mcp\McpPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Mcp\McpPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Mcp\McpPlugin" />
    </ae:configuration>
</ae:configurations>
```

#### PHP

```php
// Config/settings.php
return [
    'mcp.enabled' => true,
];
```

#### YAML

```yaml
# Config/settings.yaml
mcp.enabled: true
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="mcp.">
  <setting name="enabled">true</setting>
</settings>
```

The [Quiote Assistant MCP](/getting-started/mcp-assistant/) is a full reference app built on this package.

## Observability

### `quioteframework/telemetry-otel`

OpenTelemetry-based distributed tracing and metrics: a span tree per request, resource metrics, W3C context propagation, and log correlation. Provides `Quiote\Telemetry\TelemetryPlugin`, which drives the SDK bootstrap and per-request flush. The always-on, no-op `Trace` facade stays in the kernel, so instrumentation call sites cost nothing when this package is absent or telemetry is off.

```bash
composer require quioteframework/telemetry-otel
```

Register the plugin, then turn it on with `telemetry.enabled = true` and pick an exporter:

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Telemetry\TelemetryPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Telemetry\TelemetryPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Telemetry\TelemetryPlugin" />
    </ae:configuration>
</ae:configurations>
```

#### PHP

```php
// Config/settings.php
return [
    'telemetry.enabled' => true,
];
```

#### YAML

```yaml
# Config/settings.yaml
telemetry.enabled: true
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="telemetry.">
  <setting name="enabled">true</setting>
</settings>
```

See [Telemetry](/architecture/telemetry/) for the full `telemetry.*` surface.

### `quioteframework/telemetry-dashboard`

A standalone terminal UI that receives OTLP and visualizes traces/metrics live — handy for local development without a full collector + backend. It's **completely independent of `quioteframework/telemetry-otel`**: it's an OTLP *receiver*, not the exporter, so it needs neither that package nor a running app. It contributes the `telemetry:dashboard` console command, which the CLI registers automatically whenever the package is installed — no `plugins` entry, no bootstrap. Point any OTLP source (a Quiote app exporting via telemetry-otel, or anything else) at it.

```bash
composer require quioteframework/telemetry-dashboard
php bin/quiote telemetry:dashboard
```

## Alerting

### `quioteframework/exception-notifier`

Sends a notification — a Microsoft Teams Adaptive Card, a generic JSON webhook, or both — when the framework catches and renders an exception. Listens on `ExceptionCaughtEvent`, the same event `ErrorHandlingMiddleware` already emits for every caught exception (see [Error handling](/architecture/error-handling/)). `Quiote\ExceptionNotifier\ExceptionNotifierPlugin` registers the `teams`/`webhook` channel driver aliases and the listener that fans a caught exception out to them. Opt-in, like `whoops`: `exception_notifier.enabled` defaults to `false` — sending exception details to a channel an app hasn't configured is not a safe default.

```bash
composer require quioteframework/exception-notifier
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\ExceptionNotifier\ExceptionNotifierPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\ExceptionNotifier\ExceptionNotifierPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\ExceptionNotifier\ExceptionNotifierPlugin" />
    </ae:configuration>
</ae:configurations>
```

Then turn it on and configure at least one channel:

```php
// Config/settings.php
return [
    'exception_notifier.enabled' => true,
    'exception_notifier.channels' => [
        ['driver' => 'teams', 'name' => 'teams-ops', 'webhook_url' => 'https://<power-automate-or-teams-webhook-url>'],
    ],
];
```

The same structure in YAML:

```yaml
# Config/settings.yaml
exception_notifier:
  enabled: true
  channels:
    - driver: teams
      name: teams-ops
      webhook_url: 'https://<power-automate-or-teams-webhook-url>'
```

| Key | Default | Meaning |
|---|---|---|
| `exception_notifier.enabled` | `false` | Master switch. |
| `exception_notifier.min_status` | `500` | Only notify for exceptions mapped to this HTTP status or higher. |
| `exception_notifier.throttle_seconds` | `60` | Suppress a repeat notification for the same exception class + message within this window. `0` disables throttling. |
| `exception_notifier.ignore` | `[]` | Exception class names to never notify for — subclasses included. |
| `exception_notifier.channels` | `[]` | List of channel configs, each an array with at least `driver` and `webhook_url`. |

The status an exception maps to for `min_status` comes from `ExceptionStatusMapper`, which mirrors `ErrorHandlingMiddleware`'s own mapping so the filter sees the same status a client actually received: `InvalidArgumentException` → 400, `DomainException` → 422, everything else (including your own application exceptions, unless they extend one of those two) → 500. With the `500` default, a plain `RuntimeException` or a custom exception class already clears the bar; only exceptions that map to 400 or 422 need `min_status` lowered to be notified.

#### Channel drivers

**`teams`** posts an Adaptive Card (schema 1.4) to a Teams incoming webhook or Power Automate workflow URL — the format Microsoft currently recommends; the older MessageCard/O365 connector card format is deprecated. The card shows the exception class, its message, a fact set (status, request method + URI, correlation ID if the request carried a `Correlation-Id` or `X-Correlation-ID` header, and a UTC timestamp), and the first five stack trace frames.

**`webhook`** posts a flat JSON body to any URL: `exception_class`, `message`, `status`, `correlation_id`, `request_method`, `request_uri`, `timestamp`, and `trace` (the stack trace, one frame per array entry). It also accepts a `headers` map in its channel config for things like an API key header. It's also the reference implementation to copy when writing a custom channel.

| Channel config key | Applies to | Meaning |
|---|---|---|
| `driver` | both | `teams` or `webhook` (or a custom alias — see below). |
| `webhook_url` | both | Required. Where the notification is posted. |
| `name` | both | Optional label, used in the underlying HTTP client name and in failure log messages. Defaults to the driver name. |
| `enabled` | both | Optional, default `true`. Set `false` to disable one channel entry without deleting its config. |
| `headers` | `webhook` | Optional map of extra HTTP headers to send with the request, e.g. an API key. |

Both drivers go through the shared [HTTP client](/basics/http-client/) stack (`HttpClientFactory`), retrying the POST twice, and treat any non-2xx response as a failure.

#### Failure isolation

If a channel throws — a bad `webhook_url`, a network failure, a non-2xx response — `ExceptionNotificationListener` catches it, logs a warning under the `Quiote.ExceptionNotifier.ExceptionNotificationListener` category (see [Logging](/architecture/logging/)), and moves on to the next configured channel. A broken Teams webhook never stops the `webhook` channel from firing, and a notifier failure never becomes a second, notifier-caused exception.

#### Extending with a custom channel

Implement `NotifierChannelInterface` (a `notify()` method) and `NotifierChannelFactoryInterface` (a static `fromChannelConfig()` factory), then register the class under a driver alias — from your own plugin's `register()`, no change to this package required:

```php
ExceptionNotifierChannelRegistry::register('slack', SlackNotifierChannel::class);
```

`ExceptionNotifierChannelRegistry::instantiate()` is what `ExceptionNotificationListener` calls per channel config entry; an unregistered `driver` value, or a class that doesn't implement both interfaces, raises a `RuntimeException` at notify time (caught and logged the same as any other channel failure, not surfaced to the user).

#### Verifying it's working

There's no `exception-notifier:test` console command — confirm delivery by causing one real notification end to end:

1. Point `webhook_url` at something you can watch immediately: a Teams channel you have open, or a throwaway inspector URL (e.g. from webhook.site) for the `webhook` driver.
2. Temporarily set `exception_notifier.throttle_seconds` to `0` so a repeated test doesn't get suppressed as a duplicate.
3. Trigger a real caught exception through an actual request — e.g. an action that does `throw new \RuntimeException('exception-notifier test')` — rather than instantiating a channel and calling `notify()` directly, since `ExceptionCaughtEvent` only fires from `ErrorHandlingMiddleware`'s catch path.
4. Check the destination: the Adaptive Card in Teams, or the JSON body received at the webhook URL.
5. If nothing arrives, check the application log for `[ExceptionNotifier] channel "<name>" (driver "<driver>") failed to deliver a notification for ...` — channel failures are logged, not thrown, so a silent no-op almost always means a warning is sitting in the log rather than the listener never having run.

Once delivery is confirmed, put `throttle_seconds` back to its intended production value.

## Database adapters

Each adapter hands back a fully-configured ORM and registers a short `class` alias for use in your `databases` config. Install the package, then register its plugin so the alias resolves. Full parameter tables and usage are in [Databases](/basics/databases/).

### `quioteframework/db-eloquent`

```bash
composer require quioteframework/db-eloquent
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Eloquent\EloquentPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Eloquent\EloquentPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Eloquent\EloquentPlugin" />
    </ae:configuration>
</ae:configurations>
```

Registers the `eloquent` alias for `EloquentDatabase`. See [Databases: Eloquent](/basics/databases/#eloquent).

### `quioteframework/db-doctrine`

```bash
composer require quioteframework/db-doctrine
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Doctrine\DoctrinePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Doctrine\DoctrinePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Doctrine\DoctrinePlugin" />
    </ae:configuration>
</ae:configurations>
```

Registers both the `doctrine` (ORM) and `doctrine_dbal` (query builder only) aliases. See [Databases: Doctrine ORM](/basics/databases/#doctrine-orm).

### `quioteframework/db-cycle`

```bash
composer require quioteframework/db-cycle
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Cycle\CyclePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Cycle\CyclePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Cycle\CyclePlugin" />
    </ae:configuration>
</ae:configurations>
```

Registers the `cycle` alias for `CycleDatabase` (configured in `databases.php` only — see [Databases: Cycle ORM](/basics/databases/#cycle-orm)).

### `quioteframework/db-propulsion`

```bash
composer require quioteframework/db-propulsion
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Propulsion\PropulsionPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Propulsion\PropulsionPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Propulsion\PropulsionPlugin" />
    </ae:configuration>
</ae:configurations>
```

Registers the `propulsion` alias for `PropulsionDatabase`. Carries the [`quioteframework/propulsion`](https://github.com/quioteframework/propulsion) runtime — a PHP 8.5, Propel-style ORM with its own code generator (`bin/propulsion model:build`) — accepting `^2.0 || ^3.0`, so the adapter does not force a Propulsion major on you. Unlike the other adapters it owns its own connection factory (a runtime `config` file, no inline DSN or layer mode). See [Databases: Propulsion](/basics/databases/#propulsion).

<Aside type="note" title="PDO stays in the core">
The raw **PDO** driver (`class="pdo"`) is built into the kernel and always available — no package needed. Only the ORM adapters are extracted.
</Aside>

## Record, replay & regression tests

`quioteframework/replay` records a real request as a "cassette", replays it — in isolation by default, against stubs built from the cassette's own recorded effects — and can emit it as a committed PHPUnit regression test. The companion packages extend where cassettes are stored and what they capture. Full picture in [Record, replay & regression tests](/advanced/record-replay/) — this section is the install/enable reference.

`replay` itself is tagged `4.1.0`; the seven companion packages are tagged `4.0.0`.

### `quioteframework/replay`

```bash
composer require quioteframework/replay
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Replay\ReplayPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Replay\ReplayPlugin" />
    </ae:configuration>
</ae:configurations>
```

Registers the recorder middleware, the `file` cassette store (the default), and the `cassette:list`/`cassette:show`/`cassette:prune`/`cassette:fetch`/`replay` console commands. `replay.enabled` defaults to `false` and `replay.record` to `never`, so installing and enabling the package alone changes nothing observable. See [Record, replay & regression tests](/advanced/record-replay/).

### `quioteframework/replay-pdo`

Keeps cassettes in the app's own database (PostgreSQL or SQLite — not MySQL) instead of a pod's filesystem, which does not survive a restart. Load order is irrelevant: the package contributes the `pdo` store alias and a factory, and `ReplayPlugin`'s single `CassetteStoreInterface` binding builds whichever alias `replay.store` names. Installing it does not commit the app to a database-backed store.

```bash
composer require quioteframework/replay-pdo
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Replay\Store\Pdo\ReplayPdoPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Replay\Store\Pdo\ReplayPdoPlugin
  enabled: true
- class: Quiote\Replay\ReplayPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Replay\Store\Pdo\ReplayPdoPlugin" />
        <plugin class="Quiote\Replay\ReplayPlugin" />
    </ae:configuration>
</ae:configurations>
```

Then point `replay.store` at `pdo`. See [Record, replay & regression tests: the PDO-backed store](/advanced/record-replay/#the-pdo-backed-store).

### `quioteframework/replay-propulsion`

Records every query Propulsion runs during a request into that request's cassette, so `cassette:show` and an emitted regression test see what the database actually returned — not just the HTTP response.

```bash
composer require quioteframework/replay-propulsion
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Propulsion\PropulsionPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\Adapter\Propulsion\ReplayPropulsionPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Propulsion\PropulsionPlugin
  enabled: true
- class: Quiote\Replay\ReplayPlugin
  enabled: true
- class: Quiote\Replay\Adapter\Propulsion\ReplayPropulsionPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Propulsion\PropulsionPlugin" />
        <plugin class="Quiote\Replay\ReplayPlugin" />
        <plugin class="Quiote\Replay\Adapter\Propulsion\ReplayPropulsionPlugin" />
    </ae:configuration>
</ae:configurations>
```

See [Record, replay & regression tests: recording database effects](/advanced/record-replay/#recording-database-effects).

### `quioteframework/replay-doctrine`

Same idea for Doctrine DBAL/ORM. List `ReplayDoctrinePlugin` **after** [`db-doctrine`'s `DoctrinePlugin`](#quioteframeworkdb-doctrine) — it overrides the `doctrine`/`doctrine_dbal` driver aliases to a recording subclass, and that override needs `DoctrinePlugin`'s own registration to have already happened.

```bash
composer require quioteframework/replay-doctrine
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Doctrine\DoctrinePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\Adapter\Doctrine\ReplayDoctrinePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Doctrine\DoctrinePlugin
  enabled: true
- class: Quiote\Replay\ReplayPlugin
  enabled: true
- class: Quiote\Replay\Adapter\Doctrine\ReplayDoctrinePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Doctrine\DoctrinePlugin" />
        <plugin class="Quiote\Replay\ReplayPlugin" />
        <plugin class="Quiote\Replay\Adapter\Doctrine\ReplayDoctrinePlugin" />
    </ae:configuration>
</ae:configurations>
```

See [Record, replay & regression tests: recording database effects](/advanced/record-replay/#recording-database-effects).

### `quioteframework/replay-eloquent`

Same idea for Eloquent, via `Illuminate\Database\Events\QueryExecuted`. List `ReplayEloquentPlugin` after [`db-eloquent`'s `EloquentPlugin`](#quioteframeworkdb-eloquent), for the same driver-alias-override reason as `replay-doctrine`.

```bash
composer require quioteframework/replay-eloquent
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Eloquent\EloquentPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\Adapter\Eloquent\ReplayEloquentPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Eloquent\EloquentPlugin
  enabled: true
- class: Quiote\Replay\ReplayPlugin
  enabled: true
- class: Quiote\Replay\Adapter\Eloquent\ReplayEloquentPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Eloquent\EloquentPlugin" />
        <plugin class="Quiote\Replay\ReplayPlugin" />
        <plugin class="Quiote\Replay\Adapter\Eloquent\ReplayEloquentPlugin" />
    </ae:configuration>
</ae:configurations>
```

See [Record, replay & regression tests: recording database effects](/advanced/record-replay/#recording-database-effects).

### `quioteframework/replay-cycle`

Same idea for Cycle ORM, via `Cycle\Database\DatabaseManager::setLogger()`. List `ReplayCyclePlugin` after [`db-cycle`'s `CyclePlugin`](#quioteframeworkdb-cycle), for the same driver-alias-override reason as `replay-doctrine`.

```bash
composer require quioteframework/replay-cycle
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Database\Adapter\Cycle\CyclePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\Adapter\Cycle\ReplayCyclePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Database\Adapter\Cycle\CyclePlugin
  enabled: true
- class: Quiote\Replay\ReplayPlugin
  enabled: true
- class: Quiote\Replay\Adapter\Cycle\ReplayCyclePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Database\Adapter\Cycle\CyclePlugin" />
        <plugin class="Quiote\Replay\ReplayPlugin" />
        <plugin class="Quiote\Replay\Adapter\Cycle\ReplayCyclePlugin" />
    </ae:configuration>
</ae:configurations>
```

See [Record, replay & regression tests: recording database effects](/advanced/record-replay/#recording-database-effects).

### `quioteframework/replay-storage`

A cassette store over any `Quiote\Storage\ListableObjectStoreClientInterface` — Azure Blob, S3 or GCS — built on the framework-free [`quioteframework/storage`](#quioteframeworkstorage) contracts. Cassettes go to a deterministic, UTC-hour-partitioned key derived from the cassette's own `recorded_at`, so a lifecycle rule prunes them and a "what happened this hour" listing is one prefix away.

```bash
composer require quioteframework/replay-storage
```

It ships **no plugin of its own**: it holds `ObjectStoreCassetteStore`, the key scheme, and two of the three cassette-index strategies, for a provider-specific package to assemble. `replay-azure` is the one shipped assembly; point your own plugin's `CassetteStoreRegistry::register()` at these classes to do the same for S3 or GCS. See [Record, replay & regression tests: the object-store-backed store](/advanced/record-replay/#the-object-store-backed-store).

### `quioteframework/replay-azure`

The production target for AKS + Azure Blob + Log Analytics: registers the `azure-blob` cassette store alias, and the three-step **cassette index** — an explicit `--key`, a Log Analytics lookup that resolves a bare id from the recorder's own pointer log line, and a `--date`-hinted prefix scan for a developer with blob read but no workspace access.

```bash
composer require quioteframework/replay-azure
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Replay\Store\Azure\ReplayAzurePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Replay\Store\Azure\ReplayAzurePlugin
  enabled: true
- class: Quiote\Replay\ReplayPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Replay\Store\Azure\ReplayAzurePlugin" />
        <plugin class="Quiote\Replay\ReplayPlugin" />
    </ae:configuration>
</ae:configurations>
```

Load order is irrelevant here too, and installing the package does not commit the app to Azure: set `replay.store` to `azure-blob` (plus `replay.store.azure.account`/`.container` and an `auth` value) to actually use it. Needs a PSR-18 client bound in the container, the same way `session-azure` does. Full settings in [Record, replay & regression tests](/advanced/record-replay/#the-object-store-backed-store).

## Background jobs

### `quioteframework/queue`

A background job/queue abstraction: a `Job`/`RetryableJob` interface, an app-facing `QueueManager::push()`, the always-available in-process `sync` driver (blocking retries via `JobExecutor`), a default `LogFailedJobStore` dead-letter sink, and the `queue:work`/`queue:failed:list`/`queue:failed:retry`/`queue:failed:forget` console commands. `QueuePlugin` registers config defaults and all of the above services and commands — no app-specific secrets needed, unlike the auth packages.

```bash
composer require quioteframework/queue
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Queue\QueuePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Queue\QueuePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Queue\QueuePlugin" />
    </ae:configuration>
</ae:configurations>
```

The `sync` driver runs jobs inline in the pushing request — fine for dev/test, but production use should add `queue-db` (below) so a job's execution doesn't block the request that pushed it. See [Background jobs & queues](/advanced/queues/).

### `quioteframework/queue-db`

Adds the `db` queue driver (`DbQueueDriver`) and a persistent, queryable `DbFailedJobStore`, both backed by a PDO connection from the app's own `DatabaseManager` — a driver *for* `queue`, the same relationship the `db-*` ORM adapters have to their alias registry.

```bash
composer require quioteframework/queue-db
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Queue\QueuePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Queue\Db\QueueDbPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Queue\QueuePlugin
  enabled: true
- class: Quiote\Queue\Db\QueueDbPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Queue\QueuePlugin" />
        <plugin class="Quiote\Queue\Db\QueueDbPlugin" />
    </ae:configuration>
</ae:configurations>
```

Registers the `db` alias for `queue.default_driver`/`queue:work --driver`. `DbFailedJobStore` is registered as a service but is **not** bound as the default `FailedJobStoreInterface` automatically — bind it yourself to opt into persistent dead-letter storage. See [Background jobs & queues](/advanced/queues/#quioteframeworkqueue-db).

### `quioteframework/queue-redis`

Adds the `redis` queue driver (`RedisQueueDriver`), registered as a `queue.default_driver`/`queue:work --driver` alias. Unlike `queue-db`, the connection is self-contained — built straight from a DSN, with no dependence on the app's `DatabaseManager`.

```bash
composer require quioteframework/queue-redis predis/predis
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Queue\QueuePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Queue\Redis\QueueRedisPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Queue\QueuePlugin
  enabled: true
- class: Quiote\Queue\Redis\QueueRedisPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml — inside <ae:configuration> -->
<plugin class="Quiote\Queue\QueuePlugin" />
<plugin class="Quiote\Queue\Redis\QueueRedisPlugin" />
```

| Key | Default | Meaning |
|---|---|---|
| `queue.redis.dsn` | `redis://127.0.0.1:6379` | Connection DSN. |
| `queue.redis.prefix` | `quiote_queue` | Key prefix for the driver's own keys. |

It's a **reliable queue**, not a bare list pop. Ready jobs live in a Redis LIST (`{prefix}:ready`); `reserve()` atomically moves one into a `{prefix}:processing` LIST via `RPOPLPUSH`, so a worker that crashes mid-job leaves that job recoverable from the processing list rather than losing it. Delayed and released jobs live in a ZSET (`{prefix}:delayed`) scored by their due timestamp, which `reserve()` promotes from before polling the ready list.

### `quioteframework/scheduler`

Cron-expression task scheduling: an app subclasses `Quiote\Scheduler\Schedule` to declare what runs and when, and one crontab line runs `schedule:run` once a minute. Layered on `queue` — the recommended shape for a scheduled task is "dispatch a job".

```bash
composer require quioteframework/scheduler
```

`SchedulerPlugin` registers a **no-op default `Schedule`**, so installing without defining anything is a safe no-op rather than an error. It also registers `SchedulerLock` (best-effort overlap prevention on the PSR-16 cache) and the `schedule:run` command. See [Scheduled tasks](/advanced/scheduling/).

## Worker runtimes

The kernel ships two worker runtimes — the plain SAPI and FrankenPHP. These two packages add the off-SAPI hosts through the same `WorkerRuntimeInterface` seam. Installing a package doesn't switch anything on: activate its plugin, and give the app the extra entrypoint that server needs (`quiote new --runtime=…` generates it). Full setup, the runtime comparison matrix, and what changes once you leave the PHP SAPI: [Deployment](/architecture/deployment/).

### `quioteframework/worker-roadrunner`

Runs the app as a [RoadRunner](https://roadrunner.dev) PSR-7 worker, via the `roadrunner` alias.

```bash
composer require quioteframework/worker-roadrunner
composer require --dev spiral/roadrunner-cli && vendor/bin/rr get-binary
```

```xml
<plugin class="Quiote\Runtime\RoadRunner\WorkerRoadRunnerPlugin"/>
```

Needs a `worker.php` entrypoint and a `.rr.yaml`. Detection is automatic — RoadRunner sets `$RR_MODE=http` for its workers. Its only setting is `worker.roadrunner.chunk_size` (default `8192`). See [Running under RoadRunner](/architecture/deployment/#running-under-roadrunner).

### `quioteframework/worker-swoole`

Serves the app from an embedded [Swoole](https://swoole.com) HTTP server, via the `swoole` alias.

```bash
pecl install swoole          # 5.1 or newer
composer require quioteframework/worker-swoole
```

```xml
<plugin class="Quiote\Runtime\Swoole\WorkerSwoolePlugin"/>
```

`ext-swoole` is a Composer `suggest`, not a `require`, so the package installs and type-checks without it. Needs a `swoole.php` entrypoint, and — unlike RoadRunner — an **explicit** `$QUIOTE_WORKER_RUNTIME=swoole` opt-in, because a loaded `ext-swoole` is no evidence of running under a Swoole server. Coroutines are deliberately off. Settings are the `worker.swoole.*` family; OpenSwoole is not supported. See [Running under Swoole](/architecture/deployment/#running-under-swoole).

## Template renderers

The kernel ships only the plain-PHP renderer (`Quiote\Renderer\PhpRenderer`, the default). Alternative renderers are packages. They plug into the **config-driven renderer registry** — there's no `plugins` entry: install the package, then point an output type's `renderer` at the class in `output_types.xml` (see [Templates and rendering](/basics/templates-and-rendering/)). Because renderers are chosen per output type, an app can mix them — PHP for HTML, XSLT for a document export, and so on.

### `quioteframework/phptal`

The [PHPTAL](https://phptal.org/) renderer, `Quiote\Renderer\Phptal\PhptalRenderer`.

```bash
composer require quioteframework/phptal
```

:::caution[PHPTAL throws on a genuinely undefined array key]
A template that reads `${foo/bar}` (or `tal:content="foo/bar"`) **throws** if `bar` was never set on the `foo` array — unlike plain PHP array access with `??`/`isset()`, PHPTAL does not treat a missing key as `null`. This is upstream PHPTAL behavior, not something Quiote's renderer wrapper changes: a defensible, arguably safer default (a forgotten attribute surfaces at render time instead of silently printing nothing), but it means every attribute a PHPTAL template reads must be `setAttribute()`-ed — or explicitly given a default — on **every** code path through the view, including early-return and error branches, not just the happy path you tested first.
:::

### `quioteframework/xslt`

The XSLT renderer, `Quiote\Renderer\Xslt\XsltRenderer` (needs PHP's `ext-xsl`).

```bash
composer require quioteframework/xslt
```

### `quioteframework/twig`

The [Twig](https://twig.symfony.com/) renderer, `Quiote\Renderer\Twig\TwigRenderer`. A native integration (not an extraction) whose `TemplateLayerLoader` bridges Twig's loader to Quiote's [layout/layer](/basics/templates-and-rendering/#layouts-and-layers) model.

```bash
composer require quioteframework/twig
```

## Session backends

Session backends beyond the file- and PDO-backed ones the kernel ships, for sharing sessions across nodes or offloading them to managed object storage. See [Sessions](/basics/sessions/).

Each package ships a **`session` slot factory**, so switching backend is a class name in [`factories` config](/architecture/configuration/#factories) — name the factory below, give it its parameters, and there is nothing to wire by hand:

| Backend | Factory to name in the `session` slot | Package |
|---|---|---|
| Redis | `Quiote\Session\Redis\RedisSessionFactory` | `session-redis` |
| S3 | `Quiote\Storage\S3\S3SessionFactory` | `session-s3` |
| GCS | `Quiote\Storage\Gcs\GcsSessionFactory` | `session-gcs` |
| Azure Blob | `Quiote\Storage\Azure\AzureBlobSessionFactory` | `session-azure` |
| Azure Table | `Quiote\Storage\Azure\AzureTableSessionFactory` | `session-azure` |
| PDO | `Quiote\Session\Pdo\PdoSessionFactory` | `session-pdo` |

None of the cloud packages pull an official cloud SDK; each is a minimal REST client over PSR-18, covering just the handful of operations a session backend needs, and each expects **a `Psr\Http\Client\ClientInterface` bound in the [container](/architecture/container/)** — the same contract the matching `filesystem-*` packages use.

### `quioteframework/session-pdo`

`Quiote\Session\Pdo\PdoSessionFactory` — database-backed sessions in a table. The kernel ships an equivalent PDO backend of its own (`Quiote\Session\PdoSessionFactory`), so reach for this package only if your application already requires it. `composer require quioteframework/session-pdo`.

### `quioteframework/session-azure`

Two backends in one package: `AzureBlobSessionFactory` (one JSON blob per session) and `AzureTableSessionFactory` (one entity per session, cheaper for small payloads), both under `Quiote\Storage\Azure` and authenticated with Azure's Shared-Key schemes. Parameters: `account_name`, `account_key`, and `container` or `table`. Built on [`quioteframework/cloud-azure`](#cloud-transport-packages). `composer require quioteframework/session-azure`.

### `quioteframework/session-s3`

`Quiote\Storage\S3\S3SessionFactory` — AWS Signature v4, path-style requests, so it also targets MinIO and any S3-compatible store via `endpoint`. Parameters: `region`, `bucket`, `access_key_id`, `secret_access_key`, `key_prefix`. Built on [`quioteframework/cloud-s3`](#cloud-transport-packages). `composer require quioteframework/session-s3`.

### `quioteframework/session-gcs`

`Quiote\Storage\Gcs\GcsSessionFactory` — authenticates with a GCS **HMAC key pair** (the S3-compatible interoperability mode), so `access_key`/`secret_key` rather than a service-account JSON file. Parameters also include `bucket` and `object_prefix`. Built on [`quioteframework/cloud-gcs`](#cloud-transport-packages). `composer require quioteframework/session-gcs`.

### `quioteframework/session-redis`

`Quiote\Session\Redis\RedisSessionFactory` — one string key per session, written with `SETEX` so **Redis expires stale sessions itself**, with no GC pass to schedule (unlike the PDO and file backends). Parameters: `dsn`, `prefix`, `ttl`. `composer require quioteframework/session-redis predis/predis`. See [Sessions: Redis-backed sessions](/basics/sessions/#redis-backed-sessions).

## File storage disks

Cloud disks for the [file storage abstraction](/basics/filesystem/). The kernel ships a `local` disk; each package below adds one alias, registered from its own plugin. See [File storage: cloud disks](/basics/filesystem/#cloud-disks).

Each expects **a `Psr\Http\Client\ClientInterface` bound in the [container](/architecture/container/)** — no vendor SDK is pulled — and each throws at boot naming the missing binding if there isn't one.

All three also **list** as of 4.2: each extends `Quiote\Filesystem\ListableObjectStoreFilesystemAdapter`, so each implements [`ListableFilesystemInterface`](/basics/filesystem/#listing-is-a-separate-contract) and `listableDisk('s3')->listContents('reports/')` works. See [File storage: listing a cloud disk](/basics/filesystem/#listing-a-cloud-disk).

### `quioteframework/filesystem-s3`

`Quiote\Filesystem\S3\S3FilesystemAdapter`, registered as the `s3` alias by `S3FilesystemPlugin`. SigV4, path-style requests, so it also targets MinIO and any S3-compatible store via `filesystem.disks.s3.endpoint`. Built on [`quioteframework/cloud-s3`](#cloud-transport-packages). `composer require quioteframework/filesystem-s3`.

### `quioteframework/filesystem-gcs`

`Quiote\Filesystem\Gcs\GcsFilesystemAdapter`, registered as the `gcs` alias by `GcsFilesystemPlugin`. Authenticates with a GCS **HMAC key pair** (the S3-compatible interoperability mode), not a service-account JSON file. Built on [`quioteframework/cloud-gcs`](#cloud-transport-packages). `composer require quioteframework/filesystem-gcs`.

### `quioteframework/filesystem-azure`

`Quiote\Filesystem\Azure\AzureFilesystemAdapter`, registered as the `azure` alias by `AzureFilesystemPlugin`. Shared-Key authentication against a fixed container, named in `filesystem.disks.azure.container`. Built on [`quioteframework/cloud-azure`](#cloud-transport-packages). `composer require quioteframework/filesystem-azure`.

## Cloud transport packages

Three packages hold the signed REST clients that the `session-*`, `filesystem-*` and `replay-azure` backends share: **`quioteframework/cloud-s3`** (`Quiote\Storage\S3\S3Client`, SigV4), **`quioteframework/cloud-gcs`** (`Quiote\Storage\Gcs\GcsClient`, HMAC over the S3-compatible interoperability API), and **`quioteframework/cloud-azure`** (`AzureBlobClient`, `AzureTableClient` and `AzureMonitorQueryClient`).

Each exposes `get`, `put`, `delete` and `head` on a single object, `listObjects()` (4.2 — one normalized, paginated listing across all three providers, see [Listing a cloud disk](/basics/filesystem/#listing-a-cloud-disk)), and `request()`, which signs an arbitrary request and returns the raw PSR-7 response for anything the typed methods don't cover. All of it against the framework-free [`quioteframework/storage`](#quioteframeworkstorage) contracts.

They are transitive dependencies — `session-s3` and `filesystem-s3` both require `cloud-s3`, and so on — so **you never install them directly**. They are listed here so the dependency tree makes sense when you look at it, and because a custom backend of your own can build on them.

Each is a client against a single bucket, container or table, with no vendor SDK dependency, driven by whatever PSR-18 implementation you bind in the container. None of the three requires the framework any more, as of 4.2 — they are usable from a plain PHP project.

`cloud-azure` authenticates four ways, selected by an `auth` config value its consumers all pass through `AzureCredentialFactory`: `shared_key` (the account key), `workload_identity` (an AAD token from the AKS webhook's environment), `cli` (an existing `az login` session) and `chain` (workload identity, falling back to the CLI). It is tagged `4.1.0` — the blob and table clients are in production, but the AAD credential path has not yet authenticated against real Azure.

### `quioteframework/storage`

The object-store contracts, and nothing else: `ObjectStoreClientInterface`, `ListableObjectStoreClientInterface`, `ObjectMetadata`, `ObjectListing`, `ObjectSummary`, `ObjectStoreException`. Its only dependency is `psr/http-message` — not the framework. It arrives transitively with any `cloud-*`, `filesystem`, or `replay-storage` install; require it directly only when writing your own object-store client against the contract.

### `quioteframework/filesystem`

`FilesystemManager`, the `filesystem.*` config, `FilesystemPlugin`, the `local` disk, the object-store adapter base classes, and `Quiote\Session\ObjectStoreSessionPersistence` (the shared base the object-store session backends extend — it belongs with the adapters it mirrors, not in a `session-*` package). Requires `quioteframework/storage`.

```bash
composer require quioteframework/filesystem
```

These classes shipped inside `quioteframework/quiote` through 4.1 and moved out in 4.2 with **every namespace unchanged**. The framework has no `require` on them, so upgrading alone does not install them — see [Upgrading to 4.2](/getting-started/upgrading-to-4-2/#filesystem-and-object-store-classes-moved-into-their-own-packages) for whether that affects you and how it fails if it does. Usage is on [File storage](/basics/filesystem/).

## Redis backends

Four subsystems can be backed by Redis. They don't share a package — cache and rate limiting live in the kernel and the `ratelimit` package respectively, and queue and session are their own packages — but they do share a client, a DSN convention, and a failure mode, so they're worth reading as a set.

| Subsystem | How to switch it on | Keys |
|---|---|---|
| [Cache](/basics/caching/) | `core.cache_backend: redis` | `core.redis_dsn` |
| [Queue](/advanced/queues/) | install `quioteframework/queue-redis`, then `queue.default_driver: redis` | `queue.redis.dsn`, `queue.redis.prefix` |
| [Sessions](/basics/sessions/#redis-backed-sessions) | install `quioteframework/session-redis`, point the `session` slot at `RedisSessionFactory` | *(slot parameters: `dsn`, `prefix`, `ttl`)* |
| [Rate limiting](#quioteframeworkratelimit) | `ratelimit.storage: redis` | `ratelimit.redis.dsn` |

All of them go through Symfony's `RedisAdapter::createConnection()` DSN factory, so **any** of three clients works: `ext-redis`, `ext-relay`, or [`predis/predis`](https://github.com/predis/predis) — a pure-PHP client with no extension dependency, which is the easiest option and the one to install if you have no preference:

```bash
composer require predis/predis
```

`predis/predis` is in the framework's `suggest` block, not its `require` — Redis is opt-in, not a new hard dependency of core. If you select a Redis backend with **no** client available, each of the four raises a clear, actionable exception naming the setting and listing the three client options, at connection time. None of them silently falls back to a non-Redis backend, because a rate limiter or session store that quietly became process-local would be a security problem rather than a degradation.
