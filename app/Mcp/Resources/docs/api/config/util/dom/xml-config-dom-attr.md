# XmlConfigDomAttr

> Extended DOMAttr class.

Extended DOMAttr class.

## Synopsis

`class XmlConfigDomAttr extends DOMAttr implements Stringable`

|  |  |
|---|---|
| Extends | `DOMAttr` |
| Implements | [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Since | `1.0.0` |
| Source | `Config/Util/DOM/XmlConfigDomAttr.php` |

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) |  |
| [`getValue(): ?string`](#getvalue) | Returns the attribute's value, or null when the node carries none. |

### __toString()

`public function __toString(): string`

Returns `string`

### getValue()

`public function getValue(): ?string`

Returns the attribute's value, or null when the node carries none.

Returns `?``string`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `C14N()` | `DOMNode` |  |
| `C14NFile()` | `DOMNode` |  |
| `appendChild()` | `DOMNode` |  |
| `cloneNode()` | `DOMNode` |  |
| `compareDocumentPosition()` | `DOMNode` |  |
| `contains()` | `DOMNode` |  |
| `getLineNo()` | `DOMNode` |  |
| `getNodePath()` | `DOMNode` |  |
| `getRootNode()` | `DOMNode` |  |
| `hasAttributes()` | `DOMNode` |  |
| `hasChildNodes()` | `DOMNode` |  |
| `insertBefore()` | `DOMNode` |  |
| `isDefaultNamespace()` | `DOMNode` |  |
| `isEqualNode()` | `DOMNode` |  |
| `isId()` | `DOMAttr` |  |
| `isSameNode()` | `DOMNode` |  |
| `isSupported()` | `DOMNode` |  |
| `lookupNamespaceURI()` | `DOMNode` |  |
| `lookupPrefix()` | `DOMNode` |  |
| `normalize()` | `DOMNode` |  |
| `removeChild()` | `DOMNode` |  |
| `replaceChild()` | `DOMNode` |  |
