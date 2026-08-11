# ScheduledTaskDefinition

> Fluent builder for a single scheduled task: its cron spec, the action to run when due, and optional overlap-prevention locking.

Fluent builder for a single scheduled task: its cron spec, the action to run when due, and optional overlap-prevention locking.

Returned by [`Schedule::job()`](/api/scheduler/schedule/#job)/[`Schedule::call()`](/api/scheduler/schedule/#call); an app chains `->hourly()`/`->cron(...)`/`->withoutOverlapping()` onto the result.

## Synopsis

`final class ScheduledTaskDefinition`

|  |  |
|---|---|
| Source | `ScheduledTaskDefinition.php` |

## Constructor

### __construct()

`public function __construct(ScheduledTaskAction $action): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`ScheduledTaskAction`](/api/scheduler/scheduled-task-action/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`action(): ScheduledTaskAction`](#action) | Returns the action invoked when this task is due. |
| [`cron(string $expression): ScheduledTaskDefinition`](#cron) | Sets the cron expression that decides when this task is due. |
| [`daily(): ScheduledTaskDefinition`](#daily) | Schedules the task to run once a day at midnight. |
| [`dailyAt(string $time): ScheduledTaskDefinition`](#dailyat) |  |
| [`description(): string`](#description) | Returns a human-readable one-line summary of the task. |
| [`everyMinute(): ScheduledTaskDefinition`](#everyminute) | Schedules the task to run at the start of every minute. |
| [`hourly(): ScheduledTaskDefinition`](#hourly) | Schedules the task to run at the top of every hour. |
| [`isDueAt(DateTimeImmutable $now): bool`](#isdueat) | Reports whether the configured cron expression matches the given moment. |
| [`lockKey(): string`](#lockkey) | Deterministic across separate `schedule:run` process invocations (unlike an object identity hash) so overlap detection actually works between them — derived from the action's label and cron expression, which are stable for a given task definition in code. |
| [`lockTtlSeconds(): ?int`](#lockttlseconds) | Returns the overlap lock's lifetime in seconds, or null when the task opted out of overlap prevention. |
| [`withoutOverlapping(int $ttlSeconds = 3600): ScheduledTaskDefinition`](#withoutoverlapping) | Opt into best-effort overlap prevention via [`SchedulerLock`](/api/scheduler/scheduler-lock/). |

### action()

`public function action(): ScheduledTaskAction`

Returns the action invoked when this task is due.

Returns [`ScheduledTaskAction`](/api/scheduler/scheduled-task-action/)

### cron()

`public function cron(string $expression): ScheduledTaskDefinition`

Sets the cron expression that decides when this task is due.

The expression is stored as given and only parsed in [`ScheduledTaskDefinition::isDueAt()`](/api/scheduler/scheduled-task-definition/#isdueat), so a malformed one surfaces there rather than here. It also feeds [`ScheduledTaskDefinition::lockKey()`](/api/scheduler/scheduled-task-definition/#lockkey), so changing it changes the overlap lock the task uses.

| Parameter | Type | Description |
|---|---|---|
| `$expression` | `string` |  |

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)

### daily()

`public function daily(): ScheduledTaskDefinition`

Schedules the task to run once a day at midnight.

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)

### dailyAt()

`public function dailyAt(string $time): ScheduledTaskDefinition`

A "HH:MM" 24-hour time.

| Parameter | Type | Description |
|---|---|---|
| `$time` | `string` | A "HH:MM" 24-hour time. |

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)

### description()

`public function description(): string`

Returns a human-readable one-line summary of the task.

Combines the action's label with the cron expression, for listing and log output.

Returns `string`

### everyMinute()

`public function everyMinute(): ScheduledTaskDefinition`

Schedules the task to run at the start of every minute.

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)

### hourly()

`public function hourly(): ScheduledTaskDefinition`

Schedules the task to run at the top of every hour.

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)

### isDueAt()

`public function isDueAt(DateTimeImmutable $now): bool`

Reports whether the configured cron expression matches the given moment.

The expression is parsed on each call, so an invalid one raises the underlying cron library's exception here rather than when it was set.

| Parameter | Type | Description |
|---|---|---|
| `$now` | [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |

Returns `bool`

### lockKey()

`public function lockKey(): string`

Deterministic across separate `schedule:run` process invocations (unlike an object identity hash) so overlap detection actually works between them — derived from the action's label and cron expression, which are stable for a given task definition in code.

Returns `string`

### lockTtlSeconds()

`public function lockTtlSeconds(): ?int`

Returns the overlap lock's lifetime in seconds, or null when the task opted out of overlap prevention.

Null is the default; it becomes a number only once [`ScheduledTaskDefinition::withoutOverlapping()`](/api/scheduler/scheduled-task-definition/#withoutoverlapping) has been called.

Returns `?``int`

### withoutOverlapping()

`public function withoutOverlapping(int $ttlSeconds = 3600): ScheduledTaskDefinition`

Opt into best-effort overlap prevention via [`SchedulerLock`](/api/scheduler/scheduler-lock/).

PSR-16 has no atomic add-if-absent, so there is a narrow race window between concurrent `schedule:run` invocations checking and acquiring the lock — acceptable for the common case (a slow task still running when the next minute's invocation starts), not a hardened distributed lock.

| Parameter | Type | Description |
|---|---|---|
| `$ttlSeconds` | `int` |  |

Returns [`ScheduledTaskDefinition`](/api/scheduler/scheduled-task-definition/)
