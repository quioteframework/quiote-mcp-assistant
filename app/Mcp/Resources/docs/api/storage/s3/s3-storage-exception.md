# S3StorageException

> A failure talking to S3 storage.

A failure talking to S3 storage.

Narrows [`ObjectStoreException`](/api/storage/object-store-exception/) to this provider, so a caller working against [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) can catch the supertype while one that knows it is on S3 can still catch this.

## Synopsis

`final class S3StorageException extends ObjectStoreException`

|  |  |
|---|---|
| Extends | [`ObjectStoreException`](/api/storage/object-store-exception/) |
| Source | `S3StorageException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
