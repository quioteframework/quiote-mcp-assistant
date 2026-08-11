# RoadRunnerResponseEmitter

> Hands the response back to RoadRunner over the worker relay.

Hands the response back to RoadRunner over the worker relay.

An ordinary response goes through PSR7Worker::respond(), which serialises the whole body into one payload. A streaming body instead goes to HttpWorker::respond() with a Generator, which RoadRunner sends as a sequence of frames -- one per yielded chunk, so an SSE event reaches the client as soon as the action produces it rather than when the stream finally ends.

The generator is driven off [`SseStream::read()`](/api/http/sse/sse-stream/#read) rather than PSR7Worker's own `chunkSize` property, which is marked @internal.

## Synopsis

`final class RoadRunnerResponseEmitter implements ResponseEmitterInterface`

|  |  |
|---|---|
| Implements | [`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) |
| Source | `RoadRunnerResponseEmitter.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `DEFAULT_CHUNK_SIZE` | `8192` |  |

## Constructor

### __construct()

`public function __construct(PSR7Worker $worker, int $chunkSize = self::DEFAULT_CHUNK_SIZE): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$worker` | `PSR7Worker` |  |
| `$chunkSize` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`emit(ResponseInterface $response): void`](#emit) | Sends the response back over the RoadRunner relay. |
| [`supportsStreaming(): bool`](#supportsstreaming) | Always true: RoadRunner sends a generator body as a sequence of frames. |

### emit()

`public function emit(ResponseInterface $response): void`

Sends the response back over the RoadRunner relay.

An ordinary body goes out in a single payload via `PSR7Worker::respond()`. An [`SseStream`](/api/http/sse/sse-stream/) body is instead handed to the underlying HTTP worker as a generator, so each chunk leaves as its own frame while the action is still producing events.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### supportsStreaming()

`public function supportsStreaming(): bool`

Always true: RoadRunner sends a generator body as a sequence of frames.

Returns `bool`
