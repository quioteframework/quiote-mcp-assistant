# CookieSerializer

> Turns the cookie definitions queued on a response into `Set-Cookie` header lines.

Turns the cookie definitions queued on a response into `Set-Cookie` header lines.

Pure translation: given a cookie's declared attributes it produces the normalized form and the header string, and nothing else. It reaches for no context, no routing and no response state -- the default path a cookie inherits when it declares none is passed in, so the same definition always serializes the same way and can be asserted on directly.

## Synopsis

`final class CookieSerializer`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Response/CookieSerializer.php` |

## Constructor

### __construct()

`public function __construct(string $defaultPath = '/', ClockInterface $clock = new SystemClock(…)): mixed`

Path for a cookie that declares none. An empty string
            is treated as "/", so a cookie is never scoped to the empty path.

| Parameter | Type | Description |
|---|---|---|
| `$defaultPath` | `string` | Path for a cookie that declares none. An empty string is treated as "/", so a cookie is never scoped to the empty path. |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`header(string $name, array{value: string, expires: ?int, max_age: ?int, path: string, domain: ?string, secure: bool, httponly: bool, samesite: ?string} $normalized): string`](#header) | The `Set-Cookie` value for an already-normalized cookie. |
| [`headers(array<string, array<array-key, mixed>> $cookies): list<string>`](#headers) | Header lines for every queued cookie, in queue order. |
| [`normalize(string $name, array<array-key, mixed> $cookie): array{value: string, expires: ?int, max_age: ?int, path: string, domain: ?string, secure: bool, httponly: bool, samesite: ?string}`](#normalize) | Resolve a cookie definition into the concrete attribute set to be sent. |

### header()

`public function header(string $name, array{value: string, expires: ?int, max_age: ?int, path: string, domain: ?string, secure: bool, httponly: bool, samesite: ?string} $normalized): string`

The `Set-Cookie` value for an already-normalized cookie.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$normalized` | `array{value: string, expires: ?int, max_age: ?int, path: string, domain: ?string, secure: bool, httponly: bool, samesite: ?string}` |  |

Returns `string`

### headers()

`public function headers(array<string, array<array-key, mixed>> $cookies): list<string>`

Header lines for every queued cookie, in queue order.

Name => definition.

| Parameter | Type | Description |
|---|---|---|
| `$cookies` | `array``<``string``, ``array``<``array-key``, ``mixed``>``>` | Name => definition. |

Returns `list``<``string``>`

### normalize()

`public function normalize(string $name, array<array-key, mixed> $cookie): array{value: string, expires: ?int, max_age: ?int, path: string, domain: ?string, secure: bool, httponly: bool, samesite: ?string}`

Resolve a cookie definition into the concrete attribute set to be sent.

Keys: value, lifetime, path, domain,
            secure, httponly, encode_callback, samesite -- all optional.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$cookie` | `array``<``array-key``, ``mixed``>` | Keys: value, lifetime, path, domain, secure, httponly, encode_callback, samesite -- all optional. |

Returns `array{value: string, expires: ?int, max_age: ?int, path: string, domain: ?string, secure: bool, httponly: bool, samesite: ?string}`
