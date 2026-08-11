# Context

> An execution profile -- web, console, a named one -- and the container its services resolve from.

An execution profile -- web, console, a named one -- and the container its services resolve from.

The context owns its own identity and lifecycle: it initializes the components the compiled factories configuration declares, binds them, arms and clears per-request state, and shuts them down in order. It does not hand out its collaborators; a class that needs the routing, the user or a service declares that in its constructor and the container supplies it. [`ContextInterface`](/api/context-interface/) is what a collaborator should type-hint, and it is two methods wide for that reason.

A subclass named by `core.context_implementation` must keep the constructor signature: the registry builds it knowing only the profile name.

## Synopsis

`class Context implements ContextInterface, Stringable, ResetInterface`

|  |  |
|---|---|
| Implements | [`ContextInterface`](/api/context-interface/), [`Stringable`](https://www.php.net/manual/en/class.stringable.php), `ResetInterface` |
| Since | `1.0.0` |
| Source | `Context.php` |

## Constructor

### __construct()

`protected function __construct(string $name): mixed`

Constructor method, intentionally made protected so the context cannot be created directly.

The name of this context.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of this context. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__clone(): mixed`](#clone) | Clone method, overridden to prevent cloning, there can be only one. |
| [`__toString(): string`](#tostring) | __toString overload, returns the name of the Context. |
| [`beginRequest(): void`](#beginrequest) | Arm this context for a new request. |
| [`create(string $profile): static`](#create) | Build an uninitialized context for a profile. |
| [`flushRequestState(bool $persistUser = true): void`](#flushrequeststate) | Persist request-scoped state that lives in the session. |
| [`getContainer(): Container`](#getcontainer) | This profile's container, built on first use. |
| [`getCorrelationId(): ?string`](#getcorrelationid) | Retrieve current correlation ID (may be null outside a handled request). |
| [`getInstance(string $profile = null): Context`](#getinstance) | Retrieve the Context instance. |
| [`getLifecycle(): ContextLifecycle`](#getlifecycle) | This context's per-request lifecycle -- the flush claim and the end-of-request clears. |
| [`getModelLocator(): ModelLocator`](#getmodellocator) | Retrieve (lazily create) this context's model locator. |
| [`getName(): string`](#getname) | Retrieve the name of this Context. |
| [`getRequestHandler(): RequestHandlerInterface`](#getrequesthandler) | This context's request handler, built on first use. |
| [`getShutdownSequence(): ShutdownSequence`](#getshutdownsequence) | The components this context shuts down, in order. |
| [`initialize(): void`](#initialize) | (re)Initialize the Context instance. |
| [`reset(): void`](#reset) | Ends the request on this context and clears everything request-scoped. |
| [`resetWorkerState(?string $profile = null): void`](#resetworkerstate) | Reset every live context's request-scoped state at a persistent worker's request boundary, preserving each context's configuration. |
| [`shutdown(): void`](#shutdown) | Shut down this Context and all related factories. |

### __clone()

`public function __clone(): mixed`

Clone method, overridden to prevent cloning, there can be only one.

Returns `mixed`

### __toString()

`public function __toString(): string`

__toString overload, returns the name of the Context.

Returns `string` — The context name.

### beginRequest()

`public function beginRequest(): void`

Arm this context for a new request.

Re-arms the per-request state flush so the next flushRequestState() actually runs. Called by the request handler on the way in; [`ContextLifecycle::endRequest()`](/api/context-lifecycle/#endrequest) does it too, on the way out, and this covers a runtime that serves requests without a reset between them.

### create()

`public static function create(string $profile): static`

Build an uninitialized context for a profile.

The named constructor [`ContextRegistry`](/api/context-registry/) uses. The registry is what guarantees one context per profile, so it needs a way in that the constructor's protected visibility does not give it -- but going through here rather than opening the constructor keeps `new Context()` from being written casually, since an unregistered context is not the one anything else in the process will find.

initialize() is deliberately not called: the registry has to record the instance before initialization runs, so a context reaching back for its own profile mid-initialize finds itself instead of recursing into a second one.

| Parameter | Type | Description |
|---|---|---|
| `$profile` | `string` |  |

Returns `static`

### flushRequestState()

`public function flushRequestState(bool $persistUser = true): void`

Persist request-scoped state that lives in the session.

False for a sessionless request
            (auth.sessionless / jwt.skip_session): there is no session to
            persist into, and writing a token-derived identity into
            whatever unrelated session cookie the client still carries
            would be wrong. The flush is still *claimed*, so the post-emit
            reset() does not attempt a late write.

| Parameter | Type | Description |
|---|---|---|
| `$persistUser` | `bool` | False for a sessionless request (auth.sessionless / jwt.skip_session): there is no session to persist into, and writing a token-derived identity into whatever unrelated session cookie the client still carries would be wrong. The flush is still *claimed*, so the post-emit reset() does not attempt a late write. |

### getContainer()

`public function getContainer(): Container`

This profile's container, built on first use.

Every component the compiled factories configuration declares is bound here under both its role name and its concrete class name, so `get(\Quiote\User\User::class)` and `get(RbacSecurityUser::class)` answer the same instance.

Returns [`Container`](/api/di/container/)

### getCorrelationId()

`public function getCorrelationId(): ?string`

Retrieve current correlation ID (may be null outside a handled request).

Returns `?``string`

### getInstance()

`public static function getInstance(string $profile = null): Context`

Retrieve the Context instance.

A name corresponding to a section of the config

| Parameter | Type | Description |
|---|---|---|
| `$profile` | `string` | A name corresponding to a section of the config |

Returns [`Context`](/api/context/) — An context instance initialized with the settings of the requested context name

### getLifecycle()

`public function getLifecycle(): ContextLifecycle`

This context's per-request lifecycle -- the flush claim and the end-of-request clears.

Exposed so a host that drives the context itself can register a clear of its own without going through the plugin registry, and so what a context clears is assertable.

Returns [`ContextLifecycle`](/api/context-lifecycle/)

### getModelLocator()

`public function getModelLocator(): ModelLocator`

Retrieve (lazily create) this context's model locator.

The locator owns model resolution and model lifetimes; the context only owns the fact that there is one per context. Constructor-inject [`ModelLocator`](/api/model/model-locator/) in new code.

Returns [`ModelLocator`](/api/model/model-locator/)

### getName()

`public function getName(): string`

Retrieve the name of this Context.

Returns `string` — A context name.

### getRequestHandler()

`public function getRequestHandler(): RequestHandlerInterface`

This context's request handler, built on first use.

Declared as the PSR contract rather than as [`ContextRequestHandler`](/api/runtime/context-request-handler/): every caller outside the handler's own tests wants nothing but handle(), and a runtime that serves a context through a handler of its own is then wiring, not a subclass.

Returns [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/)

### getShutdownSequence()

`public function getShutdownSequence(): ShutdownSequence`

The components this context shuts down, in order.

The generated factory cache installs the sequence through here, and the lazy component recreation paths splice replacements back into it.

Returns [`ShutdownSequence`](/api/shutdown-sequence/)

### initialize()

`public function initialize(): void`

(re)Initialize the Context instance.

### reset()

`public function reset(): void`

Ends the request on this context and clears everything request-scoped.

Resets the model locator and the controller, flushes any user state that the middleware did not already persist, and recycles the database manager's connections instead of shutting it down, so the manager survives into the next request. The registered lifecycle clears -- session bag, user, request, logging scopes, request-scoped container entries and the registered resettable instances -- run in a `finally`, so a throw anywhere above cannot leave request N's authenticated user installed for request N+1.

### resetWorkerState()

`public static function resetWorkerState(?string $profile = null): void`

Reset every live context's request-scoped state at a persistent worker's request boundary, preserving each context's configuration.

The profile that served the request; it is reset first, but
            every other live context is reset too.

| Parameter | Type | Description |
|---|---|---|
| `$profile` | `?``string` | The profile that served the request; it is reset first, but every other live context is reset too. |

### shutdown()

`public function shutdown(): void`

Shut down this Context and all related factories.
