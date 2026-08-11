# Middleware

> The Quiote\\Mcp\\Middleware namespace — 2 documented types.

Everything under `Quiote\Mcp\Middleware`.

## Classes

| Class | Description |
|---|---|
| [`McpAuthMiddleware`](/api/mcp/middleware/mcp-auth-middleware/) | Bearer-token auth for the MCP HTTP endpoint. |
| [`McpEndpointMiddleware`](/api/mcp/middleware/mcp-endpoint-middleware/) | The Streamable-HTTP transport: matches the configured `mcp.path` (default `/mcp`) -- plus, when `mcp.auth` is `'oauth2'`, a GET to the RFC 9728 well-known metadata path, since that also has to reach [`McpServer::handleHttp()`](/api/mcp/mcp-server/#handlehttp) for the SDK's own `ProtectedResourceMetadataMiddleware` (composed there) to serve it -- and delegates everything else to the rest of the pipeline unchanged. |
