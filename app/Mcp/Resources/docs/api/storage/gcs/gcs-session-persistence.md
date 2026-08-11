# GcsSessionPersistence

> SessionPersistenceInterface storing one JSON object per session id (object `<prefix><sid>.json`) in a single GCS bucket.

[`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON object per session id (object `<prefix><sid>.json`) in a single GCS bucket.

The storage behaviour is [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/), shared with the other object-store session backends; this class supplies the client.

## Synopsis

`final class GcsSessionPersistence extends ObjectStoreSessionPersistence`

|  |  |
|---|---|
| Extends | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) |
| Source | `GcsSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $objectPrefix = 'sessions/', SessionCodecInterface $codec = null): mixed`

Defaults to the portable codec: for an object
            store the round-trip dominates, and a readable stored object is worth more than
            a compact one.

| Parameter | Type | Description |
|---|---|---|
| `$client` | `ObjectStoreClientInterface` | The store, already bound to its bucket or container. |
| `$objectPrefix` | `string` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) | Defaults to the portable codec: for an object store the round-trip dominates, and a readable stored object is worth more than a compact one. |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | Deletes the session's object from the store. |
| `load()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | Fetches the session's object from the store and decodes it. |
| `save()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) |  |
