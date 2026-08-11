# Worker mode & deployment

> Running Quiote under a persistent worker runtime — FrankenPHP, RoadRunner, Swoole or the plain SAPI — the worker loop, per-request reset, what changes off-SAPI, state-leak hazards, and Docker.

Quiote's primary deployment shape is a **persistent worker**: the application is bootstrapped once per worker process and stays resident in memory, and each HTTP request reuses that warm process. This is what makes Quiote fast — no per-request bootstrap — and it is also the single thing that most changes how you must write code, because state now outlives a request.

Which *server* provides that persistent process is a choice, not a fixed part of the framework. Quiote ships a **worker-runtime seam**: four runtimes are available today (the plain SAPI, FrankenPHP, RoadRunner and Swoole), the same application code runs under all of them, and the kernel picks one at startup.

This page covers how a runtime is selected, how the worker loop runs, what the framework resets between requests, what changes when you leave the PHP SAPI, and how to deploy with Docker. For the request path *within* one request, see [The request lifecycle](/architecture/request-lifecycle/).

## Choosing a runtime

| | `sapi` | `frankenphp` | `roadrunner` | `swoole` |
|---|---|---|---|---|
| Ships in | core | core | `quioteframework/worker-roadrunner` | `quioteframework/worker-swoole` |
| Process persists | no | yes | yes | yes |
| Detected automatically | always (fallback) | `frankenphp_handle_request()` exists | `$RR_MODE=http` | **no** — needs `$QUIOTE_WORKER_RUNTIME=swoole` |
| Populates superglobals | yes | yes | no (framework hydrates) | no (framework hydrates) |
| `header()` / `echo` work | yes | yes | no | no |
| SSE streaming | yes | yes | yes | yes |
| Detects client disconnect | yes | yes | **no** | yes |
| Entrypoint | `pub/index.php` | `pub/index.php` | `worker.php` + `.rr.yaml` | `swoole.php` |

If you have no particular reason to choose otherwise, **FrankenPHP**: it is a real SAPI, so nothing in the "what changes off-SAPI" section below applies, and it needs no extra package or entrypoint.

Swoole is the one runtime requiring an explicit opt-in, and deliberately so: `extension_loaded('swoole')` is *not* evidence of running **under** a Swoole server — the extension is routinely loaded under php-fpm — so auto-claiming on it would hijack every FPM request on such a box. RoadRunner's `$RR_MODE` is set by the server itself, which makes it a valid implicit signal.

### How the kernel picks one

Highest precedence first:

1. The `worker_runtime` option passed to `Kernel::create()`.
2. `$QUIOTE_WORKER_RUNTIME`.
3. The `core.worker_runtime` setting.
4. Auto-detection — every registered runtime is asked `isSupported()`, and the highest `detectionPriority()` among those claiming the process wins. `SapiRuntime` sits at `PHP_INT_MIN`, so it is the fallback and detection always resolves.

A runtime named **explicitly** that turns out not to be hosting the process is a **startup error**, not a silent fallback — and the error names the signal it looked for. Silently downgrading a production RoadRunner deployment to one-request-per-process is a far worse outcome than refusing to start. Use `auto` if you want detection.

Application code that needs to know asks `Quiote\Runtime\Worker\WorkerRuntimeInfo` — `alias()` for which runtime, `isPersistent()` for the question most callers actually have. It answers correctly during bootstrap too (before a runtime has been installed) by falling back to detection.

## The front controller

The entrypoint is a plain PHP file — for the scaffolded app, `pub/index.php`. The same file serves as both the classic front controller *and* the FrankenPHP worker script; there is no separate worker template. It ends by handing off to the kernel:

```php
Quiote\Runtime\Kernel::create([
    'app_dir' => dirname(__DIR__),
    'env'     => getenv('QUIOTE_ENV') ?: 'development',
    'context' => 'web',
])->run();
```

`Kernel::run()` bootstraps the app once, selects a runtime, and hands it the request loop. Under a persistent runtime that loop serves requests until the host says stop; under `sapi` it handles one request and exits. The same code deploys both ways.

RoadRunner and Swoole are started by a PHP script rather than by a web server pointed at a document root, so they need a **second** entrypoint next to `pub/` — `worker.php` and `swoole.php` respectively, which are the same shape as `pub/index.php` with the runtime pinned. `quiote new --runtime=roadrunner|swoole` generates them; `pub/index.php` stays exactly as it is, so the same codebase still runs under FrankenPHP or php-fpm unchanged.

## The worker loop

Under a persistent runtime, the shape is:

```php
// conceptually, per runtime:
while ($runtime->acquireRequest($request)) {
    $response = $loop->handle($request);   // never throws
    $runtime->emit($response);
    $loop->afterRequest();                 // in a finally
}
```

- **`WorkerLoop::handle()`** dispatches the PSR-7 request through the context (`$context->handle($request)`) and returns a response. It never throws, so a broken request can't kill the worker.
- **`WorkerLoop::afterRequest()`** runs *after every request* and is the heart of worker-mode correctness. It resets per-request state so the next request starts clean, then flushes telemetry. It runs in a `finally`, so state is reset even when emission itself fails.

The runtime owns both ends — acquiring the request and emitting the response — because that is precisely what differs between hosts. Everything in between is the shared `WorkerLoop`, which is why each runtime is well under a hundred lines. The request is rebuilt on every iteration rather than reused, so request-scoped data never carries over by accident.

## Per-request reset

Two layers cooperate to clear state between requests.

**`WorkerManager::resetForNextRequest()`** is the top-level orchestrator. In order, it:

1. Increments the request counter and reset statistics.
2. Calls `$context->reset()` (the real state clearer, below).
3. Resets the routing callback pool.
4. Every *N* requests (`QUIOTE_MAX_REQUESTS`, default 1000) runs a deeper cleanup — full callback-pool clear plus repeated GC.
5. Forces `gc_collect_cycles()`.

Config is deliberately **not** reset — it is treated as immutable for the worker's lifetime.

**`Context::reset()`** does the per-request clearing, and the *order* matters:

- Clears cached singleton model instances and the slot dispatcher.
- Calls `flushRequestState()` as a **backstop**. Normally this is a no-op: `SessionMiddleware` already claimed the flush on the pipeline unwind, which is the point — by the time `reset()` runs the response has been emitted, and a session write then goes nowhere. The backstop covers requests that never reached the middleware.
- Walks a shutdown sequence, skipping the user (owned by the flush above, and shutting it down twice would double-write). The database manager **recycles connections** (ping and drop dead ones) rather than fully closing — the manager stays warm to avoid re-init cost.
- **Nulls the session bag.** A bag surviving the request boundary would serve request *N*'s session to request *N+1* — a cross-user leak. The next request's `SessionMiddleware` binds its own, and until it does `SessionBagInterface` resolves to a `NullSessionBag`.
- Nulls `user` and `request`.
- Resets the routing object — explicitly, to prevent route-cache corruption across requests. `Routing` implements `ResetInterface` for exactly this; without it, `Context::reset()`'s `instanceof ResetInterface` guard would silently skip it, leaking compatibility-shim state (input path, initialized flag) across requests.
- Resets the translation manager — clears the cached locale, timezone, and currency, so a `setLocale()` call made while handling one request (e.g. a language switcher) can't leak into the next request on the same worker.
- Calls `$container->reset()` — which drops only **request-scoped** DI entries; singletons and definitions stay warm (that is what keeps the container fast).
- Calls `LogContext::clear()` — drops the ambient logging scopes (correlation id, user) so request *N*'s identifiers never appear on request *N+1*'s log lines.

## What changes when you leave the SAPI

RoadRunner and Swoole run under the **CLI SAPI**, which is a bigger shift than "same app, different server". PHP's own request plumbing simply isn't there: nothing fills `$_SERVER`, and `header()`/`echo` have nowhere to go. Quiote absorbs most of that — the framework hydrates superglobals from the PSR-7 request and captures stray output — but not all of it.

**This section only applies to `roadrunner` and `swoole`.** Under `sapi` and `frankenphp`, none of it does.

- **Superglobals are hydrated, not native.** `$_SERVER`, `$_GET`, `$_POST` and `$_COOKIE` are filled from the PSR-7 request before the pipeline runs and cleared at the request boundary, so `Routing`, ext/session and other legacy readers keep working unchanged.
- **`$_FILES` has no `tmp_name`.** A PSR-7 upload may be backed by a stream with no file behind it. Use `$request->getUploadedFiles()`. Under Swoole, temp files are additionally deleted when the request ends, so `moveTo()` must happen *during* the request — an upload cannot be handed to a queued job.
- **`header()` and `setcookie()` are no-ops.** Set headers on the PSR-7 response. Sessions need no special handling here — the session cookie rides the PSR-7 response like any other header, so nothing has to be synthesised off-SAPI.
- **`echo` outside a template is captured**, not sent, and folded onto the response body per [`core.worker.stray_output`](/architecture/settings-reference/#worker-runtime) (`append`, `discard`, `throw`). Under RoadRunner this is a correctness matter and not a tidiness one — stdout *is* the protocol relay.
- **Log to stderr, not stdout**, for the same reason. Point stream sinks at `php://stderr`; RoadRunner forwards worker stderr to its own log.
- **Swoole runs with coroutines off**, in `SWOOLE_BASE`. `Config`, `Context`, `PluginManager`, `RoutingCallbackPool`, `LogContext` and the hydrated superglobals are all process-global, so interleaved requests would cross-contaminate them — log lines attributed to the wrong request, one user's context serving another's. **Scale with `worker.swoole.worker_num`, not with coroutines.** Setting `worker.swoole.enable_coroutine` raises an error naming the unsafe state.
- **Swoole forks its workers after bootstrap**, so each child drops the database connections it inherited (`WorkerLoop::bootWorker()`, wired to `workerStart`). This is automatic; it matters only because it explains why a custom runtime would need to declare the `forksWorkers` capability.

### Worker recycling

Leave recycling to the server and keep `core.worker.max_requests` at its default of `0`. RoadRunner (`http.pool.max_jobs`, `max_worker_memory`) and Swoole (`worker.swoole.max_request`) recycle workers themselves, and a PHP-side stop mid-pool looks to them like a crashed worker.

### Behind a proxy

`X-Forwarded-Proto`/`-Host`/`-Port`, `X-Original-Host` and RFC 7239 `Forwarded` are applied to the request by default. There is **no trusted-proxy allowlist** — they are trusted unconditionally — so set [`core.proxy.trust_forwarded_headers`](/architecture/settings-reference/#worker-runtime) to `false` when the app is reachable directly from the internet.

## State-leak hazards

A resident process turns several ordinary patterns into bugs. The framework guards the ones it owns; the rest are on you.

| Hazard | Framework mitigation | Your responsibility |
|---|---|---|
| Singletons holding request data | `Context::reset()` nulls request/user/session bag and clears model singletons | Don't cache request-derived data on a singleton service ([scope it](/architecture/container/) request or transient) |
| Session state persisting/leaking | No process-global session id and no `$_SESSION` — there is nothing to inherit. The bag is per-request and nulled at the boundary | Mutate the user *above* `SessionMiddleware`; anything below it runs after the flush |
| DI request-scoped instances | `Container::reset()` clears them each request | Register stateful services as `SCOPE_REQUEST`, not singleton |
| Logging context leak | `LogContext::clear()` each request | Use the logging context API, not static fields |
| Stale DB connections / open transactions | `recycleConnections()` each request | For strict rollback, use `WorkerManager::manageDatabaseConnections('reset')` |
| Proxy-derived `$_SERVER` | Re-derived per request from forwarded headers before the request is built | — |
| Unbounded memory growth | Periodic deep cleanup + GC every request | Don't accumulate into static arrays without bounds |

The one rule that prevents most worker-mode bugs: **do not store request-scoped data on anything that lives longer than the request.** When in doubt about a service, prefer request or transient scope — see [The DI container](/architecture/container/#scopes).

:::caution[The `CacheManager` version memo is not auto-reset]
`CacheManager` keeps an in-process memo of namespace versions that is *not* cleared by the worker reset. In a multi-worker deployment, a version bumped by one worker may not be seen by another until its memo is refreshed. If you rely on cross-worker cache invalidation being instant, call `CacheManager::reset()` or design around TTLs. See [Caching](/basics/caching/#worker-mode-and-invalidation).
:::

## Sessions across multiple hosts

Sessions are **file-backed by default** — `Quiote\Session\FileSessionFactory`, writing to `cache/sessions`. That is correct for a single host, and for any deployment where every host mounts the same filesystem.

It is wrong the moment you put two hosts behind a load balancer without one. A user's session file exists on whichever host served the request that created it; the next request lands elsewhere, finds nothing, and the user appears logged out at random. Sticky sessions paper over it until a host is recycled.

For a multi-host deployment, either:

- **give every host the same filesystem** — a shared volume, NFS, EFS — and keep `FileSessionFactory`; or
- **point the `session` slot at a shared backend**: [PDO](/basics/sessions/#database-backed-sessions), [Redis](/basics/sessions/#redis-backed-sessions), or [S3/GCS/Azure](/basics/sessions/#cloud-object-storage-backends).

This is a one-line config change either way — see [Sessions](/basics/sessions/#available-backends) for the full backend list. Note that container filesystems are ephemeral: a session directory inside the container, with no volume behind it, loses every session on redeploy even on a single host.

## Environment variables

Quiote reads a handful of `QUIOTE_*` variables directly, mostly at bootstrap and in worker mode. The ones you actually set in deployment:

| Variable | Default | Effect |
|---|---|---|
| `QUIOTE_ENV` | `development` (sample) / `prod` (kernel) | Environment name; selects env-specific config. |
| `QUIOTE_CONTEXT` | `web` | The context to bootstrap. |
| `QUIOTE_APP_DIR` | upward search | Application root (used by the CLI and bootstrap). |
| `QUIOTE_MAX_REQUESTS` | `1000` | Requests between deep cleanups (callback-pool clear + GC). Overrides `core.worker.cleanup_interval`. |
| `QUIOTE_WORKER_RUNTIME` | unset | Force a runtime (`sapi`, `frankenphp`, `roadrunner`, `swoole`). **Required for Swoole.** |

The runtime itself is also configurable from settings — `core.worker_runtime`, `core.worker.max_requests`, `core.worker.cleanup_interval`, `core.worker.stray_output` and `core.proxy.trust_forwarded_headers`. See [Settings reference: Worker runtime](/architecture/settings-reference/#worker-runtime).

Additional `QUIOTE_*` variables exist for finer control — APCu config caching (`QUIOTE_USE_APCU_CONFIG_CACHE`, `QUIOTE_APCU_PREWARM`), DI-migration toggles (`QUIOTE_NO_CONTAINER_ALL`, `QUIOTE_CONTAINER_DEPRECATION_STRICT`, and related), and the test-isolation family (`QUIOTE_TESTING_*`, `QUIOTE_ISOLATION_*`, see [Testing](/advanced/testing/)). These are advanced knobs; the four above are what a normal deployment touches.

## Writing a custom runtime

Implement `Quiote\Runtime\Worker\WorkerRuntimeInterface` and register the alias on `WorkerRuntimeRegistry` from your plugin — the same seam the two off-SAPI packages use:

```php
WorkerRuntimeRegistry::register('mysrv', MyServerRuntime::class);
```

A runtime declares four static facts (`isSupported()`, `alias()`, `detectionPriority()`, plus `capabilities()`) and one method that serves requests, `run(WorkerLoop $loop)`. `WorkerRuntimeCapabilities` is what tells the shared loop which compensations to install — `persistent`, `populatesSuperglobals`, `sapiOutput`, `streaming`, `forksWorkers` — so you declare what your host can do rather than reimplementing the bridging. `WorkerRuntimeCapabilities::sapi()` is the correct answer for anything that is a real SAPI.

:::note[Migrating from `WorkerAdapterInterface`]
`Quiote\Runtime\Worker\WorkerAdapterInterface`, `FrankenPhpWorkerAdapter` and `SingleRequestAdapter` have been **removed**.

- A custom adapter becomes a `WorkerRuntimeInterface` implementation registered on `WorkerRuntimeRegistry`. The runtime now owns both request acquisition and response emission; everything between them lives in the shared `WorkerLoop` it is handed.
- Code asking "am I in worker mode?" via `FrankenPhpWorkerAdapter::isSupported()` should ask `WorkerRuntimeInfo::isPersistent()`, which answers for every host and works during bootstrap by falling back to detection.
- `Quiote\Runtime\HttpEmitter` still exists, now as a subclass of `Quiote\Runtime\Emitter\SapiEmitter`.
:::

## Running under FrankenPHP

The Caddyfile declares the worker entrypoint and how many resident workers to run:

```text
{
    frankenphp {
        worker {
            file /app/pub/index.php
            num 2
        }
    }
}

:80 {
    root * /app/pub
    encode zstd gzip
    php_server
}
```

`num` is the number of resident worker processes. Start with one per CPU core and tune under load.

## OPcache preloading

Worker mode already keeps the app bootstrapped in memory between requests, but each **new** worker process still pays autoloading + reflection-based autowiring for the `Quiote\*` core classes on its first request. `etc/opcache/preload.php` compiles those classes into the shared OPcache SHM arena once, at PHP process startup, so every worker starts warm instead of re-autoloading on its first request.

The script walks `Quiote/` recursively, `require_once`-ing every file that declares a class/interface/trait/enum (procedural bootstrap files like `Quiote/version.php` are skipped, since they set config values at include time rather than declaring a type) and swallowing `\Throwable` per-file — a class whose parent lives in an optional PHP extension (e.g. an XSLT processor subclass, when `ext-xsl` isn't installed) is skipped with a `stderr` warning rather than aborting preload for the whole process.

It's deliberately scoped to `Quiote/` only — the renderer/db-adapter/auth/telemetry plugin packages under `packages/*` are `require-dev`-only (see `composer.json`'s `suggest` block) and won't exist in a production install, or may depend on optional extensions.

Enable it via `php.ini`:

```ini
opcache.preload=/app/etc/opcache/preload.php
opcache.preload_user=root   ; required whenever the master process starts as root
```

:::caution[Requires a production install]
Preloading against a `composer install` that still has dev dependencies present can emit `"Can't preload unlinked class"`/`"Cannot redeclare class"` warnings from require-dev-only packages' own autoload entries (e.g. `illuminate/reflection`, `cycle/database`, pulled in only by the db-eloquent/db-cycle plugin test suites). These are unrelated to the `Quiote/`-only preload loop itself, and go away once you run `composer install --no-dev`, which the shipped `Dockerfile` already does before preloading.
:::

## Docker

The framework ships a `Dockerfile` on top of `dunglas/frankenphp`. In order, it:

1. Starts `FROM dunglas/frankenphp`.
2. Installs the PHP extensions Quiote needs — **`intl`** (i18n formatters) and **`xsl`** (XSLT rendering and XML config transforms).
3. Installs dependencies with `composer install --no-dev`.
4. Writes an `opcache.preload` ini directive pointing at `etc/opcache/preload.php` (see [OPcache preloading](#opcache-preloading) above).
5. Copies the `Caddyfile` and runs FrankenPHP.

```dockerfile
FROM dunglas/frankenphp

RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libicu-dev libxslt1-dev \
    && docker-php-ext-install intl xsl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . /app/
RUN composer install --no-interaction --no-progress --prefer-dist --no-dev

# Preload the Quiote\* core classes into OPcache once at PHP process startup
# so every FrankenPHP worker starts warm instead of re-autoloading on its
# first request. See etc/opcache/preload.php.
RUN { \
        echo "opcache.preload=/app/etc/opcache/preload.php"; \
        echo "opcache.preload_user=root"; \
    } > "$PHP_INI_DIR/conf.d/preload.ini"

COPY Caddyfile /etc/frankenphp/Caddyfile
EXPOSE 80
CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]
```

:::caution[The Caddyfile path is `/etc/frankenphp/Caddyfile`, not `/etc/caddy/Caddyfile`]
`dunglas/frankenphp` reads its configuration from `/etc/frankenphp/Caddyfile`. An image that copies the Caddyfile to `/etc/caddy/Caddyfile` has it **silently ignored** — no error, no warning — and FrankenPHP starts in classic mode rather than worker mode. The symptom is a working app that is simply slow, with none of the resident-process benefits, which is easy to misread as a performance problem rather than a configuration one.

If you inherited a Dockerfile from elsewhere, check this first. Confirm the mode by looking for the worker count in FrankenPHP's startup log.
:::

To run it with the provided `docker-compose.yml`:

1. Build the image:
   ```bash
   docker compose build
   ```
2. Start the stack (the sample maps host `8080` → container `80`):
   ```bash
   docker compose up
   ```
3. Visit `http://localhost:8080/`.

The compose file mounts the app for live editing and adds an HTTP healthcheck; strip both for a production image.

## Running under RoadRunner

Install the package and activate its plugin — installing the package alone switches nothing on:

```bash
composer require quioteframework/worker-roadrunner
composer require --dev spiral/roadrunner-cli && vendor/bin/rr get-binary
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Runtime\RoadRunner\WorkerRoadRunnerPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Runtime\RoadRunner\WorkerRoadRunnerPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml — inside <ae:configuration> -->
<plugin class="Quiote\Runtime\RoadRunner\WorkerRoadRunnerPlugin" />
```

`quiote new --runtime=roadrunner` generates the two files it needs; for an existing app, add them by hand:

```php
// worker.php, in the application root
<?php
require __DIR__ . '/vendor/autoload.php';

Quiote\Runtime\Kernel::create([
    'app_dir'        => __DIR__,
    'env'            => getenv('QUIOTE_ENV') ?: 'production',
    'worker_runtime' => 'roadrunner',
])->run();
```

```yaml
# .rr.yaml
version: "3"
server:
  command: "php worker.php"
http:
  address: "0.0.0.0:8080"
  middleware: ["static", "gzip"]
  pool:
    num_workers: 0   # one per CPU
    max_jobs: 1000
logs:
  mode: production
```

Then `rr serve`, or `quiote serve --runtime=roadrunner`. Pinning `'worker_runtime' => 'roadrunner'` is belt-and-braces (detection already works off `$RR_MODE`) but worth keeping: an explicit runtime that turns out not to be hosting the process fails at startup instead of quietly degrading to one-request-per-process.

The package's only setting is `worker.roadrunner.chunk_size` (default `8192`) — an upper bound on bytes per streamed frame. Events smaller than that are still sent immediately, one frame each.

## Running under Swoole

```bash
pecl install swoole          # 5.1 or newer
composer require quioteframework/worker-swoole
```

`ext-swoole` is a Composer `suggest`, not a `require`, so the package installs and type-checks without it; the runtime raises an actionable error if you try to serve without the extension. Activate the plugin:

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Runtime\Swoole\WorkerSwoolePlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Runtime\Swoole\WorkerSwoolePlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml — inside <ae:configuration> -->
<plugin class="Quiote\Runtime\Swoole\WorkerSwoolePlugin" />
```

`quiote new --runtime=swoole` generates `swoole.php` in the application root — the same shape as `worker.php` above with `'worker_runtime' => 'swoole'`. Then run `php swoole.php`, or `quiote swoole:serve` / `quiote serve --runtime=swoole`, both of which set `$QUIOTE_WORKER_RUNTIME=swoole` for you.

| Setting | Default | Meaning |
|---|---|---|
| `worker.swoole.host` | `0.0.0.0` | Bind address. |
| `worker.swoole.port` | `8080` | Bind port. |
| `worker.swoole.worker_num` | `1` | Worker processes. **This is the concurrency knob.** |
| `worker.swoole.max_request` | `0` | Requests before Swoole recycles a worker. `0` = never. Use this rather than `core.worker.max_requests`. |
| `worker.swoole.package_max_length` | `8388608` | Max request body. Swoole silently truncates anything larger. |
| `worker.swoole.script_name` | `/index.php` | Value for `$_SERVER['SCRIPT_NAME']`. |
| `worker.swoole.ssl` | `false` | True only when Swoole itself terminates TLS. Behind a TLS-terminating proxy, leave it false and let the `X-Forwarded-*` handling do the work. |
| `worker.swoole.enable_coroutine` | `false` | See [above](#what-changes-when-you-leave-the-sapi) — raises an error. |
| `worker.swoole.allow_coroutine_unsafe` | `false` | Escape valve for that guard. You own the outcome. |

`worker.swoole.script_name` deserves its own sentence: Swoole supplies no `SCRIPT_NAME`, so it is synthesised from this setting, and `Routing` reads it when generating URLs. A wrong value produces **wrong links rather than an error**, so check it if generated URLs come out malformed.

:::note[OpenSwoole is not supported]
It is an API-divergent fork (`OpenSwoole\Http\Server`, a separate extension). The extension surface is deliberately confined to three classes, so adding it later is a small job — but it is not claimed today.
:::

## Deploying without worker mode

Because the runtime is chosen at startup, the same app runs under classic PHP for environments where none of the above is an option — behind PHP-FPM with `try_files … /index.php`, or `php -S localhost:8000 pub/index.php` for a smoke test. That is the `sapi` runtime: you lose the warm-process speedup, but nothing in your application changes. `Caddyfile.example` at the repo root is a non-worker production template with real TLS, security headers, and access logging.
