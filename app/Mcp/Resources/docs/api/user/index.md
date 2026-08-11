# User

> The Quiote\\User namespace — 5 documented types.

Everything under `Quiote\User`.

## Classes

| Class | Description |
|---|---|
| [`CurrentUser`](/api/user/current-user/) | The seam onto the user of the request being served *now*. |
| [`RbacSecurityUser`](/api/user/rbac-security-user/) | RbacUser will handle roles and permissions for users |
| [`SecurityUser`](/api/user/security-user/) | BasicSecurityUser will handle any type of data as a credential. |
| [`User`](/api/user/user/) | User wraps a client session and provides accessor methods for user attributes. |

## Interfaces

| Interface | Description |
|---|---|
| [`ISecurityUser`](/api/user/i-security-user/) | SecurityUser provides advanced security manipulation methods. |
