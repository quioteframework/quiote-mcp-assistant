# XmlConfigDomDocument

> Extended DOMDocument class with several convenience enhancements.

Extended DOMDocument class with several convenience enhancements.

## Synopsis

`class XmlConfigDomDocument extends DOMDocument`

|  |  |
|---|---|
| Extends | `DOMDocument` |
| Since | `1.0.0` |
| Source | `Config/Util/DOM/XmlConfigDomDocument.php` |

## Constructor

### __construct()

`public function __construct(string $version = '1.0', string $encoding = 'UTF-8'): mixed`

The constructor.

The XML encoding.

| Parameter | Type | Description |
|---|---|---|
| `$version` | `string` | The XML version. |
| `$encoding` | `string` | The XML encoding. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getConfigurationElements(): array<int, XmlConfigDomElement>`](#getconfigurationelements) | Method to retrieve a list of Quiote <configuration> elements regardless of their namespace. |
| [`getDefaultNamespacePrefix(): string`](#getdefaultnamespaceprefix) | Retrieve the default namespace prefix that will be used by node classes, if set, to conveniently retrieve child elements etc via XPath. |
| [`getDefaultNamespaceUri(): string`](#getdefaultnamespaceuri) | Retrieve the default namespace URI that will be used by node classes, if set, to conveniently retrieve child elements etc in some methods. |
| [`getQuioteEnvelopeNamespace(): ?string`](#getquioteenvelopenamespace) | Retrieve the namespace of the Quiote envelope. |
| [`getSandbox(): ?XmlConfigDomElement`](#getsandbox) | Method to retrieve the Quiote <sandbox> element regardless of the namespace. |
| [`getXpath(): DOMXPath`](#getxpath) | Retrieve the DOMXPath instance that is associated with this document. |
| [`importNode(DOMNode $node, bool $deep = false): mixed`](#importnode) | Import a node into the current document. |
| [`isQuioteConfiguration(): bool`](#isquioteconfiguration) | Check whether or not this is a standard Quiote configuration file, i.e. |
| [`load(string $filename, int $options = 0): bool`](#load) | Load XML from a file. |
| [`loadXml(string $source, int $options = 0): bool`](#loadxml) | Load XML from a string. |
| [`query(string $expression, ?DOMNode $contextNode = null): DOMNodeList<DOMNode|DOMNameSpaceNode>`](#query) | Run an XPath query against this document (or, when given, a context node within it) and return the resulting node list. |
| [`relaxNGValidate(string $filename): bool`](#relaxngvalidate) | Perform RELAX NG validation on the document. |
| [`schemaValidate(string $filename, int $flags = 0): bool`](#schemavalidate) | Validate a document based on a schema. |
| [`schemaValidateSource(string $source, mixed $flags = 0): bool`](#schemavalidatesource) | Validate a document based on a schema. |
| [`setDefaultNamespace(string $namespaceUri, string $prefix = '_default'): void`](#setdefaultnamespace) | Set a default namespace that should be used when accessing elements via convenience methods (such as magic get overload for children), and bind it to the given prefix for use in XPath expressions. |
| [`xinclude(int $options = 0): int`](#xinclude) | Substitutes XIncludes in a DOMDocument object. |

### getConfigurationElements()

`public function getConfigurationElements(): array<int, XmlConfigDomElement>`

Method to retrieve a list of Quiote <configuration> elements regardless of their namespace.

Returns `array``<``int``, `[`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/)`>` — A list of XmlConfigDomElement elements.

### getDefaultNamespacePrefix()

`public function getDefaultNamespacePrefix(): string`

Retrieve the default namespace prefix that will be used by node classes, if set, to conveniently retrieve child elements etc via XPath.

Returns `string` — A namespace prefix.

### getDefaultNamespaceUri()

`public function getDefaultNamespaceUri(): string`

Retrieve the default namespace URI that will be used by node classes, if set, to conveniently retrieve child elements etc in some methods.

Returns `string` — A namespace URI.

### getQuioteEnvelopeNamespace()

`public function getQuioteEnvelopeNamespace(): ?string`

Retrieve the namespace of the Quiote envelope.

Returns `?``string` — A namespace URI, or null if it's not an Quiote config.

### getSandbox()

`public function getSandbox(): ?XmlConfigDomElement`

Method to retrieve the Quiote <sandbox> element regardless of the namespace.

Returns `?`[`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/) — The <sandbox> element, or null.

### getXpath()

`public function getXpath(): DOMXPath`

Retrieve the DOMXPath instance that is associated with this document.

Returns `DOMXPath` — The DOMXPath instance.

### importNode()

`public function importNode(DOMNode $node, bool $deep = false): mixed`

Import a node into the current document.

Whether or not to recursively import the node's
                    subtree.

| Parameter | Type | Description |
|---|---|---|
| `$node` | `DOMNode` | The node to import. |
| `$deep` | `bool` | Whether or not to recursively import the node's subtree. |

Returns `mixed` — The copied node, or false if it cannot be copied.

### isQuioteConfiguration()

`public function isQuioteConfiguration(): bool`

Check whether or not this is a standard Quiote configuration file, i.e.

with a <configurations> and <configuration> envelope.

Returns `bool` — true, if it is an Quiote config structure, false otherwise.

### load()

`public function load(string $filename, int $options = 0): bool`

Load XML from a file.

Bitwise OR of the libxml option constants.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` | The path to the XML document. |
| `$options` | `int` | Bitwise OR of the libxml option constants. |

Returns `bool` — True of the operation is successful; false otherwise.

### loadXml()

`public function loadXml(string $source, int $options = 0): bool`

Load XML from a string.

Bitwise OR of the libxml option constants.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` | The string containing the XML. |
| `$options` | `int` | Bitwise OR of the libxml option constants. |

Returns `bool` — True of the operation is successful; false otherwise.

### query()

`public function query(string $expression, ?DOMNode $contextNode = null): DOMNodeList<DOMNode|DOMNameSpaceNode>`

Run an XPath query against this document (or, when given, a context node within it) and return the resulting node list.

An optional context node to query relative to.

| Parameter | Type | Description |
|---|---|---|
| `$expression` | `string` | The XPath expression to evaluate. |
| `$contextNode` | `?``DOMNode` | An optional context node to query relative to. |

Returns `DOMNodeList``<``DOMNode``|``DOMNameSpaceNode``>`

### relaxNGValidate()

`public function relaxNGValidate(string $filename): bool`

Perform RELAX NG validation on the document.

The path to the schema.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` | The path to the schema. |

Returns `bool` — True if the validation is successful; false otherwise.

### schemaValidate()

`public function schemaValidate(string $filename, int $flags = 0): bool`

Validate a document based on a schema.

Bitwise OR of the libxml option constants.

| Parameter | Type | Description |
|---|---|---|
| `$filename` | `string` | The path to the schema. |
| `$flags` | `int` | Bitwise OR of the libxml option constants. |

Returns `bool` — True if the validation is successful; false otherwise.

### schemaValidateSource()

`public function schemaValidateSource(string $source, mixed $flags = 0): bool`

Validate a document based on a schema.

A string containing the schema.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` | A string containing the schema. |
| `$flags` | `mixed` |  |

Returns `bool` — True if the validation is successful; false otherwise.

### setDefaultNamespace()

`public function setDefaultNamespace(string $namespaceUri, string $prefix = '_default'): void`

Set a default namespace that should be used when accessing elements via convenience methods (such as magic get overload for children), and bind it to the given prefix for use in XPath expressions.

An optional prefix, defaulting to "_default"

| Parameter | Type | Description |
|---|---|---|
| `$namespaceUri` | `string` | A namespace URI |
| `$prefix` | `string` | An optional prefix, defaulting to "_default" |

### xinclude()

`public function xinclude(int $options = 0): int`

Substitutes XIncludes in a DOMDocument object.

Bitwise OR of the libxml option constants.

| Parameter | Type | Description |
|---|---|---|
| `$options` | `int` | Bitwise OR of the libxml option constants. |

Returns `int` — The number of XIncludes in the document.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `C14N()` | `DOMNode` |  |
| `C14NFile()` | `DOMNode` |  |
| `adoptNode()` | `DOMDocument` |  |
| `append()` | `DOMDocument` |  |
| `appendChild()` | `DOMNode` |  |
| `cloneNode()` | `DOMNode` |  |
| `compareDocumentPosition()` | `DOMNode` |  |
| `contains()` | `DOMNode` |  |
| `createAttribute()` | `DOMDocument` |  |
| `createAttributeNS()` | `DOMDocument` |  |
| `createCDATASection()` | `DOMDocument` |  |
| `createComment()` | `DOMDocument` |  |
| `createDocumentFragment()` | `DOMDocument` |  |
| `createElement()` | `DOMDocument` |  |
| `createElementNS()` | `DOMDocument` |  |
| `createEntityReference()` | `DOMDocument` |  |
| `createProcessingInstruction()` | `DOMDocument` |  |
| `createTextNode()` | `DOMDocument` |  |
| `getElementById()` | `DOMDocument` |  |
| `getElementsByTagName()` | `DOMDocument` |  |
| `getElementsByTagNameNS()` | `DOMDocument` |  |
| `getLineNo()` | `DOMNode` |  |
| `getNodePath()` | `DOMNode` |  |
| `getRootNode()` | `DOMNode` |  |
| `hasAttributes()` | `DOMNode` |  |
| `hasChildNodes()` | `DOMNode` |  |
| `insertBefore()` | `DOMNode` |  |
| `isDefaultNamespace()` | `DOMNode` |  |
| `isEqualNode()` | `DOMNode` |  |
| `isSameNode()` | `DOMNode` |  |
| `isSupported()` | `DOMNode` |  |
| `loadHTML()` | `DOMDocument` |  |
| `loadHTMLFile()` | `DOMDocument` |  |
| `lookupNamespaceURI()` | `DOMNode` |  |
| `lookupPrefix()` | `DOMNode` |  |
| `normalize()` | `DOMNode` |  |
| `normalizeDocument()` | `DOMDocument` |  |
| `prepend()` | `DOMDocument` |  |
| `registerNodeClass()` | `DOMDocument` |  |
| `relaxNGValidateSource()` | `DOMDocument` |  |
| `removeChild()` | `DOMNode` |  |
| `replaceChild()` | `DOMNode` |  |
| `replaceChildren()` | `DOMDocument` |  |
| `save()` | `DOMDocument` |  |
| `saveHTML()` | `DOMDocument` |  |
| `saveHTMLFile()` | `DOMDocument` |  |
| `saveXML()` | `DOMDocument` |  |
| `validate()` | `DOMDocument` |  |
