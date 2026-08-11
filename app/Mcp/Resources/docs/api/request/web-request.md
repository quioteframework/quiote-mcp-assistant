# WebRequest

> WebRequest provides additional support for web-only client requests such as cookie and file manipulation.

WebRequest provides additional support for web-only client requests such as cookie and file manipulation.

WebRequest is immutable: every mutator (setParameter, appendParameter, removeParameter, declareParameter(s), enforceValidatedParameters, clearParameters, setAttribute, appendAttribute, withUrlScheme and its siblings, and every inherited PSR-7 with*() method) returns a NEW WebRequest instance. Callers must capture and propagate the return value; a discarded return value is a no-op, not a bug in WebRequest.

The one exception is the deprecated setUrlScheme()/setUrlHost()/setUrlPort()/ setRequestUri()/setUrlPath()/setUrlQuery()/setProtocol() family, which changes this instance in place and returns void. Prefer the with*() counterparts; the setters exist for application code written against the pre-immutability API.

Composes a Nyholm\Psr7\ServerRequest to implement PSR-7 rather than extending it: Nyholm marks its request classes @final, and composition also means we are never at the mercy of a future Nyholm release changing its with*() methods away from clone-based immutability.

## Synopsis

`class WebRequest implements ServerRequestInterface, ContextComponentInterface, ResetInterface`

|  |  |
|---|---|
| Implements | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/), [`ContextComponentInterface`](/api/context-component-interface/), `ResetInterface` |
| Uses | [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/), [`Psr7RequestTrait`](/api/request/psr7-request-trait/), [`RequestInspectionTrait`](/api/request/request-inspection-trait/), [`UploadedFileAccessTrait`](/api/request/uploaded-file-access-trait/) |
| Source | `Request/WebRequest.php` |

## Constructor

### __construct()

`public function __construct(string $method = 'GET', string|UriInterface|null $uri = null, array<string, string|array<string>> $headers = [], string|resource|StreamInterface|null $body = null, string $version = '1.1', array<string, mixed> $serverParams = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |
| `$uri` | `string``|`[`UriInterface`](https://www.php-fig.org/psr/psr-7/)`|``null` |  |
| `$headers` | `array``<``string``, ``string``|``array``<``string``>``>` |  |
| `$body` | `string``|``resource``|`[`StreamInterface`](https://www.php-fig.org/psr/psr-7/)`|``null` |  |
| `$version` | `string` |  |
| `$serverParams` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`appendAttribute(string $name, mixed $value): static`](#appendattribute) | Append a value to a list-style attribute (legacy API used by views to add css/js). |
| [`appendListAttribute(string $name, mixed $value): static`](#appendlistattribute) | Backwards compat: alias for appendAttribute when code used singular. |
| [`appendParameter(string $name, mixed $value): static`](#appendparameter) | Legacy append API mirrors ParameterHolder::appendParameter semantics. |
| [`attachPsrRequest(ServerRequestInterface $request): void`](#attachpsrrequest) | Does nothing but raise an `E_USER_DEPRECATED` notice. |
| [`clearParameters(): static`](#clearparameters) | Returns a clone with every query, parsed-body and runtime parameter dropped. |
| [`declareParameter(string $name): static`](#declareparameter) | Declare a single parameter name at runtime. |
| [`declareParameters(array<string> $names): static`](#declareparameters) | Mark the given request parameter names as declared (whitelisted for strict-validation access). |
| [`enforceValidatedParameters(array<int, string> $keys): static`](#enforcevalidatedparameters) | Define the set of validated parameter names. |
| [`fromPsr(ServerRequestInterface $request): self`](#frompsr) | Build a WebRequest carrying the state of an arbitrary PSR-7 request. |
| [`getAll(?string $source): array<array-key, mixed>`](#getall) | Retrieves all fields of a stored data type (legacy RequestDataHolder compatibility). |
| [`getAttribute(mixed $name, mixed $default = null): mixed`](#getattribute) | Returns the named request attribute. |
| [`getAttributes(): array<string, mixed>`](#getattributes) | Retrieve attributes derived from the request. |
| [`getBody(): StreamInterface`](#getbody) | Returns the wrapped request's body stream. |
| [`getCookieParams(): array<string, mixed>`](#getcookieparams) | Retrieve cookies. |
| [`getFile(string $name, mixed $default = null): mixed`](#getfile) | Convenience alias for getUploadedFileArray — returns PSR-7 UploadedFileInterface array. |
| [`getHeader(mixed $name): array`](#getheader) | Returns every value of the named header, one entry per value. |
| [`getHeaderLine(mixed $name): string`](#getheaderline) | Returns the named header's values joined with commas. |
| [`getHeaders(): array<string, mixed>`](#getheaders) | Retrieves all message header values. |
| [`getMethod(): string`](#getmethod) | Returns the HTTP method of the wrapped request, in the case it was received in. |
| [`getParameter(string $name, mixed ...$args): mixed`](#getparameter) | Strict whitelist enforcement. |
| [`getParameters(?string $source = null): array<array-key, mixed>`](#getparameters) | Retrieve parameters. |
| [`getParsedBody(): array<string, mixed>|object|null`](#getparsedbody) | Retrieve any parameters provided in the request body. |
| [`getProtocol(): ?string`](#getprotocol) | Returns the protocol string of the request, e.g. |
| [`getProtocolVersion(): string`](#getprotocolversion) | Returns the HTTP protocol version of the wrapped PSR-7 request, e.g. |
| [`getQueryParams(): array<string, mixed>`](#getqueryparams) | Retrieve query string arguments. |
| [`getRequestTarget(): string`](#getrequesttarget) | Returns the request target as it appears on the request line. |
| [`getRequestUri(): string`](#getrequesturi) | Returns the path and query string as they appeared on the request line. |
| [`getRuntimeParameterKeys(): array<int, string>`](#getruntimeparameterkeys) |  |
| [`getServerParams(): array<string, mixed>`](#getserverparams) | Retrieve server parameters. |
| [`getUploadedFile(string $name): ?UploadedFileInterface`](#getuploadedfile) | Return the first uploaded file for a given field name or null if none exist. |
| [`getUploadedFileArray(string $name): array<UploadedFileInterface>`](#getuploadedfilearray) |  |
| [`getUploadedFiles(): array<string, UploadedFileInterface|array<int|string, mixed>>`](#getuploadedfiles) | Retrieve normalized file upload data. |
| [`getUri(): UriInterface`](#geturi) | Returns the wrapped request's URI. |
| [`getUrl(): string`](#geturl) | Retrieve the full request URL, including protocol, server name, port (if necessary), and request URI. |
| [`getUrlAuthority(bool $forcePort = false): string`](#geturlauthority) |  |
| [`getUrlHost(): string`](#geturlhost) | Returns the host the request was made against, without the port. |
| [`getUrlPath(): string`](#geturlpath) | Returns the path portion of the request URL, without the query string. |
| [`getUrlPort(): int`](#geturlport) | Returns the port the request was made against. |
| [`getUrlQuery(): string`](#geturlquery) | Returns the query string without its leading `?`, or an empty string when there is none. |
| [`getUrlScheme(): string`](#geturlscheme) | Returns the request's URL scheme, `http` or `https`. |
| [`getValidatedRuntimeParameterKeys(): array<int, string>`](#getvalidatedruntimeparameterkeys) | Runtime parameter keys that are also currently whitelisted -- i.e. |
| [`hasAttribute(string $name): bool`](#hasattribute) | Legacy API: check if attribute exists (non-null). |
| [`hasCookie(string $name): bool`](#hascookie) | Indicates whether or not a Cookie exists. |
| [`hasHeader(mixed $name): bool`](#hasheader) | Reports whether the wrapped request carries the named header, case-insensitively. |
| [`hasParameter(string $name): bool`](#hasparameter) | Reports whether a readable request parameter of that name exists. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Request (compat stub for factories.xml flow). |
| [`isCookieValueEmpty(string $name): bool`](#iscookievalueempty) | Checks if there is a value of a cookie is empty or not set. |
| [`isFileValueEmpty(string $field): bool`](#isfilevalueempty) | Checks if a file is empty, i.e. |
| [`isHeaderValueEmpty(string $name): bool`](#isheadervalueempty) | Checks if there is a value of a header is empty or not set. |
| [`isHttps(): bool`](#ishttps) | Reports whether the request was made over HTTPS, per its resolved URL scheme. |
| [`isParameterValueEmpty(string $field): bool`](#isparametervalueempty) | Checks if there is a value of a parameter is empty or not set. |
| [`isValueEmpty(string $source, string $field): bool`](#isvalueempty) | Checks if a field has no value (In web context this would only return true when the strings length is 0 or the field is not set. |
| [`pruneExtendedSources(array<string, bool> $headerKeep, array<string, bool> $headerFail, array<string, bool> $cookieKeep, array<string, bool> $cookieFail, array<string, bool> $fileKeep, array<string, bool> $fileFail): static`](#pruneextendedsources) | Extended pruning invoked by ValidationManager for non-parameter sources when available. |
| [`pruneParametersToValidated(array<int, string> $keep, array<int, string> $failed, bool $preserveModuleAction, ?string $moduleKey, ?string $actionKey): static`](#pruneparameterstovalidated) | Prune request parameters after validation in strict/conditional modes. |
| [`removeParameter(string $name, string $source = 'runtime'): static`](#removeparameter) | Remove a parameter from runtime store or intrinsic sources. |
| [`reset(): void`](#reset) | Reset web request state between requests in a persistent worker. |
| [`revokeParameter(string $name): static`](#revokeparameter) | Remove a runtime parameter and revoke its strict-validation whitelist entry. |
| [`setAttribute(string $name, mixed $value): static`](#setattribute) | Legacy mutator: set attribute (overwrites any existing value). |
| [`setParameter(string $name, mixed $value): static`](#setparameter) | Legacy write API: set a runtime parameter (not an attribute, not HTTP input). |
| [`setProtocol(?string $protocol): void`](#setprotocol) |  |
| [`setRequestUri(string $uri): void`](#setrequesturi) |  |
| [`setUnvalidatedParameter(string $name, mixed $value): static`](#setunvalidatedparameter) | Sets a runtime parameter's value WITHOUT whitelisting it for strict-mode access, unlike setParameter(). |
| [`setUrlHost(string $host): void`](#seturlhost) |  |
| [`setUrlPath(string $urlPath): void`](#seturlpath) |  |
| [`setUrlPort(int $port): void`](#seturlport) |  |
| [`setUrlQuery(string $urlQuery): void`](#seturlquery) |  |
| [`setUrlScheme(string $scheme): void`](#seturlscheme) |  |
| [`startup(): void`](#startup) | Do any necessary startup work after initialization. |
| [`withAddedHeader(mixed $name, mixed $value): static`](#withaddedheader) | Returns a clone with the given value appended to the named header. |
| [`withAttribute(mixed $name, mixed $value): static`](#withattribute) | Returns a clone carrying the named request attribute. |
| [`withBody(StreamInterface $body): static`](#withbody) | Returns a clone whose body is the given stream. |
| [`withCookieParams(array<string, mixed> $cookies): static`](#withcookieparams) | Return an instance with the specified cookies. |
| [`withHeader(mixed $name, mixed $value): static`](#withheader) | Returns a clone with the named header replaced by the given value. |
| [`withMethod(mixed $method): static`](#withmethod) | Returns a clone using the given HTTP method. |
| [`withParameters(array<array-key, mixed> $params): static`](#withparameters) | Bulk counterpart to setParameter(): set many runtime parameters at once. |
| [`withParsedBody(array<string, mixed>|object|null $data): static`](#withparsedbody) | Return an instance with the specified body parameters. |
| [`withProtocol(?string $protocol): static`](#withprotocol) |  |
| [`withProtocolVersion(mixed $version): static`](#withprotocolversion) | Returns a clone carrying the given HTTP protocol version. |
| [`withQueryParams(array<string, mixed> $query): static`](#withqueryparams) | Return an instance with the specified query string arguments. |
| [`withRequestTarget(mixed $requestTarget): static`](#withrequesttarget) | Returns a clone whose request line carries the given target verbatim. |
| [`withRequestUri(string $uri): static`](#withrequesturi) | Set path and query together from a combined request URI ("/path?a=b"), keeping the separately addressable path and query components consistent with it. |
| [`withUnvalidatedParameters(array<array-key, mixed> $params): static`](#withunvalidatedparameters) | Bulk counterpart to setUnvalidatedParameter(): promote many values at once (e.g. |
| [`withUploadedFiles(array<string, UploadedFileInterface|array<int|string, mixed>> $uploadedFiles): static`](#withuploadedfiles) | Create a new instance with the specified uploaded files. |
| [`withUri(UriInterface $uri, mixed $preserveHost = false): static`](#withuri) | Returns a clone using the given URI. |
| [`withUrlHost(string $host): static`](#withurlhost) |  |
| [`withUrlPath(string $urlPath): static`](#withurlpath) |  |
| [`withUrlPort(int $port): static`](#withurlport) |  |
| [`withUrlQuery(string $urlQuery): static`](#withurlquery) |  |
| [`withUrlScheme(string $scheme): static`](#withurlscheme) |  |
| [`withoutAttribute(mixed $name): static`](#withoutattribute) | Returns a clone with the named request attribute removed. |
| [`withoutHeader(mixed $name): static`](#withoutheader) | Returns a clone with the named header removed. |

### appendAttribute()

`public function appendAttribute(string $name, mixed $value): static`

Append a value to a list-style attribute (legacy API used by views to add css/js).

Values are stored as array under attribute name.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### appendListAttribute()

`public function appendListAttribute(string $name, mixed $value): static`

Backwards compat: alias for appendAttribute when code used singular.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### appendParameter()

`public function appendParameter(string $name, mixed $value): static`

Legacy append API mirrors ParameterHolder::appendParameter semantics.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### attachPsrRequest()

`public function attachPsrRequest(ServerRequestInterface $request): void`

Does nothing but raise an `E_USER_DEPRECATED` notice.

A WebRequest is itself the PSR-7 server request, so there is nothing to attach; the argument is ignored.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

### clearParameters()

`public function clearParameters(): static`

Returns a clone with every query, parsed-body and runtime parameter dropped.

The strict-validation whitelist survives, so names already declared stay readable once values are set again. This request is left untouched.

Returns `static`

### declareParameter()

`public function declareParameter(string $name): static`

Declare a single parameter name at runtime.

Intended for code that adds validators dynamically via ValidationManager::addChild() outside the compiled validators.xml path.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `static`

### declareParameters()

`public function declareParameters(array<string> $names): static`

Mark the given request parameter names as declared (whitelisted for strict-validation access).

Flat list of parameter names (bracket paths
                      allowed, e.g. 'data[0][Title]').

| Parameter | Type | Description |
|---|---|---|
| `$names` | `array``<``string``>` | Flat list of parameter names (bracket paths allowed, e.g. 'data[0][Title]'). |

Returns `static`

### enforceValidatedParameters()

`public function enforceValidatedParameters(array<int, string> $keys): static`

Define the set of validated parameter names.

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `array``<``int``, ``string``>` |  |

Returns `static`

### fromPsr()

`public static function fromPsr(ServerRequestInterface $request): self`

Build a WebRequest carrying the state of an arbitrary PSR-7 request.

WebRequest wraps a Nyholm\Psr7\ServerRequest internally, but a plain Nyholm\Psr7\ServerRequest can still flow through the pipeline (it lacks the Quiote helpers such as isHttps()/getParameter()). This adapter produces a WebRequest with the same method, URI, headers, body, protocol, server params, cookies, query params, uploaded files, parsed body and attributes, so the framework can always rely on getRequest() returning a WebRequest.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `self` — The same instance if it is already a WebRequest, else a copy.

### getAll()

`public function getAll(?string $source): array<array-key, mixed>`

Retrieves all fields of a stored data type (legacy RequestDataHolder compatibility).

| Parameter | Type | Description |
|---|---|---|
| `$source` | `?``string` |  |

Returns `array``<``array-key``, ``mixed``>` — The values.

### getAttribute()

`public function getAttribute(mixed $name, mixed $default = null): mixed`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the named request attribute.

`$default` is returned when no attribute of that name has been set, which is how attributes put on the request by middleware are read without knowing whether that middleware ran.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getAttributes()

`public function getAttributes(): array<string, mixed>`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieve attributes derived from the request.

The request "attributes" may be used to allow injection of any parameters derived from the request: e.g., the results of path match operations; the results of decrypting cookies; the results of deserializing non-form-encoded message bodies; etc. Attributes will be application and request specific, and CAN be mutable.

Returns `array``<``string``, ``mixed``>` — Attributes derived from the request.

### getBody()

`public function getBody(): StreamInterface`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the wrapped request's body stream.

The live stream, not a copy: reading from it advances the position seen by every other holder of this request.

Returns [`StreamInterface`](https://www.php-fig.org/psr/psr-7/)

### getCookieParams()

`public function getCookieParams(): array<string, mixed>`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieve cookies.

Retrieves cookies sent by the client to the server.

The data MUST be compatible with the structure of the $_COOKIE superglobal.

Returns `array``<``string``, ``mixed``>`

### getFile()

`public function getFile(string $name, mixed $default = null): mixed`

Composed in from [`UploadedFileAccessTrait`](/api/request/uploaded-file-access-trait/).

Convenience alias for getUploadedFileArray — returns PSR-7 UploadedFileInterface array.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getHeader()

`public function getHeader(mixed $name): array`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns every value of the named header, one entry per value.

An empty array when the header is not present, per PSR-7.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `array`

### getHeaderLine()

`public function getHeaderLine(mixed $name): string`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the named header's values joined with commas.

An empty string when the header is not present, per PSR-7.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `string`

### getHeaders()

`public function getHeaders(): array<string, mixed>`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieves all message header values.

The keys represent the header name as it will be sent over the wire, and each value is an array of strings associated with the header.

// Represent the headers as a string foreach ($message->getHeaders() as $name => $values) { echo $name . ": " . implode(", ", $values); }

// Emit headers iteratively: foreach ($message->getHeaders() as $name => $values) { foreach ($values as $value) { header(sprintf('%s: %s', $name, $value), false); } }

While header names are not case-sensitive, getHeaders() will preserve the exact case in which headers were originally specified.

Returns `array``<``string``, ``mixed``>` — Returns an associative array of the message's headers. Each key MUST be a header name, and each value MUST be an array of strings for that header.

### getMethod()

`public function getMethod(): string`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the HTTP method of the wrapped request, in the case it was received in.

Returns `string`

### getParameter()

`public function getParameter(string $name, mixed ...$args): mixed`

Strict whitelist enforcement.

A parameter is whitelisted iff it was declared by a validator in validators.xml (seeded via declareParameters() at config parse time) or explicitly set via setParameter() from application code.

When called WITHOUT a default (getParameter('foo')): accessing an unvalidated parameter throws, which catches developer errors early. When called WITH a default (getParameter('foo', null)): the default is returned silently. The caller has signalled they expect the parameter may be absent; raw unvalidated HTTP input is never leaked.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$args` | `mixed` |  |

Returns `mixed`

### getParameters()

`public function getParameters(?string $source = null): array<array-key, mixed>`

Retrieve parameters.

When $source is null we merge runtime parameters over intrinsic HTTP parameters. Specific sources bypass runtime store. Allowed $source values mirror legacy API: parameters|cookies|files|headers|attributes|runtime

Filtered to the same strict-validation whitelist getParameter() enforces (for the 'parameters'/null/'runtime' sources): this is the plural counterpart of getParameter() and must not be a way to route around its single-key guard. Framework-internal code that genuinely needs raw, unvalidated values for a specific purpose (e.g. echoing the submitted value back into an HTML form after a validation failure) must not use this method -- see ValidationManager::getRawParameterSnapshot().

| Parameter | Type | Description |
|---|---|---|
| `$source` | `?``string` |  |

Returns `array``<``array-key``, ``mixed``>`

### getParsedBody()

`public function getParsedBody(): array<string, mixed>|object|null`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieve any parameters provided in the request body.

If the request Content-Type is either application/x-www-form-urlencoded or multipart/form-data, and the request method is POST, this method MUST return the contents of $_POST.

Otherwise, this method may return any results of deserializing the request body content; as parsing returns structured content, the potential types MUST be arrays or objects only. A null value indicates the absence of body content.

Returns `array``<``string``, ``mixed``>``|``object``|``null` — The deserialized body parameters, if any. These will typically be an array or object.

### getProtocol()

`public function getProtocol(): ?string`

Returns the protocol string of the request, e.g.

`HTTP/1.1`.

Null when the URL metadata carries no protocol, which happens for a request built outside a SAPI.

Returns `?``string`

### getProtocolVersion()

`public function getProtocolVersion(): string`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the HTTP protocol version of the wrapped PSR-7 request, e.g.

`1.1`.

Returns `string`

### getQueryParams()

`public function getQueryParams(): array<string, mixed>`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieve query string arguments.

Retrieves the deserialized query string arguments, if any.

Note: the query params might not be in sync with the URI or server params. If you need to ensure you are only getting the original values, you may need to parse the query string from `getUri()->getQuery()` or from the `QUERY_STRING` server param.

Returns `array``<``string``, ``mixed``>`

### getRequestTarget()

`public function getRequestTarget(): string`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the request target as it appears on the request line.

The explicitly set target when there is one, otherwise the origin-form target derived from the URI, per PSR-7.

Returns `string`

### getRequestUri()

`public function getRequestUri(): string`

Returns the path and query string as they appeared on the request line.

Returns `string`

### getRuntimeParameterKeys()

`public function getRuntimeParameterKeys(): array<int, string>`

Returns `array``<``int``, ``string``>`

### getServerParams()

`public function getServerParams(): array<string, mixed>`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieve server parameters.

Retrieves data related to the incoming request environment, typically derived from PHP's $_SERVER superglobal. The data IS NOT REQUIRED to originate from $_SERVER.

Returns `array``<``string``, ``mixed``>`

### getUploadedFile()

`public function getUploadedFile(string $name): ?UploadedFileInterface`

Composed in from [`UploadedFileAccessTrait`](/api/request/uploaded-file-access-trait/).

Return the first uploaded file for a given field name or null if none exist.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `?`[`UploadedFileInterface`](https://www.php-fig.org/psr/psr-7/)

### getUploadedFileArray()

`public function getUploadedFileArray(string $name): array<UploadedFileInterface>`

Composed in from [`UploadedFileAccessTrait`](/api/request/uploaded-file-access-trait/).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `array``<``UploadedFileInterface``>`

### getUploadedFiles()

`public function getUploadedFiles(): array<string, UploadedFileInterface|array<int|string, mixed>>`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Retrieve normalized file upload data.

This method returns upload metadata in a normalized tree, with each leaf an instance of Psr\Http\Message\UploadedFileInterface.

These values MAY be prepared from $_FILES or the message body during instantiation, or MAY be injected via withUploadedFiles().

Returns `array``<``string``, ``UploadedFileInterface``|``array``<``int``|``string``, ``mixed``>``>` — An array tree of UploadedFileInterface instances; an empty array MUST be returned if no data is present.

### getUri()

`public function getUri(): UriInterface`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns the wrapped request's URI.

Returns [`UriInterface`](https://www.php-fig.org/psr/psr-7/)

### getUrl()

`public function getUrl(): string`

Retrieve the full request URL, including protocol, server name, port (if necessary), and request URI.

Recomputed dynamically rather than cached, so it always reflects any setUrlScheme()/setUrlHost()/etc. call made after construction.

Returns `string`

### getUrlAuthority()

`public function getUrlAuthority(bool $forcePort = false): string`

Whether or not ports 80 (for HTTP) and 443 (for HTTPS)
                 should be included in the return string.

| Parameter | Type | Description |
|---|---|---|
| `$forcePort` | `bool` | Whether or not ports 80 (for HTTP) and 443 (for HTTPS) should be included in the return string. |

Returns `string`

### getUrlHost()

`public function getUrlHost(): string`

Returns the host the request was made against, without the port.

Already passed through the `core.trusted_hosts` allow-list where the metadata was derived from client-controlled headers.

Returns `string`

### getUrlPath()

`public function getUrlPath(): string`

Returns the path portion of the request URL, without the query string.

Returns `string`

### getUrlPort()

`public function getUrlPort(): int`

Returns the port the request was made against.

Falls back to the scheme's default (443 for HTTPS, 80 for HTTP) when no explicit port is known.

Returns `int`

### getUrlQuery()

`public function getUrlQuery(): string`

Returns the query string without its leading `?`, or an empty string when there is none.

Returns `string`

### getUrlScheme()

`public function getUrlScheme(): string`

Returns the request's URL scheme, `http` or `https`.

Returns `string`

### getValidatedRuntimeParameterKeys()

`public function getValidatedRuntimeParameterKeys(): array<int, string>`

Runtime parameter keys that are also currently whitelisted -- i.e.

real trusted exports (setParameter()), not values merely staged for validators to see (setUnvalidatedParameter()). Used by ValidationManager to decide which runtime keys must survive pruning without re-whitelisting a value nobody actually validated.

Returns `array``<``int``, ``string``>`

### hasAttribute()

`public function hasAttribute(string $name): bool`

Legacy API: check if attribute exists (non-null).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### hasCookie()

`public function hasCookie(string $name): bool`

Composed in from [`RequestInspectionTrait`](/api/request/request-inspection-trait/).

Indicates whether or not a Cookie exists.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### hasHeader()

`public function hasHeader(mixed $name): bool`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Reports whether the wrapped request carries the named header, case-insensitively.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `bool`

### hasParameter()

`public function hasParameter(string $name): bool`

Reports whether a readable request parameter of that name exists.

Returns false outright for a name that is not on the strict-validation whitelist, whether or not a value was submitted -- this is the plural-safe counterpart of the guard [`WebRequest::getParameter()`](/api/request/web-request/#getparameter) applies, and must not become a way to probe unvalidated input. For a whitelisted name it looks through the runtime store, the intrinsic HTTP parameters, the `name[]` array form and, finally, nested bracket paths within the merged parameters.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this Request (compat stub for factories.xml flow).

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

### isCookieValueEmpty()

`public function isCookieValueEmpty(string $name): bool`

Composed in from [`RequestInspectionTrait`](/api/request/request-inspection-trait/).

Checks if there is a value of a cookie is empty or not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### isFileValueEmpty()

`public function isFileValueEmpty(string $field): bool`

Composed in from [`RequestInspectionTrait`](/api/request/request-inspection-trait/).

Checks if a file is empty, i.e.

not set or set, but not actually uploaded.

| Parameter | Type | Description |
|---|---|---|
| `$field` | `string` |  |

Returns `bool`

### isHeaderValueEmpty()

`public function isHeaderValueEmpty(string $name): bool`

Composed in from [`RequestInspectionTrait`](/api/request/request-inspection-trait/).

Checks if there is a value of a header is empty or not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### isHttps()

`public function isHttps(): bool`

Reports whether the request was made over HTTPS, per its resolved URL scheme.

Returns `bool`

### isParameterValueEmpty()

`public function isParameterValueEmpty(string $field): bool`

Composed in from [`RequestInspectionTrait`](/api/request/request-inspection-trait/).

Checks if there is a value of a parameter is empty or not set.

| Parameter | Type | Description |
|---|---|---|
| `$field` | `string` |  |

Returns `bool`

### isValueEmpty()

`public function isValueEmpty(string $source, string $field): bool`

Composed in from [`RequestInspectionTrait`](/api/request/request-inspection-trait/).

Checks if a field has no value (In web context this would only return true when the strings length is 0 or the field is not set.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` |  |
| `$field` | `string` |  |

Returns `bool`

### pruneExtendedSources()

`public function pruneExtendedSources(array<string, bool> $headerKeep, array<string, bool> $headerFail, array<string, bool> $cookieKeep, array<string, bool> $cookieFail, array<string, bool> $fileKeep, array<string, bool> $fileFail): static`

Extended pruning invoked by ValidationManager for non-parameter sources when available.

| Parameter | Type | Description |
|---|---|---|
| `$headerKeep` | `array``<``string``, ``bool``>` |  |
| `$headerFail` | `array``<``string``, ``bool``>` |  |
| `$cookieKeep` | `array``<``string``, ``bool``>` |  |
| `$cookieFail` | `array``<``string``, ``bool``>` |  |
| `$fileKeep` | `array``<``string``, ``bool``>` |  |
| `$fileFail` | `array``<``string``, ``bool``>` |  |

Returns `static`

### pruneParametersToValidated()

`public function pruneParametersToValidated(array<int, string> $keep, array<int, string> $failed, bool $preserveModuleAction, ?string $moduleKey, ?string $actionKey): static`

Prune request parameters after validation in strict/conditional modes.

| Parameter | Type | Description |
|---|---|---|
| `$keep` | `array``<``int``, ``string``>` |  |
| `$failed` | `array``<``int``, ``string``>` |  |
| `$preserveModuleAction` | `bool` |  |
| `$moduleKey` | `?``string` |  |
| `$actionKey` | `?``string` |  |

Returns `static` — New immutable instance with pruned parameters

### removeParameter()

`public function removeParameter(string $name, string $source = 'runtime'): static`

Remove a parameter from runtime store or intrinsic sources.

If $source is null or 'runtime' we only affect runtime store.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$source` | `string` |  |

Returns `static`

### reset()

`public function reset(): void`

Reset web request state between requests in a persistent worker.

Clears web-specific request properties that could leak between requests.

### revokeParameter()

`public function revokeParameter(string $name): static`

Remove a runtime parameter and revoke its strict-validation whitelist entry.

[`WebRequest::removeParameter()`](/api/request/web-request/#removeparameter) drops the value alone, so a name whitelisted by an earlier setParameter() stays declared and getParameter() answers null rather than refusing. This undoes both halves, which is what a caller needs when it is putting the request back exactly as it found it -- notably the slot parameter overlay, which must not leave a name readable that the parent request never exposed.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `static`

### setAttribute()

`public function setAttribute(string $name, mixed $value): static`

Legacy mutator: set attribute (overwrites any existing value).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### setParameter()

`public function setParameter(string $name, mixed $value): static`

Legacy write API: set a runtime parameter (not an attribute, not HTTP input).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### setProtocol()

`public function setProtocol(?string $protocol): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withProtocol(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$protocol` | `?``string` |  |

### setRequestUri()

`public function setRequestUri(string $uri): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withRequestUri(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |

### setUnvalidatedParameter()

`public function setUnvalidatedParameter(string $name, mixed $value): static`

Sets a runtime parameter's value WITHOUT whitelisting it for strict-mode access, unlike setParameter().

Used to promote a value (e.g. a route param) into the pipeline so validators can see and validate it, without granting getParameter() access to a name nobody actually registered a validator for. See RequestParameterStore::withUnvalidatedParameter().

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

Returns `static`

### setUrlHost()

`public function setUrlHost(string $host): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withUrlHost(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |

### setUrlPath()

`public function setUrlPath(string $urlPath): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withUrlPath(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$urlPath` | `string` |  |

### setUrlPort()

`public function setUrlPort(int $port): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withUrlPort(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$port` | `int` |  |

### setUrlQuery()

`public function setUrlQuery(string $urlQuery): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withUrlQuery(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$urlQuery` | `string` |  |

### setUrlScheme()

`public function setUrlScheme(string $scheme): void`

:::caution[Deprecated]
This method is deprecated. 3.2.0 Use withUrlScheme(), which returns a new request.
:::

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `string` |  |

### startup()

`public function startup(): void`

Do any necessary startup work after initialization.

This method is not called directly after initialize().

### withAddedHeader()

`public function withAddedHeader(mixed $name, mixed $value): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone with the given value appended to the named header.

Existing values of that header are kept. This request is left untouched and the clone starts with an empty parameter cache.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withAttribute()

`public function withAttribute(mixed $name, mixed $value): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone carrying the named request attribute.

This request is left untouched, so middleware wanting the attribute to be visible downstream has to pass the returned instance on.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withBody()

`public function withBody(StreamInterface $body): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone whose body is the given stream.

This request is left untouched; the clone starts with an empty parameter cache, so parameters are re-derived from the new body.

| Parameter | Type | Description |
|---|---|---|
| `$body` | [`StreamInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `static`

### withCookieParams()

`public function withCookieParams(array<string, mixed> $cookies): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Return an instance with the specified cookies.

Array of key/value pairs representing cookies.

| Parameter | Type | Description |
|---|---|---|
| `$cookies` | `array``<``string``, ``mixed``>` | Array of key/value pairs representing cookies. |

Returns `static`

### withHeader()

`public function withHeader(mixed $name, mixed $value): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone with the named header replaced by the given value.

Any existing values of that header are discarded. This request is left untouched and the clone starts with an empty parameter cache.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |
| `$value` | `mixed` |  |

Returns `static`

### withMethod()

`public function withMethod(mixed $method): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone using the given HTTP method.

The method is passed through as given; the wrapped PSR-7 request rejects a syntactically invalid one.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `mixed` |  |

Returns `static`

### withParameters()

`public function withParameters(array<array-key, mixed> $params): static`

Bulk counterpart to setParameter(): set many runtime parameters at once.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``array-key``, ``mixed``>` |  |

Returns `static`

### withParsedBody()

`public function withParsedBody(array<string, mixed>|object|null $data): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Return an instance with the specified body parameters.

The deserialized body data. This will
    typically be in an array or object.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>``|``object``|``null` | The deserialized body data. This will typically be in an array or object. |

Returns `static`

| Throws | When |
|---|---|
| `InvalidArgumentException` | if an unsupported argument type is provided. |

### withProtocol()

`public function withProtocol(?string $protocol): static`

| Parameter | Type | Description |
|---|---|---|
| `$protocol` | `?``string` |  |

Returns `static`

### withProtocolVersion()

`public function withProtocolVersion(mixed $version): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone carrying the given HTTP protocol version.

This request is left untouched; the clone wraps a new PSR-7 request and starts with an empty parameter cache.

| Parameter | Type | Description |
|---|---|---|
| `$version` | `mixed` |  |

Returns `static`

### withQueryParams()

`public function withQueryParams(array<string, mixed> $query): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Return an instance with the specified query string arguments.

Array of query string arguments, typically from
    $_GET.

| Parameter | Type | Description |
|---|---|---|
| `$query` | `array``<``string``, ``mixed``>` | Array of query string arguments, typically from $_GET. |

Returns `static`

### withRequestTarget()

`public function withRequestTarget(mixed $requestTarget): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone whose request line carries the given target verbatim.

The URI is not touched, so the target may diverge from it.

| Parameter | Type | Description |
|---|---|---|
| `$requestTarget` | `mixed` |  |

Returns `static`

### withRequestUri()

`public function withRequestUri(string $uri): static`

Set path and query together from a combined request URI ("/path?a=b"), keeping the separately addressable path and query components consistent with it.

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |

Returns `static`

### withUnvalidatedParameters()

`public function withUnvalidatedParameters(array<array-key, mixed> $params): static`

Bulk counterpart to setUnvalidatedParameter(): promote many values at once (e.g.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``array-key``, ``mixed``>` |  |

Returns `static`

### withUploadedFiles()

`public function withUploadedFiles(array<string, UploadedFileInterface|array<int|string, mixed>> $uploadedFiles): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Create a new instance with the specified uploaded files.

An array tree of UploadedFileInterface instances.

| Parameter | Type | Description |
|---|---|---|
| `$uploadedFiles` | `array``<``string``, ``UploadedFileInterface``|``array``<``int``|``string``, ``mixed``>``>` | An array tree of UploadedFileInterface instances. |

Returns `static`

| Throws | When |
|---|---|
| `InvalidArgumentException` | if an invalid structure is provided. |

### withUri()

`public function withUri(UriInterface $uri, mixed $preserveHost = false): static`

Returns a clone using the given URI.

Beyond the PSR-7 contract, the clone's URL metadata is rederived from the new URI, so [`WebRequest::getUrlHost()`](/api/request/web-request/#geturlhost), [`WebRequest::getUrlPath()`](/api/request/web-request/#geturlpath) and the rest stay in step with [`WebRequest::getUri()`](/api/request/web-request/#geturi). With `$preserveHost` set, the existing Host header wins over the URI's host, as PSR-7 requires.

| Parameter | Type | Description |
|---|---|---|
| `$uri` | [`UriInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$preserveHost` | `mixed` |  |

Returns `static`

### withUrlHost()

`public function withUrlHost(string $host): static`

| Parameter | Type | Description |
|---|---|---|
| `$host` | `string` |  |

Returns `static`

### withUrlPath()

`public function withUrlPath(string $urlPath): static`

| Parameter | Type | Description |
|---|---|---|
| `$urlPath` | `string` |  |

Returns `static`

### withUrlPort()

`public function withUrlPort(int $port): static`

| Parameter | Type | Description |
|---|---|---|
| `$port` | `int` |  |

Returns `static`

### withUrlQuery()

`public function withUrlQuery(string $urlQuery): static`

| Parameter | Type | Description |
|---|---|---|
| `$urlQuery` | `string` |  |

Returns `static`

### withUrlScheme()

`public function withUrlScheme(string $scheme): static`

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `string` |  |

Returns `static`

### withoutAttribute()

`public function withoutAttribute(mixed $name): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone with the named request attribute removed.

A no-op clone when no attribute of that name is set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `static`

### withoutHeader()

`public function withoutHeader(mixed $name): static`

Composed in from [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/).

Returns a clone with the named header removed.

Each call clones the whole wrapped request; use the private bulk counterpart when removing several headers at once.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `mixed` |  |

Returns `static`
