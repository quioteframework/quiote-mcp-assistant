# McpPlugin

> Opt-in entry point for the MCP server capability.

Opt-in entry point for the MCP server capability.

Adding this class to the `plugins` config key publishes the `mcp.*` setting defaults (all opt-in-safe: `mcp.enabled` defaults to `false`) and registers `mcp:serve`. When the adapters are extracted into a standalone composer package this plugin (and `Quiote\Mcp\*`) move to `quioteframework/quiote-mcp` unchanged, mirroring the ORM adapter plugins.

## Synopsis

`final class McpPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `McpPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `mcp.*` config defaults and wires the MCP capability. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `mcp.*` config defaults and wires the MCP capability.

Registers the `mcp:serve` and `mcp:warmup` commands and the singleton [`McpAuthenticatorInterface`](/api/mcp/auth/mcp-authenticator-interface/) binding backed by [`StaticTokenAuthenticator`](/api/mcp/auth/static-token-authenticator/). When `mcp.transports` includes `http`, also splices [`McpEndpointMiddleware`](/api/mcp/middleware/mcp-endpoint-middleware/) into the pipeline before `SecurityMiddleware`, followed by [`McpAuthMiddleware`](/api/mcp/middleware/mcp-auth-middleware/) before it — the latter only when `mcp.auth` is neither `none` (no auth) nor `oauth2` (enforced inside the SDK's own transport middleware instead).

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
