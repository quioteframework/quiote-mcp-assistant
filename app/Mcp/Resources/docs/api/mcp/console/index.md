# Console

> The Quiote\\Mcp\\Console namespace — 2 documented types.

Everything under `Quiote\Mcp\Console`.

## Classes

| Class | Description |
|---|---|
| [`McpServeCommand`](/api/mcp/console/mcp-serve-command/) | Runs this app as an MCP server over stdio -- the transport local clients (Claude Desktop, IDEs) launch as a subprocess, with no HTTP/auth surface. |
| [`McpWarmupCommand`](/api/mcp/console/mcp-warmup-command/) | Pre-populates the plain-class attribute-discovery cache (see [`McpServer::buildDiscoveryCache()`](/api/mcp/mcp-server/#builddiscoverycache)) by building the SDK server once offline, so the first real `mcp:serve`/HTTP request in a freshly started process hits the file-backed cache instead of paying the filesystem-walk + reflection cost of `Mcp\Capability\Discovery\Discoverer` itself. |
