# Session

> Mutable session handle.

Mutable session handle.

Deliberately an object rather than a plain array: PSR-7 requests are immutable, so a request attribute holding an array would be invisible to code higher up the middleware stack once a downstream handler mutates its own (forked) copy. Because this is an object, the same instance is shared across every withAttribute()-forked request in the pipeline — mutations made deep in a handler are visible to SessionMiddleware once control returns.

## Synopsis

`final class Session`

|  |  |
|---|---|
| Source | `Session/Session.php` |

## Constructor

### __construct()

`public function __construct(string $sid, array<string, mixed> $data, bool $dirty, bool $new = false): mixed`

Whether this session was freshly generated for this
                 request rather than loaded from persistence. Tracked
                 separately from $dirty so SessionManager can tell "an
     *                  untouched brand-new session, nothing to persist or
     *                  cookie yet" apart from "an existing session with
     *                  nothing changed this request" -- the latter still
                 needs its cookie refreshed (sliding expiration) even
                 though there's nothing new to write to storage.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |
| `$dirty` | `bool` |  |
| `$new` | `bool` | Whether this session was freshly generated for this request rather than loaded from persistence. Tracked separately from $dirty so SessionManager can tell "an * untouched brand-new session, nothing to persist or * cookie yet" apart from "an existing session with * nothing changed this request" -- the latter still needs its cookie refreshed (sliding expiration) even though there's nothing new to write to storage. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`all(): array<string, mixed>`](#all) |  |
| [`get(string $key, mixed $default = null): mixed`](#get) | Returns the value stored under the key, or $default when it is absent. |
| [`getId(): string`](#getid) | Returns the session id, which [`Session::replaceId()`](/api/session/session/#replaceid) changes on regeneration. |
| [`has(string $key): bool`](#has) | Whether the key is present, including when its stored value is null. |
| [`isDirty(): bool`](#isdirty) | Whether the session has unwritten changes, i.e. |
| [`isNew(): bool`](#isnew) | Whether this session was generated for the current request rather than loaded from persistence. |
| [`markClean(): void`](#markclean) | Clears the dirty flag, which [`SessionManager`](/api/session/session-manager/) does once the session has been persisted. |
| [`markDirty(): void`](#markdirty) | Forces the dirty flag on, so the session is written out even without a [`Session::set()`](/api/session/session/#set) or [`Session::remove()`](/api/session/session/#remove). |
| [`remove(string $key): void`](#remove) | Drops the key from the session and marks it dirty. |
| [`replaceData(array<string, mixed> $data): void`](#replacedata) |  |
| [`replaceId(string $sid): void`](#replaceid) | Internal hooks used by SessionManager; not intended for application code. |
| [`set(string $key, mixed $value): void`](#set) | Stores a value under the key and marks the session dirty. |

### all()

`public function all(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### get()

`public function get(string $key, mixed $default = null): mixed`

Returns the value stored under the key, or $default when it is absent.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getId()

`public function getId(): string`

Returns the session id, which [`Session::replaceId()`](/api/session/session/#replaceid) changes on regeneration.

Returns `string`

### has()

`public function has(string $key): bool`

Whether the key is present, including when its stored value is null.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `bool`

### isDirty()

`public function isDirty(): bool`

Whether the session has unwritten changes, i.e.

a write happened since it was last marked clean.

Returns `bool`

### isNew()

`public function isNew(): bool`

Whether this session was generated for the current request rather than loaded from persistence.

Stays true for the life of the request even after writes; combine with [`Session::isDirty()`](/api/session/session/#isdirty) to tell an untouched brand-new session apart from one that has acquired state and needs persisting.

Returns `bool`

### markClean()

`public function markClean(): void`

Clears the dirty flag, which [`SessionManager`](/api/session/session-manager/) does once the session has been persisted.

### markDirty()

`public function markDirty(): void`

Forces the dirty flag on, so the session is written out even without a [`Session::set()`](/api/session/session/#set) or [`Session::remove()`](/api/session/session/#remove).

### remove()

`public function remove(string $key): void`

Drops the key from the session and marks it dirty.

The session is marked dirty whether or not the key was present, so a removal of an absent key still triggers a write at the end of the request.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

### replaceData()

`public function replaceData(array<string, mixed> $data): void`

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>` |  |

### replaceId()

`public function replaceId(string $sid): void`

Internal hooks used by SessionManager; not intended for application code.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### set()

`public function set(string $key, mixed $value): void`

Stores a value under the key and marks the session dirty.

The dirty flag is what makes [`SessionManager::persistAndBakeCookies()`](/api/session/session-manager/#persistandbakecookies) write the session out at the end of the request, so a write is always unconditional here — no value comparison is made against what was there.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$value` | `mixed` |  |
