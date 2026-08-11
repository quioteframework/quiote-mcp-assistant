# DispatchJobTask

> Pushes a Job onto QueueManager rather than running it in-process — honors whatever queue driver the app has configured (sync or persistent).

Pushes a [`Job`](/api/queue/job/) onto [`QueueManager`](/api/queue/queue-manager/) rather than running it in-process — honors whatever queue driver the app has configured (sync or persistent).

## Synopsis

`final readonly class DispatchJobTask implements ScheduledTaskAction`

|  |  |
|---|---|
| Implements | [`ScheduledTaskAction`](/api/scheduler/scheduled-task-action/) |
| Source | `DispatchJobTask.php` |

## Constructor

### __construct()

`public function __construct(class-string<Job> $jobClass, array<string, mixed> $params = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$jobClass` | `class-string``<`[`Job`](/api/queue/job/)`>` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`label(): string`](#label) | Returns the job's class name as the task's label. |
| [`run(Container $container): void`](#run) | Pushes the configured job class and parameters onto the queue. |

### label()

`public function label(): string`

Returns the job's class name as the task's label.

Returns `string`

### run()

`public function run(Container $container): void`

Pushes the configured job class and parameters onto the queue.

Resolves [`QueueManager`](/api/queue/queue-manager/) from the container and enqueues the job rather than executing it here, so the app's queue driver decides whether it runs now or later.

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
