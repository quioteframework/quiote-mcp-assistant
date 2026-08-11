# CorsPlugin

> Registers CorsMiddleware through the generic plugin seam, opt-in via `cors.enabled` (the middleware itself no-ops when it's false, so simply installing this package doesn't turn CORS on for every app).

Registers [`CorsMiddleware`](/api/security/cors/cors-middleware/) through the generic plugin seam, opt-in via `cors.enabled` (the middleware itself no-ops when it's false, so simply installing this package doesn't turn CORS on for every app).

## Synopsis

`final class CorsPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `CorsPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers the CORS configuration defaults and the middleware itself. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers the CORS configuration defaults and the middleware itself.

`cors.enabled` defaults to false, so installing the package alone does not switch CORS on. The middleware is registered through its `#[Middleware]` attribute, which places it in the pipeline.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
