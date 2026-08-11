# Mcp

> The Quiote\\Mcp namespace — 16 documented types.

Everything under `Quiote\Mcp`.

## Classes

| Class | Description |
|---|---|
| [`McpCatalog`](/api/mcp/mcp-catalog/) | Process-global registry of MCP tools/resources/prompts, mirroring the static, worker-lifetime pattern of [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) and [`PluginManager`](/api/plugin/plugin-manager/): entries are added once at boot (via [`PluginRegistrar`](/api/plugin/plugin-registrar/) or attribute discovery, once that lands) and read once by [`McpServer::build()`](/api/mcp/mcp-server/#build) when the server is assembled. |
| [`McpConfig`](/api/mcp/mcp-config/) | Typed snapshot of the `mcp.*` settings family. |
| [`McpPlugin`](/api/mcp/mcp-plugin/) | Opt-in entry point for the MCP server capability. |
| [`McpServer`](/api/mcp/mcp-server/) | Our own facade over the official `mcp/sdk` `Server::builder()` API: every `Mcp\*` symbol the app touches is confined to this class (plus `ContainerAdapter`), so an SDK breaking change (it is pre-1.0) touches one file, not the whole feature. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Auth`](/api/mcp/auth/) | 2 types |
| [`Bridge`](/api/mcp/bridge/) | 2 types |
| [`Compiler`](/api/mcp/compiler/) | 4 types |
| [`Console`](/api/mcp/console/) | 2 types |
| [`Middleware`](/api/mcp/middleware/) | 2 types |
