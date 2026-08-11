# FormLoginAuthenticator

> Verifies a username/password login POST via a UserProviderInterface/PasswordHasherInterface pair.

Verifies a username/password login POST via a [`UserProviderInterface`](/api/security/auth/user-provider-interface/)/[`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) pair.

A service the app's own login endpoint/action calls directly -- the framework ships no login page or form-rendering logic, only this verification step -- but it also implements [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) so it can sit in a firewall's authenticator chain and be matched by `supports()` against the configured login-check path.

`packages/csrf` and `packages/ratelimit` are soft dependencies: pass a [`CsrfManager`](/api/security/csrf/csrf-manager/)/[`LoginThrottle`](/api/security/rate-limit/login-throttle/) instance to enable CSRF verification / brute-force throttling, or omit them to skip both.

## Synopsis

`final class FormLoginAuthenticator implements AuthenticatorInterface`

|  |  |
|---|---|
| Implements | [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) |
| Since | `1.0.0` |
| Source | `Authenticator/FormLoginAuthenticator.php` |

## Constructor

### __construct()

`public function __construct(UserProviderInterface $userProvider, PasswordHasherInterface $passwordHasher, string $checkPath = '/login', string $identifierField = 'username', string $passwordField = 'password', ?CsrfManager $csrf = null, ?LoginThrottle $throttle = null): mixed`

When given, failed attempts are throttled per identifier (see `packages/ratelimit`).

| Parameter | Type | Description |
|---|---|---|
| `$userProvider` | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) | Resolves the submitted identifier field to an identity. |
| `$passwordHasher` | [`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) | Verifies the submitted password against the identity's stored hash. |
| `$checkPath` | `string` | The path a login POST is submitted to (matched by supports()). |
| `$identifierField` | `string` | The form field name holding the username/email. |
| `$passwordField` | `string` | The form field name holding the password. |
| `$csrf` | `?`[`CsrfManager`](/api/security/csrf/csrf-manager/) | When given, the submitted CSRF token is validated (see `packages/csrf`). |
| `$throttle` | `?`[`LoginThrottle`](/api/security/rate-limit/login-throttle/) | When given, failed attempts are throttled per identifier (see `packages/ratelimit`). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authenticate(ServerRequestInterface $request): Passport`](#authenticate) |  |
| [`onFailure(AuthenticationException $exception): null`](#onfailure) |  |
| [`supports(ServerRequestInterface $request): bool`](#supports) |  |

### authenticate()

`public function authenticate(ServerRequestInterface $request): Passport`

The incoming login POST request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming login POST request. |

Returns [`Passport`](/api/security/auth/passport/) — The resolved identity, session-backed (not stateless).

| Throws | When |
|---|---|
| `AuthenticationException` | If the form data, CSRF token, or credentials are missing/invalid, or the throttle is exhausted. |

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

Returns `bool` — True if $request is a POST to the configured login-check path, otherwise false.
