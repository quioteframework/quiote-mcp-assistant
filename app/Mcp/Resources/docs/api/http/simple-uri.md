# SimpleUri

> A minimal PSR-7 `UriInterface` built by handing a URI string to `parse_url()`, so the framework can supply a URI without depending on a third-party PSR-7 implementation.

A minimal PSR-7 `UriInterface` built by handing a URI string to `parse_url()`, so the framework can supply a URI without depending on a third-party PSR-7 implementation.

[`WebRequest`](/api/request/web-request/) falls back to one of these (`http://localhost/`) when it is constructed without a URI, which is the usual case in tests and in dispatches assembled by hand rather than from an incoming HTTP request.

Deliberately thin: components are stored exactly as parsed or as supplied to the `with*()` methods. There is no percent-encoding, no case normalisation of scheme or host, no validation of the values passed in, and no default-port handling — a port equal to the scheme's default is still reported by [`SimpleUri::getPort()`](/api/http/simple-uri/#getport) and still appears in [`SimpleUri::getAuthority()`](/api/http/simple-uri/#getauthority). Every `with*()` method returns a clone.

## Synopsis

`class SimpleUri implements UriInterface`

|  |  |
|---|---|
| Implements | [`UriInterface`](https://www.php-fig.org/psr/psr-7/) |
| Source | `Http/SimpleUri.php` |

## Constructor

### __construct()

`public function __construct(string $uri): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) | Return the string representation as a URI reference. |
| [`getAuthority(): string`](#getauthority) | Returns `[user-info@]host[:port]`, omitting each part that is empty or unset. |
| [`getFragment(): string`](#getfragment) | Returns the fragment without its leading `#`, or an empty string when there is none. |
| [`getHost(): string`](#gethost) | Returns the host component, or an empty string when the parsed URI had none. |
| [`getPath(): string`](#getpath) | Returns the path component, or an empty string when the parsed URI had none. |
| [`getPort(): ?int`](#getport) | Returns the port, or null when the URI did not state one; no default-port normalisation is applied. |
| [`getQuery(): string`](#getquery) | Returns the query string without its leading `?`, or an empty string when there is none. |
| [`getScheme(): string`](#getscheme) | Returns the scheme component, or an empty string when the parsed URI had none. |
| [`getUserInfo(): string`](#getuserinfo) | Returns `user[:password]`, or an empty string when no user was present in the URI. |
| [`withFragment(mixed $fragment): static`](#withfragment) | Returns a clone carrying the given fragment, with any leading `#` stripped. |
| [`withHost(mixed $host): static`](#withhost) | Returns a clone carrying the given host, stored verbatim. |
| [`withPath(mixed $path): static`](#withpath) | Returns a clone carrying the given path, stored verbatim without encoding. |
| [`withPort(mixed $port): static`](#withport) | Returns a clone carrying the given port; null removes the port from the authority. |
| [`withQuery(mixed $query): static`](#withquery) | Returns a clone carrying the given query, with any leading `?` stripped. |
| [`withScheme(mixed $scheme): static`](#withscheme) | Returns a clone carrying the given scheme; the value is stored as supplied, without case or syntax normalisation. |
| [`withUserInfo(mixed $user, mixed $password = null): static`](#withuserinfo) | Returns a clone carrying the given user and password; a null password clears the stored password. |

### __toString()

`public function __toString(): string`

Return the string representation as a URI reference.

Depending on which components of the URI are present, the resulting string is either a full URI or relative reference according to RFC 3986, Section 4.1. The method concatenates the various components of the URI, using the appropriate delimiters:

- If a scheme is present, it MUST be suffixed by ":". - If an authority is present, it MUST be prefixed by "//". - The path can be concatenated without delimiters. But there are two cases where the path has to be adjusted to make the URI reference valid as PHP does not allow to throw an exception in __toString(): - If the path is rootless and an authority is present, the path MUST be prefixed by "/". - If the path is starting with more than one "/" and no authority is present, the starting slashes MUST be reduced to one. - If a query is present, it MUST be prefixed by "?". - If a fragment is present, it MUST be prefixed by "#".

Returns `string`

### getAuthority()

`public function getAuthority(): string`

Returns `[user-info@]host[:port]`, omitting each part that is empty or unset.

Returns `string`

### getFragment()

`public function getFragment(): string`

Returns the fragment without its leading `#`, or an empty string when there is none.

Returns `string`

### getHost()

`public function getHost(): string`

Returns the host component, or an empty string when the parsed URI had none.

Returns `string`

### getPath()

`public function getPath(): string`

Returns the path component, or an empty string when the parsed URI had none.

Returns `string`

### getPort()

`public function getPort(): ?int`

Returns the port, or null when the URI did not state one; no default-port normalisation is applied.

Returns `?``int`

### getQuery()

`public function getQuery(): string`

Returns the query string without its leading `?`, or an empty string when there is none.

Returns `string`

### getScheme()

`public function getScheme(): string`

Returns the scheme component, or an empty string when the parsed URI had none.

Returns `string`

### getUserInfo()

`public function getUserInfo(): string`

Returns `user[:password]`, or an empty string when no user was present in the URI.

Returns `string`

### withFragment()

`public function withFragment(mixed $fragment): static`

Returns a clone carrying the given fragment, with any leading `#` stripped.

| Parameter | Type | Description |
|---|---|---|
| `$fragment` | `mixed` |  |

Returns `static`

### withHost()

`public function withHost(mixed $host): static`

Returns a clone carrying the given host, stored verbatim.

| Parameter | Type | Description |
|---|---|---|
| `$host` | `mixed` |  |

Returns `static`

### withPath()

`public function withPath(mixed $path): static`

Returns a clone carrying the given path, stored verbatim without encoding.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `mixed` |  |

Returns `static`

### withPort()

`public function withPort(mixed $port): static`

Returns a clone carrying the given port; null removes the port from the authority.

| Parameter | Type | Description |
|---|---|---|
| `$port` | `mixed` |  |

Returns `static`

### withQuery()

`public function withQuery(mixed $query): static`

Returns a clone carrying the given query, with any leading `?` stripped.

| Parameter | Type | Description |
|---|---|---|
| `$query` | `mixed` |  |

Returns `static`

### withScheme()

`public function withScheme(mixed $scheme): static`

Returns a clone carrying the given scheme; the value is stored as supplied, without case or syntax normalisation.

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `mixed` |  |

Returns `static`

### withUserInfo()

`public function withUserInfo(mixed $user, mixed $password = null): static`

Returns a clone carrying the given user and password; a null password clears the stored password.

| Parameter | Type | Description |
|---|---|---|
| `$user` | `mixed` |  |
| `$password` | `mixed` |  |

Returns `static`
