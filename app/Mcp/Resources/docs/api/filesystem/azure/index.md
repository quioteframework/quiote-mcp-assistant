# Azure

> The Quiote\\Filesystem\\Azure namespace — 2 documented types.

Everything under `Quiote\Filesystem\Azure`.

## Classes

| Class | Description |
|---|---|
| [`AzureFilesystemAdapter`](/api/filesystem/azure/azure-filesystem-adapter/) | [`ListableFilesystemInterface`](/api/filesystem/listable-filesystem-interface/) over [`AzureBlobClient`](/api/storage/azure/azure-blob-client/), against a fixed container. |
| [`AzureFilesystemPlugin`](/api/filesystem/azure/azure-filesystem-plugin/) | Registers the `azure` filesystem driver alias and publishes `filesystem.disks.azure.*` config defaults. |
