# SwooleRuntime

> Serves requests from an embedded Swoole HTTP server.

Serves requests from an embedded Swoole HTTP server.

Two things make Swoole different from the other hosts:

1. It forks its worker processes when start() is called, i.e. *after* the app has bootstrapped and possibly opened database connections. Every child would inherit the same sockets and interleave on the wire, so [`WorkerLoop::bootWorker()`](/api/runtime/worker/worker-loop/#bootworker) runs on `workerStart` -- that is what `forksWorkers: true` in the capabilities is for.

2. Coroutines are switched off, deliberately. Quiote keeps process-global state (Config, Context, PluginManager, RoutingCallbackPool, LogContext, $_SESSION, the hydrated superglobals), so two requests interleaving inside one process would cross-contaminate all of it -- log lines attributed to the wrong user, session data leaking between requests. SWOOLE_BASE with `enable_coroutine => false` gives exactly the same one-request-at-a-time semantics as FrankenPHP and RoadRunner.

Detection requires an explicit opt-in via $QUIOTE_WORKER_RUNTIME, unlike RoadRunner: see [`SwooleRuntime::isSupported()`](/api/runtime/swoole/swoole-runtime/#issupported).

## Synopsis

`final class SwooleRuntime implements WorkerRuntimeInterface`

|  |  |
|---|---|
| Implements | [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) |
| Source | `SwooleRuntime.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `DEFAULT_HOST` | `'0.0.0.0'` |  |
| `DEFAULT_PORT` | `8080` |  |

## Constructor

### __construct()

`public function __construct(?SwooleServerFactory $serverFactory = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$serverFactory` | `?`[`SwooleServerFactory`](/api/runtime/swoole/swoole-server-factory/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`alias(): string`](#alias) | The registry alias: "swoole". |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | Persistent, forking, off-SAPI and streaming-capable. |
| [`detectionPriority(): int`](#detectionpriority) | Detection priority 100 — well above [`SapiRuntime`](/api/runtime/worker/sapi-runtime/)'s PHP_INT_MIN, so once [`SwooleRuntime::isSupported()`](/api/runtime/swoole/swoole-runtime/#issupported) has confirmed the opt-in this runtime wins over the plain SAPI fallback. |
| [`isSupported(): bool`](#issupported) | `extension_loaded('swoole')` alone would be wrong: the extension is routinely loaded under php-fpm, and claiming the process on that basis would hijack every FPM request on such a box. |
| [`run(WorkerLoop $loop): void`](#run) | Builds the Swoole HTTP server, wires the loop into it and serves. |
| [`settings(): array<string, mixed>`](#settings) |  |

### alias()

`public static function alias(): string`

The registry alias: "swoole".

Returns `string`

### capabilities()

`public function capabilities(): WorkerRuntimeCapabilities`

Persistent, forking, off-SAPI and streaming-capable.

`populatesSuperglobals: false` and `sapiOutput: false` are what switch on the loop's superglobal hydration and stray-output capture; `forksWorkers: true` is what makes it reset the context per worker child.

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### detectionPriority()

`public static function detectionPriority(): int`

Detection priority 100 — well above [`SapiRuntime`](/api/runtime/worker/sapi-runtime/)'s PHP_INT_MIN, so once [`SwooleRuntime::isSupported()`](/api/runtime/swoole/swoole-runtime/#issupported) has confirmed the opt-in this runtime wins over the plain SAPI fallback.

Returns `int`

### isSupported()

`public static function isSupported(): bool`

`extension_loaded('swoole')` alone would be wrong: the extension is routinely loaded under php-fpm, and claiming the process on that basis would hijack every FPM request on such a box.

Only the server itself knows it is the server, and it has no environment marker of its own -- so the operator says so.

Returns `bool`

### run()

`public function run(WorkerLoop $loop): void`

Builds the Swoole HTTP server, wires the loop into it and serves.

`workerStart` calls [`WorkerLoop::bootWorker()`](/api/runtime/worker/worker-loop/#bootworker) in each forked child. Each request is converted to PSR-7, handled, and emitted through a per-request [`SwooleResponseEmitter`](/api/runtime/swoole/swoole-response-emitter/); a throwable from the conversion or the emission is rendered via [`WorkerLoop::renderError()`](/api/runtime/worker/worker-loop/#rendererror), and [`WorkerLoop::afterRequest()`](/api/runtime/worker/worker-loop/#afterrequest) runs in a `finally`. Returns only once the server stops, after which the loop is shut down.

| Parameter | Type | Description |
|---|---|---|
| `$loop` | [`WorkerLoop`](/api/runtime/worker/worker-loop/) |  |

| Throws | When |
|---|---|
| `RuntimeException` | if coroutines are enabled without the explicit `worker.swoole.allow_coroutine_unsafe` override, or ext-swoole is missing. |

### settings()

`public static function settings(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

| Throws | When |
|---|---|
| `RuntimeException` | when coroutines are enabled without an explicit override. |
