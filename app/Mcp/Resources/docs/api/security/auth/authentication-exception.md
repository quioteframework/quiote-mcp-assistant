# AuthenticationException

> Thrown by an AuthenticatorInterface when a presented credential (password, Basic header, bearer token, ...) fails to establish an identity.

Thrown by an [`AuthenticatorInterface`](/api/security/auth/authenticator-interface/) when a presented credential (password, Basic header, bearer token, ...) fails to establish an identity.

Caught by `Quiote\Security\Auth\AuthenticationManager` (`packages/auth`) and routed to the matching firewall's [`EntryPointInterface`](/api/security/auth/entry-point-interface/).

## Synopsis

`class AuthenticationException extends RuntimeException`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Since | `1.0.0` |
| Source | `Security/Auth/AuthenticationException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
