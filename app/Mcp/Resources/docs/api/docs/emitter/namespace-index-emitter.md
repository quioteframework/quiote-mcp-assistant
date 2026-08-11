# NamespaceIndexEmitter

> Renders the index page for one namespace.

Renders the index page for one namespace.

These pages are what the site's navigation lists. Every class page is reached from the table on one of them rather than from the sidebar, because a sidebar naming all several hundred classes is rendered into every page of the site and would multiply its weight.

## Synopsis

`final class NamespaceIndexEmitter`

|  |  |
|---|---|
| Source | `Emitter/NamespaceIndexEmitter.php` |

## Constructor

### __construct()

`public function __construct(ApiIndex $index, TypeLinker $linker, Markdown $markdown = new Markdown(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$index` | [`ApiIndex`](/api/docs/ir/api-index/) |  |
| `$linker` | [`TypeLinker`](/api/docs/emitter/type-linker/) |  |
| `$markdown` | [`Markdown`](/api/docs/emitter/markdown/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`emit(string $namespace): EmittedArtifact`](#emit) |  |

### emit()

`public function emit(string $namespace): EmittedArtifact`

| Parameter | Type | Description |
|---|---|---|
| `$namespace` | `string` |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)
