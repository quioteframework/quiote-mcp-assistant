# FilesystemArtifactWriter

> Writes an EmittedArtifact to a real file, via a write-to-temp-then-rename so a concurrent request (or an opcache-warmed worker) never observes a partially written compiled validator file -- rename() is atomic on the same filesystem, unlike a direct file_put_contents() to the final path.

Writes an EmittedArtifact to a real file, via a write-to-temp-then-rename so a concurrent request (or an opcache-warmed worker) never observes a partially written compiled validator file -- rename() is atomic on the same filesystem, unlike a direct file_put_contents() to the final path.

## Synopsis

`final class FilesystemArtifactWriter implements ArtifactWriter`

|  |  |
|---|---|
| Implements | [`ArtifactWriter`](/api/support/compiler/artifact-writer/) |
| Since | `1.0.0` |
| Source | `Support/Compiler/FilesystemArtifactWriter.php` |

## Methods

| Method | Description |
|---|---|
| [`write(EmittedArtifact $artifact, string $target): void`](#write) | Creates the target directory when missing, writes the source to a process-unique temporary file beside it and renames that into place. |

### write()

`public function write(EmittedArtifact $artifact, string $target): void`

Creates the target directory when missing, writes the source to a process-unique temporary file beside it and renames that into place.

A failed rename removes the temporary file before throwing.

| Parameter | Type | Description |
|---|---|---|
| `$artifact` | [`EmittedArtifact`](/api/support/compiler/emitted-artifact/) |  |
| `$target` | `string` |  |

| Throws | When |
|---|---|
| `RuntimeException` | If the directory cannot be created, the temporary file cannot be written, or the rename fails. |
