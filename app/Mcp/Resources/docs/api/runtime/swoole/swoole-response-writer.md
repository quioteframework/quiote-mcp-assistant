# SwooleResponseWriter

> The only place in this package that touches \\Swoole\\Http\\Response.

The only place in this package that touches \Swoole\Http\Response.

Pure delegation, so there is nothing here that needs testing without the extension.

## Synopsis

`final class SwooleResponseWriter implements SwooleResponseWriterInterface`

|  |  |
|---|---|
| Implements | [`SwooleResponseWriterInterface`](/api/runtime/swoole/swoole-response-writer-interface/) |
| Source | `SwooleResponseWriter.php` |

## Constructor

### __construct()

`public function __construct(Response $response): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$response` | `Response` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`end(string $body = ''): void`](#end) | Finishes the response, optionally sending a final body. |
| [`header(string $name, string|list<string> $value): void`](#header) |  |
| [`status(int $code): void`](#status) | Sets the response status code; must be called before any body is written. |
| [`write(string $chunk): bool`](#write) |  |

### end()

`public function end(string $body = ''): void`

Finishes the response, optionally sending a final body.

Called once per request. After a streamed body the argument is omitted, because everything has already gone out through [`SwooleResponseWriter::write()`](/api/runtime/swoole/swoole-response-writer/#write).

| Parameter | Type | Description |
|---|---|---|
| `$body` | `string` |  |

### header()

`public function header(string $name, string|list<string> $value): void`

An array sends one header line per value,
       which is how multiple Set-Cookie headers survive.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `string``|``list``<``string``>` | An array sends one header line per value, which is how multiple Set-Cookie headers survive. |

### status()

`public function status(int $code): void`

Sets the response status code; must be called before any body is written.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `int` |  |

### write()

`public function write(string $chunk): bool`

| Parameter | Type | Description |
|---|---|---|
| `$chunk` | `string` |  |

Returns `bool`
