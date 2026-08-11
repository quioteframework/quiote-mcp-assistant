# SessionAuthenticationMiddleware

> Runs the session/form-login firewall's authenticator chain in `before_action`, after `Quiote\\Middleware\\RoutingMiddleware` (so `SecurityUser` is already rehydrated) and before `Quiote\\Middleware\\SecurityMiddleware` (so a successful login is visible to the authZ decision made later in the same request).

Runs the session/form-login firewall's authenticator chain in `before_action`, after `Quiote\Middleware\RoutingMiddleware` (so `SecurityUser` is already rehydrated) and before `Quiote\Middleware\SecurityMiddleware` (so a successful login is visible to the authZ decision made later in the same request).

Registered by [`AuthPlugin`](/api/security/auth/auth-plugin/) with explicit `after:`/`before:` anchors rather than a bare phase/priority, so its position stays correct regardless of how other middleware are reordered.

## Synopsis

`final class SessionAuthenticationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Since | `1.0.0` |
| Source | `Middleware/SessionAuthenticationMiddleware.php` |

## Constructor

### __construct()

`public function __construct(FirewallMap $firewalls, AuthenticationManager $manager): mixed`

Runs the matched firewall's authenticator chain.

| Parameter | Type | Description |
|---|---|---|
| `$firewalls` | [`FirewallMap`](/api/security/auth/firewall-map/) | The configured firewalls, matched by request path. |
| `$manager` | [`AuthenticationManager`](/api/security/auth/authentication-manager/) | Runs the matched firewall's authenticator chain. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`](#process) |  |

### process()

`public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

The next middleware in the pipeline.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |
| `$handler` | [`RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/) | The next middleware in the pipeline. |

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — The next middleware's response, or the firewall's entry-point response on a failed login attempt.
