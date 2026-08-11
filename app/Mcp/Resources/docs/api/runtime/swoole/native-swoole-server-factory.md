# NativeSwooleServerFactory

> Builds the real \\Swoole\\Http\\Server.

Builds the real \Swoole\Http\Server.

The only place in this package that names it, alongside [`SwooleRequestSnapshotFactory`](/api/runtime/swoole/swoole-request-snapshot-factory/) and [`SwooleResponseWriter`](/api/runtime/swoole/swoole-response-writer/).

SWOOLE_BASE (single-process-per-connection) rather than SWOOLE_PROCESS: there is no separate master routing layer to gain from, and BASE keeps each request inside one worker for its whole lifetime, which is what Quiote's process-global state requires. See [`SwooleRuntime`](/api/runtime/swoole/swoole-runtime/) for the rest of that reasoning.

## Synopsis

`final class NativeSwooleServerFactory implements SwooleServerFactory`

|  |  |
|---|---|
| Implements | [`SwooleServerFactory`](/api/runtime/swoole/swoole-server-factory/) |
| Source | `NativeSwooleServerFactory.php` |

## Constructor

### __construct()

`public function __construct(bool|null $extensionAvailable = null): mixed`

Overridable so the missing-extension
       guard is testable on a machine that does have ext-swoole, instead of
       being a test that skips itself depending on the environment.

| Parameter | Type | Description |
|---|---|---|
| `$extensionAvailable` | `bool``|``null` | Overridable so the missing-extension guard is testable on a machine that does have ext-swoole, instead of being a test that skips itself depending on the environment. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`create(string $host, int $port, array $settings): SwooleServerInterface`](#create) | Builds a \Swoole\Http\Server bound to $host:$port in SWOOLE_BASE mode. |

### create()

`public function create(string $host, int $port, array $settings): SwooleServerInterface`

Builds a \Swoole\Http\Server bound to $host:$port in SWOOLE_BASE mode.

The settings array is passed to the server's own `set()` untouched. The server is created but not started; [`SwooleServerInterface::start()`](/api/runtime/swoole/swoole-server-interface/#start) does that.

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |
| `$port` | `int` |  |
| `$settings` | `array` |  |

Returns [`SwooleServerInterface`](/api/runtime/swoole/swoole-server-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | if ext-swoole is not available in this process. |
