# ParsedHttpRequest

> The result of HttpMessageParser::tryParse() -- method, path, headers (lower-cased names), and the fully-buffered request body.

The result of [`HttpMessageParser::tryParse()`](/api/telemetry/dashboard/http-message-parser/#tryparse) -- method, path, headers (lower-cased names), and the fully-buffered request body.

## Synopsis

`final class ParsedHttpRequest`

|  |  |
|---|---|
| Source | `ParsedHttpRequest.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$body` | `string` | _readonly._ |
| `$headers` | `array` | _readonly._ |
| `$method` | `string` | _readonly._ |
| `$path` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $method, string $path, array<string, string> $headers, string $body): mixed`

header name (lower-case) => value

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |
| `$path` | `string` |  |
| `$headers` | `array``<``string``, ``string``>` | header name (lower-case) => value |
| `$body` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`header(string $name): ?string`](#header) | The value of header $name, matched case-insensitively, or null when the request did not carry it. |

### header()

`public function header(string $name): ?string`

The value of header $name, matched case-insensitively, or null when the request did not carry it.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `?``string`
