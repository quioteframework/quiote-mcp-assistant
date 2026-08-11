# Compiler

> The Quiote\\Validator\\Compiler namespace — 16 documented types.

Everything under `Quiote\Validator\Compiler`.

## Classes

| Class | Description |
|---|---|
| [`CompilationResult`](/api/validator/compiler/compilation-result/) | The outcome of compiling one ValidatorSource through an emitter: the artifact (null if a fatal diagnostic prevented emission) plus every diagnostic recorded along the way. |
| [`FluentSourceEmitter`](/api/validator/compiler/fluent-source-emitter/) | Emits a ValidatorPlan as committable, opcacheable PHP source that returns a closure over Quiote\Validator\Compiler\Runtime\ValidatorBuilder -- the same format a developer can hand-write for a validator that never had an XML config at all. |
| [`RuntimeDeclarationEmitter`](/api/validator/compiler/runtime-declaration-emitter/) | Turns a [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) into the declaration a compiled validator config returns: the validators to build, in registration order, bucketed by the request method they apply to. |
| [`ValidatorCompiler`](/api/validator/compiler/validator-compiler/) | Public entrypoint for validator compilation, independent of any CLI. |
| [`ValidatorPlanBuilder`](/api/validator/compiler/validator-plan-builder/) | Walks a parsed validators.xml document and builds a format-independent ValidatorPlan (see Quiote\Validator\Compiler\Ir). |
| [`ValidatorSource`](/api/validator/compiler/validator-source/) | A discovered (or explicitly given) validators.xml file, ready to be parsed into a ValidatorPlan. |
| [`ValidatorSourceLocator`](/api/validator/compiler/validator-source-locator/) | Finds validators.xml files on disk, the same way ConfigCache resolves config_handlers.xml's `%core.module_dir%/*&#47;Validate/*.xml` pattern for ValidatorConfigHandler -- except here the result is handed to a compiler, not compiled into the request-time cache. |

## Interfaces

| Interface | Description |
|---|---|
| [`EmitterInterface`](/api/validator/compiler/emitter-interface/) | A back-end that turns a format-independent ValidatorPlan into a committable/checkable PHP artifact (e.g. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Ir`](/api/validator/compiler/ir/) | 2 types |
| [`JsonSchema`](/api/validator/compiler/json-schema/) | 2 types |
| [`Runtime`](/api/validator/compiler/runtime/) | 4 types |
