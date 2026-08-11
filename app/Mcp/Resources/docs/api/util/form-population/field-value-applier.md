# FieldValueApplier

> Writes a submitted value onto the form element that carries it.

Writes a submitted value onto the form element that carries it.

Each control type says "this is my value" differently -- an attribute for a text input, the presence of `checked` for a checkbox, `selected` on a child option for a select, and the element's text for a textarea -- so this is where knowledge of those four shapes lives.

Removing the rendered state before setting the new one is deliberate throughout: a checkbox the view rendered as checked must come back unchecked when the submission did not include it, and a value the view rendered must not survive a submission that cleared the field.

## Synopsis

`final readonly class FieldValueApplier`

|  |  |
|---|---|
| Source | `Util/FormPopulation/FieldValueApplier.php` |

## Constructor

### __construct()

`public function __construct(DOMDocument $document, DocumentEncoding $encoding, string $xmlnsPrefix, bool $useCdataForTextareas, bool $includeHiddenInputs, bool $includePasswordInputs, \Closure(string, ?\DOMElement): array<int, \DOMElement> $queryElements): mixed`

XPath against the document.

| Parameter | Type | Description |
|---|---|---|
| `$document` | `DOMDocument` |  |
| `$encoding` | [`DocumentEncoding`](/api/util/form-population/document-encoding/) |  |
| `$xmlnsPrefix` | `string` |  |
| `$useCdataForTextareas` | `bool` |  |
| `$includeHiddenInputs` | `bool` |  |
| `$includePasswordInputs` | `bool` |  |
| `$queryElements` | `\Closure(string, ?\DOMElement): array<int, \DOMElement>` | XPath against the document. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`apply(DOMElement $element, ResolvedFieldName $name, mixed $value, ParameterHolder $parameters): bool`](#apply) | Applies the submitted value for $name to $element. |

### apply()

`public function apply(DOMElement $element, ResolvedFieldName $name, mixed $value, ParameterHolder $parameters): bool`

Applies the submitted value for $name to $element.

| Parameter | Type | Description |
|---|---|---|
| `$element` | `DOMElement` |  |
| `$name` | [`ResolvedFieldName`](/api/util/form-population/resolved-field-name/) |  |
| `$value` | `mixed` |  |
| `$parameters` | [`ParameterHolder`](/api/util/parameter-holder/) |  |

Returns `bool` — False when the element was left untouched, so the caller knows nothing was written for it.
