# HttpStatus

> The single source of truth for HTTP status-code validity and reason phrases.

The single source of truth for HTTP status-code validity and reason phrases.

Validity is a range check, not membership of a code list: the IANA registry grows, and a framework that has to be edited before an application can emit a new status code blocks that application for no benefit. Status validity is also independent of the protocol version carrying it.

## Synopsis

`final class HttpStatus`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Http/HttpStatus.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `MAX` | `599` | Highest status code the three-digit wire format permits. |
| `MIN` | `100` | Lowest status code any HTTP version permits. |

## Methods

| Method | Description |
|---|---|
| [`isRedirect(string|int $code): bool`](#isredirect) | Whether $code is a redirect status that carries a Location header. |
| [`isValid(string|int $code): bool`](#isvalid) | Whether $code can be sent as an HTTP status. |
| [`phrase(string|int $code): string`](#phrase) | The reason phrase for $code, or a generic class-derived phrase for a valid code with no registered phrase. |

### isRedirect()

`public static function isRedirect(string|int $code): bool`

Whether $code is a redirect status that carries a Location header.

304 is deliberately excluded: it is a 3xx but not a redirect.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string``|``int` |  |

Returns `bool`

### isValid()

`public static function isValid(string|int $code): bool`

Whether $code can be sent as an HTTP status.

Accepts a numeric string as well as an int, because the response API carries `string|int` status codes and config-sourced codes arrive as strings. A non-numeric string, or anything outside 100-599, is rejected.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string``|``int` |  |

Returns `bool`

### phrase()

`public static function phrase(string|int $code): string`

The reason phrase for $code, or a generic class-derived phrase for a valid code with no registered phrase.

An invalid code yields the empty string, which PSR-7 permits as a reason phrase, keeping this total rather than throwing.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string``|``int` |  |

Returns `string`
