# RecorderMiddleware

> Captures the request/response/resolved/session/exception detail for a request and writes a Cassette for whichever requests SamplingPolicy keeps.

Captures the request/response/resolved/session/exception detail for a request and writes a [`Cassette`](/api/replay/cassette/cassette/) for whichever requests [`SamplingPolicy`](/api/replay/recording/sampling-policy/) keeps.

Registered `phase: 'bootstrap', priority: 1100` -- between `StealthMiddleware` (1200) and `ErrorHandlingMiddleware` (1000) -- so it observes the *rendered* error response and also catches an exception that escapes error handling entirely. Being outermost means the PSR-7 request this middleware receives back never reflects attributes inner middleware attached (`withAttribute()` clones don't propagate outward), so resolved routing/validation state is read from [`RequestState::current()`](/api/request/request-state/#current) instead -- see the two small `RequestState::publish()` additions in `RoutingMiddleware`/`DispatchMiddleware` this depends on.

Effects: this package carries no compile-time dependency on any ORM/DB driver. A driver-specific package (e.g. `quioteframework/replay-propulsion`) registers an [`EffectSource`](/api/replay/recording/effect-source/) via [`EffectSourceRegistry::register()`](/api/replay/recording/effect-source-registry/#register) from its own plugin, and this middleware activates/deactivates every registered source for the duration of `$handler->handle()` -- see [`EffectSource`](/api/replay/recording/effect-source/)'s own docblock for why a driver needs this seam at all rather than just taking an `EffectLedger` directly (Propulsion's `addQueryObserver()` being process-scoped, not request-scoped, is the motivating case; a per-request decorator around a specific connection, the PDO/Doctrine/Eloquent/Cycle shape, has no need of it). HTTP/cache/queue/env effects are not populated by this middleware either: those still require the app's live client/cache/queue instances to be swapped for their `Recording*` counterparts, a distinct integration task per subsystem. `meta.effects_instrumented` states whether any `EffectSource` is registered at all, so a `cassette:show` reader can tell "nothing happened" apart from "nothing was watched" without reading this source file. `response.stray_output` is likewise always empty: `OutputCapture` is owned by `Quiote\Runtime\Kernel` and not reachable from a PSR-15 middleware.

## Synopsis

`final class RecorderMiddleware implements MiddlewareInterface, ResetInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/), `ResetInterface` |
| Source | `Recording/RecorderMiddleware.php` |

## Constructor

### __construct()

`public function __construct(Context $context, CassetteStoreInterface $store, ClockInterface $clock = new SystemClock(…), RandomnessInterface $randomness = new SystemRandomness(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$store` | [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) | Process an incoming server request. |
| [`reset(): void`](#reset) | Stateless: every capture below lives in a local variable inside process(), never on $this, so two sequential requests through one worker-reused instance already produce two independent cassettes. |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Process an incoming server request.

Processes an incoming server request in order to produce a response. If unable to produce the response itself, it may delegate to the provided request handler to do so.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### reset()

`public function reset(): void`

Stateless: every capture below lives in a local variable inside process(), never on $this, so two sequential requests through one worker-reused instance already produce two independent cassettes.

Implements ResetInterface anyway, matching [`WebRequest`](/api/request/web-request/)'s own precedent, so a future stateful addition is forced to wire its own reset rather than being missed.
