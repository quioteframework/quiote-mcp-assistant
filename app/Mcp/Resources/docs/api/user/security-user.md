# SecurityUser

> BasicSecurityUser will handle any type of data as a credential.

BasicSecurityUser will handle any type of data as a credential.

## Synopsis

`class SecurityUser extends User implements ISecurityUser`

|  |  |
|---|---|
| Extends | [`User`](/api/user/user/) |
| Implements | [`ISecurityUser`](/api/user/i-security-user/) |
| Since | `1.0.0` |
| Source | `User/SecurityUser.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `AUTH_NAMESPACE` | `'org.quiote.user.BasicSecurityUser.authenticated'` | The namespace under which authenticated status will be stored. |
| `CREDENTIAL_NAMESPACE` | `'org.quiote.user.BasicSecurityUser.credentials'` | The namespace under which credentials will be stored. |

## Methods

| Method | Description |
|---|---|
| [`addCredential(mixed $credential): void`](#addcredential) | Add a credential to this user. |
| [`clearCredentials(): void`](#clearcredentials) | Clear all credentials associated with this user. |
| [`getCredentials(): ?array<int, mixed>`](#getcredentials) | Returns the list of credentials that this user possesses. |
| [`getTokenClaims(): ?TokenClaims`](#gettokenclaims) | The validated claims this identity was resolved from, when [`SecurityUser::isTokenDerived()`](/api/user/security-user/#istokenderived) is true. |
| [`hasCredential(mixed $credential): bool`](#hascredential) | Indicates whether or not this user has a credential. |
| [`hasCredentials(mixed $credentials): bool`](#hascredentials) | Indicates whether or not this user has a credential or a set of credentials. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this User. |
| [`isAuthenticated(): bool`](#isauthenticated) | Indicates whether or not this user is authenticated. |
| [`isTokenDerived(): bool`](#istokenderived) | True when this user's identity was (re-)established from a token rather than the session, per `$tokenDerived`. |
| [`markTokenDerived(bool $tokenDerived = true): void`](#marktokenderived) | Mark (or clear) this user as token-derived, for this request only -- the marker is not persisted (see `$tokenDerived`). |
| [`removeCredential(mixed $credential): void`](#removecredential) | Remove a credential from this user. |
| [`reset(): void`](#reset) | Clears the authentication state on top of the parent reset. |
| [`restoreIdentityFromStorage(): void`](#restoreidentityfromstorage) | Re-populate this user's core identity attributes (see `CORE_IDENTITY_KEYS`) from storage. |
| [`setAuthenticated(mixed $authenticated): void`](#setauthenticated) | Set the authenticated status of this user. |
| [`setTokenClaims(?TokenClaims $claims): void`](#settokenclaims) | Set (or clear) the validated claims this identity was resolved from. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |

### addCredential()

`public function addCredential(mixed $credential): void`

Add a credential to this user.

Credential data.

| Parameter | Type | Description |
|---|---|---|
| `$credential` | `mixed` | Credential data. |

### clearCredentials()

`public function clearCredentials(): void`

Clear all credentials associated with this user.

### getCredentials()

`public function getCredentials(): ?array<int, mixed>`

Returns the list of credentials that this user possesses.

Returns `?``array``<``int``, ``mixed``>` — This user's credentials.

### getTokenClaims()

`public function getTokenClaims(): ?TokenClaims`

The validated claims this identity was resolved from, when [`SecurityUser::isTokenDerived()`](/api/user/security-user/#istokenderived) is true.

Returns `?`[`TokenClaims`](/api/security/auth/token-claims/)

### hasCredential()

`public function hasCredential(mixed $credential): bool`

Indicates whether or not this user has a credential.

Credential data.

| Parameter | Type | Description |
|---|---|---|
| `$credential` | `mixed` | Credential data. |

Returns `bool` — True if this user has the credential, otherwise false.

### hasCredentials()

`public function hasCredentials(mixed $credentials): bool`

Indicates whether or not this user has a credential or a set of credentials.

Credential data. Either a string or an array of
                  credentials which are all required. If these individual
                  credentials are again an array of credentials, one or
                  more of these sub-credentials will be required.

| Parameter | Type | Description |
|---|---|---|
| `$credentials` | `mixed` | Credential data. Either a string or an array of credentials which are all required. If these individual credentials are again an array of credentials, one or more of these sub-credentials will be required. |

Returns `bool` — true, if this user has the credential, otherwise false.

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

### isAuthenticated()

`public function isAuthenticated(): bool`

Indicates whether or not this user is authenticated.

Returns `bool` — true, if this user is authenticated, otherwise false.

### isTokenDerived()

`public function isTokenDerived(): bool`

True when this user's identity was (re-)established from a token rather than the session, per `$tokenDerived`.

Returns `bool`

### markTokenDerived()

`public function markTokenDerived(bool $tokenDerived = true): void`

Mark (or clear) this user as token-derived, for this request only -- the marker is not persisted (see `$tokenDerived`).

Called by a token authenticator (e.g. `BearerTokenAuthenticator`) once it has resolved and granted the credentials for this request.

Clearing it is how an endpoint that deliberately turns a token into a browser session (an SPA's session-establishing call) opts the identity back into session persistence: call `markTokenDerived(false)` before granting roles and authenticating, and the login is written out like any form login's.

| Parameter | Type | Description |
|---|---|---|
| `$tokenDerived` | `bool` |  |

### removeCredential()

`public function removeCredential(mixed $credential): void`

Remove a credential from this user.

Credential data.

| Parameter | Type | Description |
|---|---|---|
| `$credential` | `mixed` | Credential data. |

### reset()

`public function reset(): void`

Clears the authentication state on top of the parent reset.

Forgets whether the user was authenticated, its credentials and credential index, and any claims derived from a stateless token, then delegates to the parent for the attribute and context state. Called between requests in a long-running worker so no identity survives into the next one.

### restoreIdentityFromStorage()

`public function restoreIdentityFromStorage(): void`

Re-populate this user's core identity attributes (see `CORE_IDENTITY_KEYS`) from storage.

Framework code does not call this automatically; it exists so a worker cold start (a fresh FrankenPHP worker recreating this object from scratch) can restore identity-critical attributes before a token authenticator repopulates the request-scoped identity, without every subclass re-implementing the same storage read.

### setAuthenticated()

`public function setAuthenticated(mixed $authenticated): void`

Set the authenticated status of this user.

A flag indicating the authenticated status of this user.
                   Intentionally compared with `=== true` below rather than typed
                   `bool`: truthy-but-non-bool values (e.g. `1`) must be rejected, not
                   coerced.

| Parameter | Type | Description |
|---|---|---|
| `$authenticated` | `mixed` | A flag indicating the authenticated status of this user. Intentionally compared with `=== true` below rather than typed `bool`: truthy-but-non-bool values (e.g. `1`) must be rejected, not coerced. |

### setTokenClaims()

`public function setTokenClaims(?TokenClaims $claims): void`

Set (or clear) the validated claims this identity was resolved from.

Called by [`AuthenticationManager::apply()`](/api/security/auth/authentication-manager/#apply) alongside [`SecurityUser::markTokenDerived()`](/api/user/security-user/#marktokenderived) once a token authenticator has produced a successful passport.

| Parameter | Type | Description |
|---|---|---|
| `$claims` | `?`[`TokenClaims`](/api/security/auth/token-claims/) |  |

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendAttribute()` | [`User`](/api/user/user/) | Appends a value to an array attribute and marks the user dirty. |
| `appendAttributeByRef()` | [`User`](/api/user/user/) | Appends a value by reference to an array attribute and marks the user dirty. |
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearAttributes()` | [`User`](/api/user/user/) | Removes every attribute in every namespace and marks the user dirty. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an attribute. |
| `getAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute names. |
| `getAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getAttributeNamespaces()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of attribute namespaces. |
| `getAttributes()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve all attributes within a namespace. |
| `getContext()` | [`User`](/api/user/user/) | Retrieve the current application context. |
| `getDefaultNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Get the default namespace name |
| `getFlatAttributeNames()` | [`AttributeHolder`](/api/util/attribute-holder/) | Retrieve an array of flattened attribute names. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getStorageNamespace()` | [`User`](/api/user/user/) | Retrieve the Storage namespace |
| `hasAttribute()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute exists. |
| `hasAttributeNamespace()` | [`AttributeHolder`](/api/util/attribute-holder/) | Indicates whether or not an attribute namespace exists. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `isDirty()` | [`User`](/api/user/user/) | Whether this request changed user state that still needs persisting. |
| `markClean()` | [`User`](/api/user/user/) | Record that in-memory state now matches what is persisted. |
| `markDirty()` | [`User`](/api/user/user/) | Force this user to be persisted at the request boundary. |
| `persistAttributesImmediate()` | [`User`](/api/user/user/) | Immediately persist current user attributes (or a filtered subset) to storage. |
| `removeAttribute()` | [`User`](/api/user/user/) | Removes a single attribute and marks the user dirty so the removal is persisted. |
| `removeAttributeNamespace()` | [`User`](/api/user/user/) | Removes a whole attribute namespace and marks the user dirty. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `restoreContext()` | [`User`](/api/user/user/) | Re-bind context after unserialization without re-running full initialize logic. |
| `setAttribute()` | [`User`](/api/user/user/) | Sets an attribute and marks the user dirty so shutdown() persists it. |
| `setAttributeByRef()` | [`User`](/api/user/user/) | Sets an attribute by reference and marks the user dirty. |
| `setAttributes()` | [`User`](/api/user/user/) | Merges a set of attributes into a namespace and marks the user dirty. |
| `setAttributesByRef()` | [`User`](/api/user/user/) | Merges a set of attributes by reference into a namespace and marks the user dirty. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `startup()` | [`User`](/api/user/user/) | Startup the user. |
