# SchematronProcessor

> SchematronProcessor transforms DOM documents according to ISO Schematron validation and transformation rules into a document containing successful reports and failed assertions.

SchematronProcessor transforms DOM documents according to ISO Schematron validation and transformation rules into a document containing successful reports and failed assertions.

## Synopsis

`class SchematronProcessor extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `Util/SchematronProcessor.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `NAMESPACE_SCHEMATRON_ISO` | `'http://purl.oclc.org/dsdl/schematron'` |  |
| `NAMESPACE_SVRL_ISO` | `'http://purl.oclc.org/dsdl/svrl'` |  |
| `NAMESPACE_XSL_1999` | `'http://www.w3.org/1999/XSL/Transform'` |  |

## Constructor

### __construct()

`public function __construct(?array<int, string> $chain = null): mixed`

Creates a new processor for transforming documents into a Schematron report.

The list of Schematron implementation paths to process.

| Parameter | Type | Description |
|---|---|---|
| `$chain` | `?``array``<``int``, ``string``>` | The list of Schematron implementation paths to process. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getProcessors(): array<int, QuioteXsltProcessor>`](#getprocessors) | Get an array of all processors. |
| [`setNode(DOMDocument $node): void`](#setnode) | Sets the document that this processor will transform and validate. |
| [`transform(DOMDocument $schema): DOMDocument`](#transform) | Validates the node against a given Schematron validation file. |

### getProcessors()

`public function getProcessors(): array<int, QuioteXsltProcessor>`

Get an array of all processors.

Returns `array``<``int``, `[`QuioteXsltProcessor`](/api/util/quiote-xslt-processor/)`>` — An array of XsltProcessor instances.

### setNode()

`public function setNode(DOMDocument $node): void`

Sets the document that this processor will transform and validate.

The document to use.

| Parameter | Type | Description |
|---|---|---|
| `$node` | `DOMDocument` | The document to use. |

### transform()

`public function transform(DOMDocument $schema): DOMDocument`

Validates the node against a given Schematron validation file.

The validator to use.

| Parameter | Type | Description |
|---|---|---|
| `$schema` | `DOMDocument` | The validator to use. |

Returns `DOMDocument` — The transformed validation document.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`ParameterHolder`](/api/util/parameter-holder/) | Removes every parameter held, leaving the holder empty for reuse. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
