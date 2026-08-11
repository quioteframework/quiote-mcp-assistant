# Psr7DelegationTrait

> Pure one-line delegations to the wrapped Nyholm\\Psr7\\ServerRequest.

Pure one-line delegations to the wrapped Nyholm\Psr7\ServerRequest.

Everything here is mechanical passthrough with no Quiote-specific behavior; methods that need to react to the change (e.g. withUri() re-syncing URL metadata) stay on WebRequest itself.

## Synopsis

`trait Psr7DelegationTrait`

|  |  |
|---|---|
| Source | `Request/Psr7DelegationTrait.php` |

## Methods

| Method | Description |
|---|---|
| [`getAttribute(mixed $name, mixed $default = null): mixed`](#getattribute) | Returns the named request attribute. |
| [`getAttributes(): array<string, mixed>`](#getattributes) |  |
| [`getBody(): StreamInterface`](#getbody) | Returns the wrapped request's body stream. |
| [`getCookieParams(): array<string, mixed>`](#getcookieparams) |  |
| [`getHeader(mixed $name): array`](#getheader) | Returns every value of the named header, one entry per value. |
| [`getHeaderLine(mixed $name): string`](#getheaderline) | Returns the named header's values joined with commas. |
| [`getHeaders(): array<string, mixed>`](#getheaders) |  |
| [`getMethod(): string`](#getmethod) | Returns the HTTP method of the wrapped request, in the case it was received in. |
| [`getParsedBody(): array<string, mixed>|object|null`](#getparsedbody) |  |
| [`getProtocolVersion(): string`](#getprotocolversion) | Returns the HTTP protocol version of the wrapped PSR-7 request, e.g. |
| [`getQueryParams(): array<string, mixed>`](#getqueryparams) |  |
| [`getRequestTarget(): string`](#getrequesttarget) | Returns the request target as it appears on the request line. |
| [`getServerParams(): array<string, mixed>`](#getserverparams) |  |
| [`getUploadedFiles(): array<string, UploadedFileInterface|array<int|string, mixed>>`](#getuploadedfiles) |  |
| [`getUri(): UriInterface`](#geturi) | Returns the wrapped request's URI. |
| [`hasHeader(mixed $name): bool`](#hasheader) | Reports whether the wrapped request carries the named header, case-insensitively. |
| [`withAddedHeader(mixed $name, mixed $value): static`](#withaddedheader) | Returns a clone with the given value appended to the named header. |
| [`withAttribute(mixed $name, mixed $value): static`](#withattribute) | Returns a clone carrying the named request attribute. |
| [`withBody(StreamInterface $body): static`](#withbody) | Returns a clone whose body is the given stream. |
| [`withCookieParams(array<string, mixed> $cookies): static`](#withcookieparams) |  |
| [`withHeader(mixed $name, mixed $value): static`](#withheader) | Returns a clone with the named header replaced by the given value. |
| [`withMethod(mixed $method): static`](#withmethod) | Returns a clone using the given HTTP method. |
| [`withParsedBody(array<string, mixed>|object|null $data): static`](#withparsedbody) |  |
| [`withProtocolVersion(mixed $version): static`](#withprotocolversion) | Returns a clone carrying the given HTTP protocol version. |
| [`withQueryParams(array<string, mixed> $query): static`](#withqueryparams) |  |
| [`withRequestTarget(mixed $requestTarget): static`](#withrequesttarget) | Returns a clone whose request line carries the given target verbatim. |
| [`withUploadedFiles(array<string, UploadedFileInterface|array<int|string, mixed>> $uploadedFiles): static`](#withuploadedfiles) |  |
| [`withoutAttribute(mixed $name): static`](#withoutattribute) | Returns a clone with the named request attribute removed. |
| [`withoutHeader(mixed $name): static`](#withoutheader) | Returns a clone with the named header removed. |

### getAttribute()

`public function getAttribute(mixed $name, mixed $default = null): mixed`

Returns the named request attribute.

`$default` is returned when no attribute of that name has been set, which is how attributes put on the request by middleware are read without knowing whether that middleware ran.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getAttributes()

`public function getAttributes(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getBody()

`public function getBody(): StreamInterface`

Returns the wrapped request's body stream.

The live stream, not a copy: reading from it advances the position seen by every other holder of this request.

Returns [`StreamInterface`](https://www.php-fig.org/psr/psr-7/)

### getCookieParams()

`public function getCookieParams(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getHeader()

`public function getHeader(mixed $name): array`

Returns every value of the named header, one entry per value.

An empty array when the header is not present, per PSR-7.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `array`

### getHeaderLine()

`public function getHeaderLine(mixed $name): string`

Returns the named header's values joined with commas.

An empty string when the header is not present, per PSR-7.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `string`

### getHeaders()

`public function getHeaders(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getMethod()

`public function getMethod(): string`

Returns the HTTP method of the wrapped request, in the case it was received in.

Returns `string`

### getParsedBody()

`public function getParsedBody(): array<string, mixed>|object|null`

Returns `array``<``string``, ``mixed``>``|``object``|``null`

### getProtocolVersion()

`public function getProtocolVersion(): string`

Returns the HTTP protocol version of the wrapped PSR-7 request, e.g.

`1.1`.

Returns `string`

### getQueryParams()

`public function getQueryParams(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getRequestTarget()

`public function getRequestTarget(): string`

Returns the request target as it appears on the request line.

The explicitly set target when there is one, otherwise the origin-form target derived from the URI, per PSR-7.

Returns `string`

### getServerParams()

`public function getServerParams(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getUploadedFiles()

`public function getUploadedFiles(): array<string, UploadedFileInterface|array<int|string, mixed>>`

Returns `array``<``string``, `[`UploadedFileInterface`](https://www.php-fig.org/psr/psr-7/)`|``array``<``int``|``string``, ``mixed``>``>`

### getUri()

`public function getUri(): UriInterface`

Returns the wrapped request's URI.

Returns [`UriInterface`](https://www.php-fig.org/psr/psr-7/)

### hasHeader()

`public function hasHeader(mixed $name): bool`

Reports whether the wrapped request carries the named header, case-insensitively.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `bool`

### withAddedHeader()

`public function withAddedHeader(mixed $name, mixed $value): static`

Returns a clone with the given value appended to the named header.

Existing values of that header are kept. This request is left untouched and the clone starts with an empty parameter cache.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withAttribute()

`public function withAttribute(mixed $name, mixed $value): static`

Returns a clone carrying the named request attribute.

This request is left untouched, so middleware wanting the attribute to be visible downstream has to pass the returned instance on.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withBody()

`public function withBody(StreamInterface $body): static`

Returns a clone whose body is the given stream.

This request is left untouched; the clone starts with an empty parameter cache, so parameters are re-derived from the new body.

| Parameter | Type | Description |
|---|---|---|
| `$body` | [`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `static`

### withCookieParams()

`public function withCookieParams(array<string, mixed> $cookies): static`

| Parameter | Type | Description |
|---|---|---|
| `$cookies` | `array``<``string``, ``mixed``>` |  |

Returns `static`

### withHeader()

`public function withHeader(mixed $name, mixed $value): static`

Returns a clone with the named header replaced by the given value.

Any existing values of that header are discarded. This request is left untouched and the clone starts with an empty parameter cache.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withMethod()

`public function withMethod(mixed $method): static`

Returns a clone using the given HTTP method.

The method is passed through as given; the wrapped PSR-7 request rejects a syntactically invalid one.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `mixed` |  |

Returns `static`

### withParsedBody()

`public function withParsedBody(array<string, mixed>|object|null $data): static`

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>``|``object``|``null` |  |

Returns `static`

### withProtocolVersion()

`public function withProtocolVersion(mixed $version): static`

Returns a clone carrying the given HTTP protocol version.

This request is left untouched; the clone wraps a new PSR-7 request and starts with an empty parameter cache.

| Parameter | Type | Description |
|---|---|---|
| `$version` | `mixed` |  |

Returns `static`

### withQueryParams()

`public function withQueryParams(array<string, mixed> $query): static`

| Parameter | Type | Description |
|---|---|---|
| `$query` | `array``<``string``, ``mixed``>` |  |

Returns `static`

### withRequestTarget()

`public function withRequestTarget(mixed $requestTarget): static`

Returns a clone whose request line carries the given target verbatim.

The URI is not touched, so the target may diverge from it.

| Parameter | Type | Description |
|---|---|---|
| `$requestTarget` | `mixed` |  |

Returns `static`

### withUploadedFiles()

`public function withUploadedFiles(array<string, UploadedFileInterface|array<int|string, mixed>> $uploadedFiles): static`

| Parameter | Type | Description |
|---|---|---|
| `$uploadedFiles` | `array``<``string``, `[`UploadedFileInterface`](https://www.php-fig.org/psr/psr-7/)`|``array``<``int``|``string``, ``mixed``>``>` |  |

Returns `static`

### withoutAttribute()

`public function withoutAttribute(mixed $name): static`

Returns a clone with the named request attribute removed.

A no-op clone when no attribute of that name is set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `static`

### withoutHeader()

`public function withoutHeader(mixed $name): static`

Returns a clone with the named header removed.

Each call clones the whole wrapped request; use the private bulk counterpart when removing several headers at once.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `static`
