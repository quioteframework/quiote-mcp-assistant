# Middleware

> The Quiote\\Security\\Auth\\Middleware namespace — 2 documented types.

Everything under `Quiote\Security\Auth\Middleware`.

## Classes

| Class | Description |
|---|---|
| [`SessionAuthenticationMiddleware`](/api/security/auth/middleware/session-authentication-middleware/) | Runs the session/form-login firewall's authenticator chain in `before_action`, after `Quiote\Middleware\RoutingMiddleware` (so `SecurityUser` is already rehydrated) and before `Quiote\Middleware\SecurityMiddleware` (so a successful login is visible to the authZ decision made later in the same request). |
| [`StatelessAuthenticationMiddleware`](/api/security/auth/middleware/stateless-authentication-middleware/) | Runs stateless firewalls' authenticator chains (HTTP Basic, and -- once `packages/auth-jwt` is installed -- bearer/JWT) before routing and before `Quiote\Middleware\SessionMiddleware`, matching firewalls by request path. |
