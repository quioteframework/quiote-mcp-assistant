# ValidationDecision

> Immutable value object encapsulating the validation outcome for a request/action.

Immutable value object encapsulating the validation outcome for a request/action.

States: - pending: validation has not yet run (or was invalidated by a forward) - passed: validation executed successfully - failed: validation executed and failed (errors available)

## Synopsis

`final readonly class ValidationDecision`

|  |  |
|---|---|
| Source | `Execution/ValidationDecision.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$errors` | `array` | _readonly._ |
| `$state` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`failed(array<mixed> $errors = []): ValidationDecision`](#failed) |  |
| [`isFailed(): bool`](#isfailed) | Reports whether validation ran and failed; the errors are then on the $errors property. |
| [`isPassed(): bool`](#ispassed) | Reports whether validation ran and succeeded. |
| [`isPending(): bool`](#ispending) | Reports whether validation has not run yet, or was invalidated by a forward. |
| [`passed(): ValidationDecision`](#passed) | Returns a decision in the passed state: validation ran successfully, and carries no errors. |
| [`pending(): ValidationDecision`](#pending) | Returns a decision in the pending state: validation has not run, and carries no errors. |

### failed()

`public static function failed(array<mixed> $errors = []): ValidationDecision`

| Parameter | Type | Description |
|---|---|---|
| `$errors` | `array``<``mixed``>` |  |

Returns [`ValidationDecision`](/api/execution/validation-decision/)

### isFailed()

`public function isFailed(): bool`

Reports whether validation ran and failed; the errors are then on the $errors property.

Returns `bool`

### isPassed()

`public function isPassed(): bool`

Reports whether validation ran and succeeded.

Returns `bool`

### isPending()

`public function isPending(): bool`

Reports whether validation has not run yet, or was invalidated by a forward.

Returns `bool`

### passed()

`public static function passed(): ValidationDecision`

Returns a decision in the passed state: validation ran successfully, and carries no errors.

Returns [`ValidationDecision`](/api/execution/validation-decision/)

### pending()

`public static function pending(): ValidationDecision`

Returns a decision in the pending state: validation has not run, and carries no errors.

Returns [`ValidationDecision`](/api/execution/validation-decision/)
