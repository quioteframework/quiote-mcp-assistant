# Ir

> The Quiote\\Validator\\Compiler\\Ir namespace — 2 documented types.

Everything under `Quiote\Validator\Compiler\Ir`.

## Classes

| Class | Description |
|---|---|
| [`ValidatorNode`](/api/validator/compiler/ir/validator-node/) | Format-independent description of a single <validator> declaration: the resolved class, its parameters/arguments, the request methods it applies to, and any nested validators (and/or/not/xor children). |
| [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) | Format-independent description of one validator config source (today: one validators.xml file, after XInclude/XSL normalization). |
