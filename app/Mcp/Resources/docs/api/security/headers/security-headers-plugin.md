# SecurityHeadersPlugin

> Registers SecurityHeadersMiddleware through the generic plugin seam.

Registers [`SecurityHeadersMiddleware`](/api/security/headers/security-headers-middleware/) through the generic plugin seam.

Unlike CORS/rate-limiting, this middleware is safe-by-default and enabled out of the box (`security_headers.enabled` defaults to true) — the headers it adds are broadly applicable hardening, not a per-app policy decision.

## Synopsis

`final class SecurityHeadersPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `SecurityHeadersPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers the security-header configuration defaults and the middleware. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers the security-header configuration defaults and the middleware.

`security_headers.enabled` defaults to true, so the headers are added as soon as the package is installed; the individual defaults set a self-only CSP, `DENY` framing, `nosniff`, a strict referrer policy and 180-day HSTS.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
