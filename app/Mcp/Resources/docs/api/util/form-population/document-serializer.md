# DocumentSerializer

> Turns the populated DOM back into the response body.

Turns the populated DOM back into the response body.

HTML serializes with saveHTML() and needs nothing else. XHTML is where the work is: DOM's XML serializer produces output that browsers and validators object to in three separate ways, and each fix here is for one of them.

The fixes are only correct for a document that was parsed as HTML but is being written as XML, which is why each is conditional rather than unconditional. A document parsed as XML in the first place already has the namespaces and CDATA sections it needs.

## Synopsis

`final readonly class DocumentSerializer`

|  |  |
|---|---|
| Source | `Util/FormPopulation/DocumentSerializer.php` |

## Constructor

### __construct()

`public function __construct(DOMDocument $document, bool $parsedAsXml, bool $properXhtml, bool $hadXmlProlog, bool $isUtf8): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$document` | `DOMDocument` |  |
| `$parsedAsXml` | `bool` |  |
| `$properXhtml` | `bool` |  |
| `$hadXmlProlog` | `bool` |  |
| `$isUtf8` | `bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`serialize(bool $xhtml, array<string, mixed> $cfg): string`](#serialize) |  |

### serialize()

`public function serialize(bool $xhtml, array<string, mixed> $cfg): string`

| Parameter | Type | Description |
|---|---|---|
| `$xhtml` | `bool` |  |
| `$cfg` | `array``<``string``, ``mixed``>` |  |

Returns `string`

| Throws | When |
|---|---|
| `QuioteException` | if a final regular-expression pass fails. |
