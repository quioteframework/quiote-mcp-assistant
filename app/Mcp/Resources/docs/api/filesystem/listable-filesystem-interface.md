# ListableFilesystemInterface

> A filesystem that can enumerate what it holds.

A filesystem that can enumerate what it holds.

Separate from [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) because listing is the one operation a store may genuinely not offer: the S3, GCS and Azure adapters are built on single-object REST calls with no list endpoint, so they can read, write, delete, stat and test existence but cannot enumerate. Declaring listContents() on the base contract and throwing from three of four implementations made every consumer's type useless -- it could not tell whether the call would work without knowing which adapter it actually held.

Type-hint this where listing is required, and the wiring fails at the point a non-listable driver is configured rather than at the point it is called. Same shape as [`PollableQueueDriverInterface`](/api/queue/pollable-queue-driver-interface/), for the same reason.

## Synopsis

`interface ListableFilesystemInterface extends FilesystemAdapterInterface`

|  |  |
|---|---|
| Implements | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) |
| Implemented by | [`LocalFilesystemAdapter`](/api/filesystem/local-filesystem-adapter/) |
| Since | `3.2.0` |
| Source | `Filesystem/ListableFilesystemInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`listContents(string $path = ''): list<string>`](#listcontents) | The entries directly under $path. |

### listContents()

`abstract public function listContents(string $path = ''): list<string>`

The entries directly under $path.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |

Returns `list``<``string``>` — Relative paths, non-recursive.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) | Best-effort: a no-op if $path does not exist. |
| `exists()` | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) | Reports whether a file is stored at $path. |
| `lastModified()` | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) |  |
| `read()` | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) |  |
| `size()` | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) |  |
| `write()` | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) | Stores $contents at $path, replacing whatever was there. |
