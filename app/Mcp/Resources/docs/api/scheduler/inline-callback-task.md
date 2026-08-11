# InlineCallbackTask

> Runs a callback synchronously in-process, for tasks cheap enough not to need the queue.

Runs a callback synchronously in-process, for tasks cheap enough not to need the queue.

A callback that throws propagates uncaught — the caller (the `schedule:run` command) is responsible for catching per-task failures, not this class.

## Synopsis

`final class InlineCallbackTask implements ScheduledTaskAction`

|  |  |
|---|---|
| Implements | [`ScheduledTaskAction`](/api/scheduler/scheduled-task-action/) |
| Source | `InlineCallbackTask.php` |

## Constructor

### __construct()

`public function __construct(Closure $callback): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$callback` | [`Closure`](https://www.php.net/manual/en/class.closure.php) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`label(): string`](#label) | Returns a fixed label for the task. |
| [`run(Container $container): void`](#run) | Invokes the wrapped callback synchronously, passing it the container. |

### label()

`public function label(): string`

Returns a fixed label for the task.

A closure has no meaningful name, so every inline task reports `inline callback`.

Returns `string`

### run()

`public function run(Container $container): void`

Invokes the wrapped callback synchronously, passing it the container.

Anything the callback throws propagates to the caller; this class does no error handling of its own.

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
