# OidcDiscoveryClient

> Fetches an OpenID provider's metadata from `{issuer}/.well-known/openid-configuration` (OpenID Connect Discovery 1.0 §4) so an app can wire OidcClient, ClientCredentialsClient, IntrospectionClient and `auth-jwt`'s JWKS key set from one issuer URL instead of five hand-copied endpoint strings that silently rot when the provider moves them.

Fetches an OpenID provider's metadata from `{issuer}/.well-known/openid-configuration` (OpenID Connect Discovery 1.0 §4) so an app can wire [`OidcClient`](/api/security/auth/oidc-client/), [`ClientCredentialsClient`](/api/security/auth/client-credentials-client/), [`IntrospectionClient`](/api/security/auth/introspection-client/) and `auth-jwt`'s JWKS key set from one issuer URL instead of five hand-copied endpoint strings that silently rot when the provider moves them.

PSR-18 + PSR-17 rather than Guzzle, matching [`IntrospectionClient`](/api/security/auth/introspection-client/); discovery is a plain GET and does not need `league/oauth2-client`. An optional PSR-6 pool caches the document -- discovery is a synchronous network hop, so an uncached fetch on every worker boot (or every request under PHP-FPM) adds the provider's latency to the app's own. The pool is PSR-6 to match the pool `firebase/php-jwt`'s `CachedKeySet` already needs for the JWKS in the same auth stack.

## Synopsis

`final class OidcDiscoveryClient`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `OidcDiscoveryClient.php` |

## Constructor

### __construct()

`public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, ?CacheItemPoolInterface $cache = null, int $cacheTtl = 3600, bool $requireHttps = true): mixed`

Whether to reject non-HTTPS issuers, as Discovery §4 requires. Only turn this off for a local test provider.

| Parameter | Type | Description |
|---|---|---|
| `$httpClient` | [`ClientInterface`](https://www.php-fig.org/psr/psr-18/) | A PSR-18 HTTP client. |
| `$requestFactory` | `RequestFactoryInterface` | A PSR-17 request factory. |
| `$cache` | `?`[`CacheItemPoolInterface`](https://www.php-fig.org/psr/psr-6/) | A PSR-6 pool to cache fetched documents in, or null to fetch on every call. |
| `$cacheTtl` | `int` | How long (seconds) a cached document stays fresh; providers change endpoints rarely, so hours are reasonable. |
| `$requireHttps` | `bool` | Whether to reject non-HTTPS issuers, as Discovery §4 requires. Only turn this off for a local test provider. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`discover(string $issuer): OidcDiscoveryDocument`](#discover) |  |

### discover()

`public function discover(string $issuer): OidcDiscoveryDocument`

The provider's issuer identifier, e.g. `https://login.microsoftonline.com/{tenant}/v2.0`. A full `.../.well-known/openid-configuration` URL is also accepted and its issuer part used.

| Parameter | Type | Description |
|---|---|---|
| `$issuer` | `string` | The provider's issuer identifier, e.g. `https://login.microsoftonline.com/{tenant}/v2.0`. A full `.../.well-known/openid-configuration` URL is also accepted and its issuer part used. |

Returns [`OidcDiscoveryDocument`](/api/security/auth/oidc-discovery-document/) — The provider's metadata, issuer-verified per Discovery §4.3.

| Throws | When |
|---|---|
| `AuthenticationException` | If the issuer is unusable, the request fails, the response is not a 2xx JSON object, or its `issuer` does not match. |
