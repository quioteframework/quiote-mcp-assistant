# RequestState

> The seam onto the request that is current *now*.

The seam onto the request that is current *now*.

[`WebRequest`](/api/request/web-request/) is immutable, so every mutation produces a new instance and the request is replaced many times within a single request -- validation alone replaces it. Anything that holds a `WebRequest` therefore holds a snapshot, and a snapshot taken at construction is the pre-validation request: reading a parameter from it bypasses the strict-validation whitelist. That is why the container refuses to inject a request into a singleton at all.

This is what to inject instead. It resolves through to the context on every call and holds nothing, so there is no instance for a stale request to hide in:

```php public function __construct(private readonly RequestState $requestState) {} // ... $rd = FormPopulationConfig::merge($this->requestState->current(), [...]); $this->requestState->publish($rd); ```

Inside an action or a view, prefer the `WebRequest` parameter already handed to `executeRead()`/`execute*()` -- it is the current request by construction. This class is for publishing a replacement, and for collaborators that outlive a single request.

## Synopsis

`final class RequestState`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Request/RequestState.php` |

## Constructor

### __construct()

`public function __construct(\Closure(): WebRequest $read, \Closure((WebRequest | ServerRequestInterface)): void $write): mixed`

Installs a replacement.

Two closures rather than the Context itself, because `Context::getRequest()`/`setRequest()` are
gone: the read and the write are what this class needs, and taking exactly those means nothing
else on the context is reachable through it.

| Parameter | Type | Description |
|---|---|---|
| `$read` | `\Closure(): WebRequest` | Answers the request as of now. |
| `$write` | `\Closure((WebRequest | ServerRequestInterface)): void` | Installs a replacement. Two closures rather than the Context itself, because `Context::getRequest()`/`setRequest()` are gone: the read and the write are what this class needs, and taking exactly those means nothing else on the context is reachable through it. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`current(): WebRequest`](#current) | The request as of this call, built from the factory metadata if the worker request boundary has cleared it. |
| [`publish(WebRequest|ServerRequestInterface $request): void`](#publish) | Install a replacement as the current request. |

### current()

`public function current(): WebRequest`

The request as of this call, built from the factory metadata if the worker request boundary has cleared it.

Returns [`WebRequest`](/api/request/web-request/)

### publish()

`public function publish(WebRequest|ServerRequestInterface $request): void`

Install a replacement as the current request.

Every `WebRequest` mutator returns a new instance rather than mutating in place, so the result has to be published or the change is simply discarded -- silently, because dropping a return value is not an error. Anything that mutates the request must end here.

A foreign PSR-7 request is normalized into a [`WebRequest`](/api/request/web-request/) on the way in, so [`RequestState::current()`](/api/request/request-state/#current) always answers one.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`WebRequest`](/api/request/web-request/)`|`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
