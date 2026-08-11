# LocalFilesystemAdapter

> Zero-dependency local-disk FilesystemAdapterInterface — the default driver.

Zero-dependency local-disk [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) — the default driver.

Every path is resolved relative to a fixed root directory; `..` segments and absolute paths are rejected so caller-given paths can never escape the root (unlike [`FileSessionPersistence`](/api/session/file-session-persistence/), which hashes its keys, a general filesystem API takes paths straight from callers, so this guard is what keeps them contained).

Writes go to a temp file in the same directory and are renamed into place (same atomic pattern as [`FileSessionPersistence::save()`](/api/session/file-session-persistence/#save)), so readers never observe a partially written file.

## Synopsis

`final class LocalFilesystemAdapter implements ListableFilesystemInterface`

|  |  |
|---|---|
| Implements | [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) |
| Source | `Filesystem/LocalFilesystemAdapter.php` |

## Constructor

### __construct()

`public function __construct(string $root): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$root` | `string` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `FilesystemStorageException` | if the root directory cannot be created or written to. |

## Methods

| Method | Description |
|---|---|
| [`delete(string $path): void`](#delete) | Deletes the file at $path. |
| [`exists(string $path): bool`](#exists) | Reports whether $path names an existing regular file under the root. |
| [`lastModified(string $path): DateTimeImmutable`](#lastmodified) | Returns the modification time of the file at $path. |
| [`listContents(string $path = ''): list<string>`](#listcontents) | Lists the entries directly under $path, sorted, non-recursive. |
| [`read(string $path): string`](#read) | Returns the full contents of the file at $path. |
| [`size(string $path): int`](#size) | Returns the size of the file at $path in bytes. |
| [`write(string $path, string $contents): void`](#write) | Writes $contents to $path, creating any missing parent directories. |

### delete()

`public function delete(string $path): void`

Deletes the file at $path.

Best-effort: a missing file, or an unlink the OS refuses, is silently ignored. Only an invalid path is reported.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root. |

### exists()

`public function exists(string $path): bool`

Reports whether $path names an existing regular file under the root.

A directory at $path counts as absent.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root. |

### lastModified()

`public function lastModified(string $path): DateTimeImmutable`

Returns the modification time of the file at $path.

The returned instant carries the current default timezone; only its timestamp is meaningful.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root, or the mtime could not be read. |
| `FileNotFoundStorageException` | If no regular file exists at $path. |

### listContents()

`public function listContents(string $path = ''): list<string>`

Lists the entries directly under $path, sorted, non-recursive.

An empty $path lists the root itself. Paths are returned relative to the root, and directories are included alongside files. A $path that is not an existing directory yields an empty list rather than an error, so a caller need not stat it first.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `list``<``string``>` — Relative paths, in ascending string order.

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root, or the directory exists but could not be opened. |

### read()

`public function read(string $path): string`

Returns the full contents of the file at $path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root, or the file exists but could not be read. |
| `FileNotFoundStorageException` | If no regular file exists at $path. |

### size()

`public function size(string $path): int`

Returns the size of the file at $path in bytes.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `int`

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root, or the size could not be determined. |
| `FileNotFoundStorageException` | If no regular file exists at $path. |

### write()

`public function write(string $path, string $contents): void`

Writes $contents to $path, creating any missing parent directories.

The bytes go to a uniquely named temp file in the destination directory and are then renamed into place, so a concurrent reader sees either the previous file or the complete new one, never a partial write. A failed write or rename removes the temp file before throwing.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$contents` | `string` |  |

| Throws | When |
|---|---|
| `FilesystemStorageException` | If $path escapes the root, the parent directory could not be created, or the write or rename failed. |
