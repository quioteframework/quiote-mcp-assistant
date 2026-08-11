# QuioteSessionBag

> SessionBagInterface over the PSR-7-native SessionManager stack.

[`SessionBagInterface`](/api/session/session-bag-interface/) over the PSR-7-native [`SessionManager`](/api/session/session-manager/) stack.

This is the modern half of the seam. Compared with `StorageSessionBag`, four failure modes of the ext/session path stop being possible rather than merely being fixed:

- There is no process-global session id, so nothing can leak from one worker request into the next. - There is no SessionHandlerInterface, so no callback can re-enter the function that invoked it. - save() is an ordinary write with no relationship to headers_sent(), so a late write lands instead of silently vanishing. - The cookie rides the PSR-7 response rather than PHP's output layer, so it works unchanged under a non-SAPI worker runtime.

Lifecycle is owned by the middleware that installs this on the context: it calls [`SessionManager::startFromRequest()`](/api/session/session-manager/#startfromrequest) on the way in and [`SessionManager::persistAndBakeCookies()`](/api/session/session-manager/#persistandbakecookies) on the way out.

## Synopsis

`final class QuioteSessionBag implements SessionBagInterface`

|  |  |
|---|---|
| Implements | [`SessionBagInterface`](/api/session/session-bag-interface/) |
| Since | `2.2.0` |
| Source | `Session/QuioteSessionBag.php` |

## Constructor

### __construct()

`public function __construct(SessionManager $manager, Session $session, ?ServerRequestInterface $request = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$manager` | [`SessionManager`](/api/session/session-manager/) |  |
| `$session` | [`Session`](/api/session/session/) |  |
| `$request` | `?`[`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`destroy(): void`](#destroy) | Deletes the stored session and continues under a fresh, empty id. |
| [`exists(): bool`](#exists) | A brand-new session nothing has been written to yet is reported as absent, which is what keeps a default/empty write -- a logout on a client that never logged in -- from persisting a row and emitting a cookie for a client that never had a session. |
| [`get(string $key, mixed $default = null): mixed`](#get) | Read a value, or $default when the key is absent. |
| [`getId(): string`](#getid) | Returns the session id. |
| [`getSession(): Session`](#getsession) | Returns the underlying [`Session`](/api/session/session/) this bag wraps. |
| [`has(string $key): bool`](#has) | Whether the key is present in the session. |
| [`regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void`](#regenerate) | Rotates the id via the manager, keeping the session's contents. |
| [`remove(string $key): void`](#remove) | Removes the key from the underlying session, which marks it dirty so the removal is persisted. |
| [`set(string $key, mixed $value): void`](#set) | Writes through to the underlying session, which marks it dirty so it is persisted at the end of the request. |

### destroy()

`public function destroy(): void`

Deletes the stored session and continues under a fresh, empty id.

The wrapped [`Session`](/api/session/session/) instance stays usable and is marked dirty, so anything written after this — a post-logout flash message — is persisted against the new id rather than the discarded one.

### exists()

`public function exists(): bool`

A brand-new session nothing has been written to yet is reported as absent, which is what keeps a default/empty write -- a logout on a client that never logged in -- from persisting a row and emitting a cookie for a client that never had a session.

It matches the guard persistAndBakeCookies() already applies on the way out.

Returns `bool`

### get()

`public function get(string $key, mixed $default = null): mixed`

Read a value, or $default when the key is absent.

Note the normalization this hides: the legacy storages disagree on the "missing" sentinel -- SessionStorage returns null while NullStorage returns false -- and consumers only survived that through loose comparison. Implementations must return $default for both.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getId()

`public function getId(): string`

Returns the session id.

Never empty on this implementation: a session id is generated up front even for a request that carried no cookie, so an id here does not by itself mean a session exists in storage — [`QuioteSessionBag::exists()`](/api/session/quiote-session-bag/#exists) answers that.

Returns `string`

### getSession()

`public function getSession(): Session`

Returns the underlying [`Session`](/api/session/session/) this bag wraps.

For code that needs the whole session object — reading every key, or the dirty/new flags — rather than the narrow bag contract.

Returns [`Session`](/api/session/session/)

### has()

`public function has(string $key): bool`

Whether the key is present in the session.

Implementations must report a key whose stored value is null as present, so that has() and a null get() stay distinguishable.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

### regenerate()

`public function regenerate(bool $deleteOld = true, bool $privilegeTransition = false): void`

Rotates the id via the manager, keeping the session's contents.

With $privilegeTransition true the previous id is deleted outright; with it false the manager leaves a short-lived redirect marker so a request already in flight under the old cookie still resolves. The marker is bound to the request this bag was built with, when there is one.

| Parameter | Type | Description |
|---|---|---|
| `$deleteOld` | `bool` |  |
| `$privilegeTransition` | `bool` |  |

### remove()

`public function remove(string $key): void`

Removes the key from the underlying session, which marks it dirty so the removal is persisted.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

### set()

`public function set(string $key, mixed $value): void`

Writes through to the underlying session, which marks it dirty so it is persisted at the end of the request.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |
