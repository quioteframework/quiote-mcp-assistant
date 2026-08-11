# AzureFilesystemPlugin

> Registers the `azure` filesystem driver alias and publishes `filesystem.disks.azure.*` config defaults.

Registers the `azure` filesystem driver alias and publishes `filesystem.disks.azure.*` config defaults.

Requires a PSR-18 `ClientInterface` to already be bound in the container (bring your own HTTP client, same as `quioteframework/session-azure`).

## Synopsis

`final class AzureFilesystemPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `AzureFilesystemPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `filesystem.disks.azure.*` defaults, registers the `azure` driver alias and binds [`AzureFilesystemAdapter`](/api/filesystem/azure/azure-filesystem-adapter/) as a singleton. |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `filesystem.disks.azure.*` defaults, registers the `azure` driver alias and binds [`AzureFilesystemAdapter`](/api/filesystem/azure/azure-filesystem-adapter/) as a singleton.

The adapter's factory reads account name and key, container, optional endpoint and key prefix from config at resolution time and pulls the PSR-18 client out of the container then, so registering this plugin without an HTTP client bound only fails once the disk is used.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
