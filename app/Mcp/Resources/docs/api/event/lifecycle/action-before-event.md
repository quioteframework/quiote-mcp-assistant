# ActionBeforeEvent

> Emitted by ActionExecutor::execute() just before an action runs.

Emitted by [`ActionExecutor::execute()`](/api/execution/action-executor/#execute) just before an action runs.

Stoppable: a listener may call [`ActionBeforeEvent::stopPropagation()`](/api/event/lifecycle/action-before-event/#stoppropagation) to signal intent to short-circuit (reserved for future use — the executor still runs the action today; this event is currently observational).

## Synopsis

`final class ActionBeforeEvent extends StoppableEvent`

|  |  |
|---|---|
| Extends | [`StoppableEvent`](/api/event/stoppable-event/) |
| Source | `Event/Lifecycle/ActionBeforeEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$descriptor` | [`ActionDescriptor`](/api/execution/action-descriptor/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(ActionDescriptor $descriptor): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$descriptor` | [`ActionDescriptor`](/api/execution/action-descriptor/) |  |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `isPropagationStopped()` | [`StoppableEvent`](/api/event/stoppable-event/) | Whether a listener has already called [`ActionBeforeEvent::stopPropagation()`](/api/event/lifecycle/action-before-event/#stoppropagation) on this event. |
| `stopPropagation()` | [`StoppableEvent`](/api/event/stoppable-event/) | Halts propagation so the dispatcher invokes no further listeners for this event. |
