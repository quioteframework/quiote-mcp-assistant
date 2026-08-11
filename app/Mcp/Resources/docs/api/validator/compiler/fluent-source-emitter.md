# FluentSourceEmitter

> Emits a ValidatorPlan as committable, opcacheable PHP source that returns a closure over Quiote\\Validator\\Compiler\\Runtime\\ValidatorBuilder -- the same format a developer can hand-write for a validator that never had an XML config at all.

Emits a ValidatorPlan as committable, opcacheable PHP source that returns a closure over Quiote\Validator\Compiler\Runtime\ValidatorBuilder -- the same format a developer can hand-write for a validator that never had an XML config at all.

Every parameter reaching this emitter already passed ValidatorPlanBuilder's compile-time whitelist check (assuming the default 'throw'/'warn' mode), so an "unmappable" parameter here is never a bogus one -- it's a real, accepted parameter this emitter's fluent vocabulary hasn't grown a dedicated method for yet. That's exactly the case that gets flagged (Diagnostic::CODE_UNMAPPABLE_PARAMETER) rather than silently handled: the payoff of this emitter, mirroring the compile-time check, is surfacing exactly the shape of gap that let a nonexistent allowlist attribute go unenforced in the incident that motivated this compiler.

Whenever the "pretty" fluent shortcut doesn't cleanly apply (a name override, a non-default source/base, multiple/named arguments, custom error messages, or any class/parameter this emitter doesn't have a dedicated mapping for), it falls back to ValidatorBuilder::raw() with the full, untouched arguments/parameters/errors from the IR node -- this fallback is always behaviorally complete, so a coverage gap in the "pretty" mapping can never mean a validator's behavior is silently dropped from the generated file.

## Synopsis

`class FluentSourceEmitter implements EmitterInterface`

|  |  |
|---|---|
| Implements | [`EmitterInterface`](/api/validator/compiler/emitter-interface/) |
| Since | `1.0.0` |
| Source | `Validator/Compiler/FluentSourceEmitter.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(ValidatorPlan $plan): EmittedArtifact`](#emit) | Emits the plan as a PHP file returning a closure over ValidatorBuilder. |
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |

### emit()

`public function emit(ValidatorPlan $plan): EmittedArtifact`

Emits the plan as a PHP file returning a closure over ValidatorBuilder.

Clears the diagnostics from any previous call, then emits every node in plan order, preferring the fluent shortcut for a node whose class and parameters this emitter maps and falling back to ValidatorBuilder::raw() for everything else. The generated header carries a fingerprint over the source reference and the node shapes, so the file changes only when the plan does; the artifact's own checksum is taken over the finished source. Nothing is written to disk.

Diagnostics recorded along the way are retrievable through [`FluentSourceEmitter::getDiagnostics()`](/api/validator/compiler/fluent-source-emitter/#getdiagnostics); a parameter with no fluent mapping is reported there rather than being dropped, since the raw fallback still carries it.

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded during the last emit() call.
