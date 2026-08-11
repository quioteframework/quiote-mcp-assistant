# EntryPoint

> The Quiote\\Security\\Auth\\EntryPoint namespace — 2 documented types.

Everything under `Quiote\Security\Auth\EntryPoint`.

## Classes

| Class | Description |
|---|---|
| [`HttpChallengeEntryPoint`](/api/security/auth/entry-point/http-challenge-entry-point/) | The entry point for stateless (token/Basic) firewalls: a `401` RFC 9457 Problem Details body plus a `WWW-Authenticate` challenge, matching `Quiote\Mcp\Middleware\McpAuthMiddleware`'s existing shape so API clients see one consistent failure format across the framework. |
| [`LoginRedirectEntryPoint`](/api/security/auth/entry-point/login-redirect-entry-point/) | The entry point for the session/form-login firewall: a `302` redirect back to the login path. |
