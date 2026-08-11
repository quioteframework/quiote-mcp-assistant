# S3FilesystemPlugin

> Registers the `s3` filesystem driver alias and publishes `filesystem.disks.s3.*` config defaults.

Registers the `s3` filesystem driver alias and publishes `filesystem.disks.s3.*` config defaults.

Requires a PSR-18 `ClientInterface` to already be bound in the container (bring your own HTTP client, same as `quioteframework/session-s3`).

## Synopsis

`final class S3FilesystemPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `S3FilesystemPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `filesystem.disks.s3.*` defaults, registers the `s3` driver alias and binds [`S3FilesystemAdapter`](/api/filesystem/s3/s3-filesystem-adapter/) as a singleton. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `filesystem.disks.s3.*` defaults, registers the `s3` driver alias and binds [`S3FilesystemAdapter`](/api/filesystem/s3/s3-filesystem-adapter/) as a singleton.

The adapter's factory reads region, bucket, credentials, optional endpoint and key prefix from config at resolution time and pulls the PSR-18 client out of the container then, so registering this plugin without an HTTP client bound only fails once the disk is used.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
