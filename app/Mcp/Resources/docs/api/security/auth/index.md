# Auth

> The Quiote\\Security\\Auth namespace — 46 documented types.

Everything under `Quiote\Security\Auth`.

## Classes

| Class | Description |
|---|---|
| [`AuthPlugin`](/api/security/auth/auth-plugin/) | Registers the authentication foundation: a default [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/), an empty (no-op) default [`FirewallMap`](/api/security/auth/firewall-map/), and two `AuthenticationMiddleware` placements ([`StatelessAuthenticationMiddleware`](/api/security/auth/middleware/stateless-authentication-middleware/) before `Quiote\Middleware\SessionMiddleware`, so a machine token can flip a request to sessionless before session startup; [`SessionAuthenticationMiddleware`](/api/security/auth/middleware/session-authentication-middleware/) before `Quiote\Middleware\SecurityMiddleware`, so a successful login is visible to the same request's authorization decision). |
| [`AuthenticationException`](/api/security/auth/authentication-exception/) | Thrown by an [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) when a presented credential (password, Basic header, bearer token, ...) fails to establish an identity. |
| [`AuthenticationManager`](/api/security/auth/authentication-manager/) | Runs a firewall's authenticator chain against a request and, on success, populates the request's `SecurityUser`/`RbacSecurityUser`. |
| [`AuthorizationHeader`](/api/security/auth/authorization-header/) | Parses an `Authorization` header into its scheme and credential, the way RFC 9110 §11.6.2 actually specifies it rather than the way the wire format usually looks. |
| [`BearerTokenAuthenticator`](/api/security/auth/bearer-token-authenticator/) | Validates an `Authorization: Bearer` token via a [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/) (JWS verify + `iss`/`aud`), derives its [`ClientType`](/api/security/auth/client-type/) via a [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/), and resolves the identity via [`UserProviderInterface::loadByToken()`](/api/security/auth/user-provider-interface/#loadbytoken). |
| [`ClientAddress`](/api/security/auth/client-address/) | The connecting peer's address, for use as a throttle key. |
| [`ClientCredentialsClient`](/api/security/auth/client-credentials-client/) | Outbound M2M: fetches an access token via the Client Credentials grant for the app to present to another service. |
| [`ClientTypeResolver`](/api/security/auth/client-type-resolver/) | The default [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/): applies the RFC 9068 rule -- `service` when the token's `sub` equals its `client_id`/`azp` (the authority mints machine/client-credentials tokens this way), otherwise `user`. |
| [`Firewall`](/api/security/auth/firewall/) | A named, path-matched set of authenticators plus the entry point that handles a failed authentication attempt for that path -- the runtime counterpart of a `security.xml` `<firewall>` element. |
| [`FirewallMap`](/api/security/auth/firewall-map/) | An ordered list of [`Firewall`](/api/security/auth/firewall/) definitions, matched by request path. |
| [`IntrospectionClient`](/api/security/auth/introspection-client/) | A ~30-line RFC 7662 (OAuth 2.0 Token Introspection) POST helper -- `league/oauth2-client` has none. |
| [`JwtAuthPlugin`](/api/security/auth/jwt-auth-plugin/) | Registers the default [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/) (the RFC 9068 rule -- see [`ClientTypeResolver`](/api/security/auth/client-type-resolver/)). |
| [`JwtTokenValidator`](/api/security/auth/jwt-token-validator/) | Verifies a JWS via `firebase/php-jwt` (JWKS + rotation via `CachedKeySet` for RS256/ES256, or a single `Key` for a shared HS256 secret) and enforces `iss`/`aud` -- the library itself only checks `exp`/`nbf`/`iat`. |
| [`OidcAuthenticator`](/api/security/auth/oidc-authenticator/) | The callback leg of the OIDC Authorization Code + PKCE flow: verifies `state` (exact, constant-time comparison), exchanges the code for tokens via [`OidcClient`](/api/security/auth/oidc-client/), validates the ID token (signature/`iss`/ `aud` via the injected [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/), plus our own `nonce` check -- `at_hash` is intentionally not checked: it is only REQUIRED by OIDC core when an access token is returned from the *authorization* endpoint (implicit/hybrid flows), and OPTIONAL for a pure Authorization Code exchange at the *token* endpoint, which is the only flow this class implements), then maps the claims to a `UserIdentity` via `UserProviderInterface::loadByToken()` -- the same seam `packages/auth-jwt`'s `BearerTokenAuthenticator` uses. |
| [`OidcAuthorizationRequest`](/api/security/auth/oidc-authorization-request/) | The result of [`OidcClient::buildAuthorizationRequest()`](/api/security/auth/oidc-client/#buildauthorizationrequest): the URL to redirect the browser to, plus the state/PKCE-verifier/nonce the caller must persist (e.g. |
| [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) | The per-attempt secrets an OIDC auth-code + PKCE flow must round-trip through the user's session between the authorization redirect and the callback: the CSRF-style `state`, the PKCE `code_verifier`, and the OIDC `nonce` (replay/injection protection for the ID token). |
| [`OidcClient`](/api/security/auth/oidc-client/) | Wraps `league/oauth2-client`'s generic provider (via [`SpaceDelimitedScopeProvider`](/api/security/auth/space-delimited-scope-provider/), which fixes the library's comma-delimited `scope` parameter) for the OIDC Authorization Code flow. |
| [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/) | Fetches an OpenID provider's metadata from `{issuer}/.well-known/openid-configuration` (OpenID Connect Discovery 1.0 §4) so an app can wire [`OidcClient`](/api/security/auth/oidc-client/), [`ClientCredentialsClient`](/api/security/auth/client-credentials-client/), [`IntrospectionClient`](/api/security/auth/introspection-client/) and `auth-jwt`'s JWKS key set from one issuer URL instead of five hand-copied endpoint strings that silently rot when the provider moves them. |
| [`OidcDiscoveryDocument`](/api/security/auth/oidc-discovery-document/) | An immutable OpenID Provider metadata document (OpenID Connect Discovery 1.0 §3, a superset of RFC 8414 authorization-server metadata), as fetched by [`OidcDiscoveryClient`](/api/security/auth/oidc-discovery-client/). |
| [`OidcStateStorage`](/api/security/auth/oidc-state-storage/) | Persists a single in-flight [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) in the session-backed `Context` storage, keyed by its own `state` value so a concurrent second login attempt in another tab doesn't clobber the first. |
| [`Passport`](/api/security/auth/passport/) | The resolved outcome of a successful [`AuthenticatorInterface::authenticate()`](/api/security/auth/authenticator-interface/#authenticate) call: the identity plus the credentials/roles to grant, and whether the identity is stateless (re-derived from the credential every request rather than read back from the session). |
| [`SpaceDelimitedScopeProvider`](/api/security/auth/space-delimited-scope-provider/) | `league/oauth2-client`'s `AbstractProvider::getScopeSeparator()` returns a comma and `GenericProvider` does not override it, so a multi-scope authorization request comes out as `scope=openid%2Cprofile%2Cemail`. |
| [`TokenClaims`](/api/security/auth/token-claims/) | Validated claims from a bearer/JWT/OIDC token, plus the [`ClientType`](/api/security/auth/client-type/) derived from them by a [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/). |

## Interfaces

| Interface | Description |
|---|---|
| [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) | Generalizes `Quiote\Mcp\Auth\McpAuthenticatorInterface` into a framework-wide contract: one implementation per credential mechanism (form login, HTTP Basic, bearer/JWT, OIDC). |
| [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/) | Derives [`ClientType`](/api/security/auth/client-type/) from a set of already-validated token claims. |
| [`EntryPointInterface`](/api/security/auth/entry-point-interface/) | Produces the failure response for a firewall when authentication is required but absent/invalid: a `LoginRedirectEntryPoint` (reuses the existing `ForwardService` login flow) for session/form firewalls, or an `HttpChallengeEntryPoint` (401 + `WWW-Authenticate`, RFC 7807 JSON, matching `Quiote\Mcp\Middleware\McpAuthMiddleware`) for token firewalls. |
| [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) | Thin contract over PHP's `password_hash()` family, so `FormLoginAuthenticator`/`HttpBasicAuthenticator` (both in the future `packages/auth`) depend on an interface rather than the global functions directly. |
| [`PasswordProtectedUserIdentity`](/api/security/auth/password-protected-user-identity/) | A [`UserIdentity`](/api/security/auth/user-identity/) that can be checked against a password, resolved by `InMemoryUserProvider`/`PdoUserProvider`/`CallableUserProvider` and consumed by `FormLoginAuthenticator`/`HttpBasicAuthenticator` via [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/). |
| [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/) | Verifies a bearer token's signature and standard time claims (`exp`/`nbf`/`iat`) and returns its raw claim set. |
| [`UserIdentity`](/api/security/auth/user-identity/) | The identity a [`UserProviderInterface`](/api/security/auth/user-provider-interface/) resolves a credential to, before it is mapped onto a `Quiote\User\SecurityUser`/`RbacSecurityUser` by `Quiote\Security\Auth\AuthenticationManager` (`packages/auth`). |
| [`UserProviderInterface`](/api/security/auth/user-provider-interface/) | Loads a [`UserIdentity`](/api/security/auth/user-identity/) either by a stable identifier (form login, HTTP Basic) or from validated token claims (bearer/JWT/OIDC). |

## Enums

| Enum | Description |
|---|---|
| [`ClientType`](/api/security/auth/client-type/) | Distinguishes a human end-user from a machine/service caller, per the RFC 9068 rule applied by [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/): `Service` when the token's `sub` equals its `client_id`/`azp`, otherwise `User`. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Authenticator`](/api/security/auth/authenticator/) | 2 types |
| [`Config`](/api/security/auth/config/) | 2 types |
| [`EntryPoint`](/api/security/auth/entry-point/) | 2 types |
| [`Hasher`](/api/security/auth/hasher/) | 2 types |
| [`Identity`](/api/security/auth/identity/) | 1 type |
| [`Middleware`](/api/security/auth/middleware/) | 2 types |
| [`Provider`](/api/security/auth/provider/) | 3 types |
