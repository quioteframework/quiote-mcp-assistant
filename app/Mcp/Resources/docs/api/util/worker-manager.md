# WorkerManager

> Centralized state management for any persistent worker runtime (see WorkerRuntimeInterface), ensuring request-specific state is properly reset between requests while preserving performance-critical cached data.

Centralized state management for any persistent worker runtime (see [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)), ensuring request-specific state is properly reset between requests while preserving performance-critical cached data.

## Synopsis

`class WorkerManager`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Util/WorkerManager.php` |

## Methods

| Method | Description |
|---|---|
| [`configure(array<string, mixed> $config): void`](#configure) | Configure worker behavior |
| [`getRequestCount(): int`](#getrequestcount) | Get current request count |
| [`getStatistics(): array<string, mixed>`](#getstatistics) | Get worker statistics |
| [`initialize(array<string, mixed> $options = []): void`](#initialize) | Initialize the worker manager with configuration options |
| [`manageDatabaseConnections(string $strategy = 'keep'): void`](#managedatabaseconnections) | Helper method for database connection management in worker mode |
| [`resetForNextRequest(string|array<string, mixed>|null $contextProfile = null, array<string, mixed> $options = []): void`](#resetfornextrequest) | Reset all framework state for the next request in worker mode |
| [`resetObjects(array<int|string, mixed> $objects, bool $skipErrors = true): void`](#resetobjects) | This method should be called to reset any long-lived objects that might hold request-specific state between FrankenPHP worker requests. |
| [`shutdown(): void`](#shutdown) | Shutdown the worker manager and perform cleanup |

### configure()

`public static function configure(array<string, mixed> $config): void`

Configure worker behavior

Configuration options

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``string``, ``mixed``>` | Configuration options |

### getRequestCount()

`public static function getRequestCount(): int`

Get current request count

Returns `int` — Number of requests processed

### getStatistics()

`public static function getStatistics(): array<string, mixed>`

Get worker statistics

Returns `array``<``string``, ``mixed``>` — Worker statistics

### initialize()

`public static function initialize(array<string, mixed> $options = []): void`

Initialize the worker manager with configuration options

Configuration options

| Parameter | Type | Description |
|---|---|---|
| `$options` | `array``<``string``, ``mixed``>` | Configuration options |

### manageDatabaseConnections()

`public static function manageDatabaseConnections(string $strategy = 'keep'): void`

Helper method for database connection management in worker mode

Connection management strategy: 'keep' (default), 'close', or 'reset'

| Parameter | Type | Description |
|---|---|---|
| `$strategy` | `string` | Connection management strategy: 'keep' (default), 'close', or 'reset' |

### resetForNextRequest()

`public static function resetForNextRequest(string|array<string, mixed>|null $contextProfile = null, array<string, mixed> $options = []): void`

Reset all framework state for the next request in worker mode

Override default reset options

| Parameter | Type | Description |
|---|---|---|
| `$contextProfile` | `string``|``array``<``string``, ``mixed``>``|``null` | Context profile to reset (null for all). For backwards compatibility, an options array may be passed here instead. |
| `$options` | `array``<``string``, ``mixed``>` | Override default reset options |

### resetObjects()

`public static function resetObjects(array<int|string, mixed> $objects, bool $skipErrors = true): void`

This method should be called to reset any long-lived objects that might hold request-specific state between FrankenPHP worker requests.

Whether to continue if reset fails for some objects

| Parameter | Type | Description |
|---|---|---|
| `$objects` | `array``<``int``|``string``, ``mixed``>` | Array of objects to reset |
| `$skipErrors` | `bool` | Whether to continue if reset fails for some objects |

### shutdown()

`public static function shutdown(): void`

Shutdown the worker manager and perform cleanup
