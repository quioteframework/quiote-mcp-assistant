# HttpBasicAuthenticator

> Decodes an `Authorization: Basic` header and verifies it against a UserProviderInterface/PasswordHasherInterface pair.

Decodes an `Authorization: Basic` header and verifies it against a [`UserProviderInterface`](/api/security/auth/user-provider-interface/)/[`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) pair.

Stateless: identity is re-derived from the header every request.

`packages/ratelimit` is a soft dependency: pass a [`LoginThrottle`](/api/security/rate-limit/login-throttle/) to enable brute-force throttling, or omit it to skip it. It matters more here than on [`FormLoginAuthenticator`](/api/security/auth/authenticator/form-login-authenticator/) -- a Basic credential rides on every request with no form to fetch, no token to obtain and no session to establish first, so an unthrottled Basic surface is the cheapest password-guessing target an application can expose.

## Synopsis

`final class HttpBasicAuthenticator implements AuthenticatorInterface`

|  |  |
|---|---|
| Implements | [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) |
| Since | `1.0.0` |
| Source | `Authenticator/HttpBasicAuthenticator.php` |

## Constructor

### __construct()

`public function __construct(UserProviderInterface $userProvider, PasswordHasherInterface $passwordHasher, ?LoginThrottle $throttle = null): mixed`

When given, failed attempts are throttled per identifier and per client (see `packages/ratelimit`).

| Parameter | Type | Description |
|---|---|---|
| `$userProvider` | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) | Resolves the decoded username to an identity. |
| `$passwordHasher` | [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) | Verifies the decoded password against the identity's stored hash. |
| `$throttle` | `?`[`LoginThrottle`](/api/security/rate-limit/login-throttle/) | When given, failed attempts are throttled per identifier and per client (see `packages/ratelimit`). |

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

Returns [`Passport`](/api/security/auth/passport/) — The resolved identity, stateless (re-derived from the header every request).

| Throws | When |
|---|---|
| `AuthenticationException` | If the header is malformed, credentials are missing, the user is unknown, the password is wrong, or the throttle is exhausted. |

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

Returns `bool` — True if $request carries an `Authorization: Basic` header, otherwise false.
