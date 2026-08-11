# Kernel

> Boots the framework and hands the request loop to a worker runtime.

Boots the framework and hands the request loop to a worker runtime.

The Kernel deliberately knows nothing about how requests arrive or responses leave: that is the selected [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)'s job, and everything in between is [`WorkerLoop`](/api/runtime/worker/worker-loop/)'s. Its own remit is the three steps around that -- bootstrap, pick the runtime, start it.

## Synopsis

`class Kernel`

|  |  |
|---|---|
| Source | `Runtime/Kernel.php` |

## Methods

| Method | Description |
|---|---|
| [`create(array<string, mixed> $options = []): Kernel`](#create) | Create kernel with optional overrides. |
| [`run(): void`](#run) | Bootstraps the framework and hands control to the selected worker runtime. |

### create()

`public static function create(array<string, mixed> $options = []): Kernel`

Create kernel with optional overrides.

| Parameter | Type | Description |
|---|---|---|
| `$options` | `array``<``string``, ``mixed``>` |  |

Returns [`Kernel`](/api/runtime/kernel/)

### run()

`public function run(): void`

Bootstraps the framework and hands control to the selected worker runtime.

Resolves the runtime (create() option, then $QUIOTE_WORKER_RUNTIME, then `core.worker_runtime`, then auto-detection), publishes it via [`WorkerRuntimeInfo`](/api/runtime/worker/worker-runtime-info/), configures [`WorkerManager`](/api/util/worker-manager/)'s recycling for a persistent host, and starts the runtime's loop. Returns only when the runtime stops serving; under a one-request-per-process host that is after the single response.

| Throws | When |
|---|---|
| `RuntimeException` | if an explicitly named runtime reports that it is not hosting this process. |
