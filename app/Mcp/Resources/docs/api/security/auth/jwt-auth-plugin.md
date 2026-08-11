# JwtAuthPlugin

> Registers the default ClientTypeResolverInterface (the RFC 9068 rule -- see ClientTypeResolver).

Registers the default [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/) (the RFC 9068 rule -- see [`ClientTypeResolver`](/api/security/auth/client-type-resolver/)).

`TokenValidatorInterface`/ `BearerTokenAuthenticator` are not given framework-wide defaults here: they need app-specific secrets (issuer, audience, JWKS URI or shared key), so an app constructs and registers those itself -- typically inside its own plugin, alongside a `FirewallMap` built with `Quiote\Security\Auth\Config\FirewallFactory`.

## Synopsis

`final class JwtAuthPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Since | `1.0.0` |
| Source | `JwtAuthPlugin.php` |

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
