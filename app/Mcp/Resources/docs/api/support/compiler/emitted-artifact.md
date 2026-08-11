# EmittedArtifact

> The result of emitting a ValidatorPlan through a back-end: the PHP source text, a checksum of it (for --check drift detection without writing anything to disk), and a hint for where it would naturally be written.

The result of emitting a ValidatorPlan through a back-end: the PHP source text, a checksum of it (for --check drift detection without writing anything to disk), and a hint for where it would naturally be written.

Emitters never write files themselves -- ArtifactWriter (and eventually a CLI) decides that.

## Synopsis

`final class EmittedArtifact`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Support/Compiler/EmittedArtifact.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$checksum` | `string` | _readonly._ |
| `$phpSource` | `string` | _readonly._ |
| `$targetHint` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $phpSource, string $checksum, string $targetHint): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$phpSource` | `string` |  |
| `$checksum` | `string` |  |
| `$targetHint` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromSource(string $phpSource, string $targetHint): EmittedArtifact`](#fromsource) |  |

### fromSource()

`public static function fromSource(string $phpSource, string $targetHint): EmittedArtifact`

| Parameter | Type | Description |
|---|---|---|
| `$phpSource` | `string` |  |
| `$targetHint` | `string` |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)
