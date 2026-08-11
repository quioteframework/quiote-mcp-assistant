# SwooleServerInterface

> The slice of \\Swoole\\Http\\Server the runtime drives, so the loop's wiring can be asserted without ext-swoole (and without actually binding a port).

The slice of \Swoole\Http\Server the runtime drives, so the loop's wiring can be asserted without ext-swoole (and without actually binding a port).

## Synopsis

`interface SwooleServerInterface`

|  |  |
|---|---|
| Implemented by | [`NativeSwooleServer`](/api/runtime/swoole/native-swoole-server/) |
| Source | `SwooleServerInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`onRequest(callable(\Swoole\Http\Request, \Swoole\Http\Response): void $listener): void`](#onrequest) |  |
| [`onWorkerStart(callable(): void $listener): void`](#onworkerstart) | Runs once in each freshly forked worker child, before it takes a request. |
| [`start(): void`](#start) | Binds and serves; does not return until the server stops. |

### onRequest()

`abstract public function onRequest(callable(\Swoole\Http\Request, \Swoole\Http\Response): void $listener): void`

| Parameter | Type | Description |
|---|---|---|
| `$listener` | `callable(\Swoole\Http\Request, \Swoole\Http\Response): void` |  |

### onWorkerStart()

`abstract public function onWorkerStart(callable(): void $listener): void`

Runs once in each freshly forked worker child, before it takes a request.

| Parameter | Type | Description |
|---|---|---|
| `$listener` | `callable(): void` |  |

### start()

`abstract public function start(): void`

Binds and serves; does not return until the server stops.
