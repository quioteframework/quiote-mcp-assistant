# StoppableEvent

> An Event whose propagation a listener can halt.

An [`Event`](/api/event/event/) whose propagation a listener can halt.

Once [`StoppableEvent::stopPropagation()`](/api/event/stoppable-event/#stoppropagation) is called, [`EventDispatcher::dispatch()`](/api/event/event-dispatcher/#dispatch) stops invoking further listeners — the standard PSR-14 stoppable contract.

## Synopsis

`abstract class StoppableEvent extends Event implements StoppableEventInterface`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Implements | `StoppableEventInterface` |
| Source | `Event/StoppableEvent.php` |

## Methods

| Method | Description |
|---|---|
| [`isPropagationStopped(): bool`](#ispropagationstopped) | Whether a listener has already called [`StoppableEvent::stopPropagation()`](/api/event/stoppable-event/#stoppropagation) on this event. |
| [`stopPropagation(): void`](#stoppropagation) | Halts propagation so the dispatcher invokes no further listeners for this event. |

### isPropagationStopped()

`public function isPropagationStopped(): bool`

Whether a listener has already called [`StoppableEvent::stopPropagation()`](/api/event/stoppable-event/#stoppropagation) on this event.

Returns `bool`

### stopPropagation()

`public function stopPropagation(): void`

Halts propagation so the dispatcher invokes no further listeners for this event.
