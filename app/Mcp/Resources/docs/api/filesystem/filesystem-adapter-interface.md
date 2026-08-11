# FilesystemAdapterInterface

> A general-purpose \"read/write/list a file\" contract, distinct from SessionPersistenceInterface (session-shaped) and the legacy Storage hierarchy (`SessionHandlerInterface`- bound).

A general-purpose "read/write/list a file" contract, distinct from [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) (session-shaped) and the legacy `Storage` hierarchy (`SessionHandlerInterface`- bound).

Implementations are registered by alias in [`FilesystemDriverRegistry`](/api/filesystem/filesystem-driver-registry/) and resolved through [`FilesystemManager`](/api/filesystem/filesystem-manager/).

Deliberately out of scope for v1: visibility/ACLs, mime-type detection, streaming read/write, directory-as-first-class-object semantics beyond what a driver needs internally, copy/move, checksums/ETags.

Enumeration is not here: a store built on single-object calls cannot offer it, so it lives on [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) and a driver opts in by implementing that instead. [`FilesystemAdapterInterface::size()`](/api/filesystem/filesystem-adapter-interface/#size) and [`FilesystemAdapterInterface::lastModified()`](/api/filesystem/filesystem-adapter-interface/#lastmodified) are supported by every shipped driver, though a cloud provider that omits the corresponding response header makes them fail at runtime.

## Synopsis

`interface FilesystemAdapterInterface`

|  |  |
|---|---|
| Implemented by | [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/), [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) |
| Source | `Filesystem/FilesystemAdapterInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`delete(string $path): void`](#delete) | Best-effort: a no-op if $path does not exist. |
| [`exists(string $path): bool`](#exists) | Reports whether a file is stored at $path. |
| [`lastModified(string $path): DateTimeImmutable`](#lastmodified) |  |
| [`read(string $path): string`](#read) |  |
| [`size(string $path): int`](#size) |  |
| [`write(string $path, string $contents): void`](#write) | Stores $contents at $path, replacing whatever was there. |

### delete()

`abstract public function delete(string $path): void`

Best-effort: a no-op if $path does not exist.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

### exists()

`abstract public function exists(string $path): bool`

Reports whether a file is stored at $path.

Directories and prefixes do not count as files.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`

### lastModified()

`abstract public function lastModified(string $path): DateTimeImmutable`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

| Throws | When |
|---|---|
| `FileNotFoundStorageException` | if $path does not exist. |

### read()

`abstract public function read(string $path): string`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `FileNotFoundStorageException` | if $path does not exist. |

### size()

`abstract public function size(string $path): int`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `int`

| Throws | When |
|---|---|
| `FileNotFoundStorageException` | if $path does not exist. |

### write()

`abstract public function write(string $path, string $contents): void`

Stores $contents at $path, replacing whatever was there.

Implementations create whatever container the path implies (a parent directory, a key prefix) rather than requiring the caller to prepare it, and a reader must never observe a half-written file.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$contents` | `string` |  |
