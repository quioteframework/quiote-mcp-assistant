# FieldErrorDecorator

> Marks a field that failed validation, by putting the configured error class on it and on whatever else the error class map points at.

Marks a field that failed validation, by putting the configured error class on it and on whatever else the error class map points at.

The field itself is not always what should be styled: a designer may want the class on a wrapping div, or on the label rather than the input. So the map is XPath keyed -- each expression is evaluated from the field (and from each of its labels) and the class lands on whatever it selects. The first expression that selects anything wins, which is what makes the map an ordered list of increasingly general fallbacks rather than a set of independent rules.

Labels are collected two ways because HTML allows both: a label wrapping the input, and one elsewhere pointing at it by `for`.

## Synopsis

`final readonly class FieldErrorDecorator`

|  |  |
|---|---|
| Source | `Util/FormPopulation/FieldErrorDecorator.php` |

## Constructor

### __construct()

`public function __construct(\Closure(string, ?\DOMElement): array<int, \DOMElement> $queryElements, string $xmlnsPrefix): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$queryElements` | `\Closure(string, ?\DOMElement): array<int, \DOMElement>` |  |
| `$xmlnsPrefix` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`decorate(DOMElement $element, DOMElement $form, array<string, mixed> $errorClassMap): void`](#decorate) |  |

### decorate()

`public function decorate(DOMElement $element, DOMElement $form, array<string, mixed> $errorClassMap): void`

XPath expression => class name.

| Parameter | Type | Description |
|---|---|---|
| `$element` | `DOMElement` |  |
| `$form` | `DOMElement` |  |
| `$errorClassMap` | `array``<``string``, ``mixed``>` | XPath expression => class name. |
