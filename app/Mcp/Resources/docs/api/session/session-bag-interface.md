# SessionBagInterface

> The narrow per-session key/value contract everything that needs session state talks to: the User hierarchy, CSRF token storage, OIDC state, and application code.

The narrow per-session key/value contract everything that needs session state talks to: the User hierarchy, CSRF token storage, OIDC state, and application code.

Quiote carries two session mechanisms. The original one is the `storage` factory slot (`Storage` and its ext/session-backed subclasses), which the User hierarchy was hard-wired to; the newer one is [`SessionManager`](/api/session/session-manager/) over [`SessionPersistenceInterface`](/api/session/session-persistence-interface/), which is PSR-7-native and safe under long-lived worker runtimes. They were disjoint -- an application running both got two independent sessions and two cookies.

This interface is the single seam between them. Consumers depend on it rather than on either mechanism, so which one backs a request becomes configuration instead of a rewrite. It is deliberately small: everything the existing consumers actually used, plus the two operations they previously reached for with `method_exists()` probes that could never succeed.

Implementations: `StorageSessionBag` over the legacy `Storage` slot.

## Synopsis

`interface SessionBagInterface`

|  |  |
|---|---|
| Implemented by | [`NullSessionBag`](/api/session/null-session-bag/), [`QuioteSessionBag`](/api/session/quiote-session-bag/) |
| Since | `2.1.0` |
| Source | `Session/SessionBagInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`destroy(): void`](#destroy) | Discard this session's contents and continue under a fresh id. |
| [`exists(): bool`](#exists) | Whether a write can land in a session that already exists, rather than manufacturing one for a client that has none. |
| [`get(string $key, mixed $default = null): mixed`](#get) | Read a value, or $default when the key is absent. |
| [`getId(): string`](#getid) | The current session id, or '' when there is no session. |
| [`has(string $key): bool`](#has) | Whether the key is present in the session. |
| [`regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void`](#regenerate) | Move the session's contents to a fresh id, to defeat session fixation at a privilege transition. |
| [`remove(string $key): void`](#remove) | Drop the key from the session. |
| [`set(string $key, mixed $value): void`](#set) | Write a value under the key. |

### destroy()

`abstract public function destroy(): void`

Discard this session's contents and continue under a fresh id.

Used at logout, so the pre-logout id is neither replayable nor inheritable.

### exists()

`abstract public function exists(): bool`

Whether a write can land in a session that already exists, rather than manufacturing one for a client that has none.

Callers persisting default or empty state -- a logout by a client that was never logged in -- consult this so an anonymous or stateless request does not acquire a session row and a Set-Cookie it never asked for. A deliberate write that should create a session (a login) simply does not ask.

Returns `bool`

### get()

`abstract public function get(string $key, mixed $default = null): mixed`

Read a value, or $default when the key is absent.

Note the normalization this hides: the legacy storages disagree on the "missing" sentinel -- SessionStorage returns null while NullStorage returns false -- and consumers only survived that through loose comparison. Implementations must return $default for both.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getId()

`abstract public function getId(): string`

The current session id, or '' when there is no session.

Returns `string`

### has()

`abstract public function has(string $key): bool`

Whether the key is present in the session.

Implementations must report a key whose stored value is null as present, so that has() and a null get() stay distinguishable.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

### regenerate()

`abstract public function regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void`

Move the session's contents to a fresh id, to defeat session fixation at a privilege transition.

True when this rotation accompanies a
                       privilege transition (login). Implementations must
                       then stop the old id resolving *immediately* rather
                       than after any grace window, since that window is
                       exactly what a fixation attempt rides.

| Parameter | Type | Description |
|---|---|---|
| `$deleteOld` | `bool` | Whether the previous id should stop resolving. Implementations differ in how immediately they honour that; see the implementation docs. |
| `$privilegeTransition` | `bool` | True when this rotation accompanies a privilege transition (login). Implementations must then stop the old id resolving *immediately* rather than after any grace window, since that window is exactly what a fixation attempt rides. |

### remove()

`abstract public function remove(string $key): void`

Drop the key from the session.

Removing a key that is not present is not an error; implementations must treat it as a no-op on the stored state.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

### set()

`abstract public function set(string $key, mixed $value): void`

Write a value under the key.

Implementations that have no session to write to may discard the value rather than raise; callers that must not create a session for a client that has none consult [`SessionBagInterface::exists()`](/api/session/session-bag-interface/#exists) first.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |
