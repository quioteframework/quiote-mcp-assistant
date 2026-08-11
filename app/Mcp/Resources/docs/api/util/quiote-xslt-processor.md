# QuioteXsltProcessor

> Extended XSLTProcessor class that throws exceptions on errors.

Extended XSLTProcessor class that throws exceptions on errors.

## Synopsis

`class QuioteXsltProcessor extends XSLTProcessor`

|  |  |
|---|---|
| Extends | `XSLTProcessor` |
| Since | `1.0.0` |
| Source | `Util/QuioteXsltProcessor.php` |

## Methods

| Method | Description |
|---|---|
| [`importStylesheet(DOMDocument $stylesheet): bool`](#importstylesheet) | Import a stylesheet. |
| [`transformToDoc(mixed $doc, mixed $returnClass = null): object`](#transformtodoc) | Transform a document with a stylesheet. |

### importStylesheet()

`public function importStylesheet(DOMDocument $stylesheet): bool`

Import a stylesheet.

The stylesheet to import.

| Parameter | Type | Description |
|---|---|---|
| `$stylesheet` | `DOMDocument` | The stylesheet to import. |

Returns `bool`

### transformToDoc()

`public function transformToDoc(mixed $doc, mixed $returnClass = null): object`

Transform a document with a stylesheet.

The document to transform; must be a DOMDocument or SimpleXMLElement.

| Parameter | Type | Description |
|---|---|---|
| `$doc` | `mixed` | The document to transform; must be a DOMDocument or SimpleXMLElement. |
| `$returnClass` | `mixed` |  |

Returns `object` — The resulting DOMDocument (or subclass of $doc's owner document).

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getParameter()` | `XSLTProcessor` |  |
| `getSecurityPrefs()` | `XSLTProcessor` |  |
| `hasExsltSupport()` | `XSLTProcessor` |  |
| `registerPHPFunctionNS()` | `XSLTProcessor` |  |
| `registerPHPFunctions()` | `XSLTProcessor` |  |
| `removeParameter()` | `XSLTProcessor` |  |
| `setParameter()` | `XSLTProcessor` |  |
| `setProfiling()` | `XSLTProcessor` |  |
| `setSecurityPrefs()` | `XSLTProcessor` |  |
| `transformToUri()` | `XSLTProcessor` |  |
| `transformToXml()` | `XSLTProcessor` |  |
