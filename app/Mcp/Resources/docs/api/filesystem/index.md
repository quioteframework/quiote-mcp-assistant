# Filesystem

> The Quiote\\Filesystem namespace — 17 documented types.

Everything under `Quiote\Filesystem`.

## Classes

| Class | Description |
|---|---|
| [`FileNotFoundStorageException`](/api/filesystem/file-not-found-storage-exception/) | Thrown by [`FilesystemAdapterInterface::read()`](/api/filesystem/filesystem-adapter-interface/#read)/[`FilesystemAdapterInterface::size()`](/api/filesystem/filesystem-adapter-interface/#size)/[`FilesystemAdapterInterface::lastModified()`](/api/filesystem/filesystem-adapter-interface/#lastmodified) when the path does not exist. |
| [`FilesystemConfig`](/api/filesystem/filesystem-config/) | Typed snapshot of the `filesystem.*` settings family. |
| [`FilesystemDriverRegistry`](/api/filesystem/filesystem-driver-registry/) | Process-global registry mapping short driver aliases (e.g. |
| [`FilesystemManager`](/api/filesystem/filesystem-manager/) | App-facing entry point: `$container->get(FilesystemManager::class)->write('reports/x.csv', $csv)`. |
| [`FilesystemPlugin`](/api/filesystem/filesystem-plugin/) | Registers the filesystem subsystem: `filesystem.*` setting defaults (`local` disk rooted at `storage/app`, out of the box) and the [`FilesystemManager`](/api/filesystem/filesystem-manager/) service app code depends on. |
| [`FilesystemStorageException`](/api/filesystem/filesystem-storage-exception/) | Thrown when a [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) operation fails. |
| [`ListableObjectStoreFilesystemAdapter`](/api/filesystem/listable-object-store-filesystem-adapter/) | A [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) over any [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/), everything but listing inherited unchanged from [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/). |
| [`LocalFilesystemAdapter`](/api/filesystem/local-filesystem-adapter/) | Zero-dependency local-disk [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) — the default driver. |
| [`ObjectStoreFilesystemAdapter`](/api/filesystem/object-store-filesystem-adapter/) | A [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) over any [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/). |

## Interfaces

| Interface | Description |
|---|---|
| [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) | A general-purpose "read/write/list a file" contract, distinct from [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) (session-shaped) and the legacy `Storage` hierarchy (`SessionHandlerInterface`- bound). |
| [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) | A filesystem that can enumerate what it holds. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Azure`](/api/filesystem/azure/) | 2 types |
| [`Gcs`](/api/filesystem/gcs/) | 2 types |
| [`S3`](/api/filesystem/s3/) | 2 types |
