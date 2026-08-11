# ArtifactDriftResult

> The result of comparing a freshly emitted artifact against whatever is (or isn't) already on disk at its target path, without writing anything.

The result of comparing a freshly emitted artifact against whatever is (or isn't) already on disk at its target path, without writing anything.

## Synopsis

`final class ArtifactDriftResult`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Support/Compiler/ArtifactDriftResult.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$existingChecksum` | `?``string` | _readonly._ |
| `$expectedChecksum` | `string` | _readonly._ |
| `$matches` | `bool` | _readonly._ |
| `$target` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(bool $matches, ?string $existingChecksum, string $expectedChecksum, string $target): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$matches` | `bool` |  |
| `$existingChecksum` | `?``string` |  |
| `$expectedChecksum` | `string` |  |
| `$target` | `string` |  |

Returns `mixed`
