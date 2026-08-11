# BearerTokenAuthenticator

> Validates an `Authorization: Bearer` token via a TokenValidatorInterface (JWS verify + `iss`/`aud`), derives its ClientType via a ClientTypeResolverInterface, and resolves the identity via UserProviderInterface::loadByToken().

Validates an `Authorization: Bearer` token via a [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/) (JWS verify + `iss`/`aud`), derives its [`ClientType`](/api/security/auth/client-type/) via a [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/), and resolves the identity via [`UserProviderInterface::loadByToken()`](/api/security/auth/user-provider-interface/#loadbytoken).

Always stateless: identity is re-derived from the token every request. A `service` client type is what flips a request to `auth.sessionless` (applied by `StatelessAuthenticationMiddleware`, not here).

## Synopsis

`final class BearerTokenAuthenticator implements AuthenticatorInterface`

|  |  |
|---|---|
| Implements | [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) |
| Since | `1.0.0` |
| Source | `BearerTokenAuthenticator.php` |

## Constructor

### __construct()

`public function __construct(TokenValidatorInterface $validator, ClientTypeResolverInterface $clientTypeResolver, UserProviderInterface $userProvider): mixed`

Resolves the validated claims to an identity.

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`TokenValidatorInterface`](/api/security/auth/token-validator-interface/) | Verifies the token's signature and `iss`/`aud`/time claims. |
| `$clientTypeResolver` | [`ClientTypeResolverInterface`](/api/security/auth/client-type-resolver-interface/) | Derives human-vs-machine from the validated claims. |
| `$userProvider` | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) | Resolves the validated claims to an identity. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authenticate(ServerRequestInterface $request): Passport`](#authenticate) |  |
| [`onFailure(AuthenticationException $exception): null`](#onfailure) |  |
| [`supports(ServerRequestInterface $request): bool`](#supports) |  |

### authenticate()

`public function authenticate(ServerRequestInterface $request): Passport`

The incoming request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |

Returns [`Passport`](/api/security/auth/passport/) — The resolved identity, always stateless (re-derived from the token every request).

| Throws | When |
|---|---|
| `AuthenticationException` | If the token is missing, invalid, or its claims don't resolve to a known identity. |

### onFailure()

`public function onFailure(AuthenticationException $exception): null`

The exception thrown by authenticate().

| Parameter | Type | Description |
|---|---|---|
| `$exception` | [`AuthenticationException`](/api/security/auth/authentication-exception/) | The exception thrown by authenticate(). |

Returns `null` — Always null: defers to the firewall's HttpChallengeEntryPoint.

### supports()

`public function supports(ServerRequestInterface $request): bool`

The incoming request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |

Returns `bool` — True if $request carries an `Authorization: Bearer` header, otherwise false.
