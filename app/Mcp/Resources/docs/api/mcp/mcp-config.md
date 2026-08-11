# McpConfig

> Typed snapshot of the `mcp.*` settings family.

Typed snapshot of the `mcp.*` settings family.

Defaults here are read as fallbacks only — [`McpPlugin`](/api/mcp/mcp-plugin/) is what actually publishes them into [`Config`](/api/config/config/) via `configDefault()`, so an app that adds `McpPlugin` to its `plugins` key without further configuration still gets a sane, opt-in-safe setup (`enabled = false`).

## Synopsis

`final class McpConfig`

|  |  |
|---|---|
| Source | `McpConfig.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `AUTH_MODES` | `['none', 'bearer', 'oauth2']` | The accepted values of `mcp.auth`. |

## Properties

| Property | Type | Description |
|---|---|---|
| `$auth` | `string` | _readonly._ |
| `$discoverAttributes` | `bool` | _readonly._ |
| `$discoveryCache` | `bool` | _readonly._ |
| `$enabled` | `bool` | _readonly._ |
| `$exposeActions` | `bool` | _readonly._ |
| `$moduleDirs` | `array` | _readonly._ |
| `$oauthAudience` | `?``string` | _readonly._ |
| `$oauthCacheTtl` | `int` | _readonly._ |
| `$oauthIssuer` | `?``string` | _readonly._ |
| `$oauthJwksUri` | `?``string` | _readonly._ |
| `$oauthScopesSupported` | `array` | _readonly._ |
| `$path` | `string` | _readonly._ |
| `$protocolVersion` | `string` | _readonly._ |
| `$serverName` | `string` | _readonly._ |
| `$serverVersion` | `string` | _readonly._ |
| `$stateless` | `bool` | _readonly._ |
| `$transports` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(bool $enabled, list<string> $transports, string $path, string $protocolVersion, bool $stateless, string $serverName, string $serverVersion, string $auth, bool $exposeActions, list<string> $moduleDirs, bool $discoverAttributes, bool $discoveryCache, ?string $oauthIssuer, ?string $oauthAudience, ?string $oauthJwksUri, list<string> $oauthScopesSupported, int $oauthCacheTtl): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$enabled` | `bool` |  |
| `$transports` | `list``<``string``>` |  |
| `$path` | `string` |  |
| `$protocolVersion` | `string` |  |
| `$stateless` | `bool` |  |
| `$serverName` | `string` |  |
| `$serverVersion` | `string` |  |
| `$auth` | `string` |  |
| `$exposeActions` | `bool` |  |
| `$moduleDirs` | `list``<``string``>` |  |
| `$discoverAttributes` | `bool` |  |
| `$discoveryCache` | `bool` |  |
| `$oauthIssuer` | `?``string` |  |
| `$oauthAudience` | `?``string` |  |
| `$oauthJwksUri` | `?``string` |  |
| `$oauthScopesSupported` | `list``<``string``>` |  |
| `$oauthCacheTtl` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromConfig(): McpConfig`](#fromconfig) | Reads the whole `mcp.*` family out of [`Config`](/api/config/config/) into one immutable snapshot, applying the fallback defaults for anything the app (or [`McpPlugin`](/api/mcp/mcp-plugin/)) has not published. |

### fromConfig()

`public static function fromConfig(): McpConfig`

Reads the whole `mcp.*` family out of [`Config`](/api/config/config/) into one immutable snapshot, applying the fallback defaults for anything the app (or [`McpPlugin`](/api/mcp/mcp-plugin/)) has not published.

Validation happens in the constructor, so a bad `mcp.auth` value or an `oauth2` setup missing its issuer/audience fails here rather than at the first request.

Returns [`McpConfig`](/api/mcp/mcp-config/)

| Throws | When |
|---|---|
| `QuioteException` | if `mcp.auth` is not one of `AUTH_MODES`, or is `oauth2` without `mcp.oauth.issuer` and `mcp.oauth.audience`. |
