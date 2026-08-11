# WebResponseInterface

> The response an action or view writes to: body, status, headers, cookies, redirect and content type, plus the conversion to PSR-7 the runtime emits.

The response an action or view writes to: body, status, headers, cookies, redirect and content type, plus the conversion to PSR-7 the runtime emits.

Narrower than [`WebResponse`](/api/response/web-response/): its serialization hooks, parameter holder and worker-reset behaviour serve the framework's own plumbing, not the code composing a response.

Named for the framework's response rather than PSR-7's, which [`WebResponse`](/api/response/web-response/) is not -- it is mutable by design, being the thing an action progressively fills in. Convert with [`WebResponseInterface::toPsrResponse()`](/api/response/web-response-interface/#topsrresponse) at the point a real PSR-7 message is wanted.

## Synopsis

`interface WebResponseInterface`

|  |  |
|---|---|
| Implemented by | [`WebResponse`](/api/response/web-response/) |
| Since | `3.2.0` |
| Source | `Response/WebResponseInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`addHttpHeader(string $name, mixed $value): mixed`](#addhttpheader) | Add a header value, keeping any already set. |
| [`appendContent(mixed $content): mixed`](#appendcontent) | Append to a string body. |
| [`clearContent(): mixed`](#clearcontent) | Discard the body. |
| [`clearRedirect(): mixed`](#clearredirect) | Discard any queued redirect. |
| [`getContent(): mixed`](#getcontent) | The response body: a string, a scalar, a stream resource, or null when unset. |
| [`getContentType(): ?string`](#getcontenttype) | The response's Content-Type. |
| [`getCookies(): array<string, mixed>`](#getcookies) | Every queued cookie definition, keyed by name. |
| [`getHttpHeader(string $name): ?list<string>`](#gethttpheader) | All values of one header, or null when unset. |
| [`getHttpHeaders(): array<string, list<string>>`](#gethttpheaders) | Every header set on this response. |
| [`getHttpStatusCode(): string`](#gethttpstatuscode) | The status code, as a numeric string. |
| [`getOutputType(): ?OutputType`](#getoutputtype) | The output type this response is being rendered in. |
| [`getRedirect(): ?array{location: string, code: (int | string)}`](#getredirect) | The queued redirect, or null when none is set. |
| [`hasContent(): bool`](#hascontent) | Whether a body has been set. |
| [`hasHttpHeader(string $name): bool`](#hashttpheader) | Whether a header is set. |
| [`hasRedirect(): bool`](#hasredirect) | Whether a redirect is queued. |
| [`prependContent(mixed $content): mixed`](#prependcontent) | Prepend to a string body. |
| [`removeHttpHeader(string $name): mixed`](#removehttpheader) | Remove a header. |
| [`setContent(mixed $content): mixed`](#setcontent) | Replace the body. |
| [`setContentType(string $type): mixed`](#setcontenttype) | Set the response's Content-Type. |
| [`setCookie(string $name, mixed $value, int|string|null $lifetime = null, ?string $path = null, ?string $domain = null, ?bool $secure = null, ?bool $httponly = null, callable|false|null $encodeCallback = null, ?string $samesite = null): mixed`](#setcookie) | Queue a cookie. |
| [`setHttpHeader(string $name, mixed $value, bool $replace = true): mixed`](#sethttpheader) | Set a header, replacing any existing values unless $replace is false. |
| [`setHttpStatusCode(string|int $code): mixed`](#sethttpstatuscode) | Set the status code. |
| [`setOutputType(OutputType $outputType): mixed`](#setoutputtype) | Set the output type this response is being rendered in. |
| [`setRedirect(mixed $location, int|string $code = 302): mixed`](#setredirect) | Redirect to $location with $code. |
| [`toPsrResponse(?OutputType $outputType = null): ResponseInterface`](#topsrresponse) | Materialize this response as PSR-7, with no side effects on any output channel. |
| [`unsetCookie(string $name, ?string $path = null, ?string $domain = null, ?bool $secure = null, ?bool $httponly = null): mixed`](#unsetcookie) | Queue a cookie deletion. |

### addHttpHeader()

`abstract public function addHttpHeader(string $name, mixed $value): mixed`

Add a header value, keeping any already set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `mixed`

### appendContent()

`abstract public function appendContent(mixed $content): mixed`

Append to a string body.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `mixed` |  |

Returns `mixed`

### clearContent()

`abstract public function clearContent(): mixed`

Discard the body.

Returns `mixed`

### clearRedirect()

`abstract public function clearRedirect(): mixed`

Discard any queued redirect.

Returns `mixed`

### getContent()

`abstract public function getContent(): mixed`

The response body: a string, a scalar, a stream resource, or null when unset.

Returns `mixed`

### getContentType()

`abstract public function getContentType(): ?string`

The response's Content-Type.

Returns `?``string`

### getCookies()

`abstract public function getCookies(): array<string, mixed>`

Every queued cookie definition, keyed by name.

Returns `array``<``string``, ``mixed``>`

### getHttpHeader()

`abstract public function getHttpHeader(string $name): ?list<string>`

All values of one header, or null when unset.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `?``list``<``string``>`

### getHttpHeaders()

`abstract public function getHttpHeaders(): array<string, list<string>>`

Every header set on this response.

Returns `array``<``string``, ``list``<``string``>``>`

### getHttpStatusCode()

`abstract public function getHttpStatusCode(): string`

The status code, as a numeric string.

Returns `string`

### getOutputType()

`abstract public function getOutputType(): ?OutputType`

The output type this response is being rendered in.

Returns `?`[`OutputType`](/api/controller/output-type/)

### getRedirect()

`abstract public function getRedirect(): ?array{location: string, code: (int | string)}`

The queued redirect, or null when none is set.

Returns `?``array{location: string, code: (int | string)}`

### hasContent()

`abstract public function hasContent(): bool`

Whether a body has been set.

Returns `bool`

### hasHttpHeader()

`abstract public function hasHttpHeader(string $name): bool`

Whether a header is set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### hasRedirect()

`abstract public function hasRedirect(): bool`

Whether a redirect is queued.

Returns `bool`

### prependContent()

`abstract public function prependContent(mixed $content): mixed`

Prepend to a string body.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `mixed` |  |

Returns `mixed`

### removeHttpHeader()

`abstract public function removeHttpHeader(string $name): mixed`

Remove a header.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `mixed`

### setContent()

`abstract public function setContent(mixed $content): mixed`

Replace the body.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `mixed` |  |

Returns `mixed`

### setContentType()

`abstract public function setContentType(string $type): mixed`

Set the response's Content-Type.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `string` |  |

Returns `mixed`

### setCookie()

`abstract public function setCookie(string $name, mixed $value, int|string|null $lifetime = null, ?string $path = null, ?string $domain = null, ?bool $secure = null, ?bool $httponly = null, callable|false|null $encodeCallback = null, ?string $samesite = null): mixed`

Queue a cookie.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` | Null, false or the empty string deletes the cookie. |
| `$lifetime` | `int``|``string``|``null` | Seconds, or a strtotime()-parseable string. |
| `$path` | `?``string` |  |
| `$domain` | `?``string` |  |
| `$secure` | `?``bool` |  |
| `$httponly` | `?``bool` |  |
| `$encodeCallback` | `callable``|``false``|``null` | False asserts $value is pre-encoded. |
| `$samesite` | `?``string` |  |

Returns `mixed`

### setHttpHeader()

`abstract public function setHttpHeader(string $name, mixed $value, bool $replace = true): mixed`

Set a header, replacing any existing values unless $replace is false.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |
| `$replace` | `bool` |  |

Returns `mixed`

### setHttpStatusCode()

`abstract public function setHttpStatusCode(string|int $code): mixed`

Set the status code.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string``|``int` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `QuioteException` | For a code outside the acceptable range. |

### setOutputType()

`abstract public function setOutputType(OutputType $outputType): mixed`

Set the output type this response is being rendered in.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | [`OutputType`](/api/controller/output-type/) |  |

Returns `mixed`

### setRedirect()

`abstract public function setRedirect(mixed $location, int|string $code = 302): mixed`

Redirect to $location with $code.

| Parameter | Type | Description |
|---|---|---|
| `$location` | `mixed` |  |
| `$code` | `int``|``string` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `QuioteException` | For a code outside the acceptable range. |

### toPsrResponse()

`abstract public function toPsrResponse(?OutputType $outputType = null): ResponseInterface`

Materialize this response as PSR-7, with no side effects on any output channel.

Output type whose headers to fold in; defaults to
            this response's own.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?`[`OutputType`](/api/controller/output-type/) | Output type whose headers to fold in; defaults to this response's own. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### unsetCookie()

`abstract public function unsetCookie(string $name, ?string $path = null, ?string $domain = null, ?bool $secure = null, ?bool $httponly = null): mixed`

Queue a cookie deletion.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$path` | `?``string` |  |
| `$domain` | `?``string` |  |
| `$secure` | `?``bool` |  |
| `$httponly` | `?``bool` |  |

Returns `mixed`
