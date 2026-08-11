# ListenerProvider

> Priority-ordered PSR-14 listener provider.

Priority-ordered PSR-14 listener provider.

Listeners are registered against an event class name and are also matched for any subclass, implemented interface, or parent class of the dispatched event — so a listener on a base event (or an interface) sees every concrete subtype, the usual "listen broadly, dispatch specifically" behavior. Within a single event type, higher priority runs first; ties preserve registration order (stable).

## Synopsis

`final class ListenerProvider implements ListenerProviderInterface`

|  |  |
|---|---|
| Implements | `ListenerProviderInterface` |
| Source | `Event/ListenerProvider.php` |

## Methods

| Method | Description |
|---|---|
| [`getListenersForEvent(object $event): iterable<callable>`](#getlistenersforevent) |  |
| [`hasListenersFor(string $eventClass): bool`](#haslistenersfor) | Whether any registered listener would fire for this event class (matching the same subclass/interface/parent rules [`ListenerProvider::getListenersForEvent()`](/api/event/listener-provider/#getlistenersforevent) uses). |
| [`listen(string $eventClass, callable $listener, int $priority = 0): void`](#listen) | Registers a listener for an event class, subclass or interface. |
| [`reset(): void`](#reset) | Drops every registered listener and both memoization caches. |

### getListenersForEvent()

`public function getListenersForEvent(object $event): iterable<callable>`

An event for which to return the relevant listeners.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `object` | An event for which to return the relevant listeners. |

Returns `iterable``<``callable``>` — An iterable (array, iterator, or generator) of callables. Each callable MUST be type-compatible with $event.

### hasListenersFor()

`public function hasListenersFor(string $eventClass): bool`

Whether any registered listener would fire for this event class (matching the same subclass/interface/parent rules [`ListenerProvider::getListenersForEvent()`](/api/event/listener-provider/#getlistenersforevent) uses).

Cheap gate for hot-path emit sites so a no-listener app pays only this lookup, not an event-object allocation. Memoized per event class: every Events::emit() call site pays this (~5-6 lifecycle emits per request), and typeChain() otherwise allocates two arrays (class_parents()/class_implements()) on every single call.

| Parameter | Type | Description |
|---|---|---|
| `$eventClass` | `string` |  |

Returns `bool`

### listen()

`public function listen(string $eventClass, callable $listener, int $priority = 0): void`

Registers a listener for an event class, subclass or interface.

Higher `$priority` runs first; listeners registered at the same priority keep their registration order. Registering invalidates the memoized resolution and has-listeners caches, so listeners may be added at any point without stale lookups.

| Parameter | Type | Description |
|---|---|---|
| `$eventClass` | `string` |  |
| `$listener` | `callable` |  |
| `$priority` | `int` |  |

### reset()

`public function reset(): void`

Drops every registered listener and both memoization caches.

The registration sequence counter restarts at zero, so ordering after a reset behaves as it would on a fresh provider. Intended for test isolation and for long-running workers that rebuild their listener set between runs.
