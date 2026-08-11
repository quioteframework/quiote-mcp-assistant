# ScheduledTaskAction

> The \"how to invoke it\" strategy for a ScheduledTaskDefinition — either run inline (InlineCallbackTask) or dispatch onto the queue (DispatchJobTask).

The "how to invoke it" strategy for a [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/) — either run inline ([`InlineCallbackTask`](/api/scheduler/inline-callback-task/)) or dispatch onto the queue ([`DispatchJobTask`](/api/scheduler/dispatch-job-task/)).

The container is always passed explicitly rather than reached for statically, so every implementation stays constructor-injectable and testable.

## Synopsis

`interface ScheduledTaskAction`

|  |  |
|---|---|
| Implemented by | [`DispatchJobTask`](/api/scheduler/dispatch-job-task/), [`InlineCallbackTask`](/api/scheduler/inline-callback-task/) |
| Source | `ScheduledTaskAction.php` |

## Methods

| Method | Description |
|---|---|
| [`label(): string`](#label) | Returns a short, stable identifier for the action, used in schedule listings and log output. |
| [`run(Container $container): void`](#run) | Performs the task, using the given container to reach any services it needs. |

### label()

`abstract public function label(): string`

Returns a short, stable identifier for the action, used in schedule listings and log output.

It must not vary between processes for the same task: it is part of the overlap lock key derived by [`ScheduledTaskDefinition::lockKey()`](/api/scheduler/scheduled-task-definition/#lockkey).

Returns `string`

### run()

`abstract public function run(Container $container): void`

Performs the task, using the given container to reach any services it needs.

Implementations may either do the work in-process or hand it off; they are not expected to catch their own failures, as the caller running the schedule reports and isolates per-task errors.

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
