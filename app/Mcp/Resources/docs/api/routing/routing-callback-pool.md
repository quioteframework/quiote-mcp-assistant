# RoutingCallbackPool

> Quiote Routing Callback Pool - Reuses callback instances for performance This class maintains a pool of callback instances to avoid the overhead of creating new instances for each route match.

Quiote Routing Callback Pool - Reuses callback instances for performance This class maintains a pool of callback instances to avoid the overhead of creating new instances for each route match.

Particularly beneficial for complex routing configurations with many callbacks.

## Synopsis

`class RoutingCallbackPool implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Source | `Routing/RoutingCallbackPool.php` |

## Methods

| Method | Description |
|---|---|
| [`clearPool(): void`](#clearpool) | Clear the callback pool |
| [`getInstance(string $className, array<string, mixed> $parameters = []): object`](#getinstance) | Get or create callback instance from pool |
| [`getPoolSize(): int`](#getpoolsize) | Get current pool size |
| [`getResetInstance(): RoutingCallbackPool`](#getresetinstance) | Get reset instance for ResetInterface compliance |
| [`getStats(): array{pool_size: int, max_instances: int, access_count: int, memory_usage: int}`](#getstats) | Get pool statistics |
| [`removeInstance(string $className, array<string, mixed> $parameters = []): void`](#removeinstance) | Remove specific instance from pool |
| [`reset(): void`](#reset) | Reset callback pool state between requests in a persistent worker. |
| [`resetWorkerState(bool $preservePool = true, bool $resetStats = true): void`](#resetworkerstate) | Static method to reset worker state - called by WorkerManager |
| [`setMaxInstances(int $size): void`](#setmaxinstances) | Set maximum pool size |

### clearPool()

`public static function clearPool(): void`

Clear the callback pool

### getInstance()

`public static function getInstance(string $className, array<string, mixed> $parameters = []): object`

Get or create callback instance from pool

Callback parameters

| Parameter | Type | Description |
|---|---|---|
| `$className` | `string` | Callback class name |
| `$parameters` | `array``<``string``, ``mixed``>` | Callback parameters |

Returns `object` — Callback instance

### getPoolSize()

`public static function getPoolSize(): int`

Get current pool size

Returns `int` — Number of pooled instances

### getResetInstance()

`public static function getResetInstance(): RoutingCallbackPool`

Get reset instance for ResetInterface compliance

Returns [`RoutingCallbackPool`](/api/routing/routing-callback-pool/)

### getStats()

`public static function getStats(): array{pool_size: int, max_instances: int, access_count: int, memory_usage: int}`

Get pool statistics

Returns `array{pool_size: int, max_instances: int, access_count: int, memory_usage: int}` — Pool performance stats

### removeInstance()

`public static function removeInstance(string $className, array<string, mixed> $parameters = []): void`

Remove specific instance from pool

Callback parameters

| Parameter | Type | Description |
|---|---|---|
| `$className` | `string` | Callback class name |
| `$parameters` | `array``<``string``, ``mixed``>` | Callback parameters |

### reset()

`public function reset(): void`

Reset callback pool state between requests in a persistent worker.

Called from the worker request boundary; see WorkerManager::resetForNextRequest(). In worker mode, we typically want to preserve pooled instances for performance, but reset statistics.

### resetWorkerState()

`public static function resetWorkerState(bool $preservePool = true, bool $resetStats = true): void`

Static method to reset worker state - called by WorkerManager

Whether to reset access statistics (default: true)

| Parameter | Type | Description |
|---|---|---|
| `$preservePool` | `bool` | Whether to preserve pooled instances (default: true) |
| `$resetStats` | `bool` | Whether to reset access statistics (default: true) |

### setMaxInstances()

`public static function setMaxInstances(int $size): void`

Set maximum pool size

Maximum number of pooled instances

| Parameter | Type | Description |
|---|---|---|
| `$size` | `int` | Maximum number of pooled instances |
