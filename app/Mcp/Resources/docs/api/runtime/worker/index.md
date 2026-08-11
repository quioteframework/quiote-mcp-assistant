# Worker

> The Quiote\\Runtime\\Worker namespace — 7 documented types.

Everything under `Quiote\Runtime\Worker`.

## Classes

| Class | Description |
|---|---|
| [`FrankenPhpRuntime`](/api/runtime/worker/franken-php-runtime/) | FrankenPHP worker mode: a persistent process that parks in frankenphp_handle_request() and gets its superglobals refilled per request. |
| [`SapiRuntime`](/api/runtime/worker/sapi-runtime/) | The classic one-request-per-process host: php-fpm, mod_php, `php -S`, and the CLI when something calls Kernel::run() directly. |
| [`WorkerLoop`](/api/runtime/worker/worker-loop/) | Everything a worker runtime needs from the framework, so a runtime only has to know how to get a request in and a response out. |
| [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/) | What a [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) can and cannot do, so the shared [`WorkerLoop`](/api/runtime/worker/worker-loop/) knows which compensations to install rather than every runtime re-deciding. |
| [`WorkerRuntimeInfo`](/api/runtime/worker/worker-runtime-info/) | "Which runtime are we on, and what can it do?" -- the process-wide query surface for code outside the Runtime namespace that needs to behave differently in a persistent worker. |
| [`WorkerRuntimeRegistry`](/api/runtime/worker/worker-runtime-registry/) | Process-global registry mapping short runtime aliases (e.g. |

## Interfaces

| Interface | Description |
|---|---|
| [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) | A host that drives Quiote's request loop: the PHP SAPI, a FrankenPHP worker, a RoadRunner worker, a Swoole HTTP server. |
