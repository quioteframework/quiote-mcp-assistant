# OidcClient

> Wraps `league/oauth2-client`'s generic provider (via SpaceDelimitedScopeProvider, which fixes the library's comma-delimited `scope` parameter) for the OIDC Authorization Code flow.

Wraps `league/oauth2-client`'s generic provider (via [`SpaceDelimitedScopeProvider`](/api/security/auth/space-delimited-scope-provider/), which fixes the library's comma-delimited `scope` parameter) for the OIDC Authorization Code flow.

PKCE (S256) is hardcoded, not an app-configurable option, since OAuth 2.1 mandates it for the Authorization Code grant. The `nonce` authorization-request parameter and its later ID-token verification are entirely our own responsibility -- `league/oauth2-client` is OAuth2-only and has no OIDC/nonce concept.

## Synopsis

`final class OidcClient`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `OidcClient.php` |

## Constructor

### __construct()

`public function __construct(string $clientId, string $clientSecret, string $redirectUri, string $authorizationEndpoint, string $tokenEndpoint, array<int, string> $scopes = ['openid'], ?ClientInterface $httpClient = null, RandomnessInterface $randomness = new SystemRandomness(…)): mixed`

The source of entropy for the OIDC nonce.

| Parameter | Type | Description |
|---|---|---|
| `$clientId` | `string` | The OAuth client id. |
| `$clientSecret` | `string` | The OAuth client secret. |
| `$redirectUri` | `string` | This app's callback URL, registered with the authorization server. |
| `$authorizationEndpoint` | `string` | The authorization server's `/authorize` endpoint. |
| `$tokenEndpoint` | `string` | The authorization server's `/token` endpoint. |
| `$scopes` | `array``<``int``, ``string``>` | The scopes to request. |
| `$httpClient` | `?``ClientInterface` | A Guzzle HTTP client override (e.g. for testing); defaults to a real Guzzle client. |
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) | The source of entropy for the OIDC nonce. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`buildAuthorizationRequest(): OidcAuthorizationRequest`](#buildauthorizationrequest) | Generates state/PKCE-verifier/nonce and builds the authorization redirect URL. |
| [`exchangeCode(string $code, string $pkceVerifier): AccessTokenInterface`](#exchangecode) | Exchanges an authorization code for tokens, using the PKCE verifier persisted from the matching [`OidcClient::buildAuthorizationRequest()`](/api/security/auth/oidc-client/#buildauthorizationrequest) call. |
| [`fromDiscovery(OidcDiscoveryDocument $document, string $clientId, string $clientSecret, string $redirectUri, array<int, string> $scopes = ['openid'], ?ClientInterface $httpClient = null, RandomnessInterface $randomness = new SystemRandomness(…)): self`](#fromdiscovery) | Builds a client from a provider's discovery document (see [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/)) instead of hand-copied endpoint URLs. |

### buildAuthorizationRequest()

`public function buildAuthorizationRequest(): OidcAuthorizationRequest`

Generates state/PKCE-verifier/nonce and builds the authorization redirect URL.

The caller persists the returned state (e.g. via [`OidcStateStorage::store()`](/api/security/auth/oidc-state-storage/#store)) before redirecting the browser.

Returns [`OidcAuthorizationRequest`](/api/security/auth/oidc-authorization-request/) — The redirect URL plus the state to persist.

### exchangeCode()

`public function exchangeCode(string $code, string $pkceVerifier): AccessTokenInterface`

Exchanges an authorization code for tokens, using the PKCE verifier persisted from the matching [`OidcClient::buildAuthorizationRequest()`](/api/security/auth/oidc-client/#buildauthorizationrequest) call.

The PKCE `code_verifier` from the matching [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/).

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string` | The authorization code received on the callback. |
| `$pkceVerifier` | `string` | The PKCE `code_verifier` from the matching [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/). |

Returns `AccessTokenInterface` — The token response, including the ID token (see `getValues()['id_token']`).

| Throws | When |
|---|---|
| `AuthenticationException` | If the token endpoint rejects the exchange. |

### fromDiscovery()

`public static function fromDiscovery(OidcDiscoveryDocument $document, string $clientId, string $clientSecret, string $redirectUri, array<int, string> $scopes = ['openid'], ?ClientInterface $httpClient = null, RandomnessInterface $randomness = new SystemRandomness(…)): self`

Builds a client from a provider's discovery document (see [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/)) instead of hand-copied endpoint URLs.

The source of entropy for the OIDC nonce.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`OidcDiscoveryDocument`](/api/security/auth/oidc-discovery-document/) | The provider's metadata. |
| `$clientId` | `string` | The OAuth client id. |
| `$clientSecret` | `string` | The OAuth client secret. |
| `$redirectUri` | `string` | This app's callback URL, registered with the authorization server. |
| `$scopes` | `array``<``int``, ``string``>` | The scopes to request. |
| `$httpClient` | `?``ClientInterface` | A Guzzle HTTP client override (e.g. for testing); defaults to a real Guzzle client. |
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) | The source of entropy for the OIDC nonce. |

Returns `self` — A client wired to the discovered authorization and token endpoints.

| Throws | When |
|---|---|
| `AuthenticationException` | If the document lacks an authorization or token endpoint, or rules out PKCE S256. |
