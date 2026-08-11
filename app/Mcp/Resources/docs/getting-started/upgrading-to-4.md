# Upgrading to 4.0

> 4.0 breaks Context into the collaborators it was standing in for — what changes for application code, and the one thing that fails hard.

4.0 breaks `Context` into the collaborators it was standing in for, and **deletes the accessors that were standing in for them**. A class that needs the routing, the user, a model or a service says so in its constructor and lets the container hand it over. That is the change to plan for; `Quiote\Rector\Set\ContextDecompositionSetList` mechanically rewrites most of it.

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

## BREAKING: `Context`'s accessors are gone

`ContextInterface` declares two methods — `getName()` and `getContainer()` — where 3.2 declared seventeen, and `Context` itself is down from 39 public methods to 17. Every accessor that answered "some other service" has been deleted.

Each row's target is bound in the container under the class name shown, so `__construct(private readonly Routing $routing)` is the migration for most of them.

| Deleted | Inject | Notes |
|---|---|---|
| `getRouting()` | `Quiote\Routing\Routing` | rebuilt on demand in a worker, as the accessor did |
| `getController()` | `Quiote\Controller\Controller` | resolving one before `initialize()` throws, as before |
| `getRequest()` / `setRequest()` | `Quiote\Request\RequestState` | `current()` / `publish()`; resolves per call — see [which one to inject](#which-one-to-inject-for-the-request-and-the-user) |
| `getUser()` | `Quiote\User\User`, or `Quiote\User\CurrentUser` | which one depends on the holder's lifetime — same section |
| `getService($id)` | the service's own class | the container resolves it; there is no by-name lookup left |
| `getModel(…)` | `Quiote\Model\ModelLocator` | also `$context->getModelLocator()` |
| `getDatabaseManager()` / `getDatabaseConnection()` | `Quiote\Database\DatabaseManager` | `getDatabase($name)->getConnection()` |
| `getTranslationManager()` | `Quiote\Translation\TranslationManager` | |
| `getSessionManager()` / `setSessionManager()` | `Quiote\Session\SessionManager` | `Container::set()` / `unset()` to replace or drop one |
| `getSessionBag()` / `setSessionBag()` | `Quiote\Session\SessionBagInterface` | defaults to `NullSessionBag` when no session is configured |
| `getSlotDispatcher()` | `Quiote\Execution\SlotDispatcher` | request-scoped |
| `getAssetRegistry()` | `Quiote\Asset\AssetRegistry` | request-scoped |
| `getActionResolver()` | `Quiote\Execution\ActionResolver` | process-lifetime singleton |
| `getCurrentPsrRequest()` | `Quiote\Request\RequestState` | `current()` |
| `createInstanceFor()` | `Container::make()` | generic in the class it is given |
| `getFactoryInfo()` / `setFactoryInfo()` | — | the compiled factories declaration is internal now |
| `handle()` | `getRequestHandler()->handle()` | see below |
| `Context::getInstance('web')` | `Quiote\ContextRegistry` | `get()` / `has()` / `names()`; the static still exists |

What `Context` still answers is its own identity and lifecycle, which were never anyone else's: `getName()`, `getContainer()`, `getInstance()`, `create()`, `initialize()`, `shutdown()`, `reset()`, `resetWorkerState()`, `beginRequest()`, `flushRequestState()`, `getCorrelationId()`, `getRequestHandler()`, `getLifecycle()`, `getShutdownSequence()` and `getModelLocator()`.

Anything that genuinely cannot be wired statically resolves through `getContainer()`.

### Run the Rector set first

`Quiote\Rector\Set\ContextDecompositionSetList` rewrites the common call shapes — the routing, the request, the user, the translation manager, the database manager and `getService()` — and reports every site it declines in a residue file for a human to look at. It ships as a dev dependency.

### The two optional components explain their own absence

`getTranslationManager()` and `getDatabaseManager()` answered null in a context that configures neither, so call sites guarded with `?->`. Both are now bound either way: to the component when the configuration declares one, and otherwise to a factory that throws naming what would have declared it —

```
Context "web" has no Quiote\Translation\TranslationManager: the factories configuration declares
no translation_manager. A class depending on it cannot be built in this context.
```

That is what makes the injection safe. Both classes are instantiable with no required constructor arguments, so a container asked for an unbound one would otherwise have autowired a brand-new, uninitialized instance — a translation manager with no locales, a database manager with no connections — and a `?->` guard rewritten to a property fetch would have sailed straight past it.

For a genuinely *optional* dependency, `Container::tryGet()` answers null rather than throwing. A surviving `?->` at a call site keeps working; the branch it guards has simply become unreachable.

### `Context::handle()` is gone; take the PSR-15 handler instead

```php
$response = $context->getRequestHandler()->handle($request);
```

The per-request work — owning the middleware pipeline, resolving the correlation id, opening the ambient logging scope, arming the request-state flush, emitting `ResponseSendingEvent` — now lives in `Quiote\Runtime\ContextRequestHandler`, which **declares** `RequestHandlerInterface` rather than merely matching its signature.

Two internals moved with it:

- **`Context::$psrKernel` is gone.** Reach the pipeline with `$context->getRequestHandler()->pipeline()`, and drop a stale one with `forgetPipeline()` — needed by anything that reconfigures `MiddlewareCatalog` after a request has been served, since the pipeline is composed once and reused.
- **`Context::$correlationId` is gone**; `getCorrelationId()` reads it from the handler.

See [the request lifecycle](/architecture/request-lifecycle/#2-enter-the-pipeline--contextrequesthandler).

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

## Fixed: an omitted registration scope meant process lifetime

`Container::set()`, `setFactory()` and `PluginRegistrar::service()` defaulted their `$scope` argument to `SCOPE_SINGLETON`, while an *unregistered* autowired class defaulted to something else entirely. Registering a class for the sake of an alias therefore changed its lifetime, silently, to the longest one available.

The argument is nullable now, and omitting it asks the binding instead of assuming:

| Bound thing | Scope |
|---|---|
| A class name | its own `#[Service(scope: …)]`, transient for a `ServiceInterface`, otherwise request — identical to what autowiring gives it |
| A factory or closure | request — nobody declared a lifetime, and it is the answer that cannot outlive its inputs |
| An already-built instance | singleton — one object was handed over, so there is no lifetime to choose, and it is what lets a singleton hold it |
| A scalar or array | singleton — a bound value, not a service |

**Breaking** for a registration that omitted the scope and relied on getting a singleton: a factory-backed service is now rebuilt each request, and a class-name registration follows what the class declares. Pass `Container::SCOPE_SINGLETON` where you meant it — see [what an omitted scope means](/architecture/container/#what-an-omitted-scope-means) and, for plugin authors, [say what scope your services have](/architecture/plugins/#say-what-scope-your-services-have).

## Fixed: injecting `WebRequest` or `User` gave you a fresh, empty one

A defect, not a rename. The container bound each core service under its role name and its *concrete* class only. An application configures a `request` or `user` subclass, so the natural type-hint — `WebRequest`, `User` — was unregistered, and the container autowired a brand-new instance for it. A consumer asking for the request got one carrying none of the request's parameters, headers or body; one asking for the user got an unauthenticated stranger. Silently, in both cases.

The base classes are now bound alongside the concrete class, so `WebRequest`, `User`, `ISecurityUser`, `Routing`, `TranslationManager` and `DatabaseManager` all resolve to the request's real instance.

If you worked around this — resolving `'request'` by string, or type-hinting the subclass to get the real object — those still work and can now be simplified. **If you type-hinted the base class in a singleton, that wiring was silently broken and now throws at wiring time**, naming the accessor to use instead.

## Fixed: a failed context reset could leak the previous user

`Context::reset()` ran as one unguarded sequence, and the two assignments that clear identity sat *after* the controller reset, the user flush and the shutdown loop that recycles database connections. Any throwable from those — and a dead socket at a request boundary is the ordinary case — aborted the reset before identity was cleared. The next request in that worker got a fresh session bag but the previous request's `SecurityUser`, still authenticated, roles intact.

Identity is now cleared first and unconditionally, in a `finally`, and each remaining component reset is separately guarded. Nothing to do; worth knowing if you run workers.

## Fixed: a JWT login could leave a session authenticated with no roles

`markTokenDerived()` wrote its marker into the session on every stateless authentication, and only an explicit logout cleared it again. `RbacSecurityUser::initialize()` reads that marker to decide whether to rehydrate roles — so once a session had carried it, every later request on that cookie came back authenticated with **zero roles**, and stayed that way until the user logged out and back in. The visible symptom was a user who logs in through an SPA (one bearer-authenticated call) and then hits a 403 on every classic page.

The marker is now scoped to the request that presented the token: it is neither read from nor written to the session. What it protected against is enforced where the token authenticates instead — `AuthenticationManager::apply()` revokes rehydrated roles and credentials before granting the passport's own. The reverse leak is closed too: a token-derived user writes back no authentication flag, credentials or roles, so a bearer call that carries a session cookie leaves that session exactly as it found it.

- **`SecurityUser::TOKEN_DERIVED_NAMESPACE` is removed.** Nothing stores that key. Delete any reference to it; sessions written by an older version simply carry an ignored key.
- **If you call `markTokenDerived()` yourself**, it is now in-memory state and does not survive the request. Nothing else to change.
- **If you have an endpoint that turns a token into a browser session**, call `markTokenDerived(false)` before `setAuthenticated(true)` — see [Token identities and the session](/advanced/authentication-authorization/#token-identities-and-the-session).

## New: middleware can clear per-request state at the request boundary

Middleware objects are built once per worker and reused for every request that worker serves — they always were, and that is unchanged. What is new is a supported way to hold state anyway: implement `Symfony\Contracts\Service\ResetInterface`, and `MiddlewarePipeline::resetInstances()` clears it at the end of each request, alongside the session bag and the user.

Worth an audit either way. A middleware that assigns a request value to `$this->` — a resolved user, a tenant, a memoized per-user lookup — serves it to the next request on that worker, possibly a different user's. See [One instance per worker, not per request](/advanced/custom-middleware/#one-instance-per-worker-not-per-request).

## BREAKING: `ValidationService::xmlOnlyValidate()` is now `validateDeclaredOnly()`

A rename. Same signature, same behaviour:

```php
$service->xmlOnlyValidate($action, $request, $module, $action, $method);      // 3.x
$service->validateDeclaredOnly($action, $request, $module, $action, $method); // 4.0
```

The old name was wrong twice over. Validators haven't been XML-only for some time — a declaration can come from the fluent builder or a compiled declaration just as well — and "only" never referred to the declaration format anyway. What this method skips is the *other* kind of validation: the `validate()` / `validate{Method}()` methods an action implements in PHP. `validate()` runs both and reports one combined outcome; `validateDeclaredOnly()` leaves the manual methods to the caller, which is what lets `ValidationMiddleware` tell a client which of the two rejected the request.

Nothing about which validators run, or when, is different. See [Validation](/basics/validation/).

## BREAKING: four deprecated validation methods are gone

| Deleted | Use instead |
|---|---|
| `ValidationError::setMessageIndex()` | `setName()` — the deleted method only forwarded to it |
| `ValidationError::getMessageIndex()` | `getName()` — likewise |
| `ValidationIncident::hasFieldError($field)` | `getArguments()`, keyed by `ValidationArgument::getHash()` |
| `ValidationIncident::getFieldErrors($field)` | `getErrors()`, filtered on `ValidationError::hasArgument()` |

Nothing in the framework called any of them.

`ValidationManager::getFieldErrors()` is a **different** method with the same name and is unaffected — it collects `ValidationIncident::getErrors()` and never used the incident-level accessor. It is the first thing an upgrade search turns up, so check which class you are looking at before changing anything. `ValidationIncident::getFields()` also stays: still deprecated, but `ValidationManager` genuinely calls it.

## BREAKING: `ViewResolver` and `ActionExecutionSession` are gone

Two classes in `Quiote\Execution` that nothing constructed:

- **`ViewResolver`** was a deprecated stub that emitted a deprecation warning and forwarded to `Quiote\Execution\ViewNameResolver`. Call `ViewNameResolver` directly — same `resolve()` signature.
- **`ActionExecutionSession`** was a transitional wrapper never wired into dispatch. If you built one yourself, its two jobs were setting `ExecutionState::$viewModule`/`$viewName` from an `ActionExecutionContext` and reading `$context->content`; do both directly.

## BREAKING: `QuioteException`'s exception-page helpers are gone

Four public statics are deleted from `QuioteException`, and so from every exception that extends it:

| Deleted | What it did |
|---|---|
| `QuioteException::getFixedTrace()` | Stack trace with the origin forced into the first frame |
| `QuioteException::buildParamList()` | Formatted a frame's arguments for display |
| `QuioteException::highlightFile()` | Syntax-highlighted a file, as HTML lines |
| `QuioteException::highlightString()` | Syntax-highlighted a code string, as HTML lines |

These were the Agavi error page's rendering machinery, and nothing has called them since that page was replaced. Rendering an exception is the job of `Quiote\Exception\Rendering\ExceptionRenderer` now: the default `SafeRenderer` deliberately reveals nothing — no message, no class name, no trace — and the developer-facing page comes from the opt-in [`quioteframework/whoops`](/plugins/official-packages/#quioteframeworkwhoops) package, which does its own frame and source rendering. `getOriginalCode()` and the `int|string` constructor code are untouched.

**If you call them**, you are rendering your own error page: install `quioteframework/whoops` and register it, or implement `ExceptionRenderer` and register it with `ExceptionRendererRegistry` — both hand you the frames and source these methods assembled by hand. To keep the exact old output, copy the four methods out of a 3.x tag into your own class; they depend on nothing else in `QuioteException`. See [Error handling](/architecture/error-handling/#developer-vs-safe-rendering).

## Fixed: `ViewTestCase`'s response assertions work

Four helpers could never pass as documented, which is why nothing used them. `assertViewRedirectsTo()` compared a string against `getRedirect()`'s `{location, code}` record, `assertViewSetsHeader()` compared a string against the header's list of values, `assertViewSetsCookie()` compared a string against the whole cookie record — lifetime, path and flags included — and `runView()` handed the view the request's *parameter array*, a guaranteed `TypeError` against any view typed for a `WebRequest`.

Each now compares the value its `@param` promises, and `runView()` passes the request itself, the way `ActionExecutor` invokes a view. Existing tests that worked around this by asserting on the raw response keep working. See [Testing: the fragment harness](/advanced/testing/#the-fragment-harness).

## Two things that were private are now public API

Because a test or an embedding host had no honest way to reach them:

- **`Context::getShutdownSequence()`** replaces reflection on the `$shutdownSequence` property, which is no longer an array. Use `append()`, `remove()`, `replaceRole()` and `all()`.
- **`Context::create()`** is the named constructor `ContextRegistry` builds through. A subclass named by `core.context_implementation` must keep the constructor signature — that was always true, and is now declared.

## Checklist

- [ ] Run `Quiote\Rector\Set\ContextDecompositionSetList`, then work through its residue file by hand
- [ ] Search for the deleted `Context` accessors the set doesn't cover — `getModel()`, the session pair, `createInstanceFor()`, `handle()`
- [ ] Clear the config cache once, or run `cache:warmup`
- [ ] Check for anything reading a compiled config file, or the `*FactoryInfo` properties on `Context`
- [ ] If you wrote a custom config handler: update its `execute()`/`executeArray()` to return the declaration, drop any use of `BaseConfigHandler::generate()`, and implement `IDeclarationConfigHandler` if it's registered for `ConfigCache::load()`
- [ ] Check for `Context::$psrKernel` / `Context::$correlationId` access, including by reflection
- [ ] Check singletons type-hinting `WebRequest`, `User` or `ISecurityUser` — those now throw at wiring time; inject `RequestState` / `CurrentUser`
- [ ] Check anything relying on an unregistered, unannotated class behaving as a singleton — it's now request-scoped by default; register it explicitly if it must survive across requests
- [ ] Check for a bare `#[Service]` (no `scope:` argument) that relied on the old singleton default
- [ ] Check every `set()` / `setFactory()` / `service()` call that omitted the scope and meant a singleton
- [ ] Register a request-end clear for any request-scoped state your own code holds
- [ ] Search for `TOKEN_DERIVED_NAMESPACE`; drop it
- [ ] Audit your middleware for request values assigned to instance properties
- [ ] Rename `xmlOnlyValidate()` calls to `validateDeclaredOnly()`
- [ ] Search for the four deleted validation methods — `setMessageIndex()`, `getMessageIndex()`, `ValidationIncident::hasFieldError()`, `ValidationIncident::getFieldErrors()` (not `ValidationManager::getFieldErrors()`, which stays)
- [ ] Search for `ViewResolver` and `ActionExecutionSession`
- [ ] Search for `getFixedTrace()`, `buildParamList()`, `highlightFile()`, `highlightString()` on any exception
