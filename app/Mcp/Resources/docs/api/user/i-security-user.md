# ISecurityUser

> SecurityUser provides advanced security manipulation methods.

SecurityUser provides advanced security manipulation methods.

## Synopsis

`interface ISecurityUser`

|  |  |
|---|---|
| Implemented by | [`SecurityUser`](/api/user/security-user/) |
| Since | `1.0.0` |
| Source | `User/ISecurityUser.php` |

## Methods

| Method | Description |
|---|---|
| [`addCredential(mixed $credential): void`](#addcredential) | Add a credential to this user. |
| [`clearCredentials(): void`](#clearcredentials) | Clear all credentials associated with this user. |
| [`hasCredentials(mixed $credential): bool`](#hascredentials) | Indicates whether or not this user has a credential. |
| [`isAuthenticated(): bool`](#isauthenticated) | Indicates whether or not this user is authenticated. |
| [`removeCredential(mixed $credential): void`](#removecredential) | Remove a credential from this user. |
| [`setAuthenticated(mixed $authenticated): void`](#setauthenticated) | Set the authenticated status of this user. |

### addCredential()

`abstract public function addCredential(mixed $credential): void`

Add a credential to this user.

Credential data.

| Parameter | Type | Description |
|---|---|---|
| `$credential` | `mixed` | Credential data. |

### clearCredentials()

`abstract public function clearCredentials(): void`

Clear all credentials associated with this user.

### hasCredentials()

`abstract public function hasCredentials(mixed $credential): bool`

Indicates whether or not this user has a credential.

Credential data.

| Parameter | Type | Description |
|---|---|---|
| `$credential` | `mixed` | Credential data. |

Returns `bool` — true, if this user has the credential, otherwise false.

### isAuthenticated()

`abstract public function isAuthenticated(): bool`

Indicates whether or not this user is authenticated.

Returns `bool` — true, if this user is authenticated, otherwise false.

### removeCredential()

`abstract public function removeCredential(mixed $credential): void`

Remove a credential from this user.

Credential data.

| Parameter | Type | Description |
|---|---|---|
| `$credential` | `mixed` | Credential data. |

### setAuthenticated()

`abstract public function setAuthenticated(mixed $authenticated): void`

Set the authenticated status of this user.

A flag indicating the authenticated status of this user.
                   Implementations are expected to reject truthy-but-non-bool values
                   (e.g. `1`) rather than coerce them.

| Parameter | Type | Description |
|---|---|---|
| `$authenticated` | `mixed` | A flag indicating the authenticated status of this user. Implementations are expected to reject truthy-but-non-bool values (e.g. `1`) rather than coerce them. |
