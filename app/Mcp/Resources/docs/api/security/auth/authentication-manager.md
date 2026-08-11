# AuthenticationManager

> Runs a firewall's authenticator chain against a request and, on success, populates the request's `SecurityUser`/`RbacSecurityUser`.

Runs a firewall's authenticator chain against a request and, on success, populates the request's `SecurityUser`/`RbacSecurityUser`.

AuthN only -- the existing authZ path (`SecurityService`/`SecurityMiddleware`) is unchanged and runs independently afterward.

## Synopsis

`final class AuthenticationManager`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `AuthenticationManager.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller): mixed`

The owning context's Controller, used to reach its `SecurityUser`.

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) | The owning context's Controller, used to reach its `SecurityUser`. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`authenticate(ServerRequestInterface $request, Firewall $firewall): ?Passport`](#authenticate) | Tries each of $firewall's authenticators in declaration order and stops at the first one whose supports() matches $request. |

### authenticate()

`public function authenticate(ServerRequestInterface $request, Firewall $firewall): ?Passport`

Tries each of $firewall's authenticators in declaration order and stops at the first one whose supports() matches $request.

The firewall matched for this request.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |
| `$firewall` | [`Firewall`](/api/security/auth/firewall/) | The firewall matched for this request. |

Returns `?`[`Passport`](/api/security/auth/passport/) — The successful passport, or null if no authenticator supported this request.

| Throws | When |
|---|---|
| `AuthenticationException` | If the matching authenticator's credential was present but invalid. |
