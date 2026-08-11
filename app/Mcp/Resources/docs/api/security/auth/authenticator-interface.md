# AuthenticatorInterface

> Generalizes `Quiote\\Mcp\\Auth\\McpAuthenticatorInterface` into a framework-wide contract: one implementation per credential mechanism (form login, HTTP Basic, bearer/JWT, OIDC).

Generalizes `Quiote\Mcp\Auth\McpAuthenticatorInterface` into a framework-wide contract: one implementation per credential mechanism (form login, HTTP Basic, bearer/JWT, OIDC).

A firewall runs its ordered authenticator chain, calling `supports()` to pick the first match, then `authenticate()`.

## Synopsis

`interface AuthenticatorInterface`

|  |  |
|---|---|
| Implemented by | [`FormLoginAuthenticator`](/api/security/auth/authenticator/form-login-authenticator/), [`HttpBasicAuthenticator`](/api/security/auth/authenticator/http-basic-authenticator/), [`BearerTokenAuthenticator`](/api/security/auth/bearer-token-authenticator/), [`OidcAuthenticator`](/api/security/auth/oidc-authenticator/) |
| Since | `1.0.0` |
| Source | `Security/Auth/AuthenticatorInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`authenticate(ServerRequestInterface $request): Passport`](#authenticate) | Extract and validate this authenticator's credential from $request and resolve it to an identity. |
| [`onFailure(AuthenticationException $exception): ?ResponseInterface`](#onfailure) | Optional authenticator-specific failure response (e.g. |
| [`supports(ServerRequestInterface $request): bool`](#supports) | Whether this authenticator can attempt to extract a credential from $request (e.g. |

### authenticate()

`abstract public function authenticate(ServerRequestInterface $request): Passport`

Extract and validate this authenticator's credential from $request and resolve it to an identity.

The incoming request. Only ever
                   called after supports() returned true for it.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. Only ever called after supports() returned true for it. |

Returns [`Passport`](/api/security/auth/passport/) — The resolved identity, credentials/roles, and statelessness flag.

| Throws | When |
|---|---|
| `AuthenticationException` | If the presented credential is absent, malformed, or invalid. |

### onFailure()

`abstract public function onFailure(AuthenticationException $exception): ?ResponseInterface`

Optional authenticator-specific failure response (e.g.

The exception thrown by authenticate().

| Parameter | Type | Description |
|---|---|---|
| `$exception` | [`AuthenticationException`](/api/security/auth/authentication-exception/) | The exception thrown by authenticate(). |

Returns `?`[`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — A response to short-circuit with, or null to defer to the firewall's entry point.

### supports()

`abstract public function supports(ServerRequestInterface $request): bool`

Whether this authenticator can attempt to extract a credential from $request (e.g.

The incoming request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |

Returns `bool` — True if this authenticator should attempt authenticate(), otherwise false.
