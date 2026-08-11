# StaticTokenAuthenticator

> The default McpAuthenticatorInterface: a single shared secret from the `mcp.auth_token` setting.

The default [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/): a single shared secret from the `mcp.auth_token` setting.

A null/empty configured token always rejects -- there is no "auth disabled by an empty token" footgun; use `mcp.auth = 'none'` to actually disable auth.

## Synopsis

`final class StaticTokenAuthenticator implements McpAuthenticatorInterface`

|  |  |
|---|---|
| Implements | [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/) |
| Source | `Auth/StaticTokenAuthenticator.php` |

## Constructor

### __construct()

`public function __construct(?string $expectedToken): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$expectedToken` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authenticate(string $token): bool`](#authenticate) | Compares $token against the configured secret in constant time. |

### authenticate()

`public function authenticate(string $token): bool`

Compares $token against the configured secret in constant time.

Returns false whenever either the configured token or the presented one is null or empty, so a missing `mcp.auth_token` denies every request rather than accepting any.

| Parameter | Type | Description |
|---|---|---|
| `$token` | `string` |  |

Returns `bool`
