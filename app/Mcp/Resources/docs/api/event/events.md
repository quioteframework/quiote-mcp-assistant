# Events

> Static facade for the event subsystem, mirroring Log and Trace: a process-global, worker-lifetime listener registry configured once (typically by plugins at boot) and used everywhere via the facade, with no per-request wiring.

Static facade for the event subsystem, mirroring [`Log`](/api/logging/log/) and [`Trace`](/api/telemetry/trace/): a process-global, worker-lifetime listener registry configured once (typically by plugins at boot) and used everywhere via the facade, with no per-request wiring.

use Quiote\Event\Events; Events::listen(RequestMatchedEvent::class, fn($e) => ...); Events::dispatch(new RequestMatchedEvent(...));

Emit sites in the request pipeline should gate on [`Events::hasListeners()`](/api/event/events/#haslisteners) so a no-listener app never even allocates the event object, and should use [`Events::emit()`](/api/event/events/#emit) (which try/catches) rather than [`Events::dispatch()`](/api/event/events/#dispatch) directly so a buggy listener can't take down a request.

## Synopsis

`final class Events`

|  |  |
|---|---|
| Source | `Event/Events.php` |

## Methods

| Method | Description |
|---|---|
| [`dispatch(object $event): object`](#dispatch) | Dispatch an event, returning it (PSR-14). |
| [`dispatcher(): EventDispatcher`](#dispatcher) | The process-global dispatcher behind this facade, created on first use. |
| [`emit(object $event): object`](#emit) | Safe dispatch for pipeline/lifecycle emit sites: dispatches only if a listener exists, and never lets a listener exception escape into the request/bootstrap path (logs it instead, same "never crash the request" posture telemetry holds). |
| [`emitLazy(string $eventClass, \Closure(): object $factory): ?object`](#emitlazy) | Like [`Events::emit()`](/api/event/events/#emit), but the event object itself is only constructed when a listener actually exists for $eventClass -- emit(new SomeEvent(...)) still builds SomeEvent before emit() gets a chance to gate on hasListeners(), which defeats the "no allocation when nothing listens" point of the gate for every hot lifecycle emit site (dispatch, routing match, request handling, ...). |
| [`hasListeners(string $eventClass): bool`](#haslisteners) | Reports whether any listener is registered for an event class. |
| [`listen(string $eventClass, callable $listener, int $priority = 0): void`](#listen) | Registers a listener for an event class on the process-global registry. |
| [`reset(): void`](#reset) | Clears every registered listener and discards the dispatcher. |

### dispatch()

`public static function dispatch(object $event): object`

Dispatch an event, returning it (PSR-14).

Listener exceptions propagate.

| Parameter | Type | Description |
|---|---|---|
| `$event` | `object` |  |

Returns `object`

### dispatcher()

`public static function dispatcher(): EventDispatcher`

The process-global dispatcher behind this facade, created on first use.

The same instance — and therefore the same listener registry — is returned for the worker's lifetime, until [`Events::reset()`](/api/event/events/#reset) discards it.

Returns [`EventDispatcher`](/api/event/event-dispatcher/)

### emit()

`public static function emit(object $event): object`

Safe dispatch for pipeline/lifecycle emit sites: dispatches only if a listener exists, and never lets a listener exception escape into the request/bootstrap path (logs it instead, same "never crash the request" posture telemetry holds).

Returns the event (or the un-dispatched event if there were no listeners).

| Parameter | Type | Description |
|---|---|---|
| `$event` | `object` |  |

Returns `object`

### emitLazy()

`public static function emitLazy(string $eventClass, \Closure(): object $factory): ?object`

Like [`Events::emit()`](/api/event/events/#emit), but the event object itself is only constructed when a listener actually exists for $eventClass -- emit(new SomeEvent(...)) still builds SomeEvent before emit() gets a chance to gate on hasListeners(), which defeats the "no allocation when nothing listens" point of the gate for every hot lifecycle emit site (dispatch, routing match, request handling, ...).

| Parameter | Type | Description |
|---|---|---|
| `$eventClass` | `string` |  |
| `$factory` | `\Closure(): object` |  |

Returns `?``object`

### hasListeners()

`public static function hasListeners(string $eventClass): bool`

Reports whether any listener is registered for an event class.

The gate emit sites check before constructing an event object, so an app that listens to nothing pays no allocation; see [`Events::emitLazy()`](/api/event/events/#emitlazy).

| Parameter | Type | Description |
|---|---|---|
| `$eventClass` | `string` |  |

Returns `bool`

### listen()

`public static function listen(string $eventClass, callable $listener, int $priority = 0): void`

Registers a listener for an event class on the process-global registry.

Higher $priority listeners run first. The registration survives the request that made it, so it belongs at boot (typically in a plugin) rather than on the request path, where it would stack up a duplicate listener per request.

| Parameter | Type | Description |
|---|---|---|
| `$eventClass` | `string` |  |
| `$listener` | `callable` |  |
| `$priority` | `int` |  |

### reset()

`public static function reset(): void`

Clears every registered listener and discards the dispatcher.

The next facade call builds a fresh dispatcher with an empty registry. For test isolation and reconfiguration; not part of the request path.
