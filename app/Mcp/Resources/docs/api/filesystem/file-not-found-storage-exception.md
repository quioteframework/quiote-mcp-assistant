# FileNotFoundStorageException

> Thrown by FilesystemAdapterInterface::read()/FilesystemAdapterInterface::size()/FilesystemAdapterInterface::lastModified() when the path does not exist.

Thrown by [`FilesystemAdapterInterface::read()`](/api/filesystem/filesystem-adapter-interface/#read)/[`FilesystemAdapterInterface::size()`](/api/filesystem/filesystem-adapter-interface/#size)/[`FilesystemAdapterInterface::lastModified()`](/api/filesystem/filesystem-adapter-interface/#lastmodified) when the path does not exist.

## Synopsis

`class FileNotFoundStorageException extends FilesystemStorageException`

|  |  |
|---|---|
| Extends | [`FilesystemStorageException`](/api/filesystem/filesystem-storage-exception/) |
| Source | `FileNotFoundStorageException.php` |

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
