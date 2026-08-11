# GcsFilesystemPlugin

> Registers the `gcs` filesystem driver alias and publishes `filesystem.disks.gcs.*` config defaults.

Registers the `gcs` filesystem driver alias and publishes `filesystem.disks.gcs.*` config defaults.

Requires a PSR-18 `ClientInterface` to already be bound in the container (bring your own HTTP client, same as `quioteframework/session-gcs`).

## Synopsis

`final class GcsFilesystemPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `GcsFilesystemPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `filesystem.disks.gcs.*` defaults, registers the `gcs` driver alias and binds [`GcsFilesystemAdapter`](/api/filesystem/gcs/gcs-filesystem-adapter/) as a singleton. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `filesystem.disks.gcs.*` defaults, registers the `gcs` driver alias and binds [`GcsFilesystemAdapter`](/api/filesystem/gcs/gcs-filesystem-adapter/) as a singleton.

The adapter's factory reads bucket, HMAC credentials, endpoint and key prefix from config at resolution time and pulls the PSR-18 client out of the container then, so registering this plugin without an HTTP client bound only fails once the disk is used.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
