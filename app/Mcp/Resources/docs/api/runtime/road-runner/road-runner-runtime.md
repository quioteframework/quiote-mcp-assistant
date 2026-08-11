# RoadRunnerRuntime

> Serves requests as a RoadRunner PSR-7 worker.

Serves requests as a RoadRunner PSR-7 worker.

RoadRunner runs the worker under the CLI SAPI and speaks a protocol over the process's own pipes, which makes it the first host where leaving the SAPI actually bites: header() is a no-op, echo lands on the protocol channel, and superglobals are never populated. [`WorkerLoop`](/api/runtime/worker/worker-loop/) handles all of that off the capabilities below -- this class only has to move requests and responses.

Worker recycling is deliberately left to the server (`http.pool.max_jobs` in .rr.yaml): stopping the loop from PHP mid-pool looks like a crashed worker to RoadRunner, so `core.worker.max_requests` should stay at its default of 0.

## Synopsis

`final class RoadRunnerRuntime implements WorkerRuntimeInterface`

|  |  |
|---|---|
| Implements | [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) |
| Source | `RoadRunnerRuntime.php` |

## Constructor

### __construct()

`public function __construct(?PSR7WorkerInterface $worker = null, ?ResponseEmitterInterface $emitter = null): mixed`

Both collaborators are injectable so the loop can be driven from a test without a RoadRunner server on the other end of the relay.

| Parameter | Type | Description |
|---|---|---|
| `$worker` | `?``PSR7WorkerInterface` |  |
| `$emitter` | `?`[`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`alias(): string`](#alias) | The registry alias: "roadrunner". |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | Persistent, off-SAPI, streaming-capable and non-forking. |
| [`detectionPriority(): int`](#detectionpriority) | Detection priority 100 — well above [`SapiRuntime`](/api/runtime/worker/sapi-runtime/)'s PHP_INT_MIN, so a RoadRunner worker always wins over the plain SAPI fallback. |
| [`isSupported(): bool`](#issupported) | $RR_MODE is set by the RoadRunner server itself when it spawns a worker, so unlike an extension being merely loaded it is real evidence about how this process is being hosted -- which is why this needs no opt-in. |
| [`run(WorkerLoop $loop): void`](#run) | Serves requests off the relay until the server stops the worker. |

### alias()

`public static function alias(): string`

The registry alias: "roadrunner".

Returns `string`

### capabilities()

`public function capabilities(): WorkerRuntimeCapabilities`

Persistent, off-SAPI, streaming-capable and non-forking.

`populatesSuperglobals: false` and `sapiOutput: false` switch on the loop's superglobal hydration and stray-output capture; `forksWorkers` is false because RoadRunner starts each worker as its own process.

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### detectionPriority()

`public static function detectionPriority(): int`

Detection priority 100 — well above [`SapiRuntime`](/api/runtime/worker/sapi-runtime/)'s PHP_INT_MIN, so a RoadRunner worker always wins over the plain SAPI fallback.

Returns `int`

### isSupported()

`public static function isSupported(): bool`

$RR_MODE is set by the RoadRunner server itself when it spawns a worker, so unlike an extension being merely loaded it is real evidence about how this process is being hosted -- which is why this needs no opt-in.

Returns `bool`

### run()

`public function run(WorkerLoop $loop): void`

Serves requests off the relay until the server stops the worker.

Creates the PSR-7 worker and emitter unless they were injected, then loops: an unparseable payload is reported to the server and the loop continues; a null request means the server asked the worker to stop; an emission failure is reported the same way, with [`WorkerLoop::afterRequest()`](/api/runtime/worker/worker-loop/#afterrequest) in a `finally`. The loop also ends once the max-requests budget is spent, after which the loop is shut down.

| Parameter | Type | Description |
|---|---|---|
| `$loop` | [`WorkerLoop`](/api/runtime/worker/worker-loop/) |  |

| Throws | When |
|---|---|
| `RuntimeException` | if a custom PSR-7 worker was supplied without a matching emitter. |
