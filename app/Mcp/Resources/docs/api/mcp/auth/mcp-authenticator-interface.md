# McpAuthenticatorInterface

> Validates the bearer token presented to the MCP HTTP endpoint.

Validates the bearer token presented to the MCP HTTP endpoint.

Bind a different implementation via `PluginRegistrar::service(McpAuthenticatorInterface::class, ...)` to delegate to an app's own credential store instead of the static-token default ([`StaticTokenAuthenticator`](/api/mcp/auth/static-token-authenticator/)).

## Synopsis

`interface McpAuthenticatorInterface`

|  |  |
|---|---|
| Implemented by | [`StaticTokenAuthenticator`](/api/mcp/auth/static-token-authenticator/) |
| Source | `Auth/McpAuthenticatorInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`authenticate(string $token): bool`](#authenticate) |  |

### authenticate()

`abstract public function authenticate(string $token): bool`

| Parameter | Type | Description |
|---|---|---|
| `$token` | `string` |  |

Returns `bool` — whether $token is valid
