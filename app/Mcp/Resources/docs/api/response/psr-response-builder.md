# PsrResponseBuilder

> Assembles a PSR-7 response from already-resolved status, headers, cookies and body.

Assembles a PSR-7 response from already-resolved status, headers, cookies and body.

The translation step every runtime shares, with no side effects on any output channel and no dependency on a context, a request or response state: everything it needs arrives as a plain value. Deciding *what* the status and headers should be belongs to [`WebResponse`](/api/response/web-response/); turning that decision into a PSR-7 message belongs here.

## Synopsis

`final class PsrResponseBuilder`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Response/PsrResponseBuilder.php` |

## Methods

| Method | Description |
|---|---|
| [`build(int $status, array<string, list<string>|string> $headers, list<string> $setCookieLines, mixed $content, bool $withBody = true, ?string $sendfileHeaderName = null): ResponseInterface`](#build) |  |

### build()

`public function build(int $status, array<string, list<string>|string> $headers, list<string> $setCookieLines, mixed $content, bool $withBody = true, ?string $sendfileHeaderName = null): ResponseInterface`

When set and $content is a plain-file resource,
            the file's path is handed to the front-end server through this header and
            no body is emitted.

| Parameter | Type | Description |
|---|---|---|
| `$status` | `int` | Status code, already validated. |
| `$headers` | `array``<``string``, ``list``<``string``>``|``string``>` | Header name => value(s). |
| `$setCookieLines` | `list``<``string``>` | Serialized `Set-Cookie` values. |
| `$content` | `mixed` | String, scalar, stream resource, or null. |
| `$withBody` | `bool` | False to emit headers only (a redirect, typically). |
| `$sendfileHeaderName` | `?``string` | When set and $content is a plain-file resource, the file's path is handed to the front-end server through this header and no body is emitted. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)
