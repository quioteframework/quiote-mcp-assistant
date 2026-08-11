# Authenticator

> The Quiote\\Security\\Auth\\Authenticator namespace — 2 documented types.

Everything under `Quiote\Security\Auth\Authenticator`.

## Classes

| Class | Description |
|---|---|
| [`FormLoginAuthenticator`](/api/security/auth/authenticator/form-login-authenticator/) | Verifies a username/password login POST via a [`UserProviderInterface`](/api/security/auth/user-provider-interface/)/[`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) pair. |
| [`HttpBasicAuthenticator`](/api/security/auth/authenticator/http-basic-authenticator/) | Decodes an `Authorization: Basic` header and verifies it against a [`UserProviderInterface`](/api/security/auth/user-provider-interface/)/[`PasswordHasherInterface`](/api/security/auth/password-hasher-interface/) pair. |
