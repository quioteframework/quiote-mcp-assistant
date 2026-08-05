# Upgrading to 4.0

> 4.0 breaks Context into the collaborators it was standing in for — what changes for application code, and the one thing that fails hard.

4.0 breaks `Context` into the collaborators it was standing in for. **Nothing here requires application changes** — the accessors still exist and still work — with one exception, which is first because it fails hard.

:::caution[In progress]
4.0 is under development. This page tracks what has already landed; treat it as the running list rather than a final one.
:::

Coming from 3.0 or 3.1? Read [Upgrading to 3.2](/getting-started/upgrading-to-3-2/) first — that release is where the breaking contract changes are.

## Clear the config cache once

The one thing to do on the way in. Delete the cache directory (`core.cache_dir`, plus the system-temp fallback if that was unset) or run `cache:warmup` once.

From 4.0 onward this is automatic: every config cache key now includes a **framework fingerprint**, so a framework upgrade recompiles by itself. But a fingerprint cannot retroactively invalidate a cache compiled before it existed, and the compiled `factories` file changed shape in this release — a stale one fails at boot, reporting whatever its contents happen to break first rather than the staleness.

See [Configuration: a framework upgrade invalidates the cache](/architecture/configuration/#a-framework-upgrade-invalidates-the-cache) for how the fingerprint is derived, and for the one layout — a framework installed under a different package name — where you have to set `core.config_cache_fingerprint` yourself.

## Compiled configuration is data, not code

This is the change the cache clear is for, and it's worth understanding only if you read or generate compiled config.

The compiled `factories` file used to be executable PHP that was `include`d *inside* `Context::initialize()`, so it had full private access to the context and assigned straight to its properties. It now returns a declaration — an ordered operation list, the factory definitions, and the shutdown order — which `ComponentInstaller` carries out before handing the components back by role. `databases`, `output_types` and `translation` were converted the same way. No config handler emits code that touches its includer any more.

**What this changes for you.** Nothing, unless you read a compiled file directly or generated one yourself. The `factories.{xml,yaml,php}` source format is untouched. Two internals are gone: the per-component `*FactoryInfo` properties on `Context` (`requestFactoryInfo`, `userFactoryInfo`, …), and any reliance on a compiled file assigning into its includer.

## Every config handler compiles to data — breaking if you wrote one

This generalizes [compiled configuration is data, not code](#compiled-configuration-is-data-not-code) above to every config kind, not just `factories`/`databases`/`output_types`/`translation`: `settings`, `module`, `plugins`, `middleware` and `validators` compile to declarations too, and the last `eval()`s in the configuration cache (`APCuConfigCache::load()`'s statement path, and `module.xml`'s handling in `Controller`) are gone. Application config files — `Config/*.{xml,yaml,php}` — are unaffected either way.

**Breaking only if you wrote your own config handler:**

- `IXmlConfigHandler::execute()`, `IArrayConfigHandler::executeArray()` and `ILegacyConfigHandler::execute()` now return `mixed` — the declaration — not a string of generated PHP.
- `Quiote\Config\BaseConfigHandler::generate()` is removed. Return the declaration directly instead of wrapping it yourself.
- `Quiote\Config\ConfigCache::writeCacheFile()` takes `(string $config, string $cache, mixed $value, ?string $generatedBy = null)` — no `$append` parameter.
- A handler registered for `ConfigCache::load($path)` (one that mutates global state, rather than being read with `CompiledConfig::value()`) must implement `Quiote\Config\IDeclarationConfigHandler` and move what its generated statements used to do into `apply(mixed $declaration, string $sourceRef): void`. `load()` rejects a handler that doesn't implement it, naming the handler.
- `APCuConfigCache::checkConfig()` throws while APCu is in use, since there's no longer a cache *file* to hand back a path to — read a compiled value with `CompiledConfig::value()` instead of assuming a path.

See [writing your own config handler](/architecture/configuration/#writing-your-own-config-handler) for the two paths and which one applies.

## `Context` is growing seams, not losing accessors

Three collaborators are now separate classes, each bound in the container so new code can constructor-inject it instead of reaching through the context. Every accessor listed below still works.

| Instead of | Inject |
|---|---|
| `$context->getModel(…)` | `Quiote\Model\ModelLocator` |
| `Context::getInstance('web')` | `Quiote\ContextRegistry` |
| `$context->getRequest()` / `setRequest()` | `Quiote\Request\RequestState` |
| `$context->getUser()` | `Quiote\User\CurrentUser` |

See [injecting instead of reaching through the context](/architecture/container/#injecting-instead-of-reaching-through-the-context) for the full table, including `ShutdownSequence`, `ContextRequestHandler` and `ContextLifecycle`.

### `Context::handle()` moved behind a real PSR-15 handler

`Context::handle()` still works and is what every runtime calls. The per-request work — owning the middleware pipeline, resolving the correlation id, opening the ambient logging scope, arming the request-state flush, emitting `ResponseSendingEvent` — now lives in `Quiote\Runtime\ContextRequestHandler`, which **declares** `RequestHandlerInterface` rather than merely matching its signature.

Two internals moved with it:

- **`Context::$psrKernel` is gone.** Reach the pipeline with `$context->getRequestHandler()->pipeline()`, and drop a stale one with `forgetPipeline()` — needed by anything that reconfigures `MiddlewareCatalog` after a request has been served, since the pipeline is composed once and reused.
- **`Context::$correlationId` is gone**; `getCorrelationId()` reads it from the handler.

See [the request lifecycle](/architecture/request-lifecycle/#2-enter-the-pipeline--contexthandle).

### The execution helpers are container-scoped

`getSlotDispatcher()`, `getAssetRegistry()` and `getActionResolver()` resolve through the container instead of lazy properties, so their lifetimes are declared rather than maintained by hand: the action resolver is a process-lifetime singleton, and the asset registry and slot dispatcher are request-scoped, so the container drops them at the request boundary — which two manual nulls in `reset()` used to do. All three are injectable.

### Which one to inject for the request and the user

They look alike and are not.

**The user is stable within a request.** It's replaced only at the worker request boundary, never mid-request, so anything built per execution — an action, a view, a validator — can inject `SecurityUser` (or `User`, or `ISecurityUser`) and hold it.

**The request is not.** `WebRequest` is immutable, so every mutation produces a new instance and the request is replaced many times per request — validation alone replaces it. A held request is a snapshot, and a construction-time snapshot is the *pre-validation* one, so reading a parameter from it bypasses the strict-validation whitelist. Inside an action or view, use the `WebRequest` parameter already passed to `execute*()`; it's current by construction.

**A singleton can hold neither**, and the container refuses that wiring outright — see [a singleton cannot depend on request-scoped state](/architecture/container/#a-singleton-cannot-depend-on-request-scoped-state). Inject `RequestState` or `CurrentUser` there.

## New: `ContextLifecycle`, and plugins can hook the end of a request

`Quiote\ContextLifecycle` owns a context's per-request state machine — armed, claimed, cleared, armed again. Reach it with `Context::getLifecycle()`.

Anything holding request-scoped state of its own — a per-request cache, a memo keyed on the current user — previously had no way to clear it, so that state survived into the next request in a persistent worker:

```php
PluginManager::addRequestEndClear('my per-request cache', function (): void {
    MyCache::forgetRequestState();
});
```

Contributed clears run after the framework's own, so a plugin cannot displace the identity clears that go first. Each is independently guarded. See [Plugins: clearing your own state](/architecture/plugins/#clearing-your-own-state-at-the-end-of-a-request) and [the request boundary](/architecture/request-lifecycle/#the-request-boundary).

## Validators can declare constructor dependencies

Validator construction goes through the container, so a validator may take collaborators like anything else. Purely additive: a validator with no constructor — every one the framework ships, and every one written before this — is `new`'d directly.

`Container::make()`, `ValidationManager::createValidator()` and `ValidatorFactory::create()` are now generic in the class they're given, so a caller naming a concrete class gets that type back instead of `object`. See [custom validators: constructor dependencies](/advanced/custom-validators/#constructor-dependencies).

## Fixed: an unregistered class defaulted to singleton scope

An autowired class with no `#[Service]` attribute and no `ServiceInterface` used to resolve as `SCOPE_SINGLETON` — the container's most dangerous default, since a singleton keeps whatever it was handed at construction for the life of the worker. `Context` registers `request`, `user` and `sessionBag` as request-scoped under both their role name and their concrete class, so an ordinary app service constructor-injecting `RbacSecurityUser` or `WebRequest` hit exactly the cross-user identity leak `Context::clearRequestScopedState()` exists to prevent — through the one path clearing can't reach.

An unregistered, autowired class now defaults to `SCOPE_REQUEST` instead. Opt back into process lifetime explicitly, once you've confirmed the class holds no per-request state: `#[Service(scope: Container::SCOPE_SINGLETON)]`, or an explicit `set()`.

This is also what makes the [captive-dependency guard](/architecture/container/#a-singleton-cannot-depend-on-request-scoped-state) — refusing to autowire a *declared* request-scoped service into a *declared* singleton — sufficient rather than half a fix: the guard alone couldn't have caught an implicit singleton depending on an implicit request-scoped service, since neither side had declared anything. The guard still keys off declared scope only; the new default cannot itself trigger it, or every singleton autowiring an ordinary unregistered helper would throw. See [what a class gets when nothing says otherwise](/architecture/container/#what-a-class-gets-when-nothing-says-otherwise).

**Breaking**, in the strict sense: an unregistered class that happened to work as a singleton before — because nothing exposed the bug — now tears down at the request boundary instead. If something depended on that instance surviving across requests, register it explicitly as a singleton.

## Fixed: a bare `#[Service]` defaulted to singleton scope, disagreeing with `ServiceInterface`

The two ways of marking a service didn't agree: `#[Service]` with no scope argument answered singleton, but `ServiceInterface` answered transient — and the attribute took precedence over the interface check, so adding `#[Service]` to an existing service purely for discoverability silently promoted it from transient to process lifetime. An edit that reads as a no-op changed the class's lifetime.

A bare `#[Service]` now defaults to `SCOPE_TRANSIENT`, agreeing with `ServiceInterface`. Process lifetime is still available, just as an explicit claim: `#[Service(scope: Container::SCOPE_SINGLETON)]`.

**Breaking** only if your code carries a bare `#[Service]` attribute and relied on the old singleton default. Nothing in the framework, the bundled packages, or the reference application used the bare form, so no in-tree behaviour changed. See [Services and models](/basics/services-and-models/#marking-a-service).

## Fixed: injecting `WebRequest` or `User` gave you a fresh, empty one

A defect, not a rename. The container bound each core service under its role name and its *concrete* class only. An application configures a `request` or `user` subclass, so the natural type-hint — `WebRequest`, `User` — was unregistered, and the container autowired a brand-new instance for it. A consumer asking for the request got one carrying none of the request's parameters, headers or body; one asking for the user got an unauthenticated stranger. Silently, in both cases.

The base classes are now bound alongside the concrete class, so `WebRequest`, `User`, `ISecurityUser`, `Routing`, `TranslationManager` and `DatabaseManager` all resolve to the request's real instance.

If you worked around this — resolving `'request'` by string, or type-hinting the subclass to get the real object — those still work and can now be simplified. **If you type-hinted the base class in a singleton, that wiring was silently broken and now throws at wiring time**, naming the accessor to use instead.

## Fixed: a failed context reset could leak the previous user

`Context::reset()` ran as one unguarded sequence, and the two assignments that clear identity sat *after* the controller reset, the user flush and the shutdown loop that recycles database connections. Any throwable from those — and a dead socket at a request boundary is the ordinary case — aborted the reset before identity was cleared. The next request in that worker got a fresh session bag but the previous request's `SecurityUser`, still authenticated, roles intact.

Identity is now cleared first and unconditionally, in a `finally`, and each remaining component reset is separately guarded. Nothing to do; worth knowing if you run workers.

## Two things that were private are now public API

Because a test or an embedding host had no honest way to reach them:

- **`Context::getShutdownSequence()`** replaces reflection on the `$shutdownSequence` property, which is no longer an array. Use `append()`, `remove()`, `replaceRole()` and `all()`.
- **`Context::create()`** is the named constructor `ContextRegistry` builds through. A subclass named by `core.context_implementation` must keep the constructor signature — that was always true, and is now declared.

## Checklist

- [ ] Clear the config cache once, or run `cache:warmup`
- [ ] Check for anything reading a compiled config file, or the `*FactoryInfo` properties on `Context`
- [ ] If you wrote a custom config handler: update its `execute()`/`executeArray()` to return the declaration, drop any use of `BaseConfigHandler::generate()`, and implement `IDeclarationConfigHandler` if it's registered for `ConfigCache::load()`
- [ ] Check for `Context::$psrKernel` / `Context::$correlationId` access, including by reflection
- [ ] Check singletons type-hinting `WebRequest`, `User` or `ISecurityUser` — those now throw at wiring time; inject `RequestState` / `CurrentUser`
- [ ] Check anything relying on an unregistered, unannotated class behaving as a singleton — it's now request-scoped by default; register it explicitly if it must survive across requests
- [ ] Check for a bare `#[Service]` (no `scope:` argument) that relied on the old singleton default
- [ ] Register a request-end clear for any request-scoped state your own code holds
