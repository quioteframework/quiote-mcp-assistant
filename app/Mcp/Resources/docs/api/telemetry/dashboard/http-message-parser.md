# HttpMessageParser

> Minimal, bounded HTTP/1.1 request parser for the dashboard's OTLP receiver (see OtlpReceiver).

Minimal, bounded HTTP/1.1 request parser for the dashboard's OTLP receiver (see [`OtlpReceiver`](/api/telemetry/dashboard/otlp-receiver/)).

This is deliberately NOT a general HTTP parser: the OTel PHP OTLP/HTTP exporter always sends `POST /v1/traces` or `POST /v1/metrics` with a `Content-Length` header (never chunked transfer encoding), so that is the only shape this class needs to accept. Anything else -- chunked encoding, a missing/invalid Content-Length, an oversized header block or body, a malformed request/header line -- throws [`MalformedRequestException`](/api/telemetry/dashboard/malformed-request-exception/) so the receiver can reject the connection and keep serving everyone else, mirroring the "never crash the process" posture the telemetry middleware already holds on the app side.

Usage: one instance per connection. Feed it raw bytes as they arrive via [`HttpMessageParser::feed()`](/api/telemetry/dashboard/http-message-parser/#feed), then call [`HttpMessageParser::tryParse()`](/api/telemetry/dashboard/http-message-parser/#tryparse) after every feed; it returns null until a complete request has been buffered, and consumes exactly one request's bytes off the internal buffer per call (so pipelined/back-to-back requests on the same connection are handled by calling tryParse() again).

## Synopsis

`final class HttpMessageParser`

|  |  |
|---|---|
| Source | `HttpMessageParser.php` |

## Methods

| Method | Description |
|---|---|
| [`feed(string $chunk): void`](#feed) | Appends raw bytes to this connection's buffer. |
| [`tryParse(): ParsedHttpRequest|null`](#tryparse) |  |

### feed()

`public function feed(string $chunk): void`

Appends raw bytes to this connection's buffer.

| Parameter | Type | Description |
|---|---|---|
| `$chunk` | `string` |  |

| Throws | When |
|---|---|
| `MalformedRequestException` | if the buffered bytes exceed the combined header and body limits, which bounds what a single connection can make the receiver hold |

### tryParse()

`public function tryParse(): ParsedHttpRequest|null`

Returns [`ParsedHttpRequest`](/api/telemetry/dashboard/parsed-http-request/)`|``null` — null means "need more bytes", call feed() again and retry
