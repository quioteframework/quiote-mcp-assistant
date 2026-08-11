# NativeSwooleServer

> Pure delegation onto the real Swoole server.

Pure delegation onto the real Swoole server.

## Synopsis

`final class NativeSwooleServer implements SwooleServerInterface`

|  |  |
|---|---|
| Implements | [`SwooleServerInterface`](/api/runtime/swoole/swoole-server-interface/) |
| Source | `NativeSwooleServer.php` |

## Constructor

### __construct()

`public function __construct(Server $server): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$server` | `Server` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`onRequest(callable $listener): void`](#onrequest) | Registers the listener on Swoole's `request` event, arguments unchanged. |
| [`onWorkerStart(callable(): void $listener): void`](#onworkerstart) | Registers on Swoole's `workerStart` event, dropping the server and worker id arguments Swoole passes so the listener stays free of extension types. |
| [`start(): void`](#start) | Binds and serves; does not return until the server stops. |

### onRequest()

`public function onRequest(callable $listener): void`

Registers the listener on Swoole's `request` event, arguments unchanged.

| Parameter | Type | Description |
|---|---|---|
| `$listener` | `callable` |  |

### onWorkerStart()

`public function onWorkerStart(callable(): void $listener): void`

Registers on Swoole's `workerStart` event, dropping the server and worker id arguments Swoole passes so the listener stays free of extension types.

| Parameter | Type | Description |
|---|---|---|
| `$listener` | `callable(): void` |  |

### start()

`public function start(): void`

Binds and serves; does not return until the server stops.
