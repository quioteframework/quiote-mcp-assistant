# PsrResponseAdapter

> A PSR-7 view of a WebResponse, so a view or action handed a PSR-7 response can read the status, headers and body the framework has assembled.

A PSR-7 view of a [`WebResponse`](/api/response/web-response/), so a view or action handed a PSR-7 response can read the status, headers and body the framework has assembled.

Immutable, as PSR-7 requires: each with*() method returns a new adapter carrying the change and leaves both this instance and the underlying WebResponse untouched. A caller that discards the return value therefore changes nothing -- capture and propagate it, exactly as with any PSR-7 message.

To change the response the framework will actually send, write to the WebResponse itself (`$this->getResponse()->setHttpHeader(...)` from a view, or [`PsrResponseAdapter::getLegacy()`](/api/http/psr-response-adapter/#getlegacy) here). That is the mutable object; this is a value read off it.

Values not yet overridden are read through to the WebResponse, so an adapter created before the response was finished still reflects it.

## Synopsis

`class PsrResponseAdapter implements ResponseInterface`

|  |  |
|---|---|
| Implements | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |
| Source | `Http/PsrResponseAdapter.php` |

## Constructor

### __construct()

`public function __construct(WebResponse $legacy, ?StreamInterface $body = null, string $protocolVersion = '1.1'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$legacy` | [`WebResponse`](/api/response/web-response/) |  |
| `$body` | `?`[`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$protocolVersion` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getBody(): StreamInterface`](#getbody) | Returns the body stream, building one from the WebResponse's content on first call. |
| [`getHeader(string $name): list<string>`](#getheader) | Retrieves a message header value by the given case-insensitive name. |
| [`getHeaderLine(mixed $name): string`](#getheaderline) | Returns the header's values joined by `, `, or an empty string when the header is absent. |
| [`getHeaders(): array<string, list<string>>`](#getheaders) | Retrieves all message header values. |
| [`getLegacy(): WebResponse`](#getlegacy) | The underlying mutable response. |
| [`getProtocolVersion(): string`](#getprotocolversion) | Returns the protocol version this adapter carries, defaulting to `1.1` unless the constructor or withProtocolVersion() set another. |
| [`getReasonPhrase(): string`](#getreasonphrase) | Returns the phrase supplied to withStatus(), or the standard phrase HttpStatus maps the current code to. |
| [`getStatusCode(): int`](#getstatuscode) | Returns the overridden status code, or the WebResponse's current one when withStatus() was never called. |
| [`hasHeader(mixed $name): bool`](#hasheader) | Reports whether a header is present, matching the name case-insensitively against the overlay or the WebResponse. |
| [`withAddedHeader(mixed $name, mixed $value): static`](#withaddedheader) | Returns a clone with the given value or values appended to the named header. |
| [`withBody(StreamInterface $body): static`](#withbody) | Returns a clone carrying the given body stream; the WebResponse's own content is left untouched. |
| [`withHeader(mixed $name, mixed $value): static`](#withheader) | Returns a clone in which the named header is replaced by the given value or values. |
| [`withProtocolVersion(mixed $version): static`](#withprotocolversion) | Returns a clone carrying the given protocol version; the WebResponse is unaffected. |
| [`withStatus(mixed $code, mixed $reasonPhrase = ''): static`](#withstatus) | Returns a clone whose status code overrides the WebResponse's, leaving the WebResponse itself alone. |
| [`withoutHeader(mixed $name): static`](#withoutheader) | Returns a clone without the named header, matching case-insensitively. |

### getBody()

`public function getBody(): StreamInterface`

Returns the body stream, building one from the WebResponse's content on first call.

A resource is wrapped directly; null and scalar content are copied into an in-memory stream. The result is memoised on this instance, so later changes to the WebResponse's content are not picked up.

Returns [`StreamInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `RuntimeException` | when the content is neither a resource, null, nor scalar |

### getHeader()

`public function getHeader(string $name): list<string>`

Retrieves a message header value by the given case-insensitive name.

Case-insensitive header field name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | Case-insensitive header field name. |

Returns `list``<``string``>` — An array of string values as provided for the given header. If the header does not appear in the message, this method MUST return an empty array.

### getHeaderLine()

`public function getHeaderLine(mixed $name): string`

Returns the header's values joined by `, `, or an empty string when the header is absent.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `string`

### getHeaders()

`public function getHeaders(): array<string, list<string>>`

Retrieves all message header values.

The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header.

// Represent the headers as a string foreach ($message->getHeaders() as $name => $values) { echo $name . ": " . implode(", ", $values); }

// Emit headers iteratively: foreach ($message->getHeaders() as $name => $values) { foreach ($values as $value) { header(sprintf('%s: %s', $name, $value), false); } }

While header names are not case-sensitive, getHeaders() will preserve the exact case in which headers were originally specified.

Returns `array``<``string``, ``list``<``string``>``>` — Returns an associative array of the message's headers. Each key MUST be a header name, and each value MUST be an array of strings for that header.

### getLegacy()

`public function getLegacy(): WebResponse`

The underlying mutable response.

Write here to change what gets sent.

Returns [`WebResponse`](/api/response/web-response/)

### getProtocolVersion()

`public function getProtocolVersion(): string`

Returns the protocol version this adapter carries, defaulting to `1.1` unless the constructor or withProtocolVersion() set another.

Returns `string`

### getReasonPhrase()

`public function getReasonPhrase(): string`

Returns the phrase supplied to withStatus(), or the standard phrase HttpStatus maps the current code to.

Returns `string`

### getStatusCode()

`public function getStatusCode(): int`

Returns the overridden status code, or the WebResponse's current one when withStatus() was never called.

Returns `int`

### hasHeader()

`public function hasHeader(mixed $name): bool`

Reports whether a header is present, matching the name case-insensitively against the overlay or the WebResponse.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `bool`

### withAddedHeader()

`public function withAddedHeader(mixed $name, mixed $value): static`

Returns a clone with the given value or values appended to the named header.

The clone snapshots the WebResponse's headers into its own overlay. An existing header is matched case-insensitively and keeps its stored spelling; otherwise the supplied spelling starts a new entry.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withBody()

`public function withBody(StreamInterface $body): static`

Returns a clone carrying the given body stream; the WebResponse's own content is left untouched.

| Parameter | Type | Description |
|---|---|---|
| `$body` | [`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `static`

### withHeader()

`public function withHeader(mixed $name, mixed $value): static`

Returns a clone in which the named header is replaced by the given value or values.

The clone snapshots the WebResponse's headers into its own overlay, so it no longer reads headers through to the WebResponse. Any existing header with a differently cased name is removed first, and the supplied spelling is the one stored. Non-stringable values become empty strings.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withProtocolVersion()

`public function withProtocolVersion(mixed $version): static`

Returns a clone carrying the given protocol version; the WebResponse is unaffected.

| Parameter | Type | Description |
|---|---|---|
| `$version` | `mixed` |  |

Returns `static`

### withStatus()

`public function withStatus(mixed $code, mixed $reasonPhrase = ''): static`

Returns a clone whose status code overrides the WebResponse's, leaving the WebResponse itself alone.

An empty reason phrase clears any override, so [`PsrResponseAdapter::getReasonPhrase()`](/api/http/psr-response-adapter/#getreasonphrase) falls back to the standard phrase for the code.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `mixed` |  |
| `$reasonPhrase` | `mixed` |  |

Returns `static`

| Throws | When |
|---|---|
| `InvalidArgumentException` | when the code is outside the range HttpStatus accepts |

### withoutHeader()

`public function withoutHeader(mixed $name): static`

Returns a clone without the named header, matching case-insensitively.

When the header is absent this instance is returned unchanged, so no overlay is created and the adapter keeps reading headers through to the WebResponse.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `static`
