# DocumentLoader

> Parses a response body into a DOM, deciding as it goes whether the document is XHTML and how strictly to read it.

Parses a response body into a DOM, deciding as it goes whether the document is XHTML and how strictly to read it.

Two things make this more than a loadHTML() call. First, the document is whatever a view produced, so parse errors are normal and how loudly to complain is configuration: below the configured threshold they are logged and populating continues, above it they abort the request, and a fatal always stops populating because there is no usable tree to work on.

Second, an XHTML document served as ISO-8859-1 needs an XML prolog for the parser to read it correctly, so one is added when the content type declares a charset and the document has none. Whether it was added matters later -- a document that arrived without a prolog should not leave with one.

## Synopsis

`final readonly class DocumentLoader`

|  |  |
|---|---|
| Source | `Util/FormPopulation/DocumentLoader.php` |

## Constructor

### __construct()

`public function __construct(CategoryLogger $logger): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$logger` | [`CategoryLogger`](/api/logging/category-logger/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`load(string $output, array<string, mixed> $cfg, ?string $contentTypeHeader): ?ParsedDocument`](#load) |  |

### load()

`public function load(string $output, array<string, mixed> $cfg, ?string $contentTypeHeader): ?ParsedDocument`

The output type's Content-Type, for its charset.

| Parameter | Type | Description |
|---|---|---|
| `$output` | `string` |  |
| `$cfg` | `array``<``string``, ``mixed``>` |  |
| `$contentTypeHeader` | `?``string` | The output type's Content-Type, for its charset. |

Returns `?`[`ParsedDocument`](/api/util/form-population/parsed-document/) — Null when a fatal error leaves nothing to populate.

| Throws | When |
|---|---|
| `ParseException` | if an error exceeds the configured tolerance. |
