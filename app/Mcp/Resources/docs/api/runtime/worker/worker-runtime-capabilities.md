# WorkerRuntimeCapabilities

> What a WorkerRuntimeInterface can and cannot do, so the shared WorkerLoop knows which compensations to install rather than every runtime re-deciding.

What a [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) can and cannot do, so the shared [`WorkerLoop`](/api/runtime/worker/worker-loop/) knows which compensations to install rather than every runtime re-deciding.

The distinction that matters most is $populatesSuperglobals + $sapiOutput: a real SAPI (php-fpm, php -S, FrankenPHP) refills $_SERVER/$_GET/... per request and lets header()/echo reach the client, while a CLI-hosted server (RoadRunner, Swoole) does neither -- it hands over a request object and takes a response object. Everything the loop does to bridge that gap (superglobal hydration, output capture, native session-cookie synthesis) keys off these two flags.

## Synopsis

`final readonly class WorkerRuntimeCapabilities`

|  |  |
|---|---|
| Source | `Runtime/Worker/WorkerRuntimeCapabilities.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$forksWorkers` | `bool` | _readonly._ |
| `$persistent` | `bool` | _readonly._ |
| `$populatesSuperglobals` | `bool` | _readonly._ |
| `$sapiOutput` | `bool` | _readonly._ |
| `$streaming` | `bool` | _readonly._ |

## Constructor

### __construct()

`public function __construct(bool $persistent, bool $populatesSuperglobals, bool $sapiOutput, bool $streaming, bool $forksWorkers): mixed`

Worker processes are forked after bootstrap, so bootWorker() must run per child.

| Parameter | Type | Description |
|---|---|---|
| `$persistent` | `bool` | The process survives across requests, so per-request state must be reset. |
| `$populatesSuperglobals` | `bool` | The runtime fills $_SERVER/$_GET/$_POST/$_COOKIE/$_FILES itself. |
| `$sapiOutput` | `bool` | echo/header()/http_response_code() reach the client. |
| `$streaming` | `bool` | The response body can be flushed incrementally (SSE). |
| `$forksWorkers` | `bool` | Worker processes are forked after bootstrap, so bootWorker() must run per child. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`sapi(bool $persistent = false): WorkerRuntimeCapabilities`](#sapi) | The classic single-request SAPI shape: nothing persists, the SAPI owns input and output. |

### sapi()

`public static function sapi(bool $persistent = false): WorkerRuntimeCapabilities`

The classic single-request SAPI shape: nothing persists, the SAPI owns input and output.

Also the correct answer for a FrankenPHP worker apart from $persistent, hence the parameter.

| Parameter | Type | Description |
|---|---|---|
| `$persistent` | `bool` |  |

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)
