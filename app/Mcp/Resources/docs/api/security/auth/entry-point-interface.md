# EntryPointInterface

> Produces the failure response for a firewall when authentication is required but absent/invalid: a `LoginRedirectEntryPoint` (reuses the existing `ForwardService` login flow) for session/form firewalls, or an `HttpChallengeEntryPoint` (401 + `WWW-Authenticate`, RFC 7807 JSON, matching `Quiote\\Mcp\\Middleware\\McpAuthMiddleware`) for token firewalls.

Produces the failure response for a firewall when authentication is required but absent/invalid: a `LoginRedirectEntryPoint` (reuses the existing `ForwardService` login flow) for session/form firewalls, or an `HttpChallengeEntryPoint` (401 + `WWW-Authenticate`, RFC 7807 JSON, matching `Quiote\Mcp\Middleware\McpAuthMiddleware`) for token firewalls.

## Synopsis

`interface EntryPointInterface`

|  |  |
|---|---|
| Implemented by | [`HttpChallengeEntryPoint`](/api/security/auth/entry-point/http-challenge-entry-point/), [`LoginRedirectEntryPoint`](/api/security/auth/entry-point/login-redirect-entry-point/) |
| Since | `1.0.0` |
| Source | `Security/Auth/EntryPointInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`start(ServerRequestInterface $request, AuthenticationException $exception): ResponseInterface`](#start) |  |

### start()

`abstract public function start(ServerRequestInterface $request, AuthenticationException $exception): ResponseInterface`

The exception the failing authenticator threw.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The request that failed authentication. |
| `$exception` | [`AuthenticationException`](/api/security/auth/authentication-exception/) | The exception the failing authenticator threw. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — The response to send instead of continuing the pipeline.
