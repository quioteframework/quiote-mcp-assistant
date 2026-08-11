# OidcAuthorizationRequest

> The result of OidcClient::buildAuthorizationRequest(): the URL to redirect the browser to, plus the state/PKCE-verifier/nonce the caller must persist (e.g.

The result of [`OidcClient::buildAuthorizationRequest()`](/api/security/auth/oidc-client/#buildauthorizationrequest): the URL to redirect the browser to, plus the state/PKCE-verifier/nonce the caller must persist (e.g.

via [`OidcStateStorage`](/api/security/auth/oidc-state-storage/)) so the callback leg can verify them.

## Synopsis

`final class OidcAuthorizationRequest`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `OidcAuthorizationRequest.php` |

## Constructor

### __construct()

`public function __construct(string $authorizationUrl, OidcAuthorizationState $state): mixed`

The state/PKCE-verifier/nonce to persist before redirecting.

| Parameter | Type | Description |
|---|---|---|
| `$authorizationUrl` | `string` | The URL to redirect the browser to. |
| `$state` | [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) | The state/PKCE-verifier/nonce to persist before redirecting. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getAuthorizationUrl(): string`](#getauthorizationurl) |  |
| [`getState(): OidcAuthorizationState`](#getstate) |  |

### getAuthorizationUrl()

`public function getAuthorizationUrl(): string`

Returns `string` — The URL to redirect the browser to.

### getState()

`public function getState(): OidcAuthorizationState`

Returns [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) — The state/PKCE-verifier/nonce to persist before redirecting.
