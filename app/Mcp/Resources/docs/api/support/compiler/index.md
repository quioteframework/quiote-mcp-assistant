# Compiler

> The Quiote\\Support\\Compiler namespace — 6 documented types.

Everything under `Quiote\Support\Compiler`.

## Classes

| Class | Description |
|---|---|
| [`ArtifactDriftChecker`](/api/support/compiler/artifact-drift-checker/) | gofmt-style drift check: does the committed file at $target already match what we'd emit right now? |
| [`ArtifactDriftResult`](/api/support/compiler/artifact-drift-result/) | The result of comparing a freshly emitted artifact against whatever is (or isn't) already on disk at its target path, without writing anything. |
| [`Diagnostic`](/api/support/compiler/diagnostic/) | A single problem or note surfaced while building a ValidatorPlan or emitting from one. |
| [`EmittedArtifact`](/api/support/compiler/emitted-artifact/) | The result of emitting a ValidatorPlan through a back-end: the PHP source text, a checksum of it (for --check drift detection without writing anything to disk), and a hint for where it would naturally be written. |
| [`FilesystemArtifactWriter`](/api/support/compiler/filesystem-artifact-writer/) | Writes an EmittedArtifact to a real file, via a write-to-temp-then-rename so a concurrent request (or an opcache-warmed worker) never observes a partially written compiled validator file -- rename() is atomic on the same filesystem, unlike a direct file_put_contents() to the final path. |

## Interfaces

| Interface | Description |
|---|---|
| [`ArtifactWriter`](/api/support/compiler/artifact-writer/) | Writes an EmittedArtifact to disk. |
