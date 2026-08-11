# FilesystemConfig

> Typed snapshot of the `filesystem.*` settings family.

Typed snapshot of the `filesystem.*` settings family.

Defaults here are read as fallbacks only — [`FilesystemPlugin`](/api/filesystem/filesystem-plugin/) is what actually publishes them into [`Config`](/api/config/config/) via `configDefault()`.

v1 supports one instance per driver alias — there is no multi-instance config for e.g. two differently-configured S3 buckets under the same `s3` alias.

## Synopsis

`final readonly class FilesystemConfig`

|  |  |
|---|---|
| Source | `Filesystem/FilesystemConfig.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$defaultDisk` | `string` | _readonly._ |
| `$localRoot` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $defaultDisk, string $localRoot): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$defaultDisk` | `string` |  |
| `$localRoot` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromConfig(): FilesystemConfig`](#fromconfig) | Reads the current `filesystem.*` settings into a snapshot. |

### fromConfig()

`public static function fromConfig(): FilesystemConfig`

Reads the current `filesystem.*` settings into a snapshot.

The values are captured at call time; a later [`Config`](/api/config/config/) change is not reflected in an instance already built. Missing settings fall back to the `local` disk rooted at `storage/app`.

Returns [`FilesystemConfig`](/api/filesystem/filesystem-config/)
