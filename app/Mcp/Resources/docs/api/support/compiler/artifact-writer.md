# ArtifactWriter

> Writes an EmittedArtifact to disk.

Writes an EmittedArtifact to disk.

Emitters never write files themselves (see EmitterInterface) so that a future CLI's --check mode can compare against disk without ever touching it, and so tests can emit without filesystem side effects.

## Synopsis

`interface ArtifactWriter`

|  |  |
|---|---|
| Implemented by | [`FilesystemArtifactWriter`](/api/support/compiler/filesystem-artifact-writer/) |
| Since | `1.0.0` |
| Source | `Support/Compiler/ArtifactWriter.php` |

## Methods

| Method | Description |
|---|---|
| [`write(EmittedArtifact $artifact, string $target): void`](#write) | Persists the artifact's PHP source at $target. |

### write()

`abstract public function write(EmittedArtifact $artifact, string $target): void`

Persists the artifact's PHP source at $target.

Implementations must create whatever parent structure $target needs, and must never leave a partially written artifact visible at that path: either the complete artifact is there afterwards, or an exception is thrown.

| Parameter | Type | Description |
|---|---|---|
| `$artifact` | [`EmittedArtifact`](/api/support/compiler/emitted-artifact/) |  |
| `$target` | `string` |  |
