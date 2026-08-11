# WorkerLoop

> Everything a worker runtime needs from the framework, so a runtime only has to know how to get a request in and a response out.

Everything a worker runtime needs from the framework, so a runtime only has to know how to get a request in and a response out.

The compensations for leaving the SAPI behind all live here rather than being re-implemented per runtime, gated on [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/): superglobal hydration, stray-output capture, native session-cookie synthesis. A runtime that reports SAPI-shaped capabilities pays for none of it.

## Synopsis

`final class WorkerLoop`

|  |  |
|---|---|
| Source | `Runtime/Worker/WorkerLoop.php` |

## Constructor

### __construct()

`public function __construct(Context $context, WorkerRequestFactory $requestFactory, SuperglobalBridge $superglobals, OutputCapture $output, ErrorResponseFactory $errors, WorkerRuntimeCapabilities $capabilities, int $maxRequests = 0): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$requestFactory` | [`WorkerRequestFactory`](/api/runtime/request/worker-request-factory/) |  |
| `$superglobals` | [`SuperglobalBridge`](/api/runtime/superglobals/superglobal-bridge/) |  |
| `$output` | [`OutputCapture`](/api/runtime/output-capture/) |  |
| `$errors` | [`ErrorResponseFactory`](/api/runtime/error-response-factory/) |  |
| `$capabilities` | [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/) |  |
| `$maxRequests` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`afterRequest(): void`](#afterrequest) | Request boundary: clear anything that must not leak into the next request. |
| [`bootWorker(): void`](#bootworker) | Post-fork / first-request-in-this-process hook. |
| [`capabilities(): WorkerRuntimeCapabilities`](#capabilities) | Returns the hosting runtime's capabilities, as handed to the constructor. |
| [`handle(ServerRequestInterface $request): ResponseInterface`](#handle) | Runs one request through the pipeline. |
| [`renderError(Throwable $e, ?ServerRequestInterface $request = null): ResponseInterface`](#rendererror) | For a runtime that catches a protocol-level throwable of its own. |
| [`requestFromGlobals(): ServerRequestInterface`](#requestfromglobals) | For SAPI-shaped runtimes, which have no request object of their own. |
| [`requestsHandled(): int`](#requestshandled) | Returns how many requests this loop has taken in. |
| [`shouldContinue(): bool`](#shouldcontinue) | False once the max-requests budget is spent; always true when unlimited. |
| [`shutdown(): void`](#shutdown) | Graceful stop. |

### afterRequest()

`public function afterRequest(): void`

Request boundary: clear anything that must not leak into the next request.

### bootWorker()

`public function bootWorker(): void`

Post-fork / first-request-in-this-process hook.

Idempotent, so a runtime that doesn't fork can call it unconditionally before its loop.

A forking runtime (Swoole) starts its children *after* bootstrap has already built the Context and possibly opened database sockets, so every child would inherit the same connections and interleave on the wire.

### capabilities()

`public function capabilities(): WorkerRuntimeCapabilities`

Returns the hosting runtime's capabilities, as handed to the constructor.

Returns [`WorkerRuntimeCapabilities`](/api/runtime/worker/worker-runtime-capabilities/)

### handle()

`public function handle(ServerRequestInterface $request): ResponseInterface`

Runs one request through the pipeline.

Never throws: a throwable that escapes becomes an error response, so a persistent worker survives a broken request instead of dying with the pool.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### renderError()

`public function renderError(Throwable $e, ?ServerRequestInterface $request = null): ResponseInterface`

For a runtime that catches a protocol-level throwable of its own.

| Parameter | Type | Description |
|---|---|---|
| `$e` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php) |  |
| `$request` | `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### requestFromGlobals()

`public function requestFromGlobals(): ServerRequestInterface`

For SAPI-shaped runtimes, which have no request object of their own.

Returns [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)

### requestsHandled()

`public function requestsHandled(): int`

Returns how many requests this loop has taken in.

Counted at the start of [`WorkerLoop::handle()`](/api/runtime/worker/worker-loop/#handle), so a request still in flight is already included, and a failed one still counts against the max-requests budget.

Returns `int`

### shouldContinue()

`public function shouldContinue(): bool`

False once the max-requests budget is spent; always true when unlimited.

Returns `bool`

### shutdown()

`public function shutdown(): void`

Graceful stop.
