# WhoopsPlugin

> Opt-in entry point for the Whoops developer-exception renderer.

Opt-in entry point for the Whoops developer-exception renderer.

Adding this class to the `plugins` config key registers [`WhoopsRenderer`](/api/exception/rendering/whoops/whoops-renderer/) as the renderer [`ErrorHandlingMiddleware`](/api/middleware/error-handling-middleware/) uses when `core.developer_exceptions` is true (see [`ExceptionRendererRegistry`](/api/exception/rendering/exception-renderer-registry/)); without it, `core.developer_exceptions=true` still just falls back to `SafeRenderer`.

Unlike [`CsrfPlugin`](/api/security/csrf/csrf-plugin/) (kept on by default — CSRF protection is a security default, not merely a packaging concern), Whoops has no core-default registration: nothing bad happens if it's simply absent, so it follows the same fully opt-in model as [`McpPlugin`](/api/mcp/mcp-plugin/) and the ORM adapter plugins.

## Synopsis

`final class WhoopsPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `WhoopsPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers [`WhoopsRenderer`](/api/exception/rendering/whoops/whoops-renderer/) as the developer-exception renderer. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers [`WhoopsRenderer`](/api/exception/rendering/whoops/whoops-renderer/) as the developer-exception renderer.

The renderer is supplied as a factory, so Whoops is only constructed if an exception actually has to be rendered with developer detail enabled.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
