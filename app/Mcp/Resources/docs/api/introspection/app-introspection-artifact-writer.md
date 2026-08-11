# AppIntrospectionArtifactWriter

> Writes the `cache/introspection/app.json` artifact via a write-to-temp-then-rename, so an editor extension polling the file never observes a partial write mid-regeneration -- the same technique `Quiote\\Support\\Compiler\\FilesystemArtifactWriter` uses for compiled PHP artifacts, just for arbitrary JSON content instead of PHP source.

Writes the `cache/introspection/app.json` artifact via a write-to-temp-then-rename, so an editor extension polling the file never observes a partial write mid-regeneration -- the same technique `Quiote\Support\Compiler\FilesystemArtifactWriter` uses for compiled PHP artifacts, just for arbitrary JSON content instead of PHP source.

## Synopsis

`final class AppIntrospectionArtifactWriter`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Introspection/AppIntrospectionArtifactWriter.php` |

## Methods

| Method | Description |
|---|---|
| [`write(array<string, mixed> $artifact, string $target): void`](#write) |  |

### write()

`public function write(array<string, mixed> $artifact, string $target): void`

| Parameter | Type | Description |
|---|---|---|
| `$artifact` | `array``<``string``, ``mixed``>` |  |
| `$target` | `string` |  |
