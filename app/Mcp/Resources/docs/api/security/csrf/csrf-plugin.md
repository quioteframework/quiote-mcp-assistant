# CsrfPlugin

> Registers the CSRF middleware pair through the generic plugin seam instead of MiddlewarePipeline hardcoding them.

Registers the CSRF middleware pair through the generic plugin seam instead of [`MiddlewarePipeline`](/api/middleware/middleware-pipeline/) hardcoding them.

Both middleware still carry their own `#[Middleware(...)]` attribute for ordering — this plugin only supplies the per-context factory ([`PluginRegistrar::attributedMiddleware()`](/api/plugin/plugin-registrar/#attributedmiddleware)) so each middleware gets *this* pipeline's own `Controller`, not a container-autowired (and possibly unrelated, for apps with a custom Controller subclass) one.

Physically split into its own package, `packages/csrf/` (developed in-tree, symlinked via a path repository) — not yet pushed to a standalone repo, and `Quiote::bootstrap()` still runs this plugin unconditionally today (see the "core default" note there). Once that core-default call is deleted, CSRF becomes opt-in via the `plugins` config key, exactly like [`McpPlugin`](/api/mcp/mcp-plugin/) already is.

## Synopsis

`final class CsrfPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `CsrfPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers the CSRF injection and validation middleware. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers the CSRF injection and validation middleware.

Each is registered with an explicit factory that pulls the `Controller` out of the context being registered against, so a middleware instance is bound to that pipeline's own controller rather than an autowired one. Ordering still comes from each middleware's own `#[Middleware]` attribute.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
