# Cors

> The Quiote\\Security\\Cors namespace — 2 documented types.

Everything under `Quiote\Security\Cors`.

## Classes

| Class | Description |
|---|---|
| [`CorsMiddleware`](/api/security/cors/cors-middleware/) | Cross-Origin Resource Sharing (CORS) handling. |
| [`CorsPlugin`](/api/security/cors/cors-plugin/) | Registers [`CorsMiddleware`](/api/security/cors/cors-middleware/) through the generic plugin seam, opt-in via `cors.enabled` (the middleware itself no-ops when it's false, so simply installing this package doesn't turn CORS on for every app). |
