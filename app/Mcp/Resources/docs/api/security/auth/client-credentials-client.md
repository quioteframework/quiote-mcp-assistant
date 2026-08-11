# ClientCredentialsClient

> Outbound M2M: fetches an access token via the Client Credentials grant for the app to present to another service.

Outbound M2M: fetches an access token via the Client Credentials grant for the app to present to another service.

Unrelated to inbound request authentication -- pair with [`BearerTokenAuthenticator`](/api/security/auth/bearer-token-authenticator/) (`packages/auth-jwt`) on the *receiving* end.

## Synopsis

`final class ClientCredentialsClient`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `ClientCredentialsClient.php` |

## Constructor

### __construct()

`public function __construct(string $clientId, string $clientSecret, string $tokenEndpoint, array<int, string> $scopes = [], ?ClientInterface $httpClient = null): mixed`

A Guzzle HTTP client override (e.g. for testing); defaults to a real Guzzle client.

| Parameter | Type | Description |
|---|---|---|
| `$clientId` | `string` | The OAuth client id. |
| `$clientSecret` | `string` | The OAuth client secret. |
| `$tokenEndpoint` | `string` | The authorization server's `/token` endpoint. |
| `$scopes` | `array``<``int``, ``string``>` | The scopes to request. |
| `$httpClient` | `?``ClientInterface` | A Guzzle HTTP client override (e.g. for testing); defaults to a real Guzzle client. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromDiscovery(OidcDiscoveryDocument $document, string $clientId, string $clientSecret, array<int, string> $scopes = [], ?ClientInterface $httpClient = null): self`](#fromdiscovery) | Builds a client from a provider's discovery document (see [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/)) instead of a hand-copied token-endpoint URL. |
| [`getAccessToken(): AccessTokenInterface`](#getaccesstoken) |  |

### fromDiscovery()

`public static function fromDiscovery(OidcDiscoveryDocument $document, string $clientId, string $clientSecret, array<int, string> $scopes = [], ?ClientInterface $httpClient = null): self`

Builds a client from a provider's discovery document (see [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/)) instead of a hand-copied token-endpoint URL.

A Guzzle HTTP client override (e.g. for testing); defaults to a real Guzzle client.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`OidcDiscoveryDocument`](/api/security/auth/oidc-discovery-document/) | The provider's metadata. |
| `$clientId` | `string` | The OAuth client id. |
| `$clientSecret` | `string` | The OAuth client secret. |
| `$scopes` | `array``<``int``, ``string``>` | The scopes to request. |
| `$httpClient` | `?``ClientInterface` | A Guzzle HTTP client override (e.g. for testing); defaults to a real Guzzle client. |

Returns `self` — A client wired to the discovered token endpoint.

| Throws | When |
|---|---|
| `AuthenticationException` | If the document does not advertise a token endpoint. |

### getAccessToken()

`public function getAccessToken(): AccessTokenInterface`

Returns `AccessTokenInterface` — The M2M access token, for the app to present to another service.
