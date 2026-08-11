# SwooleResponseEmitter

> Writes the response to Swoole's per-request response object.

Writes the response to Swoole's per-request response object.

Constructed per request, unlike the SAPI and RoadRunner emitters, because the thing being written to is the current request's response.

Swoole's write() returning false is this runtime's client-disconnect signal -- the equivalent of connection_aborted() under a SAPI, which always reports 0 under the CLI and so cannot be used here. Without it an endless SSE generator would keep producing events for a client that has already gone.

## Synopsis

`final class SwooleResponseEmitter implements ResponseEmitterInterface`

|  |  |
|---|---|
| Implements | [`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) |
| Source | `SwooleResponseEmitter.php` |

## Constructor

### __construct()

`public function __construct(SwooleResponseWriterInterface $writer): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$writer` | [`SwooleResponseWriterInterface`](/api/runtime/swoole/swoole-response-writer-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`emit(ResponseInterface $response): void`](#emit) | Writes status, headers and body onto Swoole's response object. |
| [`supportsStreaming(): bool`](#supportsstreaming) | Always true: Swoole's write() delivers a chunk without buffering the whole body. |

### emit()

`public function emit(ResponseInterface $response): void`

Writes status, headers and body onto Swoole's response object.

A header with several values is passed as an array so repeated names (Set-Cookie) survive. For an [`SseStream`](/api/http/sse/sse-stream/) body, Content-Length is dropped and the body is written chunk by chunk until the stream ends or the client goes away, with a final `end()` closing the response either way.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### supportsStreaming()

`public function supportsStreaming(): bool`

Always true: Swoole's write() delivers a chunk without buffering the whole body.

Returns `bool`
