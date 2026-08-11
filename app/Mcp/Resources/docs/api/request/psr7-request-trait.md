# Psr7RequestTrait

> Reading and stripping of intrinsic PSR-7 request data, used by WebRequest.

Reading and stripping of intrinsic PSR-7 request data, used by [`WebRequest`](/api/request/web-request/).

The three protected helpers work purely against a `ServerRequestInterface`: one looks a single name up across parsed body, query, cookies, headers and uploaded files; one returns everything, or just one of the named sources (`parameters`, `cookies`, `files`, `headers`, `attributes`); and one returns a request clone with a name removed from whichever source holds it, or null when no source did.

They see only what arrived with the request. Runtime parameters set through `WebRequest::setParameter()`, the strict-validation whitelist and PSR-7 attributes are WebRequest's own concern and are applied around these helpers, not inside them.

## Synopsis

`trait Psr7RequestTrait`

|  |  |
|---|---|
| Source | `Request/Psr7RequestTrait.php` |

## Methods

| Method | Description |
|---|---|
| [`getRequestParam(ServerRequestInterface $request, string $name, mixed $default = null): mixed`](#getrequestparam) | Helper used by WebRequest for reading intrinsic HTTP request data. |
| [`getRequestParams(ServerRequestInterface $request, ?string $source = null): array<int|string, mixed>`](#getrequestparams) |  |
| [`withoutParameter(ServerRequestInterface $request, string $name, ?string $source = null): ?ServerRequestInterface`](#withoutparameter) |  |

### getRequestParam()

`protected function getRequestParam(ServerRequestInterface $request, string $name, mixed $default = null): mixed`

Helper used by WebRequest for reading intrinsic HTTP request data.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$name` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getRequestParams()

`protected function getRequestParams(ServerRequestInterface $request, ?string $source = null): array<int|string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$source` | `?``string` |  |

Returns `array``<``int``|``string``, ``mixed``>`

### withoutParameter()

`protected function withoutParameter(ServerRequestInterface $request, string $name, ?string $source = null): ?ServerRequestInterface`

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$name` | `string` |  |
| `$source` | `?``string` |  |

Returns `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)
