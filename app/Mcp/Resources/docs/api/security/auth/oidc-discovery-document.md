# OidcDiscoveryDocument

> An immutable OpenID Provider metadata document (OpenID Connect Discovery 1.0 §3, a superset of RFC 8414 authorization-server metadata), as fetched by OidcDiscoveryClient.

An immutable OpenID Provider metadata document (OpenID Connect Discovery 1.0 §3, a superset of RFC 8414 authorization-server metadata), as fetched by [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/).

Only `issuer` is required at construction: everything else is optional in practice, because the same metadata format serves pure OAuth 2.0 authorization servers (which may have no `jwks_uri` or `authorization_endpoint`) as well as full OpenID providers. Accessors for the endpoints a flow cannot work without ([`OidcDiscoveryDocument::getAuthorizationEndpoint()`](/api/security/auth/oidc-discovery-document/#getauthorizationendpoint), [`OidcDiscoveryDocument::getTokenEndpoint()`](/api/security/auth/oidc-discovery-document/#gettokenendpoint), [`OidcDiscoveryDocument::getJwksUri()`](/api/security/auth/oidc-discovery-document/#getjwksuri)) therefore throw rather than return null -- a missing one is a provider misconfiguration the caller cannot paper over, and failing at wiring time beats a null reaching `GenericProvider` as an empty endpoint URL.

## Synopsis

`final class OidcDiscoveryDocument`

|  |  |
|---|---|
| Since | `1.2.5` |
| Source | `OidcDiscoveryDocument.php` |

## Methods

| Method | Description |
|---|---|
| [`fromArray(array<string, mixed> $metadata, ?string $expectedIssuer = null): self`](#fromarray) | Validates a decoded metadata document and wraps it. |
| [`get(string $member): mixed`](#get) |  |
| [`getAuthorizationEndpoint(): string`](#getauthorizationendpoint) |  |
| [`getCodeChallengeMethodsSupported(): array<int, string>`](#getcodechallengemethodssupported) |  |
| [`getEndSessionEndpoint(): ?string`](#getendsessionendpoint) |  |
| [`getIdTokenSigningAlgValuesSupported(): array<int, string>`](#getidtokensigningalgvaluessupported) |  |
| [`getIntrospectionEndpoint(): ?string`](#getintrospectionendpoint) |  |
| [`getIssuer(): string`](#getissuer) |  |
| [`getJwksUri(): string`](#getjwksuri) |  |
| [`getMetadata(): array<string, mixed>`](#getmetadata) |  |
| [`getResponseTypesSupported(): array<int, string>`](#getresponsetypessupported) |  |
| [`getRevocationEndpoint(): ?string`](#getrevocationendpoint) |  |
| [`getScopesSupported(): array<int, string>`](#getscopessupported) |  |
| [`getTokenEndpoint(): string`](#gettokenendpoint) |  |
| [`getUserinfoEndpoint(): ?string`](#getuserinfoendpoint) |  |
| [`supportsPkceS256(): bool`](#supportspkces256) | A pre-flight check for [`OidcClient`](/api/security/auth/oidc-client/), which hardcodes PKCE S256 because OAuth 2.1 mandates it. |

### fromArray()

`public static function fromArray(array<string, mixed> $metadata, ?string $expectedIssuer = null): self`

Validates a decoded metadata document and wraps it.

The issuer the document was requested for, or null to skip the §4.3 check (only for callers that fetched a non-issuer-derived URL).

| Parameter | Type | Description |
|---|---|---|
| `$metadata` | `array``<``string``, ``mixed``>` | The decoded metadata document. |
| `$expectedIssuer` | `?``string` | The issuer the document was requested for, or null to skip the §4.3 check (only for callers that fetched a non-issuer-derived URL). |

Returns `self` — The validated document.

| Throws | When |
|---|---|
| `AuthenticationException` | If `issuer` is missing/not a string, or does not match $expectedIssuer. |

### get()

`public function get(string $member): mixed`

The metadata member name, e.g. `device_authorization_endpoint`.

| Parameter | Type | Description |
|---|---|---|
| `$member` | `string` | The metadata member name, e.g. `device_authorization_endpoint`. |

Returns `mixed` — The raw member value, or null if the document does not contain it.

### getAuthorizationEndpoint()

`public function getAuthorizationEndpoint(): string`

Returns `string` — The `authorization_endpoint`.

| Throws | When |
|---|---|
| `AuthenticationException` | If the document does not advertise one. |

### getCodeChallengeMethodsSupported()

`public function getCodeChallengeMethodsSupported(): array<int, string>`

Returns `array``<``int``, ``string``>` — The `code_challenge_methods_supported` list, or an empty list if absent.

### getEndSessionEndpoint()

`public function getEndSessionEndpoint(): ?string`

Returns `?``string` — The RP-initiated-logout `end_session_endpoint`, or null if the provider does not advertise one.

### getIdTokenSigningAlgValuesSupported()

`public function getIdTokenSigningAlgValuesSupported(): array<int, string>`

Returns `array``<``int``, ``string``>` — The `id_token_signing_alg_values_supported` list, or an empty list if absent.

### getIntrospectionEndpoint()

`public function getIntrospectionEndpoint(): ?string`

Returns `?``string` — The RFC 7662 `introspection_endpoint`, or null if the provider does not advertise one.

### getIssuer()

`public function getIssuer(): string`

Returns `string` — The provider's `issuer` identifier -- also the expected `iss` claim for tokens it mints.

### getJwksUri()

`public function getJwksUri(): string`

Returns `string` — The `jwks_uri`, e.g. to hand to `firebase/php-jwt`'s `CachedKeySet` for ID-token verification.

| Throws | When |
|---|---|
| `AuthenticationException` | If the document does not advertise one. |

### getMetadata()

`public function getMetadata(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>` — The full decoded metadata document.

### getResponseTypesSupported()

`public function getResponseTypesSupported(): array<int, string>`

Returns `array``<``int``, ``string``>` — The `response_types_supported` list, or an empty list if absent.

### getRevocationEndpoint()

`public function getRevocationEndpoint(): ?string`

Returns `?``string` — The RFC 7009 `revocation_endpoint`, or null if the provider does not advertise one.

### getScopesSupported()

`public function getScopesSupported(): array<int, string>`

Returns `array``<``int``, ``string``>` — The `scopes_supported` list, or an empty list if the provider does not advertise it (it is OPTIONAL, so empty does not mean "no scopes").

### getTokenEndpoint()

`public function getTokenEndpoint(): string`

Returns `string` — The `token_endpoint`.

| Throws | When |
|---|---|
| `AuthenticationException` | If the document does not advertise one. |

### getUserinfoEndpoint()

`public function getUserinfoEndpoint(): ?string`

Returns `?``string` — The `userinfo_endpoint`, or null if the provider does not advertise one.

### supportsPkceS256()

`public function supportsPkceS256(): bool`

A pre-flight check for [`OidcClient`](/api/security/auth/oidc-client/), which hardcodes PKCE S256 because OAuth 2.1 mandates it.

A provider that advertises `code_challenge_methods_supported` without `S256` will reject the authorization request; one that advertises nothing at all is not saying it lacks support (the member is OPTIONAL), so absence counts as unknown-but-allowed here.

Returns `bool` — False only if the provider advertises code-challenge methods and S256 is not among them.
