# ObjectStoreException

> A failure talking to an object store.

A failure talking to an object store.

The shared supertype of every provider's own storage exception, so code that works against [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) can catch one type instead of enumerating providers. Each provider keeps its own subclass, so `catch (S3StorageException)` still narrows to S3 when that distinction matters.

## Synopsis

`class ObjectStoreException extends RuntimeException`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Since | `3.2.0` |
| Source | `ObjectStoreException.php` |

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
