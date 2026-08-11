# SwooleServerFactory

> Creates the HTTP server SwooleRuntime binds and runs.

Creates the HTTP server [`SwooleRuntime`](/api/runtime/swoole/swoole-runtime/) binds and runs.

The seam that keeps the runtime testable: [`SwooleRuntime`](/api/runtime/swoole/swoole-runtime/) takes one of these optionally and falls back to [`NativeSwooleServerFactory`](/api/runtime/swoole/native-swoole-server-factory/), which builds a real `Swoole\Http\Server` and refuses when ext-swoole is absent. A test supplies its own implementation and gets a [`SwooleServerInterface`](/api/runtime/swoole/swoole-server-interface/) double, so the host, port and settings the runtime computed can be asserted without the extension installed.

Implementors must return a server bound to the given host and port with `$settings` applied, ready for the runtime to attach its worker-start and request handlers to.

## Synopsis

`interface SwooleServerFactory`

|  |  |
|---|---|
| Implemented by | [`NativeSwooleServerFactory`](/api/runtime/swoole/native-swoole-server-factory/) |
| Source | `SwooleServerFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`create(string $host, int $port, array<string, mixed> $settings): SwooleServerInterface`](#create) |  |

### create()

`abstract public function create(string $host, int $port, array<string, mixed> $settings): SwooleServerInterface`

Passed straight to Swoole's set().

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |
| `$port` | `int` |  |
| `$settings` | `array``<``string``, ``mixed``>` | Passed straight to Swoole's set(). |

Returns [`SwooleServerInterface`](/api/runtime/swoole/swoole-server-interface/)
