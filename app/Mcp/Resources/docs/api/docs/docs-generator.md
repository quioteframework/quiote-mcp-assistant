# DocsGenerator

> Turns the documentation model into the full set of pages, plus the manifest that describes it.

Turns the documentation model into the full set of pages, plus the manifest that describes it.

Nothing here touches the filesystem: the command decides what to do with the artifacts, so a drift check can compare them against disk without writing, and a test can assert on them without a temporary directory.

## Synopsis

`final class DocsGenerator`

|  |  |
|---|---|
| Source | `DocsGenerator.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `MANIFEST_FILE` | `'.manifest.json'` |  |

## Constructor

### __construct()

`public function __construct(Markdown $markdown = new Markdown(…), string $basePath = '/api'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$markdown` | [`Markdown`](/api/docs/emitter/markdown/) |  |
| `$basePath` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`generate(ApiIndex $index): array<string, EmittedArtifact>`](#generate) | Every page the reference consists of, keyed by its path below the output directory. |
| [`getDiagnostics(): list<Diagnostic>`](#getdiagnostics) |  |
| [`readManifest(string $outputDir): array<string, string>|null`](#readmanifest) | Reads a manifest previously written to $outputDir. |

### generate()

`public function generate(ApiIndex $index): array<string, EmittedArtifact>`

Every page the reference consists of, keyed by its path below the output directory.

| Parameter | Type | Description |
|---|---|---|
| `$index` | [`ApiIndex`](/api/docs/ir/api-index/) |  |

Returns `array``<``string``, `[`EmittedArtifact`](/api/support/compiler/emitted-artifact/)`>`

### getDiagnostics()

`public function getDiagnostics(): list<Diagnostic>`

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`

### readManifest()

`public function readManifest(string $outputDir): array<string, string>|null`

Reads a manifest previously written to $outputDir.

| Parameter | Type | Description |
|---|---|---|
| `$outputDir` | `string` |  |

Returns `array``<``string``, ``string``>``|``null` — Target path => checksum, or null when there is none.
