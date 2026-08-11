# ValidatorPlanBuilder

> Walks a parsed validators.xml document and builds a format-independent ValidatorPlan (see Quiote\\Validator\\Compiler\\Ir).

Walks a parsed validators.xml document and builds a format-independent ValidatorPlan (see Quiote\Validator\Compiler\Ir).

Keeping the traversal separate from code emission lets the same walk feed multiple back-ends — the runtime cache emitter and the fluent-source emitter — without duplicating XML-interpretation logic.

A ValidatorPlanBuilder instance is single-use: construct one per document, call build() once. classMap accumulates across the <ae:configuration> elements of that one document, so validator_definitions are scoped per file.

## Synopsis

`class ValidatorPlanBuilder`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/ValidatorPlanBuilder.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `REJECT_MODE_OFF` | `'off'` |  |
| `REJECT_MODE_THROW` | `'throw'` | Controls how unknown/misspelled validator parameters are handled at plan-build (i.e. |
| `REJECT_MODE_WARN` | `'warn'` |  |

## Methods

| Method | Description |
|---|---|
| [`build(XmlConfigDomDocument $document, string $namespace): ValidatorPlan`](#build) | Walks the document once and returns the plan it describes. |
| [`collectErrors(XmlConfigDomElement $node, array<string, mixed> $existing = []): array<string, mixed>`](#collecterrors) |  |
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |

### build()

`public function build(XmlConfigDomDocument $document, string $namespace): ValidatorPlan`

Walks the document once and returns the plan it describes.

The validators XML namespace URI, installed as
       the document's default namespace for the duration of the walk.

| Parameter | Type | Description |
|---|---|---|
| `$document` | [`XmlConfigDomDocument`](/api/config/util/dom/xml-config-dom-document/) |  |
| `$namespace` | `string` | The validators XML namespace URI, installed as the document's default namespace for the duration of the walk. |

Returns [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/)

| Throws | When |
|---|---|
| `ConfigurationException` | If a required attribute is missing, a referenced validator definition cannot be resolved, or — in 'throw' reject mode — a validator declares a parameter its class does not accept. |

### collectErrors()

`public function collectErrors(XmlConfigDomElement $node, array<string, mixed> $existing = []): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$node` | [`XmlConfigDomElement`](/api/config/util/dom/xml-config-dom-element/) |  |
| `$existing` | `array``<``string``, ``mixed``>` |  |

Returns `array``<``string``, ``mixed``>`

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Every diagnostic recorded during the last build(). Populated in 'warn' mode; in 'throw' mode only diagnostics from nodes visited before the fatal one are ever recorded, since the exception aborts the walk immediately.
