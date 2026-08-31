# Testing your application

> Unit-testing actions and services, driving the full pipeline with HttpTestCase, and process isolation for worker-safe tests.

Quiote targets long-lived codebases, so it ships a test harness built on **PHPUnit**. The framework's own test suite is the reference: it runs the real container, real config, and (for flow tests) the real middleware pipeline against PSR-7 requests. This page covers the patterns that suite actually uses.

## Which approach to reach for

Quiote gives you several test entry points. Pick by how much of the request you need to exercise:

- **Testing a service, model, or any plain unit?** Extend [`UnitTestCase`](#the-foundation-unittestcase), resolve it from the context, and call it directly. This is the default — reach for it first.
- **Testing a full request end to end** (routing, middleware, action, view, response)? Extend [`HttpTestCase`](#the-fluent-http-client) and call `$this->get('/orders')`. It drives the real pipeline through the same entry point production traffic uses.
- **Need to control the exact middleware stack** for that end-to-end test? [Compose it yourself](#testing-the-full-pipeline) against a PSR-7 request.
- **Testing just one action's view-name outcome?** [`ActionTestCase`](#the-fragment-harness) skips routing and dispatches a single action.
- **A test that mutates global state** (locale, environment, default context)? Add [process isolation](#process-isolation) so it can't poison sibling tests.

The rest of the page works through each in that order.

## Running tests

Tests are driven by PHPUnit through Composer scripts:

```bash
composer test              # the default suite (unit, flow, fragment, psr)
composer test:apcu         # APCu config-cache tests (needs apc.enable_cli)
composer test:integration  # database integration tests (Docker / Testcontainers)
composer test:e2e          # end-to-end tests (Docker)
```

The default run uses the project's root `phpunit.xml`, which excludes the `apcu`, `e2e`, and `integration` groups so the common case stays fast and Docker-free. The slower suites are opt-in.

## The foundation: `UnitTestCase`

Most tests extend `Quiote\Testing\UnitTestCase`. It bootstraps the framework once (in the `testing` environment) and gives you a live `Context` plus a helper for building requests:

```php
use Quiote\Testing\UnitTestCase;

final class OrderServiceTest extends UnitTestCase
{
    public function testPlacingAnOrderPersistsIt(): void
    {
        $context = $this->getContext();
        $service = $context->getContainer()->get(\App\Service\OrderService::class);

        $order = $service->placeOrder($this->sampleCart());

        $this->assertNotNull($order->id);
    }
}
```

`getContext()` returns the bootstrapped context, so you can resolve services, models, and other collaborators exactly as the running application would. For request-driven code, `newWebRequest($params, $whitelist)` builds a PSR-7 `WebRequest` with the given parameters already whitelisted (so [strict parameter access](/basics/requests-and-responses/#strict-parameter-access) doesn't get in the way):

```php
$request = $this->newWebRequest(['name' => 'Ada']);
$result  = $service->handle($request);
```

This — a `UnitTestCase` that resolves the unit under test from the context and exercises it directly — is the dominant pattern in the framework's own suite, and the one to reach for first.

## The fluent HTTP client

To test a whole request — routing, middleware, action, view, response — extend `Quiote\Testing\HttpTestCase`. Unlike `ActionTestCase`, which dispatches a single action in isolation, this drives the request through `$context->getRequestHandler()->handle()`: the same entry point production traffic uses, with the app's real middleware pipeline in place.

```php
use Quiote\Testing\HttpTestCase;

final class OrdersTest extends HttpTestCase
{
    public function testCreatingAnOrderReturnsItsId(): void
    {
        $this->post('/orders', ['sku' => 'WIDGET-1', 'qty' => 3])
            ->assertCreated()
            ->assertJson(['sku' => 'WIDGET-1']);
    }

    public function testAnUnknownOrderIs404(): void
    {
        $this->get('/orders/99999')->assertNotFound();
    }
}
```

### Making requests

| Method | Body |
|---|---|
| `get($uri, $headers = [])` | none |
| `post` / `put` / `patch` / `delete($uri, $data = [], $headers = [])` | form-encoded (`application/x-www-form-urlencoded`) |
| `json($method, $uri, $data = [], $headers = [])` | JSON (`application/json`) |

`json()` takes the verb as its first argument, so `$this->json('PUT', '/orders/1', [...])` covers the JSON-body case for any method. In every case an explicit `Content-Type` in `$headers` wins over the default. Set `protected ?string $contextName` on the test class to dispatch through a non-default context.

### Asserting on the response

Each method returns a `Quiote\Testing\Http\TestResponse` wrapping the PSR-7 response. Every `assert*` method returns `$this`, so they chain:

| Assertion | Checks |
|---|---|
| `assertStatus($code)` | Exact status code |
| `assertOk()` / `assertCreated()` / `assertNoContent()` | 200 / 201 / 204 |
| `assertUnauthorized()` / `assertForbidden()` / `assertNotFound()` | 401 / 403 / 404 |
| `assertRedirect($uri = null)` | A 3xx, optionally to a specific `Location` |
| `assertHeader($name, $value = null)` | Header present, optionally with an exact value |
| `assertSee($needle)` / `assertDontSee($needle)` | Substring in the raw body |
| `assertJsonEquals($array)` | Decoded body matches exactly |
| `assertJson($array)` | Decoded body **contains** this as a subset |
| `assertJsonFragment($array)` | Subset matches the body, *or* any one element of a list body |
| `assertXml($xml)` | Body matches, canonicalized (so whitespace/attribute order don't matter) |
| `assertHasXPath($expr)` | XPath expression matches something in the body |

For anything the assertions don't cover, `getPsrResponse()`, `getStatusCode()`, `getHeaderLine()`, `getContent()`, `json()` and `xml()` give you the raw material.

### App-specific assertions

Rather than subclassing `TestResponse`, register your own assertions on it. `TestResponse::extend()` takes a name and a callable that is bound to the response, so `$this` inside it is the `TestResponse`:

```php
TestResponse::extend('assertApiError', function (string $code): TestResponse {
    return $this->assertStatus(422)->assertJson(['error' => ['code' => $code]]);
});

// then, in any test:
$this->post('/orders', [])->assertApiError('sku_required');
```

Extensions are process-global (register them in your suite bootstrap or a shared base class), `hasExtension()` tells you whether a name is taken, and `clearExtensions()` resets the registry. Calling a name that is neither a real method nor a registered extension throws with a "did you mean…?" suggestion rather than a bare `BadMethodCall`.

## Testing the full pipeline

`HttpTestCase` uses the pipeline the app is actually configured with. When you need to control the middleware stack *exactly* — testing one middleware in isolation, or asserting on ordering — compose the stack yourself against a PSR-7 request. This is how the framework's own pipeline tests work:

```php
use PHPUnit\Framework\TestCase;
use Nyholm\Psr7\ServerRequest;
use Relay\Relay;
use Quiote\Quiote;
use Quiote\Execution\ActionDescriptor;
use Quiote\Middleware\{ErrorHandlingMiddleware, SecurityMiddleware, ValidationMiddleware, DispatchMiddleware};

final class ShowPostFlowTest extends TestCase
{
    public function testItRenders(): void
    {
        Quiote::bootstrap('testing', 'web', ['prewarm' => false]);
        $controller = Quiote::context('web', true)->getContainer()->get(Controller::class);

        $descriptor = new ActionDescriptor('Blog', 'ShowPost', 'GET', 'html', false);
        $stack = [
            new ErrorHandlingMiddleware(),
            new SecurityMiddleware($controller),
            new ValidationMiddleware($controller),
            new DispatchMiddleware($controller),
        ];

        $request = (new ServerRequest('GET', 'http://localhost/blog/1'))
            ->withAttribute('module', 'Blog')
            ->withAttribute('action', 'ShowPost')
            ->withAttribute('output_type', 'html')
            ->withAttribute(ActionDescriptor::class, $descriptor);

        $response = (new Relay($stack))->handle($request);

        $this->assertSame(200, $response->getStatusCode());
    }
}
```

Because this runs the actual middleware, it catches wiring problems a unit test wouldn't — security decisions, validation pruning, view resolution.

:::caution[Exercise the error path too, not just the happy path]
A custom middleware that reads or modifies the response (adding a header, say) can pass every happy-path assertion and still silently do nothing on an error response, if it's positioned relative to `ErrorHandlingMiddleware` incorrectly — see [Writing custom middleware: ErrorHandlingMiddleware placement](/advanced/custom-middleware/#errorhandlingmiddleware-before-and-after-are-not-symmetric). When you write a flow test for a new middleware that touches the response, add a second case that dispatches to a route that throws and assert your middleware's effect still shows up on the resulting error response — not just the 200 case.
:::

## Sessions

A test that needs a session binds one in the context's container, request-scoped, exactly as `SessionMiddleware` does — there is nothing to reach for by reflection:

```php
use Quiote\DI\Container;
use Quiote\Session\{SessionManager, SessionBagInterface, FileSessionPersistence, QuioteSessionBag};
use Nyholm\Psr7\ServerRequest;

$manager = new SessionManager(new FileSessionPersistence(sys_get_temp_dir() . '/qtest'));
$request = new ServerRequest('GET', 'http://localhost/');
$session = $manager->startFromRequest($request);

$context->getContainer()->set(
    SessionBagInterface::class,
    new QuioteSessionBag($manager, $session, $request),
    Container::SCOPE_REQUEST,
);
```

For a test that only needs to observe what the code under test wrote, a hand-rolled in-memory `SessionBagInterface` is usually simpler than a real backend — the interface is eight methods (`get`, `has`, `set`, `remove`, `exists`, `getId`, `regenerate`, `destroy`), so a `private array $data` double is a few lines.

`unset()` drops the binding, and the next resolution rebuilds the lazy default:

```php
$context->getContainer()->unset(SessionBagInterface::class);

$bag = $context->getContainer()->get(SessionBagInterface::class);   // Quiote\Session\NullSessionBag
$bag->set('k', 'v');
$this->assertNull($bag->get('k'));  // writes are discarded
$this->assertFalse($bag->exists());
$this->assertSame('', $bag->getId());
```

That is the shape a console command, a queue worker or a stateless API runs in, so it is worth asserting against directly if your code has a sessionless path.

`Context::setSessionManager()` is the companion seam: it installs a manager without a configured `session` factory slot, which is what lets a test exercise anything that asks the manager for its cookie name — CSRF validation, most obviously.

## Time, randomness and the environment

Three ambient reads are behind seams, so a test controls them without touching the code under test. Every `now()`, `random_bytes()`/`random_int()` and `getenv()` call inside the framework goes through one of them.

| Facade | Interface | Test implementations |
|---|---|---|
| `Quiote\Support\Clock\Clock` | `ClockInterface` (extends PSR-20) | `FrozenClock`, `OffsetClock` |
| `Quiote\Support\Random\Randomness` | `RandomnessInterface` | `SeededRandomness` |
| `Quiote\Support\Environment\Environment` | `EnvironmentReaderInterface` | write your own, or a closure-backed stub |

Each facade's `use*()` method installs an implementation process-wide **and returns the one it replaced**, so restoring is a `finally` away:

```php
$previous = Clock::useClock(FrozenClock::fromDateTime(new \DateTimeImmutable('2026-03-01 12:00:00')));
try {
    // ... assert behaviour at that instant
} finally {
    Clock::useClock($previous);
}
```

`FrozenClock` also has `advance($seconds)` and `set()`, so a test can step time forward across an expiry boundary rather than sleeping. `ClockInterface` splits the two kinds of reading on purpose: `now()`/`unixTimestamp()`/`microtime()` are wall clock, for anything that stores or compares an epoch-relative expiry, while `monotonic()` never steps backwards on an NTP correction — which is what measuring a duration actually needs.

Prefer constructor-injecting `ClockInterface`, `RandomnessInterface` or `EnvironmentReaderInterface` where you can: the container binds all three, and an injected collaborator needs no global install and no restore. The facades exist for the fully-static call sites that have no container to resolve through — and `Context` seeds the container's own bindings *from* the facades, so installing an implementation before bootstrap reaches both.

All three arrived in 4.2, and they are what makes [replay](/advanced/record-replay/)'s isolated mode possible: it freezes the clock at a cassette's recorded instant and answers environment reads from the cassette.

## Other seams worth knowing

Four more things that used to need reflection and don't:

| Need | Use |
|---|---|
| Install a configuration and restore the previous one | `Config::useRepository(new ConfigRepository([...]))`, which returns the one it replaced |
| Drop a composed middleware pipeline after reconfiguring `MiddlewareCatalog` | `$context->getRequestHandler()->forgetPipeline()` |
| Inspect or rearrange context shutdown | `$context->getShutdownSequence()` — `append()`, `remove()`, `replaceRole()`, `all()` |
| Build a context directly | `Context::create()`, the named constructor `ContextRegistry` uses |

```php
$previous = Config::useRepository(new ConfigRepository(['core.debug' => true]));
try {
    // ... assert behaviour under this configuration
} finally {
    Config::useRepository($previous);
}
```

`forgetPipeline()` matters because the pipeline is composed once and reused for the worker's lifetime — a test that registers middleware after a request has already been served would otherwise keep running against the stale one.

## The fragment harness

The framework also ships focused base classes for testing a single MVC fragment in isolation, without going through routing:

| Base class | For testing |
|---|---|
| `ActionTestCase` | One action's dispatch outcome (which view it returns) and validation |
| `ViewTestCase` | One view's output for an output type |
| `FragmentTestCase` | Shared base for the action/view fragment cases |

`ActionTestCase` is the most useful of these. You set the module and action, seed parameters, optionally run validation, then dispatch and assert on the resolved view name:

```php
use Quiote\Testing\ActionTestCase;

final class SaveUserActionTest extends ActionTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->moduleName = 'User';
        $this->actionName = 'Save';
    }

    public function testWriteReturnsSuccessView(): void
    {
        $this->setRequestMethod('write');                 // POST
        $this->applyRequestParameters(['name' => 'Ada']);

        $this->performValidation();
        $this->assertTrue($this->validationSuccess);

        $this->runAction();
        $this->assertViewNameEquals('Success');
    }
}
```

`ViewTestCase` runs one view and asserts on the response it built. `runView()` invokes the `execute{OutputType}()` method (falling back to `execute()`) with the request, the way `ActionExecutor` does, and the assertions read the resulting `WebResponse`:

```php
use Quiote\Testing\ViewTestCase;

final class UserSuccessViewTest extends ViewTestCase
{
    public function testRedirectsToTheProfile(): void
    {
        $this->runView('html');

        $this->assertViewRedirectsTo('/profile');            // the location, not the whole record
        $this->assertViewSetsHeader('X-Total', '3');
        $this->assertViewResponseHasHTTPStatus(302);
    }
}
```

`assertViewRedirectsTo()` takes the location, `assertViewSetsHeader()` a header name and one value, and `assertViewSetsCookie()` a cookie name and its value — each compares the value its signature promises, not the internal record it lives in.

:::note[These base classes are transitional]
`ActionTestCase`, `ViewTestCase`, and `ContainerTestCase` emulate a pre-PSR-7 execution container that has since been removed, and the framework's own suite has largely moved to `UnitTestCase` plus the middleware-composition pattern above. `ActionTestCase`'s argument assertions need a `performValidation()` call first, since arguments are populated by validation. `ContainerTestCase` refers to that old *execution* container, **not** the DI container. For new tests, prefer `UnitTestCase` and pipeline composition; use `ActionTestCase` for the view-name-outcome case where it fits.
:::

## Process isolation

Quiote holds a lot of process-wide state — the config store, compiled config, the APCu cache, context singletons. Under [worker mode](/architecture/deployment/) that state persists across requests by design; in a test process it means one test's environment or locale change can poison later tests in the same process. The harness solves this with **process isolation** plus a clean re-bootstrap per isolated test.

Mark a test class (or method) to run in a separate process and declare the environment it should bootstrap:

```php
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Quiote\Testing\Attributes\{IsolationEnvironment, IsolationDefaultContext, ClearIsolationCache};

#[RunTestsInSeparateProcesses]
#[IsolationEnvironment('testing.integration')]
#[IsolationDefaultContext('web')]
#[ClearIsolationCache]
final class LocaleSensitiveTest extends \Quiote\Testing\PhpUnitTestCase
{
    #[IsolationEnvironment('testing.other')]   // method-level override wins
    public function testInAnotherEnvironment(): void { /* ... */ }
}
```

The isolation attributes:

| Attribute | Effect |
|---|---|
| `IsolationEnvironment('name')` | Bootstrap this environment in the isolated process. |
| `IsolationDefaultContext('name')` | Set `core.default_context` for it. |
| `ClearIsolationCache` | Clear the compiled-config/cache dir first. |
| `Bootstrap(false)` | Skip bootstrapping Quiote in the child. |

Under the hood, PHPUnit runs the marked test in a separate process (via `RunTestsInSeparateProcesses`) and `PhpUnitTestCase::setUp()` re-establishes a pristine framework in that child process — the test-time equivalent of a fresh worker. The project's `phpunit.xml` sets `QUIOTE_ISOLATION_*` environment variables to configure this suite-wide. Reach for isolation whenever a test mutates global state (environment, locale, default context) that a sibling test could inherit.

## E2E and integration groups

Two heavier suites are gated by stock PHPUnit groups so they stay out of the default run:

- **`#[Group('integration')]`** — database integration tests that spin up real databases with Testcontainers. Run with `composer test:integration`.
- **`#[Group('e2e')]`** — end-to-end tests that stand up a real FrankenPHP worker (and, for telemetry, an OpenTelemetry collector) via docker-compose and assert on live behaviour. Run with `composer test:e2e`.

Both need Docker and are excluded from `composer test`, so day-to-day development stays fast while the full-stack checks remain available in CI.
