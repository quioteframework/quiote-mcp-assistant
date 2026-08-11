# OtlpReceiver

> A minimal OTLP/HTTP receiver: binds a TCP socket and services it on the global Revolt event loop, exactly the pattern `symfony/tui`'s own `Terminal::start()` uses for STDIN (`EventLoop::onReadable()`) -- so this runs cooperatively alongside a `Tui::run()` loop in the same process, no threads or second process needed.

A minimal OTLP/HTTP receiver: binds a TCP socket and services it on the global Revolt event loop, exactly the pattern `symfony/tui`'s own `Terminal::start()` uses for STDIN (`EventLoop::onReadable()`) -- so this runs cooperatively alongside a `Tui::run()` loop in the same process, no threads or second process needed.

Deliberately not a general HTTP server: it accepts exactly `POST /v1/traces` and `POST /v1/metrics`, the two paths the OTel PHP OTLP/HTTP exporter sends, decodes the body via [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/), and replies `200` with an empty body (the exporter only checks the status code, never the response body -- see `OpenTelemetry\SDK\Common\Export\Http\PsrTransport`). Everything else gets `400` and the connection is closed; a decode/parse failure never propagates past this class -- the receiver logs it and keeps serving every other connection, mirroring the "never crash the request" posture the telemetry middleware holds on the app side.

One connection per request (no keep-alive) -- simplest correct thing, and cheap enough at dashboard-demo request volumes; see the plan doc for the keep-alive note as a later optimization for worker-mode batch bursts.

## Synopsis

`final class OtlpReceiver`

|  |  |
|---|---|
| Source | `OtlpReceiver.php` |

## Constructor

### __construct()

`public function __construct(string $host, int $port, OtlpDecoder $decoder, callable(ReceivedSpan[]): void $onSpans, callable(ReceivedMetric[]): void $onMetrics): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |
| `$port` | `int` |  |
| `$decoder` | [`OtlpDecoder`](/api/telemetry/dashboard/otlp-decoder/) |  |
| `$onSpans` | `callable(ReceivedSpan[]): void` |  |
| `$onMetrics` | `callable(ReceivedMetric[]): void` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`boundPort(): int`](#boundport) | The actual bound port -- useful when constructed with port 0 (OS-assigned), e.g. |
| [`endpoint(): string`](#endpoint) | The `http://host:port` base URL an OTLP/HTTP exporter should be pointed at, using the actually bound port. |
| [`start(): void`](#start) | Binds the TCP socket and registers the accept watcher on the Revolt event loop. |
| [`stop(): void`](#stop) | Cancels the accept watcher and every per-connection watcher, drops the buffered parsers and closes the listening socket. |

### boundPort()

`public function boundPort(): int`

The actual bound port -- useful when constructed with port 0 (OS-assigned), e.g.

in tests.

Returns `int`

### endpoint()

`public function endpoint(): string`

The `http://host:port` base URL an OTLP/HTTP exporter should be pointed at, using the actually bound port.

Returns `string`

| Throws | When |
|---|---|
| `LogicException` | if called before [`OtlpReceiver::start()`](/api/telemetry/dashboard/otlp-receiver/#start) |

### start()

`public function start(): void`

Binds the TCP socket and registers the accept watcher on the Revolt event loop.

The socket is non-blocking and serviced cooperatively, so this returns immediately; connections are only handled once the loop runs.

| Throws | When |
|---|---|
| `RuntimeException` | if the address cannot be bound |

### stop()

`public function stop(): void`

Cancels the accept watcher and every per-connection watcher, drops the buffered parsers and closes the listening socket.

Safe to call when the receiver was never started or is already stopped; each step is guarded.
