# Changelog

> Release history for the Quiote framework, newest first.

Release history for the `quioteframework/quiote` framework package. Entries marked **breaking** need a code or config change on upgrade.

The raw, per-commit changelog lives in [`CHANGELOG.md`](https://github.com/quioteframework/quiote/blob/main/CHANGELOG.md) in the repository; this page is the curated version.

[Propulsion](/propulsion/) versions independently.

## 4.0.0

Decomposing `Context` into the collaborators it was standing in for, and deleting the accessors that stood in for them. The config cache must also be cleared once on the way in. See [Upgrading to 4.0](/getting-started/upgrading-to-4/).

- **breaking** — Every config cache key now includes a framework fingerprint, so a framework upgrade recompiles automatically instead of reusing a cache compiled by an older version. Clear the cache once on the way in; from here it's automatic. [Configuration](/architecture/configuration/#a-framework-upgrade-invalidates-the-cache)
- **breaking** — Compiled `factories`, `databases`, `output_types` and `translation` files return **data**, not executable PHP `include`d into the object that reads them. Source formats are untouched. The per-component `*FactoryInfo` properties on `Context` are gone.
- **breaking** — Every remaining config handler (`settings`, `module`, `plugins`, `middleware`, `validators`) compiles to a declaration too, removing the last `eval()`s from the configuration cache. Breaking only for a hand-written config handler: `execute()`/`executeArray()` return the declaration (`mixed`) rather than generated PHP, `BaseConfigHandler::generate()` is gone, and a handler applied via `ConfigCache::load()` must implement the new `Quiote\Config\IDeclarationConfigHandler`. [Configuration](/architecture/configuration/#writing-your-own-config-handler)
- **breaking** — Every `Context` accessor that answered "some other service" is deleted: `getRouting()`, `getController()`, `getRequest()`/`setRequest()`, `getUser()`, `getService()`, `getModel()`, `getDatabaseManager()`, `getTranslationManager()`, the session pair, the execution helpers, `createInstanceFor()` and `handle()`. `ContextInterface` declares two methods where 3.2 declared seventeen. Inject the collaborator instead — `Quiote\Rector\Set\ContextDecompositionSetList` rewrites the common shapes. [Upgrading to 4.0](/getting-started/upgrading-to-4/#breaking-contexts-accessors-are-gone)
- **breaking** — `Context::handle()` is gone; the per-request work lives in `Quiote\Runtime\ContextRequestHandler`, a real PSR-15 handler reached with `getRequestHandler()`. `Context::$psrKernel` and `$correlationId` are gone too; use `getRequestHandler()->pipeline()` / `forgetPipeline()` and `getCorrelationId()`.
- `ModelLocator`, `ContextRegistry`, `RequestState` and `CurrentUser` are separate, injectable classes. [Container](/architecture/container/#framework-state-is-a-dependency-like-any-other)
- **breaking, fixed** — An omitted `$scope` on `Container::set()`, `setFactory()` and `PluginRegistrar::service()` no longer means process lifetime. The argument is nullable, and omitting it asks the binding: a class name keeps the lifetime its own `#[Service]` declares, a factory is request-scoped, an instance or a bound value is a singleton. Registering a class purely to alias it no longer changes what it is. [Container](/architecture/container/#what-an-omitted-scope-means)
- **breaking** — `ValidationService::xmlOnlyValidate()` is `validateDeclaredOnly()`. Same signature, same behaviour: validators haven't been XML-only for some time, and what the method skips is the action's own `validate()` methods, not a declaration format. [Upgrading to 4.0](/getting-started/upgrading-to-4/#breaking-validationservicexmlonlyvalidate-is-now-validatedeclaredonly)
- **breaking** — Four deprecated validation methods are gone: `ValidationError::setMessageIndex()`/`getMessageIndex()` (use `setName()`/`getName()`) and `ValidationIncident::hasFieldError()`/`getFieldErrors()` (use `getArguments()`/`getErrors()`). `ValidationManager::getFieldErrors()` is a different method and is unaffected. [Upgrading to 4.0](/getting-started/upgrading-to-4/#breaking-four-deprecated-validation-methods-are-gone)
- **breaking** — `Quiote\Execution\ViewResolver` (a deprecated stub forwarding to `ViewNameResolver`) and `ActionExecutionSession` (a transitional wrapper never wired into dispatch) are removed.
- **breaking** — `QuioteException`'s four exception-page helpers — `getFixedTrace()`, `buildParamList()`, `highlightFile()`, `highlightString()` — are removed from it and from every exception extending it. Rendering an exception is `ExceptionRenderer`'s job. [Upgrading to 4.0](/getting-started/upgrading-to-4/#breaking-quioteexceptions-exception-page-helpers-are-gone)
- **Fixed** — `ViewTestCase`'s response assertions compare what they document: a redirect target against the location, a header against one of its values, a cookie against its value. `runView()` hands the view the request rather than the request's parameter array, which was a `TypeError` against any view. [Testing](/advanced/testing/#the-fragment-harness)
- **Fixed** — A category logger is re-resolved when the logging configuration changes, instead of serving a logger built against the old one.
- **Fixed** — `Toolkit::overloadHelper()` returns the matching method, and `Database::reset()` honours the teardown contract. The `db-propulsion` adapter no longer discards live connections on every `initialize()`.
- **Fixed** — `PropulsionDatabase::getConnection()`/`getResource()` re-resolve from Propulsion on every call instead of trusting a cached handle, so a reconfiguration on another instance can no longer leave this one silently pointed at a dropped connection. `EloquentDatabase::getCapsule()` follows the same fix through layer mode: it now re-checks the source database's current PDO on every access and rebinds it into the Illuminate connection when it has rotated underneath. [`PropulsionDatabase`](/api/database/adapter/propulsion/propulsion-database/#getconnection) · [`EloquentDatabase`](/api/database/adapter/eloquent/eloquent-database/#getcapsule)
- `Quiote\Renderer\PhpRenderer` exposes the attributes array under the configured `var_name` (`template` by default), by reference and as the array itself — so reading a key the action never set is an undefined-key warning rather than silence. [Templates and rendering](/basics/templates-and-rendering/#template-variables)
- New `core.stealth_mode` strips framework-identifying headers from every response — any `X-Quiote-*` header, plus the names in `core.stealth_additional_headers` (`X-Powered-By` by default). `StealthMiddleware` runs outside the error handler, so error and 404 responses are covered too. [Middleware reference](/architecture/middleware-reference/#stealthmiddleware)
- A generated [API reference](/api/) — every public class, interface, trait and enum the framework ships, with its methods and their types, built from the source rather than maintained by hand.
- Middleware holding per-request state can implement `Symfony\Contracts\Service\ResetInterface`; the context calls `reset()` on every middleware in the built stack at the end of each request. The stack itself is kept, and a `reset()` that throws is logged rather than silently skipping the rest. [Custom middleware](/advanced/custom-middleware/#one-instance-per-worker-not-per-request)
- **Fixed** — A declared `session` factory was ignored: `FactoryConfigHandler` answered "is this slot optional?" and "is it switched off?" with one flag, so the optional session slot was never read and every app declaring one silently got a `NullSessionBag`. Declarations are now read regardless, and a `session` factory naming a class that doesn't implement `SessionFactoryInterface` is rejected at compile time instead of ignored. The reverse case is fixed too: an optional slot whose subsystem is switched off (a `translation_manager` with `core.use_translation` false) is no longer built anyway. [Sessions](/basics/sessions/#the-session-slot)
- **Fixed** — A bearer-authenticated identity that then logged in through the session kept its session id; the id is rotated on that transition like any other privilege change.
- **Fixed** — A Postgres session blob is read as a stream rather than a string, so `bytea` sessions load.
- **Fixed** — Slot parameters are restored from the validated request, and `RoutingValue::reset()` no longer unsets a shared static property.
- The `_original_psr_request` attribute is gone. It carried a copy of the request as the client sent it — unvalidated input under a well-known name, readable from any middleware, action or view — past the pruned canonical request that strict validation produces. Nothing in the framework read it.
- New `Quiote\ContextLifecycle` owns the per-request state machine, and `PluginManager::addRequestEndClear()` lets a plugin clear its own request-scoped state at the boundary. [Plugins](/architecture/plugins/#clearing-your-own-state-at-the-end-of-a-request)
- Validators can declare constructor dependencies; construction goes through the container. [Custom validators](/advanced/custom-validators/#constructor-dependencies)
- **Fixed** — Injecting `WebRequest`, `User`, `ISecurityUser`, `Routing`, `TranslationManager` or `DatabaseManager` by base class autowired a fresh, empty instance instead of the request's real one. The base classes are bound alongside the concrete class now; the same wiring in a *singleton* throws at wiring time rather than leaking one request's identity into the next.
- **Fixed** — A throwable during `Context::reset()` could abort the reset before identity was cleared, handing the next request in a worker the previous request's authenticated user. Identity is now cleared first and unconditionally.
- The execution helpers (`getActionResolver()`, `getAssetRegistry()`, `getSlotDispatcher()`) resolve through the container with declared lifetimes, and are injectable.
- **breaking, fixed** — An unregistered, autowired class defaulted to **singleton** scope — the container's most dangerous default. It now defaults to **request** scope; opt into process lifetime explicitly. This is what a singleton constructor-injecting `RbacSecurityUser` or `WebRequest` was silently doing. [Container](/architecture/container/#what-a-class-gets-when-nothing-says-otherwise)
- **breaking, fixed** — A bare `#[Service]` (no `scope:` argument) defaulted to singleton, disagreeing with `ServiceInterface`'s transient default — so adding the attribute to an existing service for discoverability silently promoted its lifetime. Both now default to transient. [Services and models](/basics/services-and-models/#marking-a-service)

## 3.2

Tightening contracts that were quietly wrong. Most applications need no changes; see [Upgrading to 3.2](/getting-started/upgrading-to-3-2/) for the three worth grepping for.

- **breaking** — `WebResponse::setHttpStatusCode()` accepts any code in 100–599. The per-protocol whitelist made 422, 429, 308, 451, 507 and 511 unsettable, and fell through to the HTTP/1.0 list on HTTP/3. [Requests and responses](/basics/requests-and-responses/#body-status-headers)
- **breaking** — `PsrResponseAdapter` is immutable: `with*()` clones instead of mutating the shared `WebResponse` and returning `$this`. A discarded return value is now a no-op rather than a hidden mutation. [Requests and responses](/basics/requests-and-responses/#the-psr-7-view-of-the-response)
- **breaking** — `Config::$config` is private; `Quiote\Config\ConfigRepository` holds the behaviour and is injectable. The whole static `Config` API is unchanged. [Configuration](/architecture/configuration/#the-repository-behind-the-facade)
- **breaking** — `ValidationMiddleware` requires a `Controller`; it no longer resolves one from the `'web'` context by name.
- **breaking** — `listContents()` moved off `FilesystemAdapterInterface` to `ListableFilesystemInterface`; three of the four shipped drivers never could honour it. [File storage](/basics/filesystem/#listing-is-a-separate-contract)
- **breaking** — One `Quiote\Storage\ObjectMetadata` and one `ObjectStoreClientInterface` for every object store; the three per-provider metadata classes are gone. Provider exceptions now extend `ObjectStoreException`.
- **breaking** — `cors.allowed_origins: ['*']` with `cors.allow_credentials: true` throws at boot instead of emitting a pair browsers reject. [`quioteframework/cors`](/plugins/official-packages/#quioteframeworkcors)
- One `Quiote\Session\SessionCodec` behind every session backend; seven implementations disagreed on how to read back what they wrote. [Sessions](/basics/sessions/#the-stored-wire-format)
- `WebRequest`'s seven URL setters now also rewrite the wrapped PSR-7 URI, and are deprecated in favour of `with*()` counterparts. [Requests and responses](/basics/requests-and-responses/#url-metadata)
- **Fixed** — A view's `setAttribute()` was invisible to `getAttribute()`, and `appendAttribute()` did nothing under the modern execution path. The two attribute stores are one.
- New contracts: `ContextInterface`, `ControllerInterface`, `WebResponseInterface`, `ValidatorInterface`, `ContextComponentInterface`. `TelemetryBootstrap` is decomposed with its API unchanged.
- Failures on the dispatch path — dropped status, headers, redirects, cookies — are logged instead of vanishing.

## 3.1.0

A security release. Every entry closes a gap that was silently ineffective rather than loudly broken, so there's nothing to change in application code — but several change what your app actually enforces.

- **CSRF validation now runs.** `CsrfValidationMiddleware` decided "no session cookie" by looking for `session_name()` — `PHPSESSID` — while `SessionManager` names its cookie `QSID` and doesn't use ext/session at all. The probe never matched, so every unsafe request looked sessionless and was exempted, in every app using the framework's own session manager. Forms still received a token, so the failure was invisible. [Authentication & authorization](/advanced/authentication-authorization/#automatic-exemptions)
- **breaking** — The CSRF exemption for a request carrying an `Authorization` header is gone. Header presence proves nothing: `Authorization: Bearer <garbage>` plus a valid session cookie authenticated via the cookie and skipped the token check. The exemption now requires `auth.stateless`/`auth.sessionless`/`jwt.skip_session`, set only after an authenticator validated a caller-supplied credential.
- **A privilege transition deletes the old session id outright.** `regenerate()` only deleted it when the session happened to be empty, and a real login session always holds something — the CSRF token at minimum — so login always took the tombstone path, leaving an id an attacker had planted rideable for the whole grace window. The window keeps doing its real job on routine rotations. [Sessions](/basics/sessions/#a-privilege-transition-deletes-the-old-id-a-routine-rotation-migrates-it)
- **Security fails closed when an action can't be evaluated.** When `createActionInstance()` or `initialize()` threw, `SecurityMiddleware` granted access on "is authenticated" alone, skipping the action's own `isSecure()`/`getCredentials()` requirements. Authenticated is not authorized.
- **A failed context reset can no longer leak the previous user** into the next request a worker serves.
- **The scaffold generates a `session` slot**, so a new app actually enforces CSRF, and `user` is `RbacSecurityUser`. [Your first app](/getting-started/your-first-app/)
- **Firewall patterns are validated at construction.** An unanchored pattern matched anywhere in the path (`/admin` also covered `/public/admin-notes`), and an invalid one made `preg_match()` return false — read as "no match", so a regex typo left every path it guarded unauthenticated. `matches()` also tests a canonicalized path, so `/api/%2e%2e/admin` no longer depends on what the proxy in front normalized. [The firewall model](/advanced/authentication-authorization/#the-firewall-model)
- **Login throttling is per client, and the identifier probe is constant-cost.** `||` short-circuiting meant an unknown identifier returned after one indexed SELECT while a known one paid a full argon2id verification — a reliable enumeration oracle. The throttle keyed on the identifier alone, which did nothing about horizontal credential stuffing and handed an attacker a lockout primitive against a known victim. [Login rate limiting](/plugins/official-packages/#quioteframeworkratelimit)
- **The framework-middleware override guard covers the CSRF middleware**, and an unresolvable `before:`/`after:` reference declared by a guarded middleware now throws instead of dropping the constraint. A single `<use>` entry could previously disable CSRF validation or reorder it past dispatch. [Middleware pipeline](/architecture/middleware-pipeline/)
- **breaking** — `RateLimitMiddleware` reads the trusted end of `X-Forwarded-For`, skipping `ratelimit.http.trusted_proxy_hops` entries (default 1). A proxy appends rather than replaces, so keying on the leftmost value let a caller rotate the key per request and buy no throttling at all.
- **CORS no longer emits a wildcard origin alongside credentials** — a pair the fetch spec forbids, so browsers rejected the response while non-browser clients honoured it. (3.2 turns this into a boot-time configuration error.)
- **A queued job's class is verified before it is constructed**, so a queue row an attacker can influence can't have an arbitrary autoloadable class built with chosen constructor arguments. [Queues](/advanced/queues/#job-and-retryablejob)
- **An MCP tool call that was forwarded fails** instead of handing the connected model the login page's markup as the action's output. [MCP server](/advanced/mcp-server/#the-killer-feature-mcptool-on-an-existing-action)
- **`Authorization` scheme parsing follows RFC 9110** — case-insensitive, any run of whitespace — in both the Basic and Bearer authenticators, and a bare `Basic`/`Bearer` is claimed and answered with a challenge rather than falling through as "nothing presented".
- **A failed validation decision reaching dispatch is negotiated**: Problem Details for a JSON client, the HTML fragment otherwise, instead of a hardcoded `<div>Validation Failed</div>` for everyone. [Validation](/basics/validation/#when-dispatch-handles-the-failure-itself)

## 3.0.2

- `make:action` templates are generated from the configured renderer, so a scaffolded action matches the app's own template language.
- Four latent defects repaired in response headers, cache keys, OAuth scopes and rate limiting.

## 3.0.1

Object metadata for the cloud file storage disks.

- `S3Client`, `GcsClient` and `AzureBlobClient` gained a `head()` operation, returning a typed `ObjectMetadata` / `BlobMetadata` (content length, last-modified, ETag).
- [`size()` and `lastModified()`](/basics/filesystem/#cloud-disks) now work on the `s3`, `gcs` and `azure` filesystem disks; they previously threw unconditionally.
- `exists()` on a cloud disk issues a HEAD rather than a GET, so it no longer transfers the object body just to answer a boolean.
- All three clients expose `request()`, which signs an arbitrary request and returns the raw PSR-7 response, so a bucket listing — `ListObjectsV2`, `List Blobs`, pagination included — can be built without reimplementing SigV4, HMAC or Shared-Key signing. See [Listing from the bucket](/basics/filesystem/#listing-from-the-bucket).
- `listContents()` still throws on all three cloud disks: there is no list operation behind the typed client surface.

## 3.0.0

The session overhaul. Sessions became PSR-7-native and the ext/session-backed `storage` component was removed.

**Upgrading from 2.x? Read [Upgrading from 2.x to 3.0](/getting-started/upgrading-to-3/) — this release is not drop-in.**

### Sessions

- **breaking** — The `storage` factory slot and the `Quiote\Storage\*` stack (`Storage`, `SessionStorage`, `NullStorage`, `PdoSessionStorage`) are removed. Sessions are configured through the new, optional [`session` slot](/basics/sessions/#the-session-slot).
- `SessionBagInterface` is the single seam every session consumer talks to — the `User` hierarchy, CSRF token storage, OIDC state, and application code — reached via `Context::getSessionBag()`. An unconfigured context answers a `NullSessionBag`.
- Every backend ships a `session` slot factory, so switching backend is a class name in config with nothing to wire by hand: files and PDO in core, plus Redis, S3, GCS, Azure Blob and Azure Table in their packages.
- **breaking** — Anonymous requests no longer create a session or emit a cookie. A request that writes nothing costs nothing.
- **breaking** — `setAuthenticated(false)` discards the session contents and rotates the id, so a logged-out id is neither replayable nor inheritable.
- **breaking** — Request state is persisted *before* the response is emitted, inside `SessionMiddleware`. Code mutating the user after the pipeline unwind no longer persists.
- **breaking** — Only session state that actually changed is written; `User` subclasses writing to `$attributes`, `$credentials` or `$roles` directly must call `markDirty()`.
- **breaking** — `SessionManager::regenerate()` and `migrateOld()` take an additional optional request argument, used to bind the migration tombstone to the requesting client.
- Session identity is proven to survive across worker requests, with FrankenPHP now covered in the worker integration suite alongside RoadRunner and Swoole.

### Packages

- **breaking** — The signed cloud REST clients moved into three new packages: `cloud-s3`, `cloud-gcs` and `cloud-azure`. The matching `session-*` and `filesystem-*` packages now both depend on them, rather than `filesystem-s3` depending on `session-s3` to obtain a client. They are transitive dependencies — nobody installs them directly.

### Fixes

- The read cursor is released in the PDO session backends, and the PDO upsert is portable across MySQL, SQLite and Postgres.
- The native session lifecycle is repaired under worker runtimes.
- `Quiote\Middleware\SessionMiddleware` resolves session ids through the bag.

## 2.0.1

- The scheduler rebinds the default schedule per test, stopping cross-test leakage.
- Redundant `Before`/`After` attributes dropped from the HTTP client's `setUp`/`tearDown`.

## 2.0.0

A broad feature release: worker runtimes, queues, scheduling, and a large performance pass.

### Features

- **Worker runtimes** — [RoadRunner](/architecture/deployment/#running-under-roadrunner) and [Swoole](/architecture/deployment/#running-under-swoole) runtimes, verified against real servers.
- **breaking** — The worker adapter was replaced with a runtime-agnostic contract; `WorkerAdapterInterface`, `FrankenPhpWorkerAdapter` and `SingleRequestAdapter` are gone.
- [Background jobs and queues](/advanced/queues/) — the `queue` abstraction with a `sync` driver, `queue:work`, plus `queue-db` and `queue-redis` drivers.
- [Scheduled tasks](/advanced/scheduling/) — cron-expression scheduling and `schedule:run`.
- [Server-Sent Events](/advanced/server-sent-events/) streaming.
- [OpenAPI 3.1](/advanced/openapi/) documents derived from routes and validators.
- `#[MapRequest]` attribute-based request-DTO mapping.
- CORS, security-headers and HTTP rate-limit middleware.
- Redis backends for cache, queue, session and rate-limit storage.
- A general-purpose [file storage abstraction](/basics/filesystem/) with a local disk plus S3, GCS and Azure packages, and a file-backed session persistence backend.
- A [fluent HTTP test client](/advanced/testing/#the-fluent-http-client).
- `make:*` generators and a `serve` command.
- OIDC discovery for `auth-oauth` provider metadata.
- Renderers can author their own scaffold starter template.
- **breaking** — Legacy 0.11/1.0 config envelope migration was dropped.

### Performance

A framework-wide audit: OPcache preloading of core classes for FrankenPHP workers, a compiled routing IR artifact that skips the live scan, cached ICU formatters and gettext catalogs, memoized config-format resolution, cached validation/model/session/RBAC/logging/event/translation/template hot paths, and a `core.config_check_freshness` production trust-cache mode.

### Fixes

- Routing and translation-manager state is reset between worker requests.
- The session redirect grace window and slot cache TTL are guarded against backward wall-clock steps.
- Gettext plural forms selected the wrong `msgstr`.
- Dead XML routing config path removed.

## 1.2.x

Packaging and release-tooling fixes: per-output-type template resolution in app introspection, and several `composer.json` corrections for the split packages.

## 1.0.0

The first stable release.

- Declarative `plugins.xml`/`middleware.xml` config with attribute-gated plugin activation.
- The [authentication foundation](/advanced/authentication-authorization/) — form login, HTTP Basic, JWT and OIDC.
- Array-shape schema validation and position tracking for all config types.
- A compiled route/module/triad introspection artifact for the VS Code extension.
- Plain-class MCP attribute discovery with a discovery-cache warmup.
- `getPdo()` on every database adapter, for raw SQL access.
- PHPStan raised to level 8 across framework and test suite.
- **breaking** — Strict-mode bypasses closed in `getParameters()`, `isSimple()` and headers.
- **breaking** — Custom middleware placement defaults to after `ValidationMiddleware`.
- **breaking** — `WebRequest` decomposed into immutable collaborators.
- **breaking** — Plugin names resolve from the `#[Plugin]` attribute, not `PluginInterface::name()`.
