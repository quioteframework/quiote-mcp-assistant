# ApiIndexEmitter

> Renders the reference's own landing page: every top-level namespace and what it holds.

Renders the reference's own landing page: every top-level namespace and what it holds.

## Synopsis

`final class ApiIndexEmitter`

|  |  |
|---|---|
| Source | `Emitter/ApiIndexEmitter.php` |

## Constructor

### __construct()

`public function __construct(ApiIndex $index, Markdown $markdown = new Markdown(…), ?TypeLinker $linker = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$index` | [`ApiIndex`](/api/docs/ir/api-index/) |  |
| `$markdown` | [`Markdown`](/api/docs/emitter/markdown/) |  |
| `$linker` | `?`[`TypeLinker`](/api/docs/emitter/type-linker/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`emit(): EmittedArtifact`](#emit) |  |

### emit()

`public function emit(): EmittedArtifact`

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)
