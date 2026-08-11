# Config

> The Quiote\\Security\\Auth\\Config namespace — 2 documented types.

Everything under `Quiote\Security\Auth\Config`.

## Classes

| Class | Description |
|---|---|
| [`FirewallFactory`](/api/security/auth/config/firewall-factory/) | Builds a live [`FirewallMap`](/api/security/auth/firewall-map/) from [`SecurityConfigHandler`](/api/security/auth/config/security-config-handler/)'s canonical array, resolving each firewall's `<authenticator ref="...">` and `entry-point` against explicit registries the app assembles itself -- no implicit global service-locator lookups, so wiring stays visible and testable. |
| [`SecurityConfigHandler`](/api/security/auth/config/security-config-handler/) | Parses a `security.{php,xml,yml,yaml}` file -- `<password_hashers>`, `<providers>`, `<firewalls>` (each `<firewall>` carrying `pattern`, `stateless`, `sessionless`, `entry-point`, `provider`, and an ordered list of `<authenticator ref="...">` elements) -- into a canonical array of password-hasher/provider/firewall definitions. |
