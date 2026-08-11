# ActionAfterEvent

> Emitted by ActionExecutor::execute() after an action (and its view) have run, carrying the resulting execution context.

Emitted by [`ActionExecutor::execute()`](/api/execution/action-executor/#execute) after an action (and its view) have run, carrying the resulting execution context.

Not emitted when the action throws (the exception propagates instead).

## Synopsis

`final class ActionAfterEvent extends Event`

|  |  |
|---|---|
| Extends | [`Event`](/api/event/event/) |
| Source | `Event/Lifecycle/ActionAfterEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$descriptor` | [`ActionDescriptor`](/api/execution/action-descriptor/) | _readonly._ |
| `$result` | [`ActionExecutionContext`](/api/execution/action-execution-context/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(ActionDescriptor $descriptor, ActionExecutionContext $result): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$descriptor` | [`ActionDescriptor`](/api/execution/action-descriptor/) |  |
| `$result` | [`ActionExecutionContext`](/api/execution/action-execution-context/) |  |

Returns `mixed`
