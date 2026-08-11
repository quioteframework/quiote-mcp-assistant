# ParsedDocument

> A response body parsed into a DOM, with the decisions the parse made.

A response body parsed into a DOM, with the decisions the parse made.

Those decisions -- whether the document is XHTML, whether it was parsed as XML, whether it already carried an XML prolog, and what namespace prefix XPath expressions need -- are all made while reading the document and all needed again when writing it back out. Carrying them together is what keeps the serializer from having to guess.

## Synopsis

`final readonly class ParsedDocument`

|  |  |
|---|---|
| Source | `Util/FormPopulation/ParsedDocument.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$document` | `DOMDocument` | _readonly._ |
| `$hadXmlProlog` | `bool` | _readonly._ |
| `$isXhtml` | `bool` | _readonly._ |
| `$parsedAsXml` | `bool` | _readonly._ |
| `$xmlnsPrefix` | `string` | _readonly._ Prefix XPath expressions need for HTML elements, "html:" or "". |
| `$xpath` | `DOMXPath` | _readonly._ |

## Constructor

### __construct()

`public function __construct(DOMDocument $document, DOMXPath $xpath, string $xmlnsPrefix, bool $isXhtml, bool $parsedAsXml, bool $hadXmlProlog): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$document` | `DOMDocument` |  |
| `$xpath` | `DOMXPath` |  |
| `$xmlnsPrefix` | `string` |  |
| `$isXhtml` | `bool` |  |
| `$parsedAsXml` | `bool` |  |
| `$hadXmlProlog` | `bool` |  |

Returns `mixed`
