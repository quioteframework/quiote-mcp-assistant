# S3

> The Quiote\\Filesystem\\S3 namespace — 2 documented types.

Everything under `Quiote\Filesystem\S3`.

## Classes

| Class | Description |
|---|---|
| [`S3FilesystemAdapter`](/api/filesystem/s3/s3-filesystem-adapter/) | [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) over [`S3Client`](/api/storage/s3/s3-client/) (SigV4 REST client, no aws-sdk-php). |
| [`S3FilesystemPlugin`](/api/filesystem/s3/s3-filesystem-plugin/) | Registers the `s3` filesystem driver alias and publishes `filesystem.disks.s3.*` config defaults. |
