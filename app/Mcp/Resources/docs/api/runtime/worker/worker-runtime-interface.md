# WorkerRuntimeInterface

> A host that drives Quiote's request loop: the PHP SAPI, a FrankenPHP worker, a RoadRunner worker, a Swoole HTTP server.

A host that drives Quiote's request loop: the PHP SAPI, a FrankenPHP worker, a RoadRunner worker, a Swoole HTTP server.

The runtime owns both ends of a request -- acquiring it and emitting the response -- because that is precisely what differs between hosts. A SAPI takes its input from superglobals and writes with header()/echo; a CLI-hosted server is handed a request object and hands back a response object, and can do neither of those things. Everything in between is [`WorkerLoop`](/api/runtime/worker/worker-loop/)'s job, so a runtime is typically well under a hundred lines.

Runtimes register themselves with [`WorkerRuntimeRegistry`](/api/runtime/worker/worker-runtime-registry/) under a short alias; core ships `sapi` and `frankenphp`, and packages contribute the rest from their plugin.

## Synopsis

`interface WorkerRuntimeInterface`

|  |  |
|---|---|
| Implemented by | [`RoadRunnerRuntime`](/api/runtime/road-runner/road-runner-runtime/), [`SwooleRuntime`](/api/runtime/swoole/swoole-runtime/), [`FrankenPhpRuntime`](/api/runtime/worker/franken-php-runtime/), [`SapiRuntime`](/api/runtime/worker/sapi-runtime/) |
| Source | `Runtime/Worker/WorkerRuntimeInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`alias(): string`](#alias) | The registry alias, e.g. |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | Describes what this host does for itself, so [`WorkerLoop`](/api/runtime/worker/worker-loop/) knows which off-SAPI compensations to apply. |
| [`detectionPriority(): int`](#detectionpriority) | Tie-break for auto-detection: the highest priority among the runtimes reporting isSupported() wins. |
| [`isSupported(): bool`](#issupported) | Whether this runtime is the one actually hosting the current process. |
| [`run(WorkerLoop $loop): void`](#run) | Serve requests until the host says to stop. |

### alias()

`abstract public static function alias(): string`

The registry alias, e.g.

"frankenphp".

Returns `string`

### capabilities()

`abstract public function capabilities(): WorkerRuntimeCapabilities`

Describes what this host does for itself, so [`WorkerLoop`](/api/runtime/worker/worker-loop/) knows which off-SAPI compensations to apply.

Read once when the loop is built; the answer must not vary between requests on the same runtime instance.

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### detectionPriority()

`abstract public static function detectionPriority(): int`

Tie-break for auto-detection: the highest priority among the runtimes reporting isSupported() wins.

[`SapiRuntime`](/api/runtime/worker/sapi-runtime/) sits at PHP_INT_MIN so it is only ever chosen when nothing else claims the process.

Returns `int`

### isSupported()

`abstract public static function isSupported(): bool`

Whether this runtime is the one actually hosting the current process.

Must be cheap and free of side effects -- it is called for every registered runtime during auto-detection, before anything has booted.

Returns `bool`

### run()

`abstract public function run(WorkerLoop $loop): void`

Serve requests until the host says to stop.

Implementations acquire a request, pass it to [`WorkerLoop::handle()`](/api/runtime/worker/worker-loop/#handle) (which never throws), emit the response, and call [`WorkerLoop::afterRequest()`](/api/runtime/worker/worker-loop/#afterrequest) at the boundary -- the last one in a `finally`, so state is reset even when emission fails.

| Parameter | Type | Description |
|---|---|---|
| `$loop` | [`WorkerLoop`](/api/runtime/worker/worker-loop/) |  |
