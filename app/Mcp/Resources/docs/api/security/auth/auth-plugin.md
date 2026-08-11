# AuthPlugin

> Registers the authentication foundation: a default PasswordHasherInterface, an empty (no-op) default FirewallMap, and two `AuthenticationMiddleware` placements (StatelessAuthenticationMiddleware before `Quiote\\Middleware\\SessionMiddleware`, so a machine token can flip a request to sessionless before session startup; SessionAuthenticationMiddleware before `Quiote\\Middleware\\SecurityMiddleware`, so a successful login is visible to the same request's authorization decision).

Registers the authentication foundation: a default [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/), an empty (no-op) default [`FirewallMap`](/api/security/auth/firewall-map/), and two `AuthenticationMiddleware` placements ([`StatelessAuthenticationMiddleware`](/api/security/auth/middleware/stateless-authentication-middleware/) before `Quiote\Middleware\SessionMiddleware`, so a machine token can flip a request to sessionless before session startup; [`SessionAuthenticationMiddleware`](/api/security/auth/middleware/session-authentication-middleware/) before `Quiote\Middleware\SecurityMiddleware`, so a successful login is visible to the same request's authorization decision).

The default `FirewallMap` has zero firewalls, so both middleware are a complete no-op until an app registers its own `FirewallMap` (built either by hand or via [`FirewallFactory`](/api/security/auth/config/firewall-factory/) from a `security.xml`) as an earlier-registered `service()` -- see `PluginRegistrar::service()`'s set-if-absent, first-plugin-wins rule.

## Synopsis

`final class AuthPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Since | `1.0.0` |
| Source | `AuthPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) |  |

### register()

`public function register(PluginRegistrar $registrar): void`

The framework's plugin-contribution API.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) | The framework's plugin-contribution API. |
