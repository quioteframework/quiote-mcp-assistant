# Markdown

> The small amount of Markdown and YAML escaping the emitters share.

The small amount of Markdown and YAML escaping the emitters share.

Docblock prose was written for a PHP comment, not for a table cell or a YAML scalar, so anything crossing into one has to be made safe first: an unescaped pipe silently splits a row, and a colon or a quote can make a frontmatter block unparsable and fail the site build.

## Synopsis

`final class Markdown`

|  |  |
|---|---|
| Source | `Emitter/Markdown.php` |

## Methods

| Method | Description |
|---|---|
| [`cell(string $text): string`](#cell) | Prose made safe for a table cell. |
| [`oneLine(string $text): string`](#oneline) | Collapses prose onto one line, for a description or a table cell. |
| [`table(list<string> $headers, list<list<string>> $rows, bool $headerless = false): string`](#table) | A Markdown table in the site's own style: terse separators, no padding, no alignment colons. |
| [`yamlScalar(string $value): string`](#yamlscalar) | A YAML scalar that survives whatever the prose contains. |

### cell()

`public function cell(string $text): string`

Prose made safe for a table cell.

A pipe would end the cell, and a line break would end the row.

| Parameter | Type | Description |
|---|---|---|
| `$text` | `string` |  |

Returns `string`

### oneLine()

`public function oneLine(string $text): string`

Collapses prose onto one line, for a description or a table cell.

| Parameter | Type | Description |
|---|---|---|
| `$text` | `string` |  |

Returns `string`

### table()

`public function table(list<string> $headers, list<list<string>> $rows, bool $headerless = false): string`

A Markdown table in the site's own style: terse separators, no padding, no alignment colons.

Renders an empty header row, for a two-column fact list where
                        column titles would say nothing.

| Parameter | Type | Description |
|---|---|---|
| `$headers` | `list``<``string``>` |  |
| `$rows` | `list``<``list``<``string``>``>` |  |
| `$headerless` | `bool` | Renders an empty header row, for a two-column fact list where column titles would say nothing. |

Returns `string`

### yamlScalar()

`public function yamlScalar(string $value): string`

A YAML scalar that survives whatever the prose contains.

Always quoted rather than quoted-when-necessary: the rules for when a plain scalar is safe are subtle enough that guessing wrong shows up as a broken build in another repository.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |

Returns `string`
