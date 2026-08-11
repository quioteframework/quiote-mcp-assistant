# DocblockParser

> Turns a raw docblock into a DocBlock.

Turns a raw docblock into a [`DocBlock`](/api/docs/ir/doc-block/).

A real parser rather than the line-stripping regexes the framework uses elsewhere, because a reference page needs the tags those throw away: `@param` and `@return` carry the narrow types (`list<Route>` where the signature only says `array`), and `@throws` is a section of its own.

## Synopsis

`final class DocblockParser`

|  |  |
|---|---|
| Source | `Docblock/DocblockParser.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`parse(?string $docComment): DocBlock`](#parse) | Parses a docblock, treating a missing or unparsable one as simply empty. |

### parse()

`public function parse(?string $docComment): DocBlock`

Parses a docblock, treating a missing or unparsable one as simply empty.

| Parameter | Type | Description |
|---|---|---|
| `$docComment` | `?``string` |  |

Returns [`DocBlock`](/api/docs/ir/doc-block/)
