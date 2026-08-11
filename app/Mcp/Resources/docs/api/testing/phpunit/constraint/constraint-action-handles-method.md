# ConstraintActionHandlesMethod

> Constraint that checks if an Action handles an expected request method.

Constraint that checks if an Action handles an expected request method.

The Action instance is passed to the constructor.

## Synopsis

`class ConstraintActionHandlesMethod extends BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility`

|  |  |
|---|---|
| Extends | [`BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility`](/api/testing/base-constraint-because-phpunit-sucks-at-backwards-compatibility/) |
| Since | `1.0.0` |
| Source | `Testing/PHPUnit/Constraint/ConstraintActionHandlesMethod.php` |

## Constructor

### __construct()

`public function __construct(Action $actionInstance, bool $acceptGeneric = true): mixed`

Class constructor.

| Parameter | Type | Description |
|---|---|---|
| `$actionInstance` | [`Action`](/api/action/action/) | Instance of the Action to test. |
| `$acceptGeneric` | `bool` | Whether generic execute methods should be accepted. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`matches(mixed $other): bool`](#matches) | Evaluates the constraint for parameter $other. |
| [`toString(): string`](#tostring) | Returns a string representation of the constraint. |

### matches()

`public function matches(mixed $other): bool`

Evaluates the constraint for parameter $other.

Value or object to evaluate.

| Parameter | Type | Description |
|---|---|---|
| `$other` | `mixed` | Value or object to evaluate. |

Returns `bool` — The result of the evaluation.

### toString()

`public function toString(): string`

Returns a string representation of the constraint.

Returns `string` — The string representation.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `count()` | `Constraint` | Counts the number of constraint elements. |
| `evaluate()` | [`BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility`](/api/testing/base-constraint-because-phpunit-sucks-at-backwards-compatibility/) | Overridden function to cover differences between PHPUnit 3.5 and 3.6. |
