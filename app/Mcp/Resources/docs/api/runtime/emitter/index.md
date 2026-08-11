# Emitter

> The Quiote\\Runtime\\Emitter namespace — 2 documented types.

Everything under `Quiote\Runtime\Emitter`.

## Classes

| Class | Description |
|---|---|
| [`SapiEmitter`](/api/runtime/emitter/sapi-emitter/) | Emits through the PHP SAPI: http_response_code(), header(), echo. |

## Interfaces

| Interface | Description |
|---|---|
| [`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/) | Sends a PSR-7 response back to whatever is on the other end of the current worker runtime: the SAPI (header()/echo), a RoadRunner relay, a Swoole response object. |
