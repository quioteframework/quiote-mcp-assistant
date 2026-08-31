# Gcs

> The Quiote\\Filesystem\\Gcs namespace — 2 documented types.

Everything under `Quiote\Filesystem\Gcs`.

## Classes

| Class | Description |
|---|---|
| [`GcsFilesystemAdapter`](/api/filesystem/gcs/gcs-filesystem-adapter/) | [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) over [`GcsClient`](/api/storage/gcs/gcs-client/) (HMAC interop-key REST client, no google/cloud-storage). |
| [`GcsFilesystemPlugin`](/api/filesystem/gcs/gcs-filesystem-plugin/) | Registers the `gcs` filesystem driver alias and publishes `filesystem.disks.gcs.*` config defaults. |
