# FilesystemManager

> App-facing entry point: `$container->get(FilesystemManager::class)->write('reports/x.csv', $csv)`.

App-facing entry point: `$container->get(FilesystemManager::class)->write('reports/x.csv', $csv)`.

Resolves the configured driver (or an explicit alias) from [`FilesystemDriverRegistry`](/api/filesystem/filesystem-driver-registry/) via [`Container::get()`](/api/di/container/#get) — a driver is a long-lived service (memoized like any other), not constructed per call. Mirrors [`QueueManager`](/api/queue/queue-manager/) exactly.

## Synopsis

`final readonly class FilesystemManager`

|  |  |
|---|---|
| Source | `FilesystemManager.php` |

## Constructor

### __construct()

`public function __construct(Container $container, FilesystemConfig $config): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |
| `$config` | [`FilesystemConfig`](/api/filesystem/filesystem-config/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`delete(string $path): void`](#delete) | Deletes $path from the default disk. |
| [`disk(?string $alias = null): FilesystemAdapterInterface`](#disk) | Resolves a disk by driver alias, defaulting to the configured `filesystem.default_disk`. |
| [`exists(string $path): bool`](#exists) | Reports whether $path exists on the default disk. |
| [`listContents(string $path = ''): list<string>`](#listcontents) |  |
| [`listableDisk(?string $alias = null): ListableFilesystemInterface`](#listabledisk) | The configured disk, narrowed to one that can enumerate its contents. |
| [`read(string $path): string`](#read) | Reads $path from the default disk. |
| [`write(string $path, string $contents): void`](#write) | Writes $contents to $path on the default disk. |

### delete()

`public function delete(string $path): void`

Deletes $path from the default disk.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

### disk()

`public function disk(?string $alias = null): FilesystemAdapterInterface`

Resolves a disk by driver alias, defaulting to the configured `filesystem.default_disk`.

The alias is mapped to a class through [`FilesystemDriverRegistry`](/api/filesystem/filesystem-driver-registry/) and the instance comes from the container, so a driver registered as a singleton is shared across calls rather than rebuilt per operation.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `?``string` |  |

Returns [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | If the alias is unknown, or the class the container returned does not implement [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/). |

### exists()

`public function exists(string $path): bool`

Reports whether $path exists on the default disk.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `bool`

### listContents()

`public function listContents(string $path = ''): list<string>`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `list``<``string``>` — Relative paths directly under $path, non-recursive.

| Throws | When |
|---|---|
| `RuntimeException` | If the configured driver cannot enumerate. |

### listableDisk()

`public function listableDisk(?string $alias = null): ListableFilesystemInterface`

The configured disk, narrowed to one that can enumerate its contents.

Not every store can: the object-store drivers are built on single-object calls with no list endpoint. Asking here rather than discovering it from a thrown exception means the failure names the disk that cannot do it and the driver behind it.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `?``string` |  |

Returns [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | If the resolved driver is not listable. |

### read()

`public function read(string $path): string`

Reads $path from the default disk.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `string`

### write()

`public function write(string $path, string $contents): void`

Writes $contents to $path on the default disk.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$contents` | `string` |  |
