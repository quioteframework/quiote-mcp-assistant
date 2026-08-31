# ObjectStoreSessionPersistence

> A SessionPersistenceInterface storing one object per session id in any ObjectStoreClientInterface.

A [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one object per session id in any [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/).

Every object store holds a session the same way: derive a key from the id, write the encoded payload, read it back, delete it. That is provider-independent, so it lives here once and the provider packages supply only their client.

There is no garbage collection: an object store has no cheap way to enumerate expired sessions (see [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) for why these clients cannot list), so expiry belongs to a bucket lifecycle rule configured alongside the store rather than to a pass on the request path.

## Synopsis

`class ObjectStoreSessionPersistence implements SessionPersistenceInterface`

|  |  |
|---|---|
| Implements | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) |
| Since | `3.2.0` |
| Source | `ObjectStoreSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $keyPrefix = 'sessions/', string $keySuffix = '.json', SessionCodecInterface $codec = new SessionCodec(…)): mixed`

Defaults to the portable codec: for an object
            store the round-trip dominates, and a readable stored object is worth more than
            a compact one.

| Parameter | Type | Description |
|---|---|---|
| `$client` | [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) | The store, already bound to its bucket or container. |
| `$keyPrefix` | `string` | Prepended to every session id to form the object key. |
| `$keySuffix` | `string` | Appended to it, e.g. '.json' so the stored object is recognisable in a bucket listing. |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) | Defaults to the portable codec: for an object store the round-trip dominates, and a readable stored object is worth more than a compact one. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $sid): void`](#delete) | Deletes the session's object from the store. |
| [`load(string $sid): ?array`](#load) | Fetches the session's object from the store and decodes it. |
| [`save(string $sid, array<string, mixed> $data): void`](#save) |  |

### delete()

`public function delete(string $sid): void`

Deletes the session's object from the store.

Delegates straight to the client, which treats an absent key as a no-op.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

### load()

`public function load(string $sid): ?array`

Fetches the session's object from the store and decodes it.

Returns null when the store has no object under the derived key or the object is empty; a missing key is an ordinary miss, not an error.

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |

Returns `?``array`

### save()

`public function save(string $sid, array<string, mixed> $data): void`

| Parameter | Type | Description |
|---|---|---|
| `$sid` | `string` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |
