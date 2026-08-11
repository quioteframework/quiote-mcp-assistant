# ClassPageEmitter

> Renders one class as a Starlight page.

Renders one class as a Starlight page.

The output follows the site's own conventions: the H1 comes from the frontmatter title, so the body starts at `##`; a lead paragraph precedes the first heading; internal links are root-absolute and end in a slash. Signatures are inline code rather than fenced PHP, which keeps several thousand syntax-highlighting passes out of the site build; the tables beside them carry the linked types instead.

## Synopsis

`final class ClassPageEmitter`

|  |  |
|---|---|
| Source | `Emitter/ClassPageEmitter.php` |

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
| [`emit(ClassDoc $class): EmittedArtifact`](#emit) |  |

### emit()

`public function emit(ClassDoc $class): EmittedArtifact`

| Parameter | Type | Description |
|---|---|---|
| `$class` | [`ClassDoc`](/api/docs/ir/class-doc/) |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)
