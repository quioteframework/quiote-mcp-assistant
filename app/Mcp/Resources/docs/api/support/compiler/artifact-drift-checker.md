# ArtifactDriftChecker

> gofmt-style drift check: does the committed file at $target already match what we'd emit right now?

gofmt-style drift check: does the committed file at $target already match what we'd emit right now?

Never writes anything -- a future CLI's `--check` mode is exactly "emit, checkDrift, exit non-zero on mismatch".

## Synopsis

`final class ArtifactDriftChecker`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Support/Compiler/ArtifactDriftChecker.php` |

## Methods

| Method | Description |
|---|---|
| [`check(EmittedArtifact $artifact, string $target): ArtifactDriftResult`](#check) | Compares a freshly emitted artifact against the file currently at $target. |

### check()

`public function check(EmittedArtifact $artifact, string $target): ArtifactDriftResult`

Compares a freshly emitted artifact against the file currently at $target.

A missing target, or one that cannot be read, counts as drift with a null existing checksum; otherwise the result is in sync when the SHA-256 of the file on disk equals the artifact's checksum. Nothing is written.

| Parameter | Type | Description |
|---|---|---|
| `$artifact` | [`EmittedArtifact`](/api/support/compiler/emitted-artifact/) |  |
| `$target` | `string` |  |

Returns [`ArtifactDriftResult`](/api/support/compiler/artifact-drift-result/)
