# Middleware

> The Quiote\\Security\\Csrf\\Middleware namespace — 2 documented types.

Everything under `Quiote\Security\Csrf\Middleware`.

## Classes

| Class | Description |
|---|---|
| [`CsrfInjectionMiddleware`](/api/security/csrf/middleware/csrf-injection-middleware/) | Delivers the CSRF token to clients so they can echo it back on unsafe requests. |
| [`CsrfValidationMiddleware`](/api/security/csrf/middleware/csrf-validation-middleware/) | Verifies a CSRF token on every unsafe (state-changing) request before the action is dispatched. |
