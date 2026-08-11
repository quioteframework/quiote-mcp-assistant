# Runtime

> The Quiote\\Validator\\Compiler\\Runtime namespace — 4 documented types.

Everything under `Quiote\Validator\Compiler\Runtime`.

## Classes

| Class | Description |
|---|---|
| [`CompiledValidatorRegistry`](/api/validator/compiler/runtime/compiled-validator-registry/) | Resolves and loads the compiled/hand-written PHP validator-builder file for a module/action, if one exists, and applies it to a ValidatorBuilder scoped to the given container. |
| [`ValidatorBuilder`](/api/validator/compiler/runtime/validator-builder/) | Fluent facade for registering validators directly in PHP, without an intervening XML file. |
| [`ValidatorDeclarationApplier`](/api/validator/compiler/runtime/validator-declaration-applier/) | Builds the validators a compiled validator config declares and attaches them to a validation manager. |
| [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/) | A fluent handle onto a single, already-registered Validator instance. |
