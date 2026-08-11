# IntrospectionClient

> A ~30-line RFC 7662 (OAuth 2.0 Token Introspection) POST helper -- `league/oauth2-client` has none.

A ~30-line RFC 7662 (OAuth 2.0 Token Introspection) POST helper -- `league/oauth2-client` has none.

Used only on revocation-sensitive paths; the default resource-server validation is local JWKS verification via `packages/auth-jwt`.

## Synopsis

`final class IntrospectionClient`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `IntrospectionClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, string $introspectionEndpoint, string $clientId, string $clientSecret): mixed`

The OAuth client secret, sent via HTTP Basic per RFC 7662 §2.1.

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) | A PSR-18 HTTP client. |
| `$requestFactory` | `RequestFactoryInterface` | A PSR-17 request factory. |
| `$streamFactory` | `StreamFactoryInterface` | A PSR-17 stream factory, for the POST body. |
| `$introspectionEndpoint` | `string` | The authorization server's RFC 7662 introspection endpoint. |
| `$clientId` | `string` | The OAuth client id, sent via HTTP Basic per RFC 7662 §2.1. |
| `$clientSecret` | `string` | The OAuth client secret, sent via HTTP Basic per RFC 7662 §2.1. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromDiscovery(OidcDiscoveryDocument $document, ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, string $clientId, string $clientSecret): self`](#fromdiscovery) | Builds a client from a provider's discovery document (see [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/)). |
| [`introspect(string $token): array<string, mixed>`](#introspect) |  |

### fromDiscovery()

`public static function fromDiscovery(OidcDiscoveryDocument $document, ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, string $clientId, string $clientSecret): self`

Builds a client from a provider's discovery document (see [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/)).

The OAuth client secret, sent via HTTP Basic per RFC 7662 §2.1.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`OidcDiscoveryDocument`](/api/security/auth/oidc-discovery-document/) | The provider's metadata. |
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) | A PSR-18 HTTP client. |
| `$requestFactory` | `RequestFactoryInterface` | A PSR-17 request factory. |
| `$streamFactory` | `StreamFactoryInterface` | A PSR-17 stream factory, for the POST body. |
| `$clientId` | `string` | The OAuth client id, sent via HTTP Basic per RFC 7662 §2.1. |
| `$clientSecret` | `string` | The OAuth client secret, sent via HTTP Basic per RFC 7662 §2.1. |

Returns `self` — A client wired to the discovered introspection endpoint.

| Throws | When |
|---|---|
| `AuthenticationException` | If the document does not advertise an introspection endpoint. |

### introspect()

`public function introspect(string $token): array<string, mixed>`

The token to introspect.

| Parameter | Type | Description |
|---|---|---|
| `$token` | `string` | The token to introspect. |

Returns `array``<``string``, ``mixed``>` — The introspection response.

| Throws | When |
|---|---|
| `AuthenticationException` | If the request fails, the response is malformed, or the token is not active. |
