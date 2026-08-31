# Csrf

> The Quiote\\Security\\Csrf namespace — 6 documented types.

Everything under `Quiote\Security\Csrf`.

## Classes

| Class | Description |
|---|---|
| [`CsrfManager`](/api/security/csrf/csrf-manager/) | Application-facing CSRF helper. |
| [`CsrfPlugin`](/api/security/csrf/csrf-plugin/) | Registers the CSRF middleware pair through the generic plugin seam instead of [`MiddlewarePipeline`](/api/middleware/middleware-pipeline/) hardcoding them. |
| [`RandomnessBackedTokenGenerator`](/api/security/csrf/randomness-backed-token-generator/) | A drop-in replacement for Symfony's default `UriSafeTokenGenerator`, generating the same URI-safe base64 shape but through [`RandomnessInterface`](/api/support/random/randomness-interface/) instead of a direct `random_bytes()` call -- so a cassette that records the [`RandomnessInterface`](/api/support/random/randomness-interface/) reads behind a CSRF token can reproduce that exact token value on replay, and a request whose form POST depends on it does not fail the CSRF check purely because the token could not be regenerated deterministically. |
| [`SessionTokenStorage`](/api/security/csrf/session-token-storage/) | Symfony CSRF TokenStorage backed by Quiote's session. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Middleware`](/api/security/csrf/middleware/) | 2 types |
