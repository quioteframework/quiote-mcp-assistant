# WebResponse

> WebResponse handles the HTTP response: status code, headers, cookies, redirects and the content sent back to the client.

WebResponse handles the HTTP response: status code, headers, cookies, redirects and the content sent back to the client.

## Synopsis

`class WebResponse extends AttributeHolder implements WebResponseInterface`

|  |  |
|---|---|
| Extends | [`AttributeHolder`](/api/util/attribute-holder/) |
| Implements | [`WebResponseInterface`](/api/response/web-response-interface/) |
| Since | `1.0.0` |
| Source | `Response/WebResponse.php` |

## Methods

| Method | Description |
|---|---|
| [`__sleep(): list<string>`](#sleep) | Pre-serialization callback. |
| [`__wakeup(): void`](#wakeup) | Post-unserialization callback. |
| [`addHttpHeader(string $name, mixed $value): void`](#addhttpheader) |  |
| [`appendContent(mixed $content): void`](#appendcontent) | Append content to the existing content for this Response. |
| [`clear(): void`](#clear) | Clear all response data. |
| [`clearContent(): void`](#clearcontent) | Clear the content for this Response. |
| [`clearHttpHeaders(): void`](#clearhttpheaders) | Clears the HTTP headers set for this response. |
| [`clearOutputType(): void`](#clearoutputtype) | Clear the Output Type to use with this response. |
| [`clearRedirect(): void`](#clearredirect) | Clear any set redirect information. |
| [`getContent(): mixed`](#getcontent) | Retrieve the content set for this Response. |
| [`getContentSize(): int|false`](#getcontentsize) | Retrieve the size (in bytes) of the content set for this Response. |
| [`getContentType(): ?string`](#getcontenttype) | Retrieve the content type set for the response. |
| [`getContext(): Context`](#getcontext) | Retrieve the Context instance this Response object belongs to. |
| [`getCookie(string $name): ?array<string, mixed>`](#getcookie) | Get a cookie set for later sending. |
| [`getCookies(): array<string, array{value: mixed, lifetime: (int | string | null), path: (string | null), domain: (string | null), secure: bool, httponly: bool, encode_callback: (callable | false), samesite: (string | null)}>`](#getcookies) | Get a list of cookies set for later sending. |
| [`getHttpHeader(string $name): ?list<string>`](#gethttpheader) | Retrieve the HTTP header values set for the response. |
| [`getHttpHeaders(): array<string, list<string>>`](#gethttpheaders) | Retrieve the HTTP headers set for the response. |
| [`getHttpStatusCode(): string`](#gethttpstatuscode) | Gets the HTTP status code set for the response. |
| [`getOutputType(): ?OutputType`](#getoutputtype) | Get the Output Type to use with this response. |
| [`getPsrResponse(): ?ResponseInterface`](#getpsrresponse) | Returns the attached PSR-7 response, or null when none was attached. |
| [`getRedirect(): ?array{location: string, code: (int | string)}`](#getredirect) | Get info about the set redirect. |
| [`getStagedResponse(): ?ResponseInterface`](#getstagedresponse) | The response staged by [`WebResponse::send()`](/api/response/web-response/#send), or null if send() was never called. |
| [`hasContent(): bool`](#hascontent) | Check whether or not some content is set. |
| [`hasCookie(string $name): bool`](#hascookie) | Check if a cookie has been set for later sending. |
| [`hasHttpHeader(string $name): bool`](#hashttpheader) | Check if an HTTP header has been set for the response. |
| [`hasRedirect(): bool`](#hasredirect) | Check if a redirect is set. |
| [`hasStagedResponse(): bool`](#hasstagedresponse) | Whether [`WebResponse::send()`](/api/response/web-response/#send) has staged a response awaiting emission. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Response. |
| [`isContentMutable(): bool`](#iscontentmutable) | Determine whether the content in the response may be modified by appending or prepending data using string operations. |
| [`merge(WebResponse $otherResponse): void`](#merge) | Import response metadata (attributes, headers, cookies, redirect) from another response. |
| [`normalizeHttpHeaderName(string $name): string`](#normalizehttpheadername) | Normalizes a HTTP header names |
| [`prependContent(mixed $content): void`](#prependcontent) | Prepend content to the existing content for this Response. |
| [`removeCookie(string $name): void`](#removecookie) | Remove a cookie previously set for later sending. |
| [`removeHttpHeader(string $name): mixed`](#removehttpheader) | Remove the HTTP header set for the response |
| [`reset(): void`](#reset) | Reset response state for worker compatibility: everything a request can put on the response has to go, or request N's body/headers/cookies would bleed into request N+1. |
| [`send(OutputType $outputType = null): void`](#send) | Stage this response for emission. |
| [`sendContent(): void`](#sendcontent) | Send the content for this response. |
| [`setContent(mixed $content): void`](#setcontent) | Set the content for this Response. |
| [`setContentType(string $type): void`](#setcontenttype) | Set the content type for the response. |
| [`setCookie(string $name, mixed $value, mixed $lifetime = null, ?string $path = null, ?string $domain = null, ?bool $secure = null, ?bool $httponly = null, mixed $encodeCallback = null, ?string $samesite = null): void`](#setcookie) |  |
| [`setHttpHeader(string $name, mixed $value, bool $replace = true): void`](#sethttpheader) | Set a HTTP header for the response |
| [`setHttpStatusCode(string|int $code): void`](#sethttpstatuscode) | Sets a HTTP status code for the response. |
| [`setOutputType(OutputType $outputType): void`](#setoutputtype) | Set the Output Type to use with this response. |
| [`setPsrResponse(?ResponseInterface $psr): void`](#setpsrresponse) | Attach a PSR-7 response instance for forwarding. |
| [`setRedirect(mixed $location, int|string $code = 302): void`](#setredirect) | Redirect externally. |
| [`toPsrResponse(?OutputType $outputType = null): ResponseInterface`](#topsrresponse) | Materialize this response as PSR-7: status, prepared headers, queued cookies and body, with no side effects on any output channel. |
| [`unsetCookie(string $name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null): void`](#unsetcookie) | Unset an existing cookie. |
| [`validateHttpStatusCode(string|int $code): bool`](#validatehttpstatuscode) | Check if the given HTTP status code is valid. |

### __sleep()

`public function __sleep(): list<string>`

Pre-serialization callback.

Heavy object references (the Context, the OutputType) and the content stream cannot be serialized, so record the identifiers needed to look them back up in __wakeup() and leave the objects themselves out.

Returns `list``<``string``>`

### __wakeup()

`public function __wakeup(): void`

Post-unserialization callback.

Restores the Context, the OutputType and the content stream from the identifiers recorded by __sleep().

### addHttpHeader()

`public function addHttpHeader(string $name, mixed $value): void`

A HTTP header field value, or an array of values.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A HTTP header field name. |
| `$value` | `mixed` | A HTTP header field value, or an array of values. |

### appendContent()

`public function appendContent(mixed $content): void`

Append content to the existing content for this Response.

The content to be appended to this Response.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `mixed` | The content to be appended to this Response. |

### clear()

`public function clear(): void`

Clear all response data.

### clearContent()

`public function clearContent(): void`

Clear the content for this Response.

### clearHttpHeaders()

`public function clearHttpHeaders(): void`

Clears the HTTP headers set for this response.

### clearOutputType()

`public function clearOutputType(): void`

Clear the Output Type to use with this response.

### clearRedirect()

`public function clearRedirect(): void`

Clear any set redirect information.

### getContent()

`public function getContent(): mixed`

Retrieve the content set for this Response.

Returns `mixed` — The content set in this Response.

### getContentSize()

`public function getContentSize(): int|false`

Retrieve the size (in bytes) of the content set for this Response.

Returns `int``|``false` — The content size in bytes, or false if it could not be determined.

### getContentType()

`public function getContentType(): ?string`

Retrieve the content type set for the response.

Returns `?``string` — A content type, or null if none is set.

### getContext()

`final public function getContext(): Context`

Retrieve the Context instance this Response object belongs to.

Returns [`Context`](/api/context/) — An Context instance.

| Throws | When |
|---|---|
| `InitializationException` | If this Response has not been initialized yet. |

### getCookie()

`public function getCookie(string $name): ?array<string, mixed>`

Get a cookie set for later sending.

The name of the cookie.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the cookie. |

Returns `?``array``<``string``, ``mixed``>` — An associative array containing the cookie data or null if no cookie with that name has been set.

### getCookies()

`public function getCookies(): array<string, array{value: mixed, lifetime: (int | string | null), path: (string | null), domain: (string | null), secure: bool, httponly: bool, encode_callback: (callable | false), samesite: (string | null)}>`

Get a list of cookies set for later sending.

Returns `array``<``string``, ``array{value: mixed, lifetime: (int | string | null), path: (string | null), domain: (string | null), secure: bool, httponly: bool, encode_callback: (callable | false), samesite: (string | null)}``>` — An associative array of cookie names (key) and cookie information (value, associative array).

### getHttpHeader()

`public function getHttpHeader(string $name): ?list<string>`

Retrieve the HTTP header values set for the response.

A HTTP header field name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A HTTP header field name. |

Returns `?``list``<``string``>` — All values set for that header, or null if no headers set

### getHttpHeaders()

`public function getHttpHeaders(): array<string, list<string>>`

Retrieve the HTTP headers set for the response.

Returns `array``<``string``, ``list``<``string``>``>` — An associative array of HTTP header names and values.

### getHttpStatusCode()

`public function getHttpStatusCode(): string`

Gets the HTTP status code set for the response.

Returns `string` — A numeric HTTP status code between 100 and 505, or null if no status code has been set.

### getOutputType()

`public function getOutputType(): ?OutputType`

Get the Output Type to use with this response.

Returns `?`[`OutputType`](/api/controller/output-type/) — The Output Type instance associated with, or null if none is set.

### getPsrResponse()

`public function getPsrResponse(): ?ResponseInterface`

Returns the attached PSR-7 response, or null when none was attached.

Not a snapshot of this response: it is the instance handed to [`WebResponse::setPsrResponse()`](/api/response/web-response/#setpsrresponse), replaced in place as status codes, headers and cookies set on this response are mirrored onto it. It is null until a response is attached, and again after [`WebResponse::reset()`](/api/response/web-response/#reset).

Returns `?`[`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### getRedirect()

`public function getRedirect(): ?array{location: string, code: (int | string)}`

Get info about the set redirect.

Returns `?``array{location: string, code: (int | string)}` — An assoc array of redirect info, or null if none set.

### getStagedResponse()

`public function getStagedResponse(): ?ResponseInterface`

The response staged by [`WebResponse::send()`](/api/response/web-response/#send), or null if send() was never called.

Returns `?`[`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### hasContent()

`public function hasContent(): bool`

Check whether or not some content is set.

Returns `bool` — If any content is set, false otherwise.

### hasCookie()

`public function hasCookie(string $name): bool`

Check if a cookie has been set for later sending.

The name of the cookie.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the cookie. |

Returns `bool` — True if a cookie with that name has been set, else false.

### hasHttpHeader()

`public function hasHttpHeader(string $name): bool`

Check if an HTTP header has been set for the response.

A HTTP header field name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A HTTP header field name. |

Returns `bool` — true if the header exists, false otherwise.

### hasRedirect()

`public function hasRedirect(): bool`

Check if a redirect is set.

Returns `bool` — true, if a redirect is set, otherwise false

### hasStagedResponse()

`public function hasStagedResponse(): bool`

Whether [`WebResponse::send()`](/api/response/web-response/#send) has staged a response awaiting emission.

Returns `bool`

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this Response.

An array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | An Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An array of initialization parameters. |

### isContentMutable()

`public function isContentMutable(): bool`

Determine whether the content in the response may be modified by appending or prepending data using string operations.

Typically false for streams or responses where the content is not a string (e.g. an array).

Returns `bool` — If the content can be treated as / changed like a string.

### merge()

`public function merge(WebResponse $otherResponse): void`

Import response metadata (attributes, headers, cookies, redirect) from another response.

The other response to import information from.

| Parameter | Type | Description |
|---|---|---|
| `$otherResponse` | [`WebResponse`](/api/response/web-response/) | The other response to import information from. |

### normalizeHttpHeaderName()

`public function normalizeHttpHeaderName(string $name): string`

Normalizes a HTTP header names

A HTTP header name

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A HTTP header name |

Returns `string` — A normalized HTTP header name

### prependContent()

`public function prependContent(mixed $content): void`

Prepend content to the existing content for this Response.

The content to be prepended to this Response.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `mixed` | The content to be prepended to this Response. |

### removeCookie()

`public function removeCookie(string $name): void`

Remove a cookie previously set for later sending.

The name of the cookie.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the cookie. |

### removeHttpHeader()

`public function removeHttpHeader(string $name): mixed`

Remove the HTTP header set for the response

A HTTP header field name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A HTTP header field name. |

Returns `mixed` — The removed header's value or null if header was not set.

### reset()

`public function reset(): void`

Reset response state for worker compatibility: everything a request can put on the response has to go, or request N's body/headers/cookies would bleed into request N+1.

The Context is deliberately kept -- it is application-scoped, not request-scoped, and a reused response instance is not re-initialize()d before the next request.

### send()

`public function send(OutputType $outputType = null): void`

Stage this response for emission.

An optional Output Type object with information
                            the response can use to send additional data,
                            such as HTTP headers

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | [`OutputType`](/api/controller/output-type/) | An optional Output Type object with information the response can use to send additional data, such as HTTP headers |

### sendContent()

`public function sendContent(): void`

:::caution[Deprecated]
This method is deprecated. Call send() instead; this no longer echoes, because emission belongs to the runtime's emitter. Kept so existing callers still get their content to the client rather than silently losing it.
:::

Send the content for this response.

### setContent()

`public function setContent(mixed $content): void`

Set the content for this Response.

The content to be sent in this Response.

| Parameter | Type | Description |
|---|---|---|
| `$content` | `mixed` | The content to be sent in this Response. |

### setContentType()

`public function setContentType(string $type): void`

Set the content type for the response.

A content type.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `string` | A content type. |

### setCookie()

`public function setCookie(string $name, mixed $value, mixed $lifetime = null, ?string $path = null, ?string $domain = null, ?bool $secure = null, ?bool $httponly = null, mixed $encodeCallback = null, ?string $samesite = null): void`

The SameSite attribute for the cookie.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A cookie name. |
| `$value` | `mixed` | Data to store into a cookie. If null or empty cookie will be tried to be removed. |
| `$lifetime` | `mixed` | The lifetime of the cookie in seconds. When you pass 0 the cookie will be valid until the browser is closed. You can also use a strtotime() string instead of an int. |
| `$path` | `?``string` | The path on the server the cookie will be available on. |
| `$domain` | `?``string` | The domain the cookie is available on. |
| `$secure` | `?``bool` | Indicates that the cookie should only be transmitted over a secure HTTPS connection. |
| `$httponly` | `?``bool` | Whether the cookie will be made accessible only through the HTTP protocol, and not to client-side scripts. |
| `$encodeCallback` | `mixed` | Callback to encode the cookie value. Set to false if you did already encode the value on your own. |
| `$samesite` | `?``string` | The SameSite attribute for the cookie. |

### setHttpHeader()

`public function setHttpHeader(string $name, mixed $value, bool $replace = true): void`

Set a HTTP header for the response

If true, a header with that name will be overwritten,
                   otherwise, the value will be appended.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A HTTP header field name. |
| `$value` | `mixed` | A HTTP header field value, of an array of values. |
| `$replace` | `bool` | If true, a header with that name will be overwritten, otherwise, the value will be appended. |

### setHttpStatusCode()

`public function setHttpStatusCode(string|int $code): void`

Sets a HTTP status code for the response.

A numeric HTTP status code.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string``|``int` | A numeric HTTP status code. |

### setOutputType()

`public function setOutputType(OutputType $outputType): void`

Set the Output Type to use with this response.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | [`OutputType`](/api/controller/output-type/) |  |

### setPsrResponse()

`public function setPsrResponse(?ResponseInterface $psr): void`

Attach a PSR-7 response instance for forwarding.

| Parameter | Type | Description |
|---|---|---|
| `$psr` | `?`[`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### setRedirect()

`public function setRedirect(mixed $location, int|string $code = 302): void`

Redirect externally.

A numeric HTTP status code.

| Parameter | Type | Description |
|---|---|---|
| `$location` | `mixed` | Where to redirect. |
| `$code` | `int``|``string` | A numeric HTTP status code. |

### toPsrResponse()

`public function toPsrResponse(?OutputType $outputType = null): ResponseInterface`

Materialize this response as PSR-7: status, prepared headers, queued cookies and body, with no side effects on any output channel.

Output type whose http_headers to fold in;
                        defaults to this response's own.

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | `?`[`OutputType`](/api/controller/output-type/) | Output type whose http_headers to fold in; defaults to this response's own. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

| Throws | When |
|---|---|
| `QuioteException` | If a relative redirect is set with no initialized Context. |

### unsetCookie()

`public function unsetCookie(string $name, string $path = null, string $domain = null, bool $secure = null, bool $httponly = null): void`

Unset an existing cookie.

Whether the cookie will be made accessible only through
                   the HTTP protocol, and not to client-side scripts.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A cookie name. |
| `$path` | `string` | The path on the server the cookie will be available on. |
| `$domain` | `string` | The domain the cookie is available on. |
| `$secure` | `bool` | Indicates that the cookie should only be transmitted over a secure HTTPS connection. |
| `$httponly` | `bool` | Whether the cookie will be made accessible only through the HTTP protocol, and not to client-side scripts. |

### validateHttpStatusCode()

`public function validateHttpStatusCode(string|int $code): bool`

Check if the given HTTP status code is valid.

A numeric HTTP status code.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string``|``int` | A numeric HTTP status code. |

Returns `bool` — True, if the code is valid, or false otherwise.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Append an attribute. |
| `appendAttributeByRef()` | [`AttributeHolder`](/api/util/attribute-holder/) | Append an attribute by reference. |
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Clear all attributes. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an attribute. |
| `getAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute names. |
| `getAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getAttributeNamespaces()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute namespaces. |
| `getAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getDefaultNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Get the default namespace name |
| `getFlatAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of flattened attribute names. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute exists. |
| `hasAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute namespace exists. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Remove an attribute. |
| `removeAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Remove an attribute namespace and all of its associated attributes. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an attribute. |
| `setAttributeByRef()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an attribute by reference. |
| `setAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an array of attributes. |
| `setAttributesByRef()` | [`AttributeHolder`](/api/util/attribute-holder/) | Set an array of attributes by reference. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
