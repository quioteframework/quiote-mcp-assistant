# OidcAuthenticator

> The callback leg of the OIDC Authorization Code + PKCE flow: verifies `state` (exact, constant-time comparison), exchanges the code for tokens via OidcClient, validates the ID token (signature/`iss`/ `aud` via the injected TokenValidatorInterface, plus our own `nonce` check -- `at_hash` is intentionally not checked: it is only REQUIRED by OIDC core when an access token is returned from the *authorization* endpoint (implicit/hybrid flows), and OPTIONAL for a pure Authorization Code exchange at the *token* endpoint, which is the only flow this class implements), then maps the claims to a `UserIdentity` via `UserProviderInterface::loadByToken()` -- the same seam `packages/auth-jwt`'s `BearerTokenAuthenticator` uses.

The callback leg of the OIDC Authorization Code + PKCE flow: verifies `state` (exact, constant-time comparison), exchanges the code for tokens via [`OidcClient`](/api/security/auth/oidc-client/), validates the ID token (signature/`iss`/ `aud` via the injected [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/), plus our own `nonce` check -- `at_hash` is intentionally not checked: it is only REQUIRED by OIDC core when an access token is returned from the *authorization* endpoint (implicit/hybrid flows), and OPTIONAL for a pure Authorization Code exchange at the *token* endpoint, which is the only flow this class implements), then maps the claims to a `UserIdentity` via `UserProviderInterface::loadByToken()` -- the same seam `packages/auth-jwt`'s `BearerTokenAuthenticator` uses.

Does not initiate the flow: building the authorization redirect (via [`OidcClient::buildAuthorizationRequest()`](/api/security/auth/oidc-client/#buildauthorizationrequest)) is left to the app's own login-initiation code (e.g. its login action/controller), since only the app knows when it wants to redirect to the identity provider versus showing another login option.

## Synopsis

`final class OidcAuthenticator implements AuthenticatorInterface`

|  |  |
|---|---|
| Implements | [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) |
| Since | `1.0.0` |
| Source | `OidcAuthenticator.php` |

## Constructor

### __construct()

`public function __construct(OidcClient $client, TokenValidatorInterface $idTokenValidator, UserProviderInterface $userProvider, OidcStateStorage $stateStorage, string $callbackPath): mixed`

The path the identity provider redirects back to (matched by supports()).

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`OidcClient`](/api/security/auth/oidc-client/) | Exchanges the authorization code for tokens. |
| `$idTokenValidator` | [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/) | Verifies the ID token's signature and `iss`/`aud`/time claims. |
| `$userProvider` | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) | Resolves the validated ID-token claims to an identity. |
| `$stateStorage` | [`OidcStateStorage`](/api/security/auth/oidc-state-storage/) | Retrieves the state/PKCE-verifier/nonce persisted before the redirect. |
| `$callbackPath` | `string` | The path the identity provider redirects back to (matched by supports()). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authenticate(ServerRequestInterface $request): Passport`](#authenticate) |  |
| [`onFailure(AuthenticationException $exception): null`](#onfailure) |  |
| [`supports(ServerRequestInterface $request): bool`](#supports) |  |

### authenticate()

`public function authenticate(ServerRequestInterface $request): Passport`

The incoming OIDC callback request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming OIDC callback request. |

Returns [`Passport`](/api/security/auth/passport/) — The resolved identity, session-backed (not stateless).

| Throws | When |
|---|---|
| `AuthenticationException` | If the code/state are missing, the state/nonce don't match, the token exchange fails, or the claims don't resolve to a known identity. |

### onFailure()

`public function onFailure(AuthenticationException $exception): null`

The exception thrown by authenticate().

| Parameter | Type | Description |
|---|---|---|
| `$exception` | [`AuthenticationException`](/api/security/auth/authentication-exception/) | The exception thrown by authenticate(). |

Returns `null` — Always null: defers to the firewall's LoginRedirectEntryPoint.

### supports()

`public function supports(ServerRequestInterface $request): bool`

The incoming request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |

Returns `bool` — True if $request is the OIDC callback (matches $callbackPath and carries `code`/`state`), otherwise false.
