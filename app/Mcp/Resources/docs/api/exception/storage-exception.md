# StorageException

> StorageException is thrown when a requested Storage implementation doesn't exist or data cannot be read from or written to the storage.

StorageException is thrown when a requested Storage implementation doesn't exist or data cannot be read from or written to the storage.

## Synopsis

`class StorageException extends QuioteException`

|  |  |
|---|---|
| Extends | [`QuioteException`](/api/exception/quiote-exception/) |
| Since | `1.0.0` |
| Source | `Exception/StorageException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getOriginalCode()` | [`QuioteException`](/api/exception/quiote-exception/) | Returns the original code, which may be a string (e.g. |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
