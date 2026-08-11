# Schedule

> App-facing base class for defining scheduled tasks — mirrors how an app subclasses `Quiote\\Routing\\Routing` for its route table.

App-facing base class for defining scheduled tasks — mirrors how an app subclasses `Quiote\Routing\Routing` for its route table.

Subclass and implement [`Schedule::define()`](/api/scheduler/schedule/#define); bind the subclass as [`Schedule`](/api/scheduler/schedule/) in `Config/factories.xml` so `schedule:run` resolves it.

## Synopsis

`abstract class Schedule`

|  |  |
|---|---|
| Source | `Schedule.php` |

## Methods

| Method | Description |
|---|---|
| [`build(): list<ScheduledTaskDefinition>`](#build) |  |
| [`call(\Closure(\Quiote\DI\Container): void $callback): ScheduledTaskDefinition`](#call) |  |
| [`define(): void`](#define) |  |
| [`job(class-string<Job> $jobClass, array<string, mixed> $params = []): ScheduledTaskDefinition`](#job) |  |

### build()

`public function build(): list<ScheduledTaskDefinition>`

Returns `list``<`[`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)`>`

### call()

`protected function call(\Closure(\Quiote\DI\Container): void $callback): ScheduledTaskDefinition`

| Parameter | Type | Description |
|---|---|---|
| `$callback` | `\Closure(\Quiote\DI\Container): void` |  |

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)

### define()

`abstract protected function define(): void`

### job()

`protected function job(class-string<Job> $jobClass, array<string, mixed> $params = []): ScheduledTaskDefinition`

| Parameter | Type | Description |
|---|---|---|
| `$jobClass` | `class-string``<`[`Job`](/api/queue/job/)`>` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)
