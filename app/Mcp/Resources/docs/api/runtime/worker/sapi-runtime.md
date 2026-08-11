# SapiRuntime

> The classic one-request-per-process host: php-fpm, mod_php, `php -S`, and the CLI when something calls Kernel::run() directly.

The classic one-request-per-process host: php-fpm, mod_php, `php -S`, and the CLI when something calls Kernel::run() directly.

Always supported, at the lowest possible detection priority, so [`WorkerRuntimeRegistry::detect()`](/api/runtime/worker/worker-runtime-registry/#detect) can never come back empty-handed.

## Synopsis

`final class SapiRuntime implements WorkerRuntimeInterface`

|  |  |
|---|---|
| Implements | [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) |
| Source | `Runtime/Worker/SapiRuntime.php` |

## Constructor

### __construct()

`public function __construct(ResponseEmitterInterface $emitter = new SapiEmitter(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$emitter` | [`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`alias(): string`](#alias) | The registry alias: "sapi". |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | SAPI-shaped and non-persistent: the process serves exactly one request. |
| [`detectionPriority(): int`](#detectionpriority) | PHP_INT_MIN: the lowest possible priority, so any other supported runtime outranks this one and it is only chosen when nothing else claims the process. |
| [`isSupported(): bool`](#issupported) | Always true: this runtime claims every process, so [`WorkerRuntimeRegistry::detect()`](/api/runtime/worker/worker-runtime-registry/#detect) can never come back empty-handed. |
| [`run(WorkerLoop $loop): void`](#run) | Handles the single request built from the superglobals and emits it. |

### alias()

`public static function alias(): string`

The registry alias: "sapi".

Returns `string`

### capabilities()

`public function capabilities(): WorkerRuntimeCapabilities`

SAPI-shaped and non-persistent: the process serves exactly one request.

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### detectionPriority()

`public static function detectionPriority(): int`

PHP_INT_MIN: the lowest possible priority, so any other supported runtime outranks this one and it is only chosen when nothing else claims the process.

Returns `int`

### isSupported()

`public static function isSupported(): bool`

Always true: this runtime claims every process, so [`WorkerRuntimeRegistry::detect()`](/api/runtime/worker/worker-runtime-registry/#detect) can never come back empty-handed.

Returns `bool`

### run()

`public function run(WorkerLoop $loop): void`

Handles the single request built from the superglobals and emits it.

There is no loop and no request-boundary reset: the process ends with the response, so nothing can leak into a next request.

| Parameter | Type | Description |
|---|---|---|
| `$loop` | [`WorkerLoop`](/api/runtime/worker/worker-loop/) |  |
