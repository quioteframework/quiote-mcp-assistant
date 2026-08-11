# OidcAuthorizationState

> The per-attempt secrets an OIDC auth-code + PKCE flow must round-trip through the user's session between the authorization redirect and the callback: the CSRF-style `state`, the PKCE `code_verifier`, and the OIDC `nonce` (replay/injection protection for the ID token).

The per-attempt secrets an OIDC auth-code + PKCE flow must round-trip through the user's session between the authorization redirect and the callback: the CSRF-style `state`, the PKCE `code_verifier`, and the OIDC `nonce` (replay/injection protection for the ID token).

## Synopsis

`final class OidcAuthorizationState`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `OidcAuthorizationState.php` |

## Constructor

### __construct()

`public function __construct(string $state, string $pkceVerifier, string $nonce): mixed`

The OIDC `nonce` sent in the authorization request, expected back in the ID token.

| Parameter | Type | Description |
|---|---|---|
| `$state` | `string` | The CSRF-style `state` value sent to and echoed back by the authorization server. |
| `$pkceVerifier` | `string` | The PKCE `code_verifier` (S256 challenge was derived from this). |
| `$nonce` | `string` | The OIDC `nonce` sent in the authorization request, expected back in the ID token. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getNonce(): string`](#getnonce) |  |
| [`getPkceVerifier(): string`](#getpkceverifier) |  |
| [`getState(): string`](#getstate) |  |

### getNonce()

`public function getNonce(): string`

Returns `string` — The OIDC `nonce`.

### getPkceVerifier()

`public function getPkceVerifier(): string`

Returns `string` — The PKCE `code_verifier`.

### getState()

`public function getState(): string`

Returns `string` — The `state` value.
