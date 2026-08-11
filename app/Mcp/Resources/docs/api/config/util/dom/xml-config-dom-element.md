# XmlConfigDomElement

> Extended DOMElement class with several convenience enhancements.

Extended DOMElement class with several convenience enhancements.

The owner document of any node in this DOM tree is always an XmlConfigDomDocument: XmlConfigDomDocument::__construct() registers Quiote's node classes via registerNodeClass() for every DOM node type, including DOMDocument itself, so $ownerDocument is never a vanilla DOMDocument.

## Synopsis

`class XmlConfigDomElement extends DOMElement implements IteratorAggregate, Stringable`

|  |  |
|---|---|
| Extends | `DOMElement` |
| Implements | [`IteratorAggregate`](https://www.php.net/manual/en/class.iteratoraggregate.php), [`Stringable`](https://www.php.net/manual/en/class.stringable.php) |
| Since | `1.0.0` |
| Source | `Config/Util/DOM/XmlConfigDomElement.php` |

## Methods

| Method | Description |
|---|---|
| [`__toString(): string`](#tostring) | __toString() magic method, returns the element value. |
| [`countChildren(string $name, string $namespaceUri = null, bool $pluralMagic = false): int`](#countchildren) | Count the number of child elements with a given name. |
| [`get(string $name, string $namespaceUri = null): array<int, XmlConfigDomElement>`](#get) | Convenience method to retrieve child elements of the given name. |
| [`getAttribute(string $name, ?string $default = null): ?string`](#getattribute) | Retrieve an attribute value. |
| [`getAttributeNS(string $namespaceUri, string $localName, ?string $default = null): ?string`](#getattributens) | Retrieve a namespaced attribute value. |
| [`getAttributes(): array<string, ?string>`](#getattributes) | Retrieve all attributes of the element that are in no namespace. |
| [`getAttributesNS(string $namespaceUri): array<string, ?string>`](#getattributesns) | Retrieve all attributes of the element that are in the given namespace. |
| [`getChild(string $name, string $namespaceUri = null): ?XmlConfigDomElement`](#getchild) | Return a single child element with a given name. |
| [`getChildren(string $name, string $namespaceUri = null, bool $pluralMagic = false): array<int, XmlConfigDomElement>`](#getchildren) | Retrieve all children with the given element name. |
| [`getIterator(): Traversable<int, XmlConfigDomElement>`](#getiterator) | Returns an iterator for the child nodes. |
| [`getLiteralValue(): null|bool|int|float|string`](#getliteralvalue) | Returns the literal value. |
| [`getName(): string`](#getname) | Returns the element name. |
| [`getQuioteParameters(array<int|string, mixed> $existing = []): array<int|string, mixed>`](#getquioteparameters) | Retrieve all of the Quiote parameter elements associated with this element. |
| [`getValue(): string`](#getvalue) | Returns the element value. |
| [`has(string $name, string $namespaceUri = null): bool`](#has) | Convenience method to check if there are child elements of the given name. |
| [`hasChild(string $name, string $namespaceUri = null): bool`](#haschild) | Determine whether this element has a particular child element. |
| [`hasChildren(string $name, string $namespaceUri = null, bool $pluralMagic = false): bool`](#haschildren) | Determine whether there is at least one instance of a child element with a given name. |
| [`hasQuioteParameters(): bool`](#hasquioteparameters) | Check whether or not the element has Quiote parameters as children. |

### __toString()

`public function __toString(): string`

__toString() magic method, returns the element value.

Returns `string` — The element value.

### countChildren()

`public function countChildren(string $name, string $namespaceUri = null, bool $pluralMagic = false): int`

Count the number of child elements with a given name.

Whether or not to apply automatic singular/plural
                   handling that skips plural container elements.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |
| `$pluralMagic` | `bool` | Whether or not to apply automatic singular/plural handling that skips plural container elements. |

Returns `int` — The number of child elements with the given name.

### get()

`public function get(string $name, string $namespaceUri = null): array<int, XmlConfigDomElement>`

Convenience method to retrieve child elements of the given name.

The namespace URI. If null, the document default
                   namespace will be used. If an empty string, no namespace
                   will be used.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element(s) to check for. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |

Returns `array``<``int``, `[`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/)`>` — A list of the child elements.

### getAttribute()

`public function getAttribute(string $name, ?string $default = null): ?string`

Retrieve an attribute value.

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | An attribute name. |
| `$default` | `?``string` | A default attribute value. |

Returns `?``string` — An attribute value, if the attribute exists, otherwise null or the given default.

### getAttributeNS()

`public function getAttributeNS(string $namespaceUri, string $localName, ?string $default = null): ?string`

Retrieve a namespaced attribute value.

A default attribute value.

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | A namespace URI. |
| `$localName` | `string` | An attribute name. |
| `$default` | `?``string` | A default attribute value. |

Returns `?``string` — An attribute value, if the attribute exists, otherwise null or the given default.

### getAttributes()

`public function getAttributes(): array<string, ?string>`

Retrieve all attributes of the element that are in no namespace.

Returns `array``<``string``, ``?``string``>` — An associative array of attribute names and values.

### getAttributesNS()

`public function getAttributesNS(string $namespaceUri): array<string, ?string>`

Retrieve all attributes of the element that are in the given namespace.

The namespace URI.

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | The namespace URI. |

Returns `array``<``string``, ``?``string``>` — An associative array of attribute names and values.

### getChild()

`public function getChild(string $name, string $namespaceUri = null): ?XmlConfigDomElement`

Return a single child element with a given name.

The namespace URI. If null, the document default
                   namespace will be used. If an empty string, no namespace
                   will be used.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |

Returns `?`[`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/) — The child element, or null if none exists.

### getChildren()

`public function getChildren(string $name, string $namespaceUri = null, bool $pluralMagic = false): array<int, XmlConfigDomElement>`

Retrieve all children with the given element name.

Whether or not to apply automatic singular/plural
                   handling that skips plural container elements.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |
| `$pluralMagic` | `bool` | Whether or not to apply automatic singular/plural handling that skips plural container elements. |

Returns `array``<``int``, `[`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/)`>` — A list of the child elements.

### getIterator()

`public function getIterator(): Traversable<int, XmlConfigDomElement>`

Returns an iterator for the child nodes.

Returns [`Traversable`](https://www.php.net/manual/en/class.traversable.php)`<``int``, `[`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/)`>` — An iterator.

### getLiteralValue()

`public function getLiteralValue(): null|bool|int|float|string`

Returns the literal value.

By default, that means whitespace is trimmed, boolean literals ("on", "yes", "true", "no", "off", "false") are converted and configuration directives ("%core.app_dir%") are expanded. Takes attributes {http://www.w3.org/XML/1998/namespace}space and {http://quiote.dev/quiote/config/global/envelope/1.1}literalize into account when computing the literal value. This way, users can control the trimming and the literalization of values. AEP-100 has a list of all the conversion rules that apply.

Returns `null``|``bool``|``int``|``float``|``string` — The element content converted according to the rules defined in AEP-100.

### getName()

`public function getName(): string`

Returns the element name.

Returns `string` — The element name.

### getQuioteParameters()

`public function getQuioteParameters(array<int|string, mixed> $existing = []): array<int|string, mixed>`

Retrieve all of the Quiote parameter elements associated with this element.

An array of existing parameters.

| Parameter | Type | Description |
|---|---|---|
| `$existing` | `array``<``int``|``string``, ``mixed``>` | An array of existing parameters. |

Returns `array``<``int``|``string``, ``mixed``>` — The complete array of parameters.

### getValue()

`public function getValue(): string`

Returns the element value.

Returns `string` — The element value.

### has()

`public function has(string $name, string $namespaceUri = null): bool`

Convenience method to check if there are child elements of the given name.

The namespace URI. If null, the document default
                   namespace will be used. If an empty string, no namespace
                   will be used.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element(s) to check for. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |

Returns `bool` — True if one or more child elements with the given name exist, false otherwise.

### hasChild()

`public function hasChild(string $name, string $namespaceUri = null): bool`

Determine whether this element has a particular child element.

The namespace URI. If null, the document default
                   namespace will be used. If an empty string, no namespace
                   will be used.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |

Returns `bool` — True if there is exactly one instance of an element with the given name; false otherwise.

### hasChildren()

`public function hasChildren(string $name, string $namespaceUri = null, bool $pluralMagic = false): bool`

Determine whether there is at least one instance of a child element with a given name.

Whether or not to apply automatic singular/plural
                   handling that skips plural container elements.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The name of the element. |
| `$namespaceUri` | `string` | The namespace URI. If null, the document default namespace will be used. If an empty string, no namespace will be used. |
| `$pluralMagic` | `bool` | Whether or not to apply automatic singular/plural handling that skips plural container elements. |

Returns `bool` — True if one or more child elements with the given name exist, false otherwise.

### hasQuioteParameters()

`public function hasQuioteParameters(): bool`

Check whether or not the element has Quiote parameters as children.

Returns `bool` — True, if there are parameters, false otherwise.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `C14N()` | `DOMNode` |  |
| `C14NFile()` | `DOMNode` |  |
| `after()` | `DOMElement` |  |
| `append()` | `DOMElement` |  |
| `appendChild()` | `DOMNode` |  |
| `before()` | `DOMElement` |  |
| `cloneNode()` | `DOMNode` |  |
| `compareDocumentPosition()` | `DOMNode` |  |
| `contains()` | `DOMNode` |  |
| `getAttributeNames()` | `DOMElement` |  |
| `getAttributeNode()` | `DOMElement` |  |
| `getAttributeNodeNS()` | `DOMElement` |  |
| `getElementsByTagName()` | `DOMElement` |  |
| `getElementsByTagNameNS()` | `DOMElement` |  |
| `getLineNo()` | `DOMNode` |  |
| `getNodePath()` | `DOMNode` |  |
| `getRootNode()` | `DOMNode` |  |
| `hasAttribute()` | `DOMElement` |  |
| `hasAttributeNS()` | `DOMElement` |  |
| `hasAttributes()` | `DOMNode` |  |
| `hasChildNodes()` | `DOMNode` |  |
| `insertAdjacentElement()` | `DOMElement` |  |
| `insertAdjacentText()` | `DOMElement` |  |
| `insertBefore()` | `DOMNode` |  |
| `isDefaultNamespace()` | `DOMNode` |  |
| `isEqualNode()` | `DOMNode` |  |
| `isSameNode()` | `DOMNode` |  |
| `isSupported()` | `DOMNode` |  |
| `lookupNamespaceURI()` | `DOMNode` |  |
| `lookupPrefix()` | `DOMNode` |  |
| `normalize()` | `DOMNode` |  |
| `prepend()` | `DOMElement` |  |
| `remove()` | `DOMElement` |  |
| `removeAttribute()` | `DOMElement` |  |
| `removeAttributeNS()` | `DOMElement` |  |
| `removeAttributeNode()` | `DOMElement` |  |
| `removeChild()` | `DOMNode` |  |
| `replaceChild()` | `DOMNode` |  |
| `replaceChildren()` | `DOMElement` |  |
| `replaceWith()` | `DOMElement` |  |
| `setAttribute()` | `DOMElement` |  |
| `setAttributeNS()` | `DOMElement` |  |
| `setAttributeNode()` | `DOMElement` |  |
| `setAttributeNodeNS()` | `DOMElement` |  |
| `setIdAttribute()` | `DOMElement` |  |
| `setIdAttributeNS()` | `DOMElement` |  |
| `setIdAttributeNode()` | `DOMElement` |  |
| `toggleAttribute()` | `DOMElement` |  |
