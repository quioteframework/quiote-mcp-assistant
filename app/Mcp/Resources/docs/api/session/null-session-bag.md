# NullSessionBag

> A SessionBagInterface that stores nothing.

A [`SessionBagInterface`](/api/session/session-bag-interface/) that stores nothing.

What an application gets when it configures no `session` factory slot. The User hierarchy, CSRF token storage and OIDC state all read and write through the bag unconditionally, so they need something to talk to even where a session makes no sense -- a console command, a queue worker, a stateless JSON API, a test context. This is that something, and it keeps "a User but * no sessions" expressible without a session backend, the way the old NullStorage did for the storage slot it replaces.

Writes are discarded rather than rejected: a component that opportunistically records something in the session should not have to know whether one exists. exists() answers false, so callers persisting default or empty state skip their write entirely instead of relying on that.

## Synopsis

`final class NullSessionBag implements SessionBagInterface`

|  |  |
|---|---|
| Implements | [`SessionBagInterface`](/api/session/session-bag-interface/) |
| Since | `3.0.0` |
| Source | `Session/NullSessionBag.php` |

## Methods

| Method | Description |
|---|---|
| [`destroy(): void`](#destroy) | No-op; there is no session state to discard. |
| [`exists(): bool`](#exists) | Always false, so callers persisting default or empty state skip their write entirely. |
| [`get(string $key, mixed $default = null): mixed`](#get) | Always returns $default; nothing is ever stored. |
| [`getId(): string`](#getid) | Always the empty string, the contract's "no session" id. |
| [`has(string $key): bool`](#has) | Always false; no key is ever present. |
| [`regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void`](#regenerate) | No-op; with no id and no contents there is nothing to rotate. |
| [`remove(string $key): void`](#remove) | No-op; there is nothing stored to remove. |
| [`set(string $key, mixed $value): void`](#set) | Discards the value silently, so opportunistic writes need no session check. |

### destroy()

`public function destroy(): void`

No-op; there is no session state to discard.

### exists()

`public function exists(): bool`

Always false, so callers persisting default or empty state skip their write entirely.

Returns `bool`

### get()

`public function get(string $key, mixed $default = null): mixed`

Always returns $default; nothing is ever stored.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getId()

`public function getId(): string`

Always the empty string, the contract's "no session" id.

Returns `string`

### has()

`public function has(string $key): bool`

Always false; no key is ever present.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

### regenerate()

`public function regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void`

No-op; with no id and no contents there is nothing to rotate.

| Parameter | Type | Description |
|---|---|---|
| `$deleteOld` | `bool` |  |
| `$privilegeTransition` | `bool` |  |

### remove()

`public function remove(string $key): void`

No-op; there is nothing stored to remove.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

### set()

`public function set(string $key, mixed $value): void`

Discards the value silently, so opportunistic writes need no session check.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |
