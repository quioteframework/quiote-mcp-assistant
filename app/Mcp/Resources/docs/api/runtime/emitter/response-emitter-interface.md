# ResponseEmitterInterface

> Sends a PSR-7 response back to whatever is on the other end of the current worker runtime: the SAPI (header()/echo), a RoadRunner relay, a Swoole response object.

Sends a PSR-7 response back to whatever is on the other end of the current worker runtime: the SAPI (header()/echo), a RoadRunner relay, a Swoole response object.

Each runtime owns its emitter, which is why the Kernel no longer constructs one. Lifetime differs deliberately: the SAPI and RoadRunner emitters live as long as the worker, while Swoole's wraps the per-request response object.

## Synopsis

`interface ResponseEmitterInterface`

|  |  |
|---|---|
| Implemented by | [`SapiEmitter`](/api/runtime/emitter/sapi-emitter/), [`RoadRunnerResponseEmitter`](/api/runtime/road-runner/road-runner-response-emitter/), [`SwooleResponseEmitter`](/api/runtime/swoole/swoole-response-emitter/) |
| Source | `Runtime/Emitter/ResponseEmitterInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(ResponseInterface $response): void`](#emit) | Writes the status line, headers and body out through the host's channel. |
| [`supportsStreaming(): bool`](#supportsstreaming) | Whether this emitter can flush a body incrementally, i.e. |

### emit()

`abstract public function emit(ResponseInterface $response): void`

Writes the status line, headers and body out through the host's channel.

Called once per request by the runtime, after [`WorkerLoop::handle()`](/api/runtime/worker/worker-loop/#handle) has produced the response. An emitter reporting [`ResponseEmitterInterface::supportsStreaming()`](/api/runtime/emitter/response-emitter-interface/#supportsstreaming) must deliver an [`SseStream`](/api/http/sse/sse-stream/) body chunk by chunk rather than casting it to a string.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### supportsStreaming()

`abstract public function supportsStreaming(): bool`

Whether this emitter can flush a body incrementally, i.e.

whether a [`SseStream`](/api/http/sse/sse-stream/) body will actually stream. When false, `core.worker.sse_fallback` decides what happens instead.

Returns `bool`
