# StatelessAuthenticationMiddleware

> Runs stateless firewalls' authenticator chains (HTTP Basic, and -- once `packages/auth-jwt` is installed -- bearer/JWT) before routing and before `Quiote\\Middleware\\SessionMiddleware`, matching firewalls by request path.

Runs stateless firewalls' authenticator chains (HTTP Basic, and -- once `packages/auth-jwt` is installed -- bearer/JWT) before routing and before `Quiote\Middleware\SessionMiddleware`, matching firewalls by request path.

Registered by [`AuthPlugin`](/api/security/auth/auth-plugin/) with an explicit `before: Quiote\Middleware\SessionMiddleware::class` anchor rather than relying on a bare phase/priority: `MiddlewarePhase::ORDER` places the `bootstrap` phase (where `SessionMiddleware` sits at priority 900) ahead of the `pre_routing`/`pre` phases unconditionally, so only an explicit edge guarantees this runs first -- letting a machine-client token signal "no session" (via the `auth.sessionless` request attribute) before session startup.

## Synopsis

`final class StatelessAuthenticationMiddleware implements MiddlewareInterface`

|  |  |
|---|---|
| Implements | [`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/) |
| Since | `1.0.0` |
| Source | `Middleware/StatelessAuthenticationMiddleware.php` |

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

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) — The next middleware's response, or the firewall's entry-point response on an invalid credential.
