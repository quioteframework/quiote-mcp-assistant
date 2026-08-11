# RbacSecurityUser

> RbacUser will handle roles and permissions for users

RbacUser will handle roles and permissions for users

## Synopsis

`class RbacSecurityUser extends SecurityUser`

|  |  |
|---|---|
| Extends | [`SecurityUser`](/api/user/security-user/) |
| Since | `1.0.0` |
| Source | `User/RbacSecurityUser.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ROLES_NAMESPACE` | `'org.quiote.user.RbacSecurityUser.roles'` | The namespace under which roles will be stored. |

## Methods

| Method | Description |
|---|---|
| [`getRoles(): array<int, string>`](#getroles) | Return a list of roles this user has been granted. |
| [`grantRole(string $role): void`](#grantrole) | Set a role membership for this user. |
| [`grantRoles(array<int, string> $roles): void`](#grantroles) | Set many role memberships for this user. |
| [`hasRole(string $role): bool`](#hasrole) | Check whether or not a user is a member of a certain role. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this User. |
| [`reset(): void`](#reset) | Clears the role state on top of the parent reset. |
| [`revokeAllRoles(): void`](#revokeallroles) | Revoke all roles. |
| [`revokeRole(string $role): void`](#revokerole) | Revoke a role membership for this user. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |

### getRoles()

`public function getRoles(): array<int, string>`

Return a list of roles this user has been granted.

Returns `array``<``int``, ``string``>` — An array of role names.

### grantRole()

`public function grantRole(string $role): void`

Set a role membership for this user.

The role name to add to this user.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` | The role name to add to this user. |

### grantRoles()

`public function grantRoles(array<int, string> $roles): void`

Set many role memberships for this user.

An array of role names.

| Parameter | Type | Description |
|---|---|---|
| `$roles` | `array``<``int``, ``string``>` | An array of role names. |

### hasRole()

`public function hasRole(string $role): bool`

Check whether or not a user is a member of a certain role.

The role name to remove from this user.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` | The role name to remove from this user. |

Returns `bool` — Whether or not the user is a member of the given role.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this User.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | An Context instance. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

| Throws | When |
|---|---|
| `InitializationException` | If an error occurs while initializing this User. |

### reset()

`public function reset(): void`

Clears the role state on top of the parent reset.

Drops the granted roles and the cached role definitions along with the context, parameters and attributes, then delegates to the parent so the authentication and credential state goes too. Nothing is persisted -- roles held only in memory are discarded.

### revokeAllRoles()

`public function revokeAllRoles(): void`

Revoke all roles.

### revokeRole()

`public function revokeRole(string $role): void`

Revoke a role membership for this user.

The role name to remove from this user.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` | The role name to remove from this user. |

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addCredential()` | [`SecurityUser`](/api/user/security-user/) | Add a credential to this user. |
| `appendAttribute()` | [`User`](/api/user/user/) | Appends a value to an array attribute and marks the user dirty. |
| `appendAttributeByRef()` | [`User`](/api/user/user/) | Appends a value by reference to an array attribute and marks the user dirty. |
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearAttributes()` | [`User`](/api/user/user/) | Removes every attribute in every namespace and marks the user dirty. |
| `clearCredentials()` | [`SecurityUser`](/api/user/security-user/) | Clear all credentials associated with this user. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an attribute. |
| `getAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute names. |
| `getAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getAttributeNamespaces()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute namespaces. |
| `getAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getContext()` | [`User`](/api/user/user/) | Retrieve the current application context. |
| `getCredentials()` | [`SecurityUser`](/api/user/security-user/) | Returns the list of credentials that this user possesses. |
| `getDefaultNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Get the default namespace name |
| `getFlatAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of flattened attribute names. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getStorageNamespace()` | [`User`](/api/user/user/) | Retrieve the Storage namespace |
| `getTokenClaims()` | [`SecurityUser`](/api/user/security-user/) | The validated claims this identity was resolved from, when [`RbacSecurityUser::isTokenDerived()`](/api/user/rbac-security-user/#istokenderived) is true. |
| `hasAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute exists. |
| `hasAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute namespace exists. |
| `hasCredential()` | [`SecurityUser`](/api/user/security-user/) | Indicates whether or not this user has a credential. |
| `hasCredentials()` | [`SecurityUser`](/api/user/security-user/) | Indicates whether or not this user has a credential or a set of credentials. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `isAuthenticated()` | [`SecurityUser`](/api/user/security-user/) | Indicates whether or not this user is authenticated. |
| `isDirty()` | [`User`](/api/user/user/) | Whether this request changed user state that still needs persisting. |
| `isTokenDerived()` | [`SecurityUser`](/api/user/security-user/) | True when this user's identity was (re-)established from a token rather than the session, per `$tokenDerived`. |
| `markClean()` | [`User`](/api/user/user/) | Record that in-memory state now matches what is persisted. |
| `markDirty()` | [`User`](/api/user/user/) | Force this user to be persisted at the request boundary. |
| `markTokenDerived()` | [`SecurityUser`](/api/user/security-user/) | Mark (or clear) this user as token-derived, for this request only -- the marker is not persisted (see `$tokenDerived`). |
| `persistAttributesImmediate()` | [`User`](/api/user/user/) | Immediately persist current user attributes (or a filtered subset) to storage. |
| `removeAttribute()` | [`User`](/api/user/user/) | Removes a single attribute and marks the user dirty so the removal is persisted. |
| `removeAttributeNamespace()` | [`User`](/api/user/user/) | Removes a whole attribute namespace and marks the user dirty. |
| `removeCredential()` | [`SecurityUser`](/api/user/security-user/) | Remove a credential from this user. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `restoreContext()` | [`User`](/api/user/user/) | Re-bind context after unserialization without re-running full initialize logic. |
| `restoreIdentityFromStorage()` | [`SecurityUser`](/api/user/security-user/) | Re-populate this user's core identity attributes (see `CORE_IDENTITY_KEYS`) from storage. |
| `setAttribute()` | [`User`](/api/user/user/) | Sets an attribute and marks the user dirty so shutdown() persists it. |
| `setAttributeByRef()` | [`User`](/api/user/user/) | Sets an attribute by reference and marks the user dirty. |
| `setAttributes()` | [`User`](/api/user/user/) | Merges a set of attributes into a namespace and marks the user dirty. |
| `setAttributesByRef()` | [`User`](/api/user/user/) | Merges a set of attributes by reference into a namespace and marks the user dirty. |
| `setAuthenticated()` | [`SecurityUser`](/api/user/security-user/) | Set the authenticated status of this user. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `setTokenClaims()` | [`SecurityUser`](/api/user/security-user/) | Set (or clear) the validated claims this identity was resolved from. |
| `startup()` | [`User`](/api/user/user/) | Startup the user. |
