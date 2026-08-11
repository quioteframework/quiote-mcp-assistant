# S3SessionPersistence

> SessionPersistenceInterface storing one JSON object per session id (key `<prefix><sid>.json`) in a single S3 bucket.

[`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON object per session id (key `<prefix><sid>.json`) in a single S3 bucket.

The storage behaviour is [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/), shared with the other object-store session backends; this class supplies the client.

## Synopsis

`final class S3SessionPersistence extends ObjectStoreSessionPersistence`

|  |  |
|---|---|
| Extends | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) |
| Source | `S3SessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $keyPrefix = 'sessions/', SessionCodecInterface $codec = null): mixed`

Defaults to the portable codec: for an object
            store the round-trip dominates, and a readable stored object is worth more than
            a compact one.

| Parameter | Type | Description |
|---|---|---|
| `$client` | `ObjectStoreClientInterface` | The store, already bound to its bucket or container. |
| `$keyPrefix` | `string` | Prepended to every session id to form the object key. |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) | Defaults to the portable codec: for an object store the round-trip dominates, and a readable stored object is worth more than a compact one. |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | Deletes the session's object from the store. |
| `load()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | Fetches the session's object from the store and decodes it. |
| `save()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) |  |
