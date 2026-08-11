# Swoole

> The Quiote\\Runtime\\Swoole namespace — 14 documented types.

Everything under `Quiote\Runtime\Swoole`.

## Classes

| Class | Description |
|---|---|
| [`NativeSwooleServer`](/api/runtime/swoole/native-swoole-server/) | Pure delegation onto the real Swoole server. |
| [`NativeSwooleServerFactory`](/api/runtime/swoole/native-swoole-server-factory/) | Builds the real \Swoole\Http\Server. |
| [`SwooleConverterOptions`](/api/runtime/swoole/swoole-converter-options/) | The handful of things a Swoole request cannot tell us and the server operator has to. |
| [`SwooleRequestConverter`](/api/runtime/swoole/swoole-request-converter/) | Turns a [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/) into a PSR-7 request. |
| [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/) | A Swoole HTTP request reduced to plain arrays. |
| [`SwooleRequestSnapshotFactory`](/api/runtime/swoole/swoole-request-snapshot-factory/) | The only place in this package that touches \Swoole\Http\Request. |
| [`SwooleResponseEmitter`](/api/runtime/swoole/swoole-response-emitter/) | Writes the response to Swoole's per-request response object. |
| [`SwooleResponseWriter`](/api/runtime/swoole/swoole-response-writer/) | The only place in this package that touches \Swoole\Http\Response. |
| [`SwooleRuntime`](/api/runtime/swoole/swoole-runtime/) | Serves requests from an embedded Swoole HTTP server. |
| [`WorkerSwoolePlugin`](/api/runtime/swoole/worker-swoole-plugin/) | Registers the `swoole` worker-runtime alias, its settings, and the `swoole:serve` launcher. |

## Interfaces

| Interface | Description |
|---|---|
| [`SwooleResponseWriterInterface`](/api/runtime/swoole/swoole-response-writer-interface/) | The slice of \Swoole\Http\Response the emitter needs, so the emitter can be tested against a recording double on a machine with no ext-swoole. |
| [`SwooleServerFactory`](/api/runtime/swoole/swoole-server-factory/) | Creates the HTTP server [`SwooleRuntime`](/api/runtime/swoole/swoole-runtime/) binds and runs. |
| [`SwooleServerInterface`](/api/runtime/swoole/swoole-server-interface/) | The slice of \Swoole\Http\Server the runtime drives, so the loop's wiring can be asserted without ext-swoole (and without actually binding a port). |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Console`](/api/runtime/swoole/console/) | 1 type |
