# Services and models

> Where business logic goes — writing a service with constructor injection, and using models as data objects.

Quiote is deliberately unopinionated about where your business logic lives (see [Design philosophy](/getting-started/philosophy/)). It does not mandate a repository pattern, a service layer shape, or a "model" base class. What it gives you is two conventions — **services** and **models** — and a container that wires the first one for you. This page is the practical answer to "where does my code go?"

The short version:

- **Services** hold behaviour — business logic, repositories, finders, integrations. They are resolved through the [DI container](/architecture/container/) with constructor injection.
- **Models** are data objects — a DTO built from a row, a value object, a domain entity. They are resolved through `Quiote\Model\ModelLocator`.

These were historically conflated (Agavi used "model" for both singleton service objects and transient data objects). Quiote keeps them separate on purpose.

## Writing a service

A service is a plain object. There is no base class to extend and nothing to register in a config file — you declare its dependencies as constructor parameters and the container supplies them:

```php
<?php
namespace App\Service;

use App\Repository\OrderRepository;
use Psr\Clock\ClockInterface;

final class OrderService
{
    public function __construct(
        private OrderRepository $repo,
        private ClockInterface $clock,
    ) {}

    public function placeOrder(Cart $cart): Order
    {
        // business logic here
        return $this->repo->save(Order::fromCart($cart, $this->clock->now()));
    }
}
```

That is a complete, usable service. When something asks the container for `OrderService`, the container inspects the constructor, resolves `OrderRepository` and `ClockInterface`, and builds it.

### Using it from an action

This is the part that's easy to leave implicit: **an action is built the same way a service is.** `Controller::createActionInstance()` builds every action through `Container::make()`, so an action's constructor is autowired exactly like `OrderService`'s — declare the dependency, and it's there. Nothing to register, no `factories` entry, no base-class hook.

```php
<?php
namespace App\Modules\Shop\Actions;

use App\Service\OrderService;
use Quiote\Action\Action;
use Quiote\Request\WebRequest;

class PlaceOrderAction extends Action
{
    public function __construct(private readonly OrderService $orders) {}

    public function executeWrite(WebRequest $rd)
    {
        $cart = Cart::fromRequest($rd);   // read the submitted items, however your app does that
        $order = $this->orders->placeOrder($cart);

        $this->setAttribute('order', $order);

        return 'Success';
    }
}
```

Walk through what happens on a request to this action:

1. Routing resolves the request to module `Shop`, action `PlaceOrder`.
2. `Controller::createActionInstance()` calls `Container::make(PlaceOrderAction::class)`.
3. The container reflects the constructor, sees a `OrderService $orders` parameter, and resolves it — which means **resolving `OrderService`'s own constructor first**: `OrderRepository` and `ClockInterface` are autowired transitively, with no more effort than the single-parameter case. One `use` statement pulled in a whole dependency graph.
4. The executor calls `initialize()` (the framework context — see [the two-phase pattern](/architecture/actions-and-views/#the-two-phase-pattern)), then dispatches to `executeWrite()`, which is just an ordinary method call on an object that already has everything it needs.

That's the whole mechanism — there's no separate "action DI" to learn beyond [autowiring](/architecture/container/#autowiring) itself.

For the same example built one file at a time — including the two cases that *do* need registering (an interface, and a constructor value that isn't a type), how to pick a scope, and how to test the result — see [Dependency injection in practice](/architecture/dependency-injection-in-practice/).

**A view injects exactly the same way.** If the view rendering the result needs its own collaborator — a formatter, a different repository — declare it the same way:

```php
<?php
namespace App\Modules\Shop\Views;

use App\Service\PriceFormatter;
use Quiote\View\View;

class PlaceOrderSuccessView extends View
{
    public function __construct(private readonly PriceFormatter $formatter) {}

    public function executeHtml(): void
    {
        $order = $this->getAttribute('order');
        $this->setAttribute('formattedTotal', $this->formatter->format($order->total));
    }
}
```

Two things worth knowing once this is working:

- **The action and the service don't share a lifetime.** `Container::make()` never caches, so `PlaceOrderAction` is a brand-new instance on every dispatch regardless of anything. `OrderService` follows *its own* scope — transient by default (see [marking a service](#marking-a-service) below) — so two actions injecting it in the same request may get the same instance or two different ones depending on what you declared. This only matters if the service holds state between calls; a stateless service (the common case) behaves identically either way.
- **Need a specific implementation, or a literal value, instead of autowiring by type?** `#[Inject('id')]` and `#[Autowire($value)]` work on an action's constructor parameters exactly as they do on a service's — see [autowiring](/architecture/container/#autowiring) for the full resolution order.

**Testing this action** means either constructing it with test doubles — its dependencies are just constructor arguments — or driving a full request through the pipeline. See [the fluent HTTP client](/advanced/testing/#the-fluent-http-client) and the [`UnitTestCase`](/advanced/testing/#the-foundation-unittestcase) example, plus [testing what you wired](/architecture/dependency-injection-in-practice/#10-testing-what-you-wired).

### Marking a service

Two optional markers make intent explicit and control lifetime:

- **`#[Service]`** — marks the class as a service and declares its [scope](/architecture/container/#scopes) in one place:

  ```php
  use Quiote\DI\Attribute\Service;
  use Quiote\DI\Container;

  #[Service(scope: Container::SCOPE_REQUEST)]
  final class OrderService { /* ... */ }
  ```

- **`Quiote\Service\ServiceInterface`** — an empty marker interface. Implementing it lets the container tell a service apart from an arbitrary autowireable class.

Neither is required to be injectable, but they matter for one reason: **scope**. A bare `#[Service]` (no `scope:` argument) and `ServiceInterface` both default to **transient** — the two ways of declaring a service agree. A class the container autowires without either marker defaults to **request** scope, not singleton: an ordinary, unvetted class defaulting to process lifetime under [worker mode](/architecture/deployment/) is exactly the cross-request leak the [captive-dependency guard](/architecture/container/#a-singleton-cannot-depend-on-request-scoped-state) exists to catch elsewhere, so nothing gets promoted to singleton by default. Singleton is only ever what you ask for explicitly:

```php
#[Service(scope: Container::SCOPE_SINGLETON)]
final class OrderService { /* ... */ }
```

:::caution[Adding `#[Service]` to an existing class is not a no-op if you specify a scope]
The attribute takes precedence over `ServiceInterface` when both are present. Since a *bare* `#[Service]` now agrees with `ServiceInterface` on transient, adding one to an existing service purely for discoverability changes nothing. But writing `#[Service(scope: Container::SCOPE_SINGLETON)]` on a class that used to fall through to the request-scope default does change its lifetime — make that claim only once you've confirmed the class holds no per-request state.
:::

:::caution[Scope discipline under worker mode]
A worker process is long-lived, so a singleton service that stores request data leaks it into the next request. Register anything holding per-request state as `SCOPE_REQUEST` (torn down at each request boundary) or `SCOPE_TRANSIENT` (fresh every time). Reserve singleton for verified-stateless services. See [The DI container](/architecture/container/#scopes).
:::

A **singleton** service needing the request or the current user can't hold either directly — the container refuses that wiring outright. Inject `Quiote\Request\RequestState` or `Quiote\User\CurrentUser`, which resolve per call instead of capturing a snapshot. See [a singleton cannot depend on request-scoped state](/architecture/container/#a-singleton-cannot-depend-on-request-scoped-state) for why, and [Authentication and authorization](/advanced/authentication-authorization/#the-user-hierarchy) for the user hierarchy itself.

### Reaching a service without injection

Prefer constructor injection. For the cases that don't fit it — a lazy, conditional lookup deep inside a method — the context exposes a locator:

```php
$orders = $this->getContext()->getContainer()->get(OrderService::class);
```

`get()` is typed on the class it is given, so this is as well typed as an injected property. It is there for legacy call sites and genuinely conditional lookups, not the default way to reach a collaborator.

### The transitional `Service` base class

There is a `Quiote\Service\Service` base class that exposes `getContext()`. It exists only to help a half-migrated service reach through the context while its collaborators are being converted to injection. It is scaffolding to shed — the end state is a plain object with injected dependencies and no base class. Don't reach for it in new code; extending it out of habit rebuilds the service-locator pattern under a new name.

For the full container API — `set()`, `make()`, `#[Inject]`, `#[Autowire]`, `#[Required]`, autowiring order — see [The DI container](/architecture/container/).

## Models

A model is a data object. Where a service *does* things, a model *is* something: a row loaded from the database, a value object, a piece of domain state. You get one from `Quiote\Model\ModelLocator`, which is injectable like any other collaborator:

```php
public function __construct(private readonly ModelLocator $models) {}

// ...
$post = $this->models->get('Post', 'Blog');
```

A class holding a context can also reach the locator through it — `$this->getContext()->getModelLocator()`.

### How a model resolves

`get($name, $module = null, $parameters = null)` locates the class the same way [modules](/basics/modules/) locate actions and views:

| Call | Class |
|---|---|
| `get('Post', 'Blog')` | `App\Modules\Blog\Models\PostModel` |
| `get('Clock')` | `App\Models\ClockModel` |
| `get(\App\Domain\Money::class)` | that class as-is (FQCN passthrough) |

A module model lives in the module's `Models/` directory; a global model lives in the app-level `Models/` directory. If you pass a fully-qualified class name, it is used directly.

The `App\` prefix in those class names is your app's `core.namespace_prefix`, and the global `Models/` directory is `core.model_dir` — both are `settings`:

```php
// Config/settings.php
return [
    'core.namespace_prefix' => 'App',
    'core.model_dir'        => '/srv/app/Models',
];
```

The same settings can be written in YAML or XML — see [Configuration](/architecture/configuration/#settings).

The `$parameters` argument, when given, is passed both to the constructor and — if the class defines one — to an `initialize($context, $parameters)` method.

### Model lifetime

By default a model is built fresh every time. A model that implements `Quiote\Model\ISingletonModel` is cached on the context for its lifetime instead — one instance shared per request. Because the context is reset between worker requests, a singleton model must not hold request-specific state that could leak; treat singleton models as stateless caches, not per-request scratch space.

The abstract `Quiote\Model\Model` base class provides `getContext()` and serialization hooks (it swaps the live context for its name when serialized and restores it on wake-up), so a model can be safely cached or stored in a session.

## Which one do I use?

| Question | Use |
|---|---|
| Does it hold behaviour / talk to other services? | A **service** with constructor injection |
| Is it a passive data object built from a row or request? | A **model** via `ModelLocator::get()` |
| Does it need to be autowired into other classes? | A **service** (the container only autowires services) |
| Does it need to be serialized into a session? | A **model** (the base class handles context serialization) |

New code should put logic in services and reserve models for data. The two conventions stay separate so that "where does this happen?" always has a clear answer — behaviour in the container, data in the model locator.
