# ValidatorCompiler

> Public entrypoint for validator compilation, independent of any CLI.

Public entrypoint for validator compilation, independent of any CLI.

A future `quiote compile validators` command is expected to be a thin wrapper: discover()/compile() here, ArtifactWriter (or a --check comparison) for output, print diagnostics, choose an exit code.

## Synopsis

`class ValidatorCompiler`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/ValidatorCompiler.php` |

## Methods

| Method | Description |
|---|---|
| [`compile(ValidatorSource $source, EmitterInterface $emitter): CompilationResult`](#compile) | Convenience wrapper: parse() + emit() in one call, with diagnostics from both stages merged. |
| [`discover(iterable<string> $roots = null): array<ValidatorSource>`](#discover) |  |
| [`emit(ValidatorPlan $plan, EmitterInterface $emitter): EmittedArtifact`](#emit) | Hands a plan to the given emitter and returns the artifact it produced. |
| [`parse(ValidatorSource $source): array{0: ValidatorPlan, 1: Diagnostic[]}`](#parse) | Parses a validator source into its format-independent IR. |

### compile()

`public function compile(ValidatorSource $source, EmitterInterface $emitter): CompilationResult`

Convenience wrapper: parse() + emit() in one call, with diagnostics from both stages merged.

In 'throw' mode a ConfigurationException from parse() propagates as normal -- compile() only suppresses nothing; it exists purely to save the caller two lines.

| Parameter | Type | Description |
|---|---|---|
| `$source` | [`ValidatorSource`](/api/validator/compiler/validator-source/) |  |
| `$emitter` | [`EmitterInterface`](/api/validator/compiler/emitter-interface/) |  |

Returns [`CompilationResult`](/api/validator/compiler/compilation-result/)

### discover()

`public function discover(iterable<string> $roots = null): array<ValidatorSource>`

Glob patterns; defaults to
                               ValidatorSourceLocator::defaultRoots()
                               when omitted.

| Parameter | Type | Description |
|---|---|---|
| `$roots` | `iterable``<``string``>` | Glob patterns; defaults to ValidatorSourceLocator::defaultRoots() when omitted. |

Returns `array``<`[`ValidatorSource`](/api/validator/compiler/validator-source/)`>`

### emit()

`public function emit(ValidatorPlan $plan, EmitterInterface $emitter): EmittedArtifact`

Hands a plan to the given emitter and returns the artifact it produced.

Nothing is written to disk here, and no diagnostics are collected: this is a straight delegation, kept as a named step so callers can parse once and emit through several back-ends.

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) |  |
| `$emitter` | [`EmitterInterface`](/api/validator/compiler/emitter-interface/) |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)

### parse()

`public function parse(ValidatorSource $source): array{0: ValidatorPlan, 1: Diagnostic[]}`

Parses a validator source into its format-independent IR.

| Parameter | Type | Description |
|---|---|---|
| `$source` | [`ValidatorSource`](/api/validator/compiler/validator-source/) |  |

Returns `array{0: ValidatorPlan, 1: Diagnostic[]}` — The plan and every diagnostic recorded while building it (empty in 'throw' mode unless the source is clean).
