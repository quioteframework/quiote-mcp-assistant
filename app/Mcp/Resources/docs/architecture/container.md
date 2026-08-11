# The DI container

> Quiote's dependency-injection container — how services are registered, resolved, autowired, and scoped, and where your own services fit in.

A **dependency-injection (DI) container** is the object that builds your objects for you. Instead of a class reaching out to find the things it needs, it lists them as constructor parameters, and the container supplies them when it creates the class. Quiote's container is `Quiote\DI\Container`, a small [PSR-11](https://www.php-fig.org/psr/psr-11/) implementation.

Here is the shift it makes, concretely. The old Agavi style had a class reach back through the context to locate its collaborators:

```php
// Before: the class goes looking for what it needs
class OrderService
{
    public function doThing(): void
    {
        $repo = $this->getContext()->getModel('OrderRepository'); // service-locator style
    }
}
```

With the container, the class just *declares* what it needs, and receives it already built:

```php
// After: the container supplies collaborators through the constructor
class OrderService
{
    public function __construct(private OrderRepository $repo) {} // injected for you
}
```

The container is small on purpose — it's code Quiote owns rather than a third-party dependency, in keeping with the framework's low-magic stance. This page covers how it works and, importantly, **where your own services get registered**.

## How it fits in a request

The container is built once when a [context](/architecture/request-lifecycle/) boots, and three kinds of thing end up inside it:

1. **Core framework objects** — the controller, request, routing, session bag, user, database manager, and so on. These are built by the older `factories` config (see [Configuration](/architecture/configuration/#factories)), and then **bridged into the container** by `Context::registerCoreServicesInContainer()`, which registers each one under its role name (e.g. `databaseManager`), its concrete class, **and the contracts it satisfies** — `ControllerInterface`, `WebResponseInterface`, `WebRequest`, `User`, `ISecurityUser`, `Routing`, `TranslationManager`, `DatabaseManager`. *(The `factories` config itself does not talk to the container — it builds the objects, and the context registers the results. That's the one wiring detail worth remembering.)*

   Binding the base classes matters more than it looks. An application configures a `request` or `user` **subclass**, so with only the concrete class bound, the natural type-hint — `WebRequest`, `User` — was unregistered, and the container autowired a brand-new instance for it: a consumer asking for the request got an empty one carrying none of the request's parameters, headers or body, and one asking for the user got an unauthenticated stranger. Silently, in both cases. If you worked around that by resolving `'request'` by string or by type-hinting your own subclass, those still work and can now be simplified.
2. **Plugin services** — anything a [plugin](/architecture/plugins/) contributes via `PluginRegistrar::service()` at boot (see [Registering services](#registering-services) below).
3. **Your application's services** — resolved on demand, either by constructor injection or an explicit lookup.

During a request the container is mostly invisible: your action's and view's dependencies are already wired by the time your code runs. Where it actively works each request is at the boundaries:

> Context boots → `factories` build the core objects → `Context::registerCoreServicesInContainer()` registers them → plugins' `register()` add their services → **each request:** actions and views are built fresh via `make()` (never cached), their constructor dependencies autowired → at the end of the request `Container::reset()` clears request-scoped services, keeping singletons for the next request.

That last step is why scopes matter under a long-lived worker — see below.

## Scopes

Every service resolves under one of three scopes, which decide how long its instance lives:

| Scope | Constant | Lifetime |
|---|---|---|
| Singleton | `Container::SCOPE_SINGLETON` | Built once, reused for the whole worker's life. |
| Transient | `Container::SCOPE_TRANSIENT` | Built fresh every time it's asked for. |
| Request | `Container::SCOPE_REQUEST` | Built once per request, then cleared at the request boundary. |

**Why this matters under [worker mode](/architecture/deployment/).** A FrankenPHP worker stays in memory across many requests. A stateful object registered as a *singleton* would carry its state from one request into the next — leaking one user's data into another's request. Request-scoped services avoid that: `Container::reset()` runs at each request boundary (in lockstep with the context's own reset) and drops them, so the next request builds them clean. Singletons and the container's definitions survive; only request-scoped instances are cleared.

:::tip[Rule of thumb]
When unsure, choose **transient** or **request** scope. Reserve **singleton** for objects you've confirmed hold no per-request state.
:::

### What a class gets when nothing says otherwise

Autowiring picks a default scope by checking, in order:

1. A `#[Service(scope: ...)]` attribute — including the bare `#[Service]` form, whose own default is `SCOPE_TRANSIENT`.
2. `Quiote\Service\ServiceInterface` — also `SCOPE_TRANSIENT`.
3. Anything else — `SCOPE_REQUEST`.

**Singleton is never a default; it's only ever a claim you make explicitly**, with `#[Service(scope: Container::SCOPE_SINGLETON)]` or an explicit `set()`. An ordinary, unvetted class autowired for the first time resolves as request-scoped rather than process-lifetime, so nothing gets silently promoted to a singleton that then leaks one request's state into the next under a worker. Since a bare `#[Service]` and `ServiceInterface` agree at transient, adding the attribute to an existing service purely for discoverability doesn't change its lifetime — only writing an explicit `scope:` does.

### A singleton cannot depend on request-scoped state

The container refuses that wiring rather than letting it fail silently later. A singleton is constructed once and keeps whatever it was handed forever, so `reset()` — which drops the container's own reference to a request-scoped instance — cannot reach inside it. Under a worker the singleton then serves request 1's instance to every later request, and for `request`, `user` and `sessionBag` that is a cross-user identity leak.

So autowiring a singleton whose constructor asks for a request-scoped service throws a `ContainerException` at wiring time, naming the parameter, the service, and — for the request and the user — the accessor to inject instead:

| Instead of | A singleton injects | Why |
|---|---|---|
| `WebRequest` | `Quiote\Request\RequestState` | `current()` / `publish()`, resolved per call |
| `SecurityUser` / `User` | `Quiote\User\CurrentUser` | `get()` / `isAuthenticated()`, resolved per call |

Both hold nothing themselves, so there is nothing to go stale — every call resolves the live request or user afresh, rather than memoizing what it saw first.

```php
final class AuditLogger
{
    public function __construct(private readonly CurrentUser $currentUser) {}

    public function record(string $action): void
    {
        $user = $this->currentUser->get();   // User|ISecurityUser — check before calling SecurityUser-only methods
        $actor = $user instanceof SecurityUser ? $user->getUsername() : 'anonymous';
        // ...
    }
}
```

`get()` returns `User|ISecurityUser` — whichever concrete class your app's `user` factory role points at — so code that needs `SecurityUser`- or `RbacSecurityUser`-only methods (`getCredentials()`, `hasRole()`, …) checks with `instanceof` first.

`isAuthenticated()` is a convenience beyond what the concrete classes offer: it answers `false` for a plain `User` that doesn't implement `ISecurityUser` at all — an app with no security layer configured has no authenticated users, rather than a method that doesn't exist to call. Calling `->isAuthenticated()` on the injected user object itself has no such guard; it only compiles at all when the configured `user` class implements `ISecurityUser`.

**Anything built per execution — an action, a view, a validator — is not affected**, because `make()` never caches its result. Those can inject request-scoped collaborators directly, and should: inside an action or a view, the `WebRequest` handed to `execute*()` is current by construction, while a *held* request is a snapshot. Since `WebRequest` is immutable, every mutation produces a new instance — validation alone replaces it several times — so a construction-time snapshot is the *pre-validation* request, and reading a parameter from it bypasses the strict-validation whitelist.

The user is different: it is replaced only at the worker request boundary, never mid-request, so an action or view may inject `SecurityUser` (or `User`, or `ISecurityUser`) and hold it for its own lifetime.

## Registering services

There are two places you register a service, depending on who owns it.

### The usual path: a plugin's `register()`

Application and package services are registered inside a [plugin](/architecture/plugins/), through the `PluginRegistrar` handed to `register()`. This is the normal way to add your own service to the container:

```php
// src/Plugin/AppPlugin.php
namespace App\Plugin;

use Quiote\DI\Container;
use Quiote\Plugin\{PluginInterface, PluginRegistrar};
use Quiote\Plugin\Attribute\Plugin;

#[Plugin(name: 'app')]
final class AppPlugin implements PluginInterface
{
    public function register(PluginRegistrar $r): void
    {
        // id, concrete (class-string | closure | instance), scope, ...aliases
        $r->service(OrderService::class, OrderService::class, Container::SCOPE_REQUEST);
        $r->service(ClockInterface::class, fn() => new SystemClock());
    }
}
```

:::tip[Pass the scope, especially in a plugin]
A plugin's services are wired once at boot and then live in every application that enables it, under whatever runtime that application deploys. Writing the scope out states the lifetime you actually mean, where the omitted form leaves it to be inferred — see [what an omitted scope means](#what-an-omitted-scope-means) for what is inferred, and from what.
:::

The plugin only runs once you list it in your `Config/plugins.{php,yaml,xml}` file — see [Plugins](/architecture/plugins/#registering-a-plugin). At boot, `PluginManager` calls each plugin's `register()`, and the deferred `service()` calls are applied to each context's container (registered only if not already bound, so your app and the core always win over a plugin).

### The lower-level path: the container API directly

If you hold a `Container` instance yourself (for example in a test or a custom bootstrap), you register with `set()`, `setFactory()`, and `alias()` — there is no `bind()` or `register()` method:

```php
use Quiote\DI\Container;

$c = new Container();

// A class name — autowired when first resolved:
$c->set(OrderService::class, OrderService::class, Container::SCOPE_REQUEST);

// A closure factory:
$c->setFactory(Mailer::class, fn() => new Mailer(getenv('SMTP_DSN')));

// An already-built instance:
$c->set('clock', new SystemClock());

// An alias — bind an interface to a concrete id:
$c->alias(ClockInterface::class, 'clock');
```

`set()` also takes a fourth argument: constructor values the container can't figure out from types alone (scalars, config strings), bound by parameter name:

```php
$c->set(AuditLog::class, AuditLog::class, Container::SCOPE_REQUEST, [
    'table'     => 'audit_entries',
    'retention' => '90 days',
]);
```

### What an omitted scope means

The `$scope` argument of `set()`, `setFactory()` and `PluginRegistrar::service()` is nullable. Omitting it asks the binding what its lifetime is, rather than assuming one:

| Bound thing | Scope |
|---|---|
| A class name | its own `#[Service(scope: …)]`, transient for a `ServiceInterface`, otherwise request — identical to what [autowiring](#what-a-class-gets-when-nothing-says-otherwise) gives it |
| A factory or closure | request — nobody declared a lifetime, and it is the answer that cannot outlive its inputs |
| An already-built instance | singleton — one object was handed over, so there is no lifetime to choose, and it is what lets a singleton hold it |
| A scalar or array | singleton — a bound value, not a service |

The class-name row is the one that does real work: registering a class **only to give it an alias** leaves its lifetime exactly where the class itself declared it. A factory that must be a process singleton has to say so — the container will not infer process lifetime for something it builds.

## Resolving services

Three methods read from the container:

```php
$orders = $c->get(OrderService::class);   // resolve, memoized per scope
$fresh  = $c->make(OrderService::class);  // resolve, always a brand-new instance
$c->has(OrderService::class);             // is it registered? (PSR-11)
```

- **`get()`** resolves aliases, returns the cached instance for singleton/request scopes (building and caching it the first time), and detects dependency cycles — a circular dependency throws `ContainerException` with the full resolution path so you can see what referred to what.
- **`make()`** always builds a fresh, never-cached instance. This is the path the framework uses for **actions, views and validators**, which are per-request and must never be reused. You can pass construction-time overrides: `make(FooAction::class, [SomeDependency::class => $value])`. It's generic in the class it's given, so a caller naming a concrete class gets that type back rather than `object`.
- **`has()`** reports only what has been *explicitly registered* — not everything that *could* be autowired. So a mistyped dependency fails loudly instead of a look-alike being silently constructed.

## Autowiring

When the container builds a class, it fills each constructor parameter by trying these sources **in order**, stopping at the first that applies:

1. A value bound at registration time **by parameter name** (the `set()` params array, or `make()` overrides).
2. A value bound **by type**.
3. An **`#[Inject('id')]`** attribute on the parameter — resolved via `get('id')`.
4. An **`#[Autowire(value)]`** attribute — a literal value supplied inline.
5. A **type-hinted class** that can itself be autowired — resolved via `get()`.
6. The parameter's **default value**, if it has one.
7. Otherwise, a loud `ContainerException` — the container never guesses.

A class with no constructor is simply instantiated with `new`.

### A worked example

```php
use Quiote\DI\Container;
use Quiote\DI\Attribute\{Service, Inject, Autowire};
use Symfony\Contracts\Service\Attribute\Required;

#[Service(scope: Container::SCOPE_REQUEST)]           // marks it a service + sets its scope
final class OrderService
{
    public function __construct(
        private OrderRepository $repo,                // (5) autowired by type
        #[Inject('clock')] private ClockInterface $clock,   // (3) resolved by container id
        #[Autowire('USD')] private string $currency,  // (4) a literal value
    ) {}

    #[Required]
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;                      // optional setter injection
    }
}
```

The four attributes:

- **`#[Service(scope: ...)]`** — marks a class as a service and declares its scope in one place (so you don't have to pass the scope at every registration).
- **`#[Inject('id')]`** — fill this parameter from a specific container id, instead of by its type.
- **`#[Autowire(value)]`** — inject a literal scalar value (a table name, a mode, a default) for a parameter that has no type to autowire against. It's a literal, not a config lookup — to pull a value from config, register the service with a `set()` params binding (or a factory closure) that reads `Config::get()`.
- **`#[Required]`** — after construction, the container calls every `#[Required]` method with autowired arguments. Use it for cross-cutting optional dependencies (a logger, say) you don't want in every constructor.

:::note
The container refuses a `#[Required]` method named `initialize`, or one that type-hints an action/view init context (`ActionInitContext` / `ViewInitContext`) — those are per-request framework hooks the container doesn't own, so it won't call them.
:::

This example builds `OrderService` in isolation. For the other end — an action injecting it, calling it, and a view injecting a second service to format the result — see [using a service from an action](/basics/services-and-models/#using-it-from-an-action), or [Dependency injection in practice](/architecture/dependency-injection-in-practice/) for the same graph built one file at a time, from the service through to the test.

## The service layer

A "service" in Quiote is just a plain object with injected dependencies — **not a base class you must extend**. Two opt-in markers exist:

- **`Quiote\Service\ServiceInterface`** — an empty marker interface. Implementing it (or carrying `#[Service]`) lets the container tell a real service apart from any other autowireable class, and defaults it to **transient** scope.
- **`Quiote\Service\Service`** — an optional, transitional base class that exposes `getContext()`. It exists so a half-migrated service can still reach through the context while its collaborators are being converted to injection. Treat it as scaffolding to remove, not a permanent parent.

The end state for a service is a plain object with constructor-injected dependencies and no base class at all.

### Services vs. models

Quiote historically used the word "model" for two unrelated things: long-lived service/repository objects, and short-lived data objects (DTOs). The container separates them:

- **Services** — resolved through the container, by injection. Business logic, repositories, finders.
- **Models** — resolved through `ModelLocator::get()`. Transient data objects, typically built from a database row.

Inject **services**; the model locator remains for the DTO half.

## Type-hinting a contract instead of a class

Four interfaces let a service depend on a seam rather than an implementation, and all four are resolvable from the container:

| Contract | Implemented by |
|---|---|
| `Quiote\ContextInterface` | `Context` (aliased to whatever `core.context_implementation` names) |
| `Quiote\Controller\ControllerInterface` | `Controller` |
| `Quiote\Response\WebResponseInterface` | `WebResponse` |
| `Quiote\Validator\ValidatorInterface` | `Validator` |

```php
public function __construct(private readonly ContextInterface $context) {}
```

All of it is additive: no existing signature changed, and the interfaces declare no PHP return types where the implementations declare none, so subclasses stay compatible either way. `Quiote\ContextComponentInterface` types the `initialize()`/`startup()` pair that `WebRequest`, `User`, `Routing` and `DatabaseManager` share.

The configuration repository is injectable too, so a service can declare it rather than reaching for the static facade:

```php
public function __construct(private readonly \Quiote\Config\ConfigRepository $config) {}
```

See [Configuration: reading config at runtime](/architecture/configuration/#reading-config-at-runtime).

## Framework state is a dependency like any other

`Context` answers for its own identity and lifecycle. Everything it used to reach on another object's behalf is a collaborator in the container, so a class that needs one declares it:

| Inject | For | Notes |
|---|---|---|
| `Quiote\Routing\Routing` | route matching and URL generation | rebuilt on demand in a worker |
| `Quiote\Controller\Controller` | the controller | resolving one before the context is initialized throws |
| `Quiote\Model\ModelLocator` | `get()` — [models](/basics/services-and-models/#models) | also `$context->getModelLocator()` |
| `Quiote\Database\DatabaseManager` | `getDatabase($name)->getConnection()` | |
| `Quiote\Translation\TranslationManager` | translation and i18n | |
| `Quiote\Session\SessionManager`, `Quiote\Session\SessionBagInterface` | the session | the bag is a `NullSessionBag` when no session is configured |
| `Quiote\Request\RequestState` | `current()` / `publish()` — the request | resolves per call — [what a singleton needs](#a-singleton-cannot-depend-on-request-scoped-state) |
| `Quiote\User\CurrentUser` | `get()` / `isAuthenticated()` — the user | likewise |
| `Quiote\ContextRegistry` | `get()` / `has()` / `names()` — another context by name | `Context::getInstance()` answers from this registry |
| `Quiote\ShutdownSequence` | `append()` / `remove()` / `replaceRole()` / `all()` | also `$context->getShutdownSequence()` |
| `Quiote\Runtime\ContextRequestHandler` | the PSR-15 handler and its pipeline | also `$context->getRequestHandler()` |
| `Quiote\ContextLifecycle` | the per-request state machine | also `$context->getLifecycle()` |

A class that declares `ModelLocator` says what it needs; one that takes `Context` can reach anything and tells a reader nothing.

The execution helpers — `Quiote\Execution\ActionResolver`, `Quiote\Asset\AssetRegistry`, `Quiote\Execution\SlotDispatcher` — are in the container too, with their lifetimes declared rather than maintained by hand: the action resolver is a process-lifetime singleton, and the asset registry and slot dispatcher are request-scoped, so the container drops them at the request boundary. All three are injectable by class or by short id (`actionResolver`, `assetRegistry`, `slotDispatcher`).

The translation and database managers are bound even in a context that configures neither — to a factory that throws naming what would have declared it, rather than to a brand-new, uninitialized instance. For a genuinely optional dependency, ask with `tryGet()`, which answers `null`.

## Reaching the container from a request

Prefer constructor injection. When that doesn't fit — a legacy call site, or a genuinely lazy, conditional lookup — go through the context's container:

```php
$service = $this->getContext()->getContainer()->get(OrderService::class);
```

`get()` is typed on the class it's given, so this is as well typed as an injected property would be. It's there for those cases; new code should inject its dependencies through the constructor instead.
