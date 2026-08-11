# CompilationResult

> The outcome of compiling one ValidatorSource through an emitter: the artifact (null if a fatal diagnostic prevented emission) plus every diagnostic recorded along the way.

The outcome of compiling one ValidatorSource through an emitter: the artifact (null if a fatal diagnostic prevented emission) plus every diagnostic recorded along the way.

A future CLI reports diagnostics and decides the process exit code from this; ValidatorCompiler itself never throws for ordinary (non-crashing) problems in 'warn' mode.

## Synopsis

`final class CompilationResult`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/CompilationResult.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$artifact` | `?`[`EmittedArtifact`](/api/support/compiler/emitted-artifact/) | _readonly._ |
| `$diagnostics` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(?EmittedArtifact $artifact, array<Diagnostic> $diagnostics): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$artifact` | `?`[`EmittedArtifact`](/api/support/compiler/emitted-artifact/) |  |
| `$diagnostics` | `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`hasErrors(): bool`](#haserrors) | Reports whether any recorded diagnostic is of error severity. |

### hasErrors()

`public function hasErrors(): bool`

Reports whether any recorded diagnostic is of error severity.

Warnings and lesser severities do not count, so a result can carry diagnostics and still answer false. A true here means the artifact, if one was emitted at all, should not be trusted.

Returns `bool`
