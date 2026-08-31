# QueueManager

> App-facing entry point: `$container->get(QueueManager::class)->push(SendWelcomeEmail::class, ['userId' => 5])`.

App-facing entry point: `$container->get(QueueManager::class)->push(SendWelcomeEmail::class, ['userId' => 5])`.

Resolves the configured driver (or an explicit alias) from [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) via [`Container::get()`](/api/di/container/#get) — a driver is a long-lived service (memoized like any other), not a fresh-per-call action/view, so a persistent driver's own service factory (e.g. `quioteframework/queue-db`'s `QueueDbPlugin` resolving a real PDO connection) runs instead of raw constructor autowiring.

## Synopsis

`final readonly class QueueManager`

|  |  |
|---|---|
| Source | `QueueManager.php` |

## Constructor

### __construct()

`public function __construct(Container $container, QueueConfig $config, ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
| `$config` | [`QueueConfig`](/api/queue/queue-config/) |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`driver(?string $alias = null): QueueDriverInterface`](#driver) | Resolves a queue driver by alias, defaulting to `queue.default_driver`. |
| [`push(class-string<Job> $jobClass, array<string, mixed> $params = [], ?int $delaySeconds = null): void`](#push) |  |

### driver()

`public function driver(?string $alias = null): QueueDriverInterface`

Resolves a queue driver by alias, defaulting to `queue.default_driver`.

The alias is translated to a class through [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) and the instance comes from the container, so a driver registered with its own service factory is built by that factory and memoized as a singleton.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `?``string` |  |

Returns [`QueueDriverInterface`](/api/queue/queue-driver-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | if the alias is unknown to the registry, or the resolved service does not implement [`QueueDriverInterface`](/api/queue/queue-driver-interface/). |

### push()

`public function push(class-string<Job> $jobClass, array<string, mixed> $params = [], ?int $delaySeconds = null): void`

| Parameter | Type | Description |
|---|---|---|
| `$jobClass` | `class-string``<`[`Job`](/api/queue/job/)`>` |  |
| `$params` | `array``<``string``, ``mixed``>` |  |
| `$delaySeconds` | `?``int` |  |
