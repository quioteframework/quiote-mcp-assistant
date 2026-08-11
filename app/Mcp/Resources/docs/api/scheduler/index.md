# Scheduler

> The Quiote\\Scheduler namespace — 8 documented types.

Everything under `Quiote\Scheduler`.

## Classes

| Class | Description |
|---|---|
| [`DispatchJobTask`](/api/scheduler/dispatch-job-task/) | Pushes a [`Job`](/api/queue/job/) onto [`QueueManager`](/api/queue/queue-manager/) rather than running it in-process — honors whatever queue driver the app has configured (sync or persistent). |
| [`InlineCallbackTask`](/api/scheduler/inline-callback-task/) | Runs a callback synchronously in-process, for tasks cheap enough not to need the queue. |
| [`Schedule`](/api/scheduler/schedule/) | App-facing base class for defining scheduled tasks — mirrors how an app subclasses `Quiote\Routing\Routing` for its route table. |
| [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/) | Fluent builder for a single scheduled task: its cron spec, the action to run when due, and optional overlap-prevention locking. |
| [`SchedulerLock`](/api/scheduler/scheduler-lock/) | Best-effort overlap-prevention lock for [`ScheduledTaskDefinition::withoutOverlapping()`](/api/scheduler/scheduled-task-definition/#withoutoverlapping), built on the app's existing PSR-16 `CacheInterface` rather than a new lock subsystem. |
| [`SchedulerPlugin`](/api/scheduler/scheduler-plugin/) | Registers the scheduler subsystem: a default no-op [`Schedule`](/api/scheduler/schedule/) (so an app with nothing configured just runs zero tasks instead of erroring), the [`SchedulerLock`](/api/scheduler/scheduler-lock/) service, and `schedule:run`. |

## Interfaces

| Interface | Description |
|---|---|
| [`ScheduledTaskAction`](/api/scheduler/scheduled-task-action/) | The "how to invoke it" strategy for a [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/) — either run inline ([`InlineCallbackTask`](/api/scheduler/inline-callback-task/)) or dispatch onto the queue ([`DispatchJobTask`](/api/scheduler/dispatch-job-task/)). |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Console`](/api/scheduler/console/) | 1 type |
