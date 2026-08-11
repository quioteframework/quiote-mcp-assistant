# Auth

> The Quiote\\Mcp\\Auth namespace — 2 documented types.

Everything under `Quiote\Mcp\Auth`.

## Classes

| Class | Description |
|---|---|
| [`StaticTokenAuthenticator`](/api/mcp/auth/static-token-authenticator/) | The default [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/): a single shared secret from the `mcp.auth_token` setting. |

## Interfaces

| Interface | Description |
|---|---|
| [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/) | Validates the bearer token presented to the MCP HTTP endpoint. |
