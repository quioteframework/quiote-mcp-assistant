# FilesystemPlugin

> Registers the filesystem subsystem: `filesystem.*` setting defaults (`local` disk rooted at `storage/app`, out of the box) and the FilesystemManager service app code depends on.

Registers the filesystem subsystem: `filesystem.*` setting defaults (`local` disk rooted at `storage/app`, out of the box) and the [`FilesystemManager`](/api/filesystem/filesystem-manager/) service app code depends on.

A cloud backend (e.g. `quioteframework/filesystem-s3`) registers its own alias into [`FilesystemDriverRegistry`](/api/filesystem/filesystem-driver-registry/) from its own plugin — this class does not need to change for that.

Like every plugin, this is opt-in via the `plugins` config key — even though it lives in core, an app must list it to get [`FilesystemManager`](/api/filesystem/filesystem-manager/).

## Synopsis

`final class FilesystemPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `Filesystem/FilesystemPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Publishes the `filesystem.default_disk` and `filesystem.disks.local.root` defaults and binds [`FilesystemConfig`](/api/filesystem/filesystem-config/), [`LocalFilesystemAdapter`](/api/filesystem/local-filesystem-adapter/) and [`FilesystemManager`](/api/filesystem/filesystem-manager/). |

### register()

`public function register(PluginRegistrar $registrar): void`

Publishes the `filesystem.default_disk` and `filesystem.disks.local.root` defaults and binds [`FilesystemConfig`](/api/filesystem/filesystem-config/), [`LocalFilesystemAdapter`](/api/filesystem/local-filesystem-adapter/) and [`FilesystemManager`](/api/filesystem/filesystem-manager/).

The adapter and the manager are registered as factories that read [`FilesystemConfig`](/api/filesystem/filesystem-config/) out of the container when first resolved, so an app's own config overrides apply even though the defaults are declared here.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
