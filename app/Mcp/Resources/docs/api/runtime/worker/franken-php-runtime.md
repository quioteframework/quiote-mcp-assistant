# FrankenPhpRuntime

> FrankenPHP worker mode: a persistent process that parks in frankenphp_handle_request() and gets its superglobals refilled per request.

FrankenPHP worker mode: a persistent process that parks in frankenphp_handle_request() and gets its superglobals refilled per request.

FrankenPHP is a real SAPI, so this is the one persistent runtime that keeps every SAPI-shaped assumption -- header()/echo work, superglobals arrive populated, flush() streams -- and the loop's off-SAPI compensations stay switched off.

## Synopsis

`final class FrankenPhpRuntime implements WorkerRuntimeInterface`

|  |  |
|---|---|
| Implements | [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) |
| Source | `Runtime/Worker/FrankenPhpRuntime.php` |

## Constructor

### __construct()

`public function __construct(Closure(callable): bool|null $handleRequest = null, ResponseEmitterInterface $emitter = new SapiEmitter(…)): mixed`

Injectable so the loop
       is testable without FrankenPHP; defaults to the real extension function.

| Parameter | Type | Description |
|---|---|---|
| `$handleRequest` | `Closure(callable): bool``|``null` | Injectable so the loop is testable without FrankenPHP; defaults to the real extension function. |
| `$emitter` | [`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`alias(): string`](#alias) | The registry alias: "frankenphp". |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | SAPI-shaped and persistent: superglobals and output work natively, across many requests. |
| [`detectionPriority(): int`](#detectionpriority) | Detection priority 100 — well above [`SapiRuntime`](/api/runtime/worker/sapi-runtime/)'s PHP_INT_MIN, so a FrankenPHP worker always wins over the plain SAPI fallback. |
| [`isSupported(): bool`](#issupported) | True when the FrankenPHP extension is present, detected by the existence of frankenphp_handle_request(). |
| [`run(WorkerLoop $loop): void`](#run) | Boots the worker, then serves requests from frankenphp_handle_request(). |

### alias()

`public static function alias(): string`

The registry alias: "frankenphp".

Returns `string`

### capabilities()

`public function capabilities(): WorkerRuntimeCapabilities`

SAPI-shaped and persistent: superglobals and output work natively, across many requests.

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### detectionPriority()

`public static function detectionPriority(): int`

Detection priority 100 — well above [`SapiRuntime`](/api/runtime/worker/sapi-runtime/)'s PHP_INT_MIN, so a FrankenPHP worker always wins over the plain SAPI fallback.

Returns `int`

### isSupported()

`public static function isSupported(): bool`

True when the FrankenPHP extension is present, detected by the existence of frankenphp_handle_request().

That function only exists inside a FrankenPHP worker process, so no opt-in environment marker is needed.

Returns `bool`

### run()

`public function run(WorkerLoop $loop): void`

Boots the worker, then serves requests from frankenphp_handle_request().

Each iteration builds the request from the refilled superglobals, runs it through the loop and emits the response; [`WorkerLoop::afterRequest()`](/api/runtime/worker/worker-loop/#afterrequest) runs in a `finally` so a failed emission still resets request state. The loop ends when FrankenPHP asks the worker to stop or the max-requests budget is spent, and [`WorkerLoop::shutdown()`](/api/runtime/worker/worker-loop/#shutdown) is called on the way out.

| Parameter | Type | Description |
|---|---|---|
| `$loop` | [`WorkerLoop`](/api/runtime/worker/worker-loop/) |  |
