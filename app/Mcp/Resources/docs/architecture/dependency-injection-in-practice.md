# Dependency injection in practice

> A start-to-finish walkthrough — write a service, inject it into an action, grow its dependency graph, bind an interface, feed it configuration, and test the result.

[The DI container](/architecture/container/) explains the machinery: scopes, registration, the autowiring order. This page is the other half — one worked example, built up file by file, answering the question people actually arrive with: **I have an action, I want a service in it, what do I write and where?**

Every snippet below is a real file in a real application. Nothing is elided except the parts that have nothing to do with wiring.

## What you are building

A `Shop` module with one submission flow:

- **`PlaceOrderAction`** handles `POST /orders` and needs an **`OrderService`** to do the work.
- **`OrderService`** needs an **`OrderRepository`** (to persist) and a **`ClockInterface`** (so "now" is testable).
- **`PlaceOrderSuccessView`** needs a **`PriceFormatter`** to render the total.

Laid out in the [application directory](/getting-started/your-first-app/#the-shape-of-an-application):

```
app/
├── Service/
│   ├── OrderService.php          # App\Service\OrderService
│   ├── OrderRepository.php       # App\Service\OrderRepository
│   ├── PriceFormatter.php        # App\Service\PriceFormatter
│   └── SystemClock.php           # App\Service\SystemClock
├── Modules/
│   └── Shop/
│       ├── Actions/PlaceOrderAction.php
│       ├── Views/PlaceOrderSuccessView.php
│       └── Templates/PlaceOrderSuccess.php
└── Plugin/
    └── AppPlugin.php             # only needed from step 4 onwards
```

`Service/` is not a directory the framework knows about — put your services wherever your autoloader can find them. The scaffolded app maps its namespace prefix (`core.namespace_prefix`, `App` by default) to the application root, so `App\Service\OrderService` lives at `Service/OrderService.php`. With a Composer `psr-4` entry instead, it lives wherever that entry points.

## 1. Write the service

A service is a plain class. No base class, no interface, no config file, no registration:

```php
<?php
// Service/OrderService.php
namespace App\Service;

use App\Domain\Cart;
use App\Domain\Order;
use Psr\Clock\ClockInterface;

final class OrderService
{
    public function __construct(
        private readonly OrderRepository $repo,
        private readonly ClockInterface $clock,
    ) {}

    public function placeOrder(Cart $cart): Order
    {
        $order = Order::fromCart($cart, $this->clock->now());

        return $this->repo->save($order);
    }
}
```

The constructor is the whole declaration of what this class needs. That is the contract the container reads.

## 2. Inject it into the action

An action is built by the container the same way a service is — `Controller::createActionInstance()` routes through `Container::make()`, so an action's constructor is autowired exactly like `OrderService`'s. There is no separate "action DI" to learn, nothing to register, and no `factories` entry:

```php
<?php
// Modules/Shop/Actions/PlaceOrderAction.php
namespace App\Modules\Shop\Actions;

use App\Domain\Cart;
use App\Service\OrderService;
use Quiote\Action\Action;
use Quiote\Request\WebRequest;

class PlaceOrderAction extends Action
{
    public function __construct(private readonly OrderService $orders) {}

    public function executeWrite(WebRequest $rd)
    {
        $cart  = Cart::fromRequest($rd);
        $order = $this->orders->placeOrder($cart);

        $this->setAttribute('order', $order);

        return 'Success';
    }
}
```

That is the complete answer to "how do I get a service into an action": **type-hint it in the constructor and use it.** Everything else on this page is a variation on that one move.

### What happens on the request

1. Routing resolves `POST /orders` to module `Shop`, action `PlaceOrder`.
2. `Controller::createActionInstance()` calls `Container::make(PlaceOrderAction::class)`.
3. The container reflects the constructor, sees `OrderService $orders`, and resolves it — which means resolving **`OrderService`'s own constructor first**: `OrderRepository` and `ClockInterface` are built transitively. One `use` statement pulled in the whole graph.
4. The executor calls `initialize()` with the per-request framework context, then dispatches `executeWrite()` — an ordinary method call on an object that already has everything it needs.

Two consequences of step 2 worth holding on to:

- **`make()` never caches.** The action is a brand-new instance on every dispatch, whatever else is registered. The *service* follows its own [scope](#7-how-long-does-my-service-live) — the two lifetimes are unrelated.
- **The constructor is yours; `initialize()` is the framework's.** Injected collaborators go in the constructor, the per-request context arrives through `initialize()`. Adding a constructor dependency to an action never interferes with the framework's own wiring — that is what [the two-phase pattern](/architecture/actions-and-views/#the-two-phase-pattern) buys you.

:::caution[Do not inject the request into an action]
`WebRequest` is immutable, so every mutation produces a new instance — validation alone replaces it several times. A request captured at construction time is the *pre-validation* one, and reading a parameter from it bypasses the strict-validation whitelist. Use the `WebRequest $rd` your `execute*()` method is handed; it is current by construction.
:::

## 3. The view injects the same way

Views are built through `Container::make()` too, so a view that needs its own collaborator just declares it:

```php
<?php
// Modules/Shop/Views/PlaceOrderSuccessView.php
namespace App\Modules\Shop\Views;

use App\Service\PriceFormatter;
use Quiote\View\View;

class PlaceOrderSuccessView extends View
{
    public function __construct(private readonly PriceFormatter $formatter) {}

    public function executeHtml(): void
    {
        $this->loadLayout();

        $order = $this->getAttribute('order');
        $this->setAttribute('formattedTotal', $this->formatter->format($order->total));
    }
}
```

```php
<?php // Modules/Shop/Templates/PlaceOrderSuccess.php ?>
<h1>Thank you</h1>
<p>Your total: <?= htmlspecialchars($template['formattedTotal']) ?></p>
```

The template gets values, never services. If a template needs something formatted, format it in the view — that is what the view's injected collaborator is for.

**Validators are built this way too.** `ValidatorFactory` resolves them through `make()`, so a [custom validator](/advanced/custom-validators/) may declare constructor dependencies like anything else, and gets a fresh instance per validation.

## 4. The first thing that needs registering: an interface

Steps 1–3 required no configuration at all, because every dependency was a **concrete, instantiable class** — the container can autowire those on sight. Two kinds of dependency it cannot:

- an **interface** or abstract class (there is nothing to instantiate), and
- a class whose constructor needs something that isn't a type — a DSN, a table name, a flag.

`ClockInterface` is the first kind. Left alone, `OrderService` fails to build:

```
Cannot autowire 'App\Service\OrderService': unsatisfied dependency
'Psr\Clock\ClockInterface' for parameter $clock (requested as 'App\Service\OrderService')
```

Bind it in a [plugin](/architecture/plugins/) — the normal place an application registers services:

```php
<?php
// Plugin/AppPlugin.php
namespace App\Plugin;

use App\Service\SystemClock;
use Psr\Clock\ClockInterface;
use Quiote\DI\Container;
use Quiote\Plugin\Attribute\Plugin;
use Quiote\Plugin\{PluginInterface, PluginRegistrar};

#[Plugin(name: 'app')]
final class AppPlugin implements PluginInterface
{
    public function register(PluginRegistrar $r): void
    {
        // service(id, concrete, scope, ...aliases)
        $r->service(SystemClock::class, SystemClock::class, Container::SCOPE_SINGLETON, ClockInterface::class);
    }
}
```

The fourth argument onwards are **aliases**: `ClockInterface` now resolves to the same registration as `SystemClock`, which is what lets `OrderService` keep type-hinting the interface. The plugin runs only once it is listed in `Config/plugins.{php,yaml,xml}` — see [registering a plugin](/architecture/plugins/#registering-a-plugin).

`register()` is called once at boot, not per request. Nothing in it should do work; it should only describe wiring.

### Choosing between two implementations

Once an interface has more than one implementation, name the one you want with `#[Inject]`:

```php
$r->service('clock.system', SystemClock::class, Container::SCOPE_SINGLETON, ClockInterface::class);
$r->service('clock.frozen', FrozenClock::class, Container::SCOPE_SINGLETON);
```

```php
public function __construct(
    #[Inject('clock.frozen')] private readonly ClockInterface $clock,
) {}
```

`#[Inject('id')]` resolves that exact container id and ignores the type-hint for resolution purposes. The type-hint still documents (and, at runtime, enforces) what you expect back.

## 5. Feeding a service configuration

A constructor parameter with no class to autowire against needs a value from somewhere. There are three ways, in increasing order of how much they can do.

**A literal, inline.** `#[Autowire]` supplies a constant value:

```php
use Quiote\DI\Attribute\Autowire;

public function __construct(
    private readonly OrderRepository $repo,
    #[Autowire('USD')] private readonly string $currency,
) {}
```

It is a literal, not a config lookup — the value is written in the source.

**A value bound at registration.** `Container::set()` takes a fourth argument: constructor values bound **by parameter name**.

```php
$c->set(AuditLog::class, AuditLog::class, Container::SCOPE_REQUEST, [
    'table'     => 'audit_entries',
    'retention' => '90 days',
]);
```

**A factory closure** — the one to reach for when the value comes from configuration, because the closure runs at resolution time, when config is loaded:

```php
$r->service(
    Mailer::class,
    static fn(Container $c): Mailer => new Mailer(
        dsn:      Config::getString('app.mail.dsn'),
        fromName: Config::getString('app.mail.from_name', 'Shop'),
        logger:   $c->get(LoggerInterface::class),
    ),
    Container::SCOPE_SINGLETON,
);
```

The closure receives the container, so a factory can still resolve collaborators for the parts it isn't configuring by hand. The scope is written out because a factory with none is request-scoped — a mailer meant to be shared for the life of the worker has to say so.

A service that reads a lot of settings can inject the configuration repository instead of taking each value as a parameter:

```php
public function __construct(private readonly \Quiote\Config\ConfigRepository $config) {}
```

See [reading config at runtime](/architecture/configuration/#reading-config-at-runtime).

## 6. Framework services you can inject

Your own classes are not the only thing in the container. The core objects are registered under their role name, their concrete class, **and the contracts they satisfy**, so an action or service can declare them directly:

| Inject | For |
|---|---|
| `Quiote\Config\ConfigRepository` | reading settings |
| `Quiote\Database\DatabaseManager` | `getDatabase($name)->getConnection()` |
| `Quiote\Model\ModelLocator` | `get()` — the [model](/basics/services-and-models/#models) half |
| `Quiote\Translation\TranslationManager` | translation and i18n |
| `Quiote\Request\RequestState` | `current()` / `publish()` — the request, resolved per call |
| `Quiote\User\CurrentUser` | `get()` / `isAuthenticated()` — the user, resolved per call |
| `Quiote\ContextRegistry` | reaching another context by name |
| `Quiote\Controller\ControllerInterface`, `Quiote\Response\WebResponseInterface`, `Quiote\ContextInterface`, `Quiote\Validator\ValidatorInterface` | the four core contracts |

So the repository from step 1 can take the database manager and be done:

```php
<?php
// Service/OrderRepository.php
namespace App\Service;

use App\Domain\Order;
use Quiote\Database\DatabaseManager;

final class OrderRepository
{
    public function __construct(private readonly DatabaseManager $databases) {}

    public function save(Order $order): Order
    {
        // The connection object's type depends on the configured adapter — PDO for the PDO adapter.
        $connection = $this->databases->getDatabase()->getConnection();
        // ... persist, set $order->id ...

        return $order;
    }
}
```

For the full list, including the accessors each one replaces, see [injecting instead of reaching through the context](/architecture/container/#framework-state-is-a-dependency-like-any-other).

## 7. How long does my service live?

This is where a working wiring becomes a *correct* one. Under a persistent worker a singleton lives for the whole process, so anything it holds from one request is visible to the next. The rule of thumb: **transient or request unless you have confirmed the class holds no per-request state.**

A class declares its own lifetime with `#[Service]`, and that is the one place worth putting it:

| Declaration | Scope |
|---|---|
| `#[Service(scope: …)]` | whatever you wrote |
| bare `#[Service]`, or `ServiceInterface` | transient |
| neither | request |

The `$scope` argument on `service()`, `set()` and `setFactory()` is nullable, and omitting it asks the binding rather than assuming process lifetime — a class name answers with the table above, a factory gets request scope, an already-built instance or a bound value is a singleton. So registering `OrderService` purely to alias it leaves its lifetime alone:

```php
// null scope: OrderService keeps whatever lifetime its own class declares
$r->service(OrderService::class, OrderService::class, null, OrderPlacer::class);
```

Passing the scope anyway is still worth it in a plugin, whose services live in every application that enables it:

```php
$r->service(OrderService::class, OrderService::class, Container::SCOPE_REQUEST);
```

### The error you will eventually hit

A singleton that constructor-injects a request-scoped service is refused at wiring time, not left to leak:

```
Cannot autowire 'App\Service\AuditLogger': it is singleton-scoped but parameter $user
depends on 'Quiote\User\SecurityUser', which is request-scoped. The singleton would capture
one request's instance and keep serving it to every later request in a persistent worker.
Inject Quiote\User\CurrentUser instead; it resolves per call and holds nothing.
```

The message names the fix. `CurrentUser` and `RequestState` hold nothing themselves — each call reaches through to the live object — so a singleton can hold them safely:

```php
final class AuditLogger
{
    public function __construct(private readonly CurrentUser $currentUser) {}

    public function record(string $action): void
    {
        $user  = $this->currentUser->get();   // User|ISecurityUser
        $actor = $user instanceof SecurityUser ? $user->getUsername() : 'anonymous';
        // ...
    }
}
```

Actions, views and validators are exempt: `make()` never caches them, so they may inject request-scoped collaborators freely. See [a singleton cannot depend on request-scoped state](/architecture/container/#a-singleton-cannot-depend-on-request-scoped-state).

## 8. Optional and cross-cutting dependencies

**A dependency you can do without** — "use the app's PSR-18 client if one is bound" — asks with `tryGet()`, which answers `null` instead of throwing:

```php
$client = $container->tryGet(ClientInterface::class) ?? new DefaultClient();
```

**A dependency you don't want in every constructor** — a logger, typically — can arrive through a setter marked `#[Required]`. The container calls every `#[Required]` method after construction, with autowired arguments:

```php
use Symfony\Contracts\Service\Attribute\Required;

#[Required]
public function setLogger(LoggerInterface $logger): void
{
    $this->logger = $logger;
}
```

A `#[Required]` method named `initialize()`, or one type-hinting `ActionInitContext` / `ViewInitContext`, is refused — those are per-request framework hooks the container does not own.

## 9. When injection genuinely doesn't fit

A legacy call site, or a lookup that is conditional deep inside a method, can go through the container directly:

```php
$orders = $this->getContext()->getContainer()->get(OrderService::class);
```

`get()` is typed on the class it is given, so this is as well typed as an injected property. It is still worth avoiding: a class that resolves its collaborators mid-method tells a reader nothing about what it needs, and a test cannot substitute them without touching global state. Injection is the default; this is the exception.

## 10. Testing what you wired

Constructor injection's whole payoff is here: **the unit under test needs no container at all.**

```php
$service = new OrderService(new InMemoryOrderRepository(), new FrozenClock('2026-01-01'));

$order = $service->placeOrder($cart);
```

The same goes for the action, since its dependencies are also just constructor arguments:

```php
$action = new PlaceOrderAction($fakeOrderService);
```

When you want the container to build the graph but with one piece swapped, `make()` takes overrides matched by parameter **name or type**:

```php
$action = $container->make(PlaceOrderAction::class, [
    OrderService::class => $fakeOrderService,
]);
```

And to change what a *whole request* resolves — driving the pipeline with [`HttpTestCase`](/advanced/testing/#the-fluent-http-client), say — rebind on the context's container and clean up afterwards:

```php
protected function setUp(): void
{
    parent::setUp();
    $this->getContext()->getContainer()->set(ClockInterface::class, new FrozenClock('2026-01-01'));
}

protected function tearDown(): void
{
    $this->getContext()->getContainer()->unset(ClockInterface::class);
    parent::tearDown();
}
```

`unset()` drops the binding and any instance resolved from it; `forgetResolved()` drops only the instance, keeping the binding that produced it. See [Testing your application](/advanced/testing/).

## When the container refuses: reading the error

The container never guesses, so every failure names what it was building and what it could not supply.

| Message | What it means | Fix |
|---|---|---|
| `Cannot autowire 'C': unsatisfied dependency 'D' for parameter $x` | `D` is an interface, an abstract class, or not instantiable | bind it — [step 4](#4-the-first-thing-that-needs-registering-an-interface) |
| `Cannot autowire 'C': untyped parameter $x without default` | a scalar or untyped parameter with nothing to resolve it from | `#[Autowire]`, a `set()` params binding, or a factory — [step 5](#5-feeding-a-service-configuration) |
| `Service 'X' not found and no autowireable class/alias exists` | the id was never registered and names no instantiable class | check the spelling, or register it |
| `Cannot autowire 'C': it is singleton-scoped but parameter $x depends on '…', which is request-scoped` | the captive-dependency guard | inject `CurrentUser` / `RequestState`, or make `C` request-scoped — [step 7](#the-error-you-will-eventually-hit) |
| `Circular dependency detected while resolving 'X': A -> B -> A` | a cycle; the full path is in the message | break it — usually one of the two should take a narrower collaborator |
| `The container resolves "X" to Y, which is not a X` | something is bound under `X` that isn't one | check what was registered for that id |
| `Failed constructing 'C': …` | the constructor itself threw, after arguments resolved fine | the message wraps the original exception |
| `Error while invoking factory for 'X': …` | a factory closure threw | as above, in the closure |

One more worth knowing: **`has()` reports only explicit registrations**, not everything that *could* be autowired. A mistyped class name therefore fails loudly at resolution rather than a look-alike being quietly constructed.

## Where to go next

- [The DI container](/architecture/container/) — the reference: full autowiring order, the container API, scopes in detail.
- [Services and models](/basics/services-and-models/) — which of your classes should be a service at all, and which should stay a model.
- [Writing a plugin](/architecture/plugins/) — everything else `PluginRegistrar` can register alongside services.
