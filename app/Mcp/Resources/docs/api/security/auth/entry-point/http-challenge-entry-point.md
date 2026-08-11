# HttpChallengeEntryPoint

> The entry point for stateless (token/Basic) firewalls: a `401` RFC 9457 Problem Details body plus a `WWW-Authenticate` challenge, matching `Quiote\\Mcp\\Middleware\\McpAuthMiddleware`'s existing shape so API clients see one consistent failure format across the framework.

The entry point for stateless (token/Basic) firewalls: a `401` RFC 9457 Problem Details body plus a `WWW-Authenticate` challenge, matching `Quiote\Mcp\Middleware\McpAuthMiddleware`'s existing shape so API clients see one consistent failure format across the framework.

## Synopsis

`final class HttpChallengeEntryPoint implements EntryPointInterface`

|  |  |
|---|---|
| Implements | [`EntryPointInterface`](/api/security/auth/entry-point-interface/) |
| Since | `1.0.0` |
| Source | `EntryPoint/HttpChallengeEntryPoint.php` |

## Constructor

### __construct()

`public function __construct(string $scheme = 'Bearer', ?string $realm = null): mixed`

An optional `realm` parameter to include in the challenge.

| Parameter | Type | Description |
|---|---|---|
| `$scheme` | `string` | The `WWW-Authenticate` scheme (e.g. `Bearer`, `Basic`). |
| `$realm` | `?``string` | An optional `realm` parameter to include in the challenge. |

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
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The request that failed authentication. |
| `$exception` | [`AuthenticationException`](/api/security/auth/authentication-exception/) | The exception the failing authenticator threw. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — A `401` response with a `WWW-Authenticate` header and an RFC 9457 Problem Details body.
