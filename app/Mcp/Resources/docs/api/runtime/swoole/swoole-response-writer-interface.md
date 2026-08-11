# SwooleResponseWriterInterface

> The slice of \\Swoole\\Http\\Response the emitter needs, so the emitter can be tested against a recording double on a machine with no ext-swoole.

The slice of \Swoole\Http\Response the emitter needs, so the emitter can be tested against a recording double on a machine with no ext-swoole.

## Synopsis

`interface SwooleResponseWriterInterface`

|  |  |
|---|---|
| Implemented by | [`SwooleResponseWriter`](/api/runtime/swoole/swoole-response-writer/) |
| Source | `SwooleResponseWriterInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`end(string $body = ''): void`](#end) | Finishes the response, optionally sending a final body. |
| [`header(string $name, string|list<string> $value): void`](#header) |  |
| [`status(int $code): void`](#status) | Sets the response status code; must be called before any body is written. |
| [`write(string $chunk): bool`](#write) |  |

### end()

`abstract public function end(string $body = ''): void`

Finishes the response, optionally sending a final body.

Called once per request. After a streamed body the argument is omitted, because everything has already gone out through [`SwooleResponseWriterInterface::write()`](/api/runtime/swoole/swoole-response-writer-interface/#write).

| Parameter | Type | Description |
|---|---|---|
| `$body` | `string` |  |

### header()

`abstract public function header(string $name, string|list<string> $value): void`

An array sends one header line per value,
       which is how multiple Set-Cookie headers survive.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `string``|``list``<``string``>` | An array sends one header line per value, which is how multiple Set-Cookie headers survive. |

### status()

`abstract public function status(int $code): void`

Sets the response status code; must be called before any body is written.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `int` |  |

### write()

`abstract public function write(string $chunk): bool`

| Parameter | Type | Description |
|---|---|---|
| `$chunk` | `string` |  |

Returns `bool` — False once the client is gone, which ends a stream early.
