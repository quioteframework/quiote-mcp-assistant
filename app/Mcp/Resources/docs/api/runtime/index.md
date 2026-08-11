# Runtime

> The Quiote\\Runtime namespace — 35 documented types.

Everything under `Quiote\Runtime`.

## Classes

| Class | Description |
|---|---|
| [`ContextRequestHandler`](/api/runtime/context-request-handler/) | Turns a PSR-7 request into a response for one context. |
| [`ErrorResponseFactory`](/api/runtime/error-response-factory/) | Turns a throwable that escaped the middleware pipeline into a response. |
| [`HttpEmitter`](/api/runtime/http-emitter/) | The original SAPI emitter, kept as the name apps and tests already reference. |
| [`Kernel`](/api/runtime/kernel/) | Boots the framework and hands the request loop to a worker runtime. |
| [`OutputCapture`](/api/runtime/output-capture/) | Catches anything the application echoes outside the response body while a runtime with no SAPI output channel is handling the request. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Emitter`](/api/runtime/emitter/) | 2 types |
| [`Proxy`](/api/runtime/proxy/) | 2 types |
| [`Request`](/api/runtime/request/) | 1 type |
| [`RoadRunner`](/api/runtime/road-runner/) | 3 types |
| [`Superglobals`](/api/runtime/superglobals/) | 1 type |
| [`Swoole`](/api/runtime/swoole/) | 14 types |
| [`Worker`](/api/runtime/worker/) | 7 types |
