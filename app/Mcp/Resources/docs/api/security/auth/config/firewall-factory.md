# FirewallFactory

> Builds a live FirewallMap from SecurityConfigHandler's canonical array, resolving each firewall's `<authenticator ref=\"...\">` and `entry-point` against explicit registries the app assembles itself -- no implicit global service-locator lookups, so wiring stays visible and testable.

Builds a live [`FirewallMap`](/api/security/auth/firewall-map/) from [`SecurityConfigHandler`](/api/security/auth/config/security-config-handler/)'s canonical array, resolving each firewall's `<authenticator ref="...">` and `entry-point` against explicit registries the app assembles itself -- no implicit global service-locator lookups, so wiring stays visible and testable.

Apps that assemble firewalls purely in PHP never need this class or `security.xml` at all.

## Synopsis

`final class FirewallFactory`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/FirewallFactory.php` |

## Constructor

### __construct()

`public function __construct(array<string, AuthenticatorInterface> $authenticators, array<string, EntryPointInterface> $entryPoints): mixed`

Keyed by `entry-point` (e.g. "login", "challenge").

| Parameter | Type | Description |
|---|---|---|
| `$authenticators` | `array``<``string``, `[`AuthenticatorInterface`](/api/security/auth/authenticator-interface/)`>` | Keyed by the `ref` used in security.xml. |
| `$entryPoints` | `array``<``string``, `[`EntryPointInterface`](/api/security/auth/entry-point-interface/)`>` | Keyed by `entry-point` (e.g. "login", "challenge"). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`build(array{firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>} $config): FirewallMap`](#build) |  |

### build()

`public function build(array{firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>} $config): FirewallMap`

The canonical array from [`SecurityConfigHandler::toCanonicalArray()`](/api/security/auth/config/security-config-handler/#tocanonicalarray).

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array{firewalls: array<string, array{pattern: string, stateless: bool, sessionless: bool, entry_point: ?string, provider: ?string, authenticators: array<int, string>}>}` | The canonical array from [`SecurityConfigHandler::toCanonicalArray()`](/api/security/auth/config/security-config-handler/#tocanonicalarray). |

Returns [`FirewallMap`](/api/security/auth/firewall-map/) — The resulting firewalls, in the same order as $config.

| Throws | When |
|---|---|
| `RuntimeException` | If a firewall references an authenticator ref or entry-point key not present in the constructor's registries. |
