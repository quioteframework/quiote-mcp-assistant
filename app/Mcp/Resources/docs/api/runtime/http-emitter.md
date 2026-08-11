# HttpEmitter

> The original SAPI emitter, kept as the name apps and tests already reference.

The original SAPI emitter, kept as the name apps and tests already reference.

The implementation moved to [`SapiEmitter`](/api/runtime/emitter/sapi-emitter/) when response emission became a per-runtime concern ([`ResponseEmitterInterface`](/api/runtime/emitter/response-emitter-interface/)); new code should depend on that interface instead of this class.

## Synopsis

`class HttpEmitter extends SapiEmitter`

|  |  |
|---|---|
| Extends | [`SapiEmitter`](/api/runtime/emitter/sapi-emitter/) |
| Source | `Runtime/HttpEmitter.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `emit()` | [`SapiEmitter`](/api/runtime/emitter/sapi-emitter/) | Sends the response through http_response_code(), header() and echo. |
| `supportsStreaming()` | [`SapiEmitter`](/api/runtime/emitter/sapi-emitter/) | Always true: the SAPI can flush a body incrementally to the client. |
