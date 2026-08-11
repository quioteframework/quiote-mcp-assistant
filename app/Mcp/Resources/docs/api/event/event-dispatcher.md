# EventDispatcher

> A minimal PSR-14 dispatcher over a ListenerProvider.

A minimal PSR-14 dispatcher over a [`ListenerProvider`](/api/event/listener-provider/).

Per PSR-14, the dispatcher does not swallow listener exceptions — a throwing listener propagates to the caller (fail-loud). Framework emit sites that must survive a misbehaving listener (the request pipeline) wrap their own [`EventDispatcher::dispatch()`](/api/event/event-dispatcher/#dispatch) call in try/catch; see [`Events`](/api/event/events/) call sites.

## Synopsis

`final class EventDispatcher implements EventDispatcherInterface`

|  |  |
|---|---|
| Implements | [`EventDispatcherInterface`](https://www.php-fig.org/psr/psr-14/) |
| Source | `Event/EventDispatcher.php` |

## Constructor

### __construct()

`public function __construct(ListenerProvider $provider = new ListenerProvider(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$provider` | [`ListenerProvider`](/api/event/listener-provider/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`dispatch(object $event): object`](#dispatch) | Passes the event to every matching listener and returns the same instance. |
| [`provider(): ListenerProvider`](#provider) | Returns the listener provider this dispatcher draws its listeners from, for registration. |

### dispatch()

`public function dispatch(object $event): object`

Passes the event to every matching listener and returns the same instance.

Listeners run in the order the provider yields them (priority first, then registration order). If the event implements `StoppableEventInterface`, propagation is checked before the first listener — an already-stopped event is returned untouched — and again after each listener, breaking out as soon as one stops it. Listener exceptions are not caught and propagate to the caller.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `object` |  |

Returns `object`

### provider()

`public function provider(): ListenerProvider`

Returns the listener provider this dispatcher draws its listeners from, for registration.

Returns [`ListenerProvider`](/api/event/listener-provider/)
