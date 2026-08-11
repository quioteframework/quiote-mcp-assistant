# LoginRedirectEntryPoint

> The entry point for the session/form-login firewall: a `302` redirect back to the login path.

The entry point for the session/form-login firewall: a `302` redirect back to the login path.

Complements, and does not duplicate, the existing anonymous-access forward already handled by `Quiote\Middleware\SecurityMiddleware` via `SecurityService::decide()` + `ForwardService` (unchanged -- authentication and authorization stay separate concerns) -- this entry point only fires when a login *attempt* itself fails (e.g. a bad password on the login POST), not on plain unauthenticated browsing.

## Synopsis

`final class LoginRedirectEntryPoint implements EntryPointInterface`

|  |  |
|---|---|
| Implements | [`EntryPointInterface`](/api/security/auth/entry-point-interface/) |
| Since | `1.0.0` |
| Source | `EntryPoint/LoginRedirectEntryPoint.php` |

## Constructor

### __construct()

`public function __construct(string $loginPath = '/login', string $errorQueryParameter = 'error'): mixed`

The query parameter appended to signal a failed attempt (e.g. `?error=1`).

| Parameter | Type | Description |
|---|---|---|
| `$loginPath` | `string` | The path to redirect back to. |
| `$errorQueryParameter` | `string` | The query parameter appended to signal a failed attempt (e.g. `?error=1`). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`start(ServerRequestInterface $request, AuthenticationException $exception): ResponseInterface`](#start) |  |

### start()

`public function start(ServerRequestInterface $request, AuthenticationException $exception): ResponseInterface`

The exception the failing authenticator threw.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The request that failed authentication (the login POST). |
| `$exception` | [`AuthenticationException`](/api/security/auth/authentication-exception/) | The exception the failing authenticator threw. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — A `302` redirect back to the login path with the error query parameter set.
