# AzureBlobSessionPersistence

> SessionPersistenceInterface storing one JSON blob per session id (named `<sid>.json`) in a single Azure Blob container.

[`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON blob per session id (named `<sid>.json`) in a single Azure Blob container.

Azure takes the container per call, so the client is wrapped in an [`AzureBlobContainerClient`](/api/storage/azure/azure-blob-container-client/) that binds it and creates it on first write. Everything after that is the shared behaviour in [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/).

## Synopsis

`final class AzureBlobSessionPersistence extends ObjectStoreSessionPersistence`

|  |  |
|---|---|
| Extends | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) |
| Source | `AzureBlobSessionPersistence.php` |

## Constructor

### __construct()

`public function __construct(ObjectStoreClientInterface $client, string $container = 'quiote-sessions', SessionCodecInterface $codec = null): mixed`

Defaults to the portable codec: for an object
            store the round-trip dominates, and a readable stored object is worth more than
            a compact one.

| Parameter | Type | Description |
|---|---|---|
| `$client` | `ObjectStoreClientInterface` | The store, already bound to its bucket or container. |
| `$container` | `string` |  |
| `$codec` | [`SessionCodecInterface`](/api/session/session-codec-interface/) | Defaults to the portable codec: for an object store the round-trip dominates, and a readable stored object is worth more than a compact one. |

Returns `mixed`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | Deletes the session's object from the store. |
| `load()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | Fetches the session's object from the store and decodes it. |
| `save()` | [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) |  |
