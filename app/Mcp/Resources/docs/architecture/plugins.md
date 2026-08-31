# Plugins and extensibility

> The plugin system — one lifecycle that lets a package contribute config, services, middleware, routes, events, commands, and HTTP clients.

Quiote's core is deliberately [unopinionated](/getting-started/philosophy/). The plugin system is how opinionated, batteries-included behaviour drops in on top of it: a self-contained package contributes to the framework through one `register()` call, and the app opts in by listing it.

A plugin adds **no new low-level mechanism**. Every contribution routes to a seam that already exists — [config](/architecture/configuration/) defaults, [DI](/architecture/container/) services, [middleware](/architecture/middleware-pipeline/), [events](/architecture/events/), routes/modules, commands, and [HTTP clients](/basics/http-client/). The plugin system just wraps those seams in one coherent, discoverable API.

:::note[Plugin vs. middleware]
A plugin runs its `register()` **once at boot** to wire capabilities in; a middleware runs **on every request** as a stage of the pipeline. A plugin can *contribute* middleware (among much else), but they're not the same thing — and you can add middleware without a plugin. See [Plugin vs. middleware](/plugins/overview/#plugin-vs-middleware) for the full comparison.
:::

<Aside type="tip" title="This is how the framework itself is built">
Plugins aren't just for your code — **many subsystems have been extracted from the kernel into their own `quioteframework/*` packages** (CSRF, rate limiting, the Whoops error page, the MCP server, OpenTelemetry, the telemetry dashboard, the Eloquent / Doctrine / Cycle / Propulsion adapters, template renderers, and session backends). Most ship a plugin like the ones described here; a few plug into a config-driven registry instead (renderers, database aliases). This page covers the mechanism and how to write your own; for the extracted packages and how to install them, see the [Plugins overview](/plugins/overview/) and [Official packages](/plugins/official-packages/).
</Aside>

## Writing a plugin

Implement `Quiote\Plugin\PluginInterface` — just a `register()` that receives a `PluginRegistrar` — and mark the class with `#[Quiote\Plugin\Attribute\Plugin]`, passing a `name` for diagnostics/logging:

```php
<?php
namespace App\Plugin;

use Quiote\Plugin\{PluginInterface, PluginRegistrar};
use Quiote\Plugin\Attribute\Plugin;
use Quiote\DI\Container;

#[Plugin(name: 'health')]
final class HealthPlugin implements PluginInterface
{
    public function register(PluginRegistrar $r): void
    {
        $r->configDefault('health.path', '/healthz')
          ->attributedMiddleware(\App\Plugin\Health\HealthMiddleware::class)
          ->service(HealthChecker::class, HealthChecker::class, Container::SCOPE_SINGLETON)
          ->listen(\Quiote\Event\Lifecycle\KernelBootEvent::class, fn($e) => /* ... */)
          ->command(\App\Plugin\Health\HealthCommand::class);
    }
}
```

`PluginInterface` itself declares no `name()` method — a plugin only has to implement `register()`. The `#[Plugin(name: '...')]` attribute's `name` argument is what `PluginManager::resolveName()` actually reads for diagnostics/logging; don't also add your own `name(): string` method to the class, since nothing would call it and you'd just be maintaining the same string twice.

If a plugin's name genuinely can't be a compile-time constant — computed from config, an environment value, or an instance the plugin was built with — implement `Quiote\Plugin\NamedPlugin` (`extends PluginInterface`, adds back `name(): string`) instead of passing `name` to the attribute. `resolveName()` prefers `NamedPlugin::name()` over the attribute when a plugin implements both. A plugin with **neither** a `NamedPlugin` implementation nor an attribute `name` fails fast at boot with a `QuioteException` naming both routes — it's never silently unnamed.

<Aside type="caution" title="`#[Plugin]` is mandatory for class-string activation">
Naming a class in `plugins.*` (or passing a class-string to `PluginManager::add()`) is **not, by itself, enough to activate it** — the class must also carry `#[Plugin]`. Without it, `PluginManager::instantiate()` refuses (logs, returns `null`) and the plugin never runs, even if it's correctly named in `plugins.php`. This is a deliberate supply-chain safeguard: merely `composer require`-ing a package can never activate anything in it, because the class itself must have already opted in at authoring time.

The check is **skipped** for `PluginManager::add(new HealthPlugin())` — passing an already-constructed instance is itself the trust boundary, since your own code named the class directly rather than routing it through a string that could originate from a config file. All official `quioteframework/*` plugin packages already carry the attribute — see [Official packages](/plugins/official-packages/).
</Aside>

`register()` is called **once at boot**. Each `PluginRegistrar` method is fluent (returns `$this`) and maps to an existing seam:

| Method | Contributes | Routes to |
|---|---|---|
| `configDefault($key, $value)` | A config default (set-if-absent) | `Config::set(…, overwrite: false)` |
| `service($id, $concrete, $scope, ...$aliases)` | A DI service (per container, if not already bound) | `Container::set()` |
| `middleware($fqcn, $factory, $after, $before, $priority)` | Middleware at a position | `MiddlewareCatalog::register()` |
| `attributedMiddleware($fqcn, $factory?)` | An attribute-ordered middleware | `MiddlewareCatalog::registerAttributed()` |
| `listen($eventClass, $listener, $priority)` | An event listener | `Events::listen()` |
| `moduleDirectory($dir)` | A module dir for `#[Route]` scanning | route scanner default set |
| `command($fqcn)` | A console command | console registry |
| `httpClient($name, $configurator)` | A named HTTP client | `HttpClientFactory::configure()` |
| `databaseDriver($alias, $adapterClass)` | A database adapter alias | `DatabaseDriverRegistry` (see [Databases](/basics/databases/)) |
| `developerExceptionRenderer($factory)` | The developer-mode exception renderer (set-if-absent) | `ExceptionRendererRegistry::setDeveloperRenderer()` |

### Say what scope your services have

`service()`'s `$scope` is nullable, and leaving it out asks the binding: a class name keeps the lifetime its own `#[Service]` declares (request scope if it declares none), a factory or closure is request-scoped, and an already-built instance or a bound value is a singleton. See [what an omitted scope means](/architecture/container/#what-an-omitted-scope-means).

**Write it out anyway.** A plugin's services are wired once at boot and then live in every application that enables it, under whatever runtime that application deploys — and the plugin author is the only person in a position to know whether the service holds per-request state. `Container::SCOPE_SINGLETON` on an object you have confirmed is stateless, `SCOPE_REQUEST` on anything that isn't, states that judgement where a reader of the plugin can see it:

```php
// Stateless: one HTTP client for the life of the worker.
$r->service(HealthChecker::class, HealthChecker::class, Container::SCOPE_SINGLETON);

// Holds the current request's findings: dropped at the request boundary.
$r->service(HealthReport::class, fn() => new HealthReport(), Container::SCOPE_REQUEST);
```

The one case for omitting it is a registration made purely to add an alias, where the point is to *not* disturb the class's declared lifetime.

### Clearing your own state at the end of a request

A plugin holding request-scoped state of its own — a per-request cache, a memo keyed on the current user — needs that state gone before the process serves the next request. Register a clear:

```php
use Quiote\Plugin\PluginManager;

PluginManager::addRequestEndClear('my per-request cache', function (): void {
    MyCache::forgetRequestState();
});
```

`Quiote\ContextLifecycle` runs these at the end of every request, **after** the framework's own clears, so a plugin cannot displace the identity clears (session bag, user, request) that go first. Each clear is independently guarded: one that throws is logged and stepped over, every other clear still runs, and so does the re-arm afterwards — a broken clear cannot cost the next request its state-flush claim.

Clears are keyed by label, so registering the same label twice replaces rather than clearing twice.

Under classic per-request PHP this is harmless but unnecessary; under a [persistent worker](/architecture/deployment/) it's the difference between per-request state and a leak. See [the request lifecycle](/architecture/request-lifecycle/#the-request-boundary).

### Clearing your own static state

Request-scoped state and *process*-scoped state are two different problems. A driver registry a plugin populates at boot must survive every request — but it must **not** survive `PluginManager::reset()`, which is what a test suite calls to get a clean process between cases. Register that clear from `register()`:

```php
$registrar->stateReset('my-driver-registry', static fn() => MyDriverRegistry::reset());
```

`PluginManager::addStateReset('label', $closure)` is the same seam from outside a plugin. Callbacks are keyed by label, so two plugins touching the same registry collapse into one call.

This replaced (in 4.2) a hard-coded call in `PluginManager::reset()` that cleared the filesystem driver registry by name — core reaching into one optional subsystem it happened to know about. A plugin that keeps static state and registers no reset leaks it between tests in the same process.

### How a plugin fits in a request

A plugin does **not** run on every request — it runs **once at boot**, and its job is to wire contributions into seams the framework already uses. After that, requests flow through those contributions as if the framework had shipped them itself:

1. **How the framework finds and runs it.** `PluginManager::bootFromConfig()` (called from `Quiote::bootstrap()`, after settings load) instantiates each activated plugin and calls its `register(PluginRegistrar)` exactly once. Each `PluginRegistrar` method hands its contribution to the matching registry — middleware to `MiddlewareCatalog`, services to the container, listeners to `Events`, routes to the module scanner, and so on.

2. **The path a request then takes.** Nothing plugin-specific happens at request time:

   > `Quiote::bootstrap()` calls each plugin's `register()` → contributions land in their registries → the middleware pipeline builds from the merged set → a request flows through that pipeline (`ErrorHandling` → … → `Routing` → `Security` → `Dispatch`) with the plugin's middleware, routes, and services participating like any other.

So a plugin's middleware is ordered by the same [attribute/catalog rules](/architecture/middleware-pipeline/#how-the-order-is-decided) as everyone else's, its routes are matched by the normal scanner, and its services resolve from the same [container](/architecture/container/). There is no separate plugin runtime to reason about.

## Registering a plugin

Two ways. **The correct, documented way** is a dedicated `Config/plugins.{xml,php,yaml,yml}` file (`Quiote\Config\PluginConfigHandler`) — a flat, ordered enable/disable list, resolved like any other config type (`.php` > `.yaml`/`.yml` > `.xml`):

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \App\Plugin\HealthPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: App\Plugin\HealthPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="App\Plugin\HealthPlugin" />
    </ae:configuration>
</ae:configurations>
```

`enabled` (PHP/YAML) / the `enabled="…"` attribute (XML) defaults to `true` when omitted, so a bare `['class' => ...]` entry is enough to turn a plugin on; set it to `false` to declare a class without activating it.

`enabled` can also be an [`%env(NAME)%` placeholder](/architecture/configuration/#env-placeholders-deciding-a-value-at-load-time) instead of a literal bool, so a container image ships one compiled config and a deployment turns the plugin on or off by setting a variable and restarting — no recompile:

```php
['class' => \App\Plugin\DebugToolbarPlugin::class, 'enabled' => '%env(DEBUG_TOOLBAR, false)%'],
```

This is a **drop-in**, the same way [declarative `middleware.xml`](/advanced/custom-middleware/#declarative-middlewarexml) is: any module's own `Config/` directory can carry its own `Config/plugins.*` (discovered by `Quiote::bootstrap()` globbing `core.module_dir`, no app wiring required), so a module registers its own plugins just by containing the file. Per-plugin options still live in `settings.*` (contributed by the plugin via `configDefault()`) — `plugins.*` only controls which plugins run and in what order. App-declared plugins are compiled first, so if the same class is declared by both the app and a module, the app's declaration wins.

Or **programmatically**, before the kernel runs:

```php
// pub/index.php — before Kernel::run()
use Quiote\Plugin\PluginManager;

PluginManager::add(App\Plugin\HealthPlugin::class);

Quiote\Runtime\Kernel::create([/* ... */])->run();
```

Either way, `register()` runs during `Quiote::bootstrap()` — **after settings load, before contexts are created** — in deterministic order: **programmatic `add()` calls first** (they happen before bootstrap), **then config order**. The list is de-duplicated by class, and the **first occurrence wins** (`PluginManager` stores each class with `??=`, so a later duplicate is ignored). A class-string reaching either path must carry `#[Plugin]` (see above) or it's silently refused.

<Aside type="note" title="A settings.* `plugins` key happens to work — don't rely on it">
`plugins.xml` and `PluginManager::add()` both ultimately land in the same `plugins` config key/registry, so a `<setting name="plugins">` entry (or a `'plugins' => [...]` line) inside `settings.*` happens to work too. That's an incidental consequence of the shared storage, not a supported interface — it's intentionally undocumented anywhere else, and the scaffolder and every example in this repo only ever write to `Config/plugins.*`. Use the dedicated file.
</Aside>

## Ordering and override rules

The rules are predictable and exist so a plugin can never silently override your application:

- **App settings load before plugins**, so `configDefault()` is *set-if-absent*: your `settings.*` always win, and a plugin only fills a key you left unset.
- **Among plugins, first writer wins** for both config defaults and DI services (also set-if-absent). Declared order decides who's first.
- **DI services** are applied per [container](/architecture/container/) when it's built, and only if the id isn't already bound — app and core bindings win.
- **Middleware** uses the normal [attribute / catalog ordering](/architecture/middleware-pipeline/) — a plugin's middleware is placed by the same rules as anyone else's, no special precedence.

So the precedence for anything contestable is, in order: **app, first plugin, later plugins, core defaults.**

## Current boundaries

A few contribution kinds work with documented limits (the mechanism is real and tested; these are scoped follow-ups):

- **Module routes** — a plugin's `moduleDirectory()` is scanned for `#[Route]` actions, but action FQCNs are derived from `core.namespace_prefix`, so a plugin's modules are discovered for routing only when they follow that namespace convention. Full multi-root module *resolution* in the controller (independent per-plugin namespaces) is future work — plugin modules are discovered for routing, not yet resolved from arbitrary roots.
- **Commands** — `bin/quiote` builds its console app *before* bootstrap, so plugin-contributed commands appear once a bootstrap has populated the registry in the same process (e.g. a programmatically constructed `Application` after `Quiote::bootstrap()`). Wiring `bin/quiote` to bootstrap first is a deliberate non-goal for now.

## The enablers

Two of the framework features the plugin system leans on are documented in their own right:

- **[Events](/architecture/events/)** — the lifecycle hooks a plugin listens to (via `register()`, calling `$r->listen(...)`).
- **[HTTP client](/basics/http-client/)** — named clients a plugin can pre-configure (`$r->httpClient(...)`).

Together these are the backbone of the "unopinionated core, opinionated drop-ins" design: the core stays lean, and anything with an opinion — an auth provider, health checks, a mailer — ships as a plugin you choose to add.

For copy-pasteable steps through the most common tasks — enabling a database adapter, turning on the Whoops error page, writing your own plugin or middleware — see the [Plugins & middleware quickstart](/plugins/quickstart/).
