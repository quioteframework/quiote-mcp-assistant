# ValidatorPlan

> Format-independent description of one validator config source (today: one validators.xml file, after XInclude/XSL normalization).

Format-independent description of one validator config source (today: one validators.xml file, after XInclude/XSL normalization).

A ValidatorPlan is what any back-end emitter (runtime cache, fluent source, a future CLI's --check) consumes; it never needs to know which front-end produced it.

## Synopsis

`final class ValidatorPlan`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/Ir/ValidatorPlan.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$nodes` | `array` | _readonly._ |
| `$sourceRef` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<ValidatorNode> $nodes, string $sourceRef): mixed`

Origin reference (e.g. file path), for diagnostics
                         and generated-file headers.

| Parameter | Type | Description |
|---|---|---|
| `$nodes` | `array``<`[`ValidatorNode`](/api/validator/compiler/ir/validator-node/)`>` | Top-level validator nodes, in document order. |
| `$sourceRef` | `string` | Origin reference (e.g. file path), for diagnostics and generated-file headers. |

Returns `mixed`
