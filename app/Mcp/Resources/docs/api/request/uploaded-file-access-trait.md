# UploadedFileAccessTrait

> Convenience accessors returning flat lists of UploadedFileInterface instances, hiding PSR-7's nested-array upload structure from callers.

Convenience accessors returning flat lists of UploadedFileInterface instances, hiding PSR-7's nested-array upload structure from callers.

## Synopsis

`trait UploadedFileAccessTrait`

|  |  |
|---|---|
| Source | `Request/UploadedFileAccessTrait.php` |

## Methods

| Method | Description |
|---|---|
| [`getFile(string $name, mixed $default = null): mixed`](#getfile) | Convenience alias for getUploadedFileArray — returns PSR-7 UploadedFileInterface array. |
| [`getUploadedFile(string $name): ?UploadedFileInterface`](#getuploadedfile) | Return the first uploaded file for a given field name or null if none exist. |
| [`getUploadedFileArray(string $name): array<UploadedFileInterface>`](#getuploadedfilearray) |  |

### getFile()

`public function getFile(string $name, mixed $default = null): mixed`

Convenience alias for getUploadedFileArray — returns PSR-7 UploadedFileInterface array.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getUploadedFile()

`public function getUploadedFile(string $name): ?UploadedFileInterface`

Return the first uploaded file for a given field name or null if none exist.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `?`[`UploadedFileInterface`](https://www.php-fig.org/psr/psr-7/)

### getUploadedFileArray()

`public function getUploadedFileArray(string $name): array<UploadedFileInterface>`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `array``<`[`UploadedFileInterface`](https://www.php-fig.org/psr/psr-7/)`>`
