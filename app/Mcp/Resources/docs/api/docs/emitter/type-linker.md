# TypeLinker

> Renders a type as Markdown, linking the parts that have somewhere to point.

Renders a type as Markdown, linking the parts that have somewhere to point.

Only the class names inside a type are linked, never the whole thing, so `list<Route>|null` keeps `list` and `null` as plain text while `Route` reaches its page. A type used in a signature line is rendered plain instead: a link inside a code span does not render, so signatures stay code and the tables beside them carry the links.

## Synopsis

`final class TypeLinker`

|  |  |
|---|---|
| Source | `Emitter/TypeLinker.php` |

## Constructor

### __construct()

`public function __construct(ApiIndex $index, string $basePath = '/api'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$index` | [`ApiIndex`](/api/docs/ir/api-index/) |  |
| `$basePath` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`link(string $fqcn): ?string`](#link) | The link for one class, or null when it is not part of the reference. |
| [`plain(string $text): string`](#plain) | The plain-text form of prose, for a frontmatter description where a link cannot go. |
| [`prose(string $text): string`](#prose) | Turns the ``…`` markers the reference resolver left in prose into real links. |
| [`render(TypeRef $type): string`](#render) | The type as Markdown, with every documented class inside it linked. |

### link()

`public function link(string $fqcn): ?string`

The link for one class, or null when it is not part of the reference.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `?``string`

### plain()

`public function plain(string $text): string`

The plain-text form of prose, for a frontmatter description where a link cannot go.

| Parameter | Type | Description |
|---|---|---|
| `$text` | `string` |  |

Returns `string`

### prose()

`public function prose(string $text): string`

Turns the ``…`` markers the reference resolver left in prose into real links.

A marker naming a member becomes a link to that member's anchor on its class's page. A marker naming something the reference does not document degrades to inline code, which still reads correctly.

| Parameter | Type | Description |
|---|---|---|
| `$text` | `string` |  |

Returns `string`

### render()

`public function render(TypeRef $type): string`

The type as Markdown, with every documented class inside it linked.

| Parameter | Type | Description |
|---|---|---|
| `$type` | [`TypeRef`](/api/docs/ir/type-ref/) |  |

Returns `string`
