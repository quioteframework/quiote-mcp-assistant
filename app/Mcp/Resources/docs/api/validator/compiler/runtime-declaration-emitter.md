# RuntimeDeclarationEmitter

> Turns a ValidatorPlan into the declaration a compiled validator config returns: the validators to build, in registration order, bucketed by the request method they apply to.

Turns a [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) into the declaration a compiled validator config returns: the validators to build, in registration order, bucketed by the request method they apply to.

The artifact is data, so it cannot register anything by itself -- [`ValidatorDeclarationApplier`](/api/validator/compiler/runtime/validator-declaration-applier/) is what builds and attaches the validators. That is deliberate: a compiled artifact of PHP statements makes a poisoned config cache entry into arbitrary code execution, and this cache is served from APCu, where a poisoned entry never touches disk at all.

Bucket keys are request methods, `''` being the bucket that applies to every method. The applier runs the `''` bucket and then the bucket matching the request's method, which is the order the declaration is written in.

Within a bucket, order is registration order: a container validator is listed before the children that attach to it, each child naming its parent.

## Synopsis

`class RuntimeDeclarationEmitter`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Validator/Compiler/RuntimeDeclarationEmitter.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(ValidatorPlan $plan): array{buckets: array<string, array{declaredParameters: list<string>, validators: list<array{name: string, class: string, parameters: array<string, mixed>, arguments: array<(int | string), mixed>, errors: array<(int | string), mixed>, parent: (string | null)}>}>}`](#emit) |  |

### emit()

`public function emit(ValidatorPlan $plan): array{buckets: array<string, array{declaredParameters: list<string>, validators: list<array{name: string, class: string, parameters: array<string, mixed>, arguments: array<(int | string), mixed>, errors: array<(int | string), mixed>, parent: (string | null)}>}>}`

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`ValidatorPlan`](/api/validator/compiler/ir/validator-plan/) |  |

Returns `array{buckets: array<string, array{declaredParameters: list<string>, validators: list<array{name: string, class: string, parameters: array<string, mixed>, arguments: array<(int | string), mixed>, errors: array<(int | string), mixed>, parent: (string | null)}>}>}`
