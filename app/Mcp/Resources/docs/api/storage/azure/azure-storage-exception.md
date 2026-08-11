# AzureStorageException

> A failure talking to Azure storage.

A failure talking to Azure storage.

Narrows [`ObjectStoreException`](/api/storage/object-store-exception/) to this provider, so a caller working against [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/) can catch the supertype while one that knows it is on Azure can still catch this.

## Synopsis

`final class AzureStorageException extends ObjectStoreException`

|  |  |
|---|---|
| Extends | [`ObjectStoreException`](/api/storage/object-store-exception/) |
| Source | `AzureStorageException.php` |

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
