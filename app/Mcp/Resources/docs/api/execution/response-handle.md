# ResponseHandle

> Minimal façade exposing response operations in no-container execution paths.

Minimal façade exposing response operations in no-container execution paths.

Designed to work with WebResponse or legacy Response-compatible objects.

## Synopsis

`class ResponseHandle`

|  |  |
|---|---|
| Source | `Execution/ResponseHandle.php` |

## Constructor

### __construct()

`public function __construct(object $inner): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$inner` | `object` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`addHeader(string $name, string $value, bool $replace = true): void`](#addheader) | Sets an HTTP header on the wrapped response, replacing any existing value unless $replace is false. |
| [`append(string $content): void`](#append) | Appends content to the wrapped response; does nothing when it exposes no appendContent(). |
| [`clear(): void`](#clear) | Discards the wrapped response's content; does nothing when it exposes no clearContent(). |
| [`getContent(): string`](#getcontent) | Returns the wrapped response's content, or an empty string when it exposes no getContent(). |
| [`getInner(): mixed`](#getinner) | Returns the wrapped response object, for callers needing an API this façade does not expose. |
| [`set(string $content): void`](#set) | Replaces the wrapped response's content; does nothing when it exposes no setContent(). |
| [`setStatusCode(int $code): void`](#setstatuscode) | Sets the wrapped response's HTTP status code; does nothing when it exposes no setHttpStatusCode(). |

### addHeader()

`public function addHeader(string $name, string $value, bool $replace = true): void`

Sets an HTTP header on the wrapped response, replacing any existing value unless $replace is false.

Does nothing when the wrapped object exposes no setHttpHeader().

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `string` |  |
| `$replace` | `bool` |  |

### append()

`public function append(string $content): void`

Appends content to the wrapped response; does nothing when it exposes no appendContent().

| Parameter | Type | Description |
|---|---|---|
| `$content` | `string` |  |

### clear()

`public function clear(): void`

Discards the wrapped response's content; does nothing when it exposes no clearContent().

### getContent()

`public function getContent(): string`

Returns the wrapped response's content, or an empty string when it exposes no getContent().

Returns `string`

### getInner()

`public function getInner(): mixed`

Returns the wrapped response object, for callers needing an API this façade does not expose.

Returns `mixed`

### set()

`public function set(string $content): void`

Replaces the wrapped response's content; does nothing when it exposes no setContent().

| Parameter | Type | Description |
|---|---|---|
| `$content` | `string` |  |

### setStatusCode()

`public function setStatusCode(int $code): void`

Sets the wrapped response's HTTP status code; does nothing when it exposes no setHttpStatusCode().

| Parameter | Type | Description |
|---|---|---|
| `$code` | `int` |  |
