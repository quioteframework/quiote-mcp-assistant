# SapiEmitter

> Emits through the PHP SAPI: http_response_code(), header(), echo.

Emits through the PHP SAPI: http_response_code(), header(), echo.

Correct for php-fpm, php -S and FrankenPHP worker mode alike -- FrankenPHP is a real SAPI, so flushing inside a frankenphp_handle_request() callback reaches the client exactly as it does under FPM.

Not usable off-SAPI (RoadRunner, Swoole): under the CLI SAPI header() is a no-op and echo goes to the process's stdout, which is the server's protocol channel rather than the response body.

## Synopsis

`class SapiEmitter implements ResponseEmitterInterface`

|  |  |
|---|---|
| Implements | [`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) |
| Source | `Runtime/Emitter/SapiEmitter.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(ResponseInterface $response): void`](#emit) | Sends the response through http_response_code(), header() and echo. |
| [`supportsStreaming(): bool`](#supportsstreaming) | Always true: the SAPI can flush a body incrementally to the client. |

### emit()

`public function emit(ResponseInterface $response): void`

Sends the response through http_response_code(), header() and echo.

Any Content-Type already set on the SAPI is removed first, so an early fallback header cannot survive alongside the response's own. Remaining headers are appended in order, allowing repeated names. An [`SseStream`](/api/http/sse/sse-stream/) body is flushed event by event instead of being echoed in one piece.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### supportsStreaming()

`public function supportsStreaming(): bool`

Always true: the SAPI can flush a body incrementally to the client.

Returns `bool`
