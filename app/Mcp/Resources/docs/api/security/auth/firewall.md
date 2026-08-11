# Firewall

> A named, path-matched set of authenticators plus the entry point that handles a failed authentication attempt for that path -- the runtime counterpart of a `security.xml` `<firewall>` element.

A named, path-matched set of authenticators plus the entry point that handles a failed authentication attempt for that path -- the runtime counterpart of a `security.xml` `<firewall>` element.

## Synopsis

`final class Firewall`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Firewall.php` |

## Constructor

### __construct()

`public function __construct(string $name, string $pattern, array<AuthenticatorInterface> $authenticators, EntryPointInterface $entryPoint, bool $stateless = false, bool $sessionless = false): mixed`

Session axis: no session is started at all for requests under this firewall.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | A diagnostic name for this firewall (e.g. "api", "main"). |
| `$pattern` | `string` | A PCRE pattern (without delimiters) matched against the request path. |
| `$authenticators` | `array``<`[`AuthenticatorInterface`](/api/security/auth/authenticator-interface/)`>` | Tried in order; the first one whose supports() matches wins. |
| `$entryPoint` | [`EntryPointInterface`](/api/security/auth/entry-point-interface/) | Produces the failure response when authentication is required but absent/invalid. |
| `$stateless` | `bool` | Identity axis: re-derived from the credential every request rather than read back from the session. |
| `$sessionless` | `bool` | Session axis: no session is started at all for requests under this firewall. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`canonicalize(string $path): string`](#canonicalize) | Collapse a request path to the form a filesystem-style resolver would reach: fully percent-decoded, backslashes treated as separators, duplicate slashes collapsed, and `.`/`..` segments resolved. |
| [`getAuthenticators(): array<AuthenticatorInterface>`](#getauthenticators) |  |
| [`getEntryPoint(): EntryPointInterface`](#getentrypoint) |  |
| [`getName(): string`](#getname) |  |
| [`isSessionless(): bool`](#issessionless) | Session axis: no session is started at all for requests under this firewall (pure machine-to-machine surfaces). |
| [`isStateless(): bool`](#isstateless) | Identity axis: re-derived from the credential every request rather than read back from the session as the source of truth. |
| [`matches(string $path): bool`](#matches) | Whether $path falls under this firewall. |

### canonicalize()

`public static function canonicalize(string $path): string`

Collapse a request path to the form a filesystem-style resolver would reach: fully percent-decoded, backslashes treated as separators, duplicate slashes collapsed, and `.`/`..` segments resolved.

The raw request path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The raw request path. |

Returns `string` — The normalized path, always starting with `/`.

### getAuthenticators()

`public function getAuthenticators(): array<AuthenticatorInterface>`

Returns `array``<`[`AuthenticatorInterface`](/api/security/auth/authenticator-interface/)`>` — This firewall's authenticator chain, in try order.

### getEntryPoint()

`public function getEntryPoint(): EntryPointInterface`

Returns [`EntryPointInterface`](/api/security/auth/entry-point-interface/) — The entry point for a failed authentication attempt on this firewall.

### getName()

`public function getName(): string`

Returns `string` — This firewall's diagnostic name.

### isSessionless()

`public function isSessionless(): bool`

Session axis: no session is started at all for requests under this firewall (pure machine-to-machine surfaces).

Returns `bool` — True if this firewall is sessionless, otherwise false.

### isStateless()

`public function isStateless(): bool`

Identity axis: re-derived from the credential every request rather than read back from the session as the source of truth.

Returns `bool` — True if this firewall is stateless, otherwise false.

### matches()

`public function matches(string $path): bool`

Whether $path falls under this firewall.

The request path to test (e.g. `$request->getUri()->getPath()`).

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` | The request path to test (e.g. `$request->getUri()->getPath()`). |

Returns `bool` — True if $path matches this firewall's pattern, otherwise false.
