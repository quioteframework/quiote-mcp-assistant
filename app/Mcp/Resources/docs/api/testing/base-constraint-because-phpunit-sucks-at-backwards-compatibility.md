# BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility

> Base constraint that caters for breaking changes between PHPUnit 3.5 and 3.6.

Base constraint that caters for breaking changes between PHPUnit 3.5 and 3.6.

Concrete constraints must implement match().

## Synopsis

`abstract class BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility extends Constraint`

|  |  |
|---|---|
| Extends | `Constraint` |
| Since | `1.0.0` |
| Source | `Testing/BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility.php` |

## Methods

| Method | Description |
|---|---|
| [`evaluate(mixed $other, string $description = '', bool $returnResult = false): ?bool`](#evaluate) | Overridden function to cover differences between PHPUnit 3.5 and 3.6. |

### evaluate()

`public function evaluate(mixed $other, string $description = '', bool $returnResult = false): ?bool`

Overridden function to cover differences between PHPUnit 3.5 and 3.6.

Whether to return a result or throw an exception (3.6+).

| Parameter | Type | Description |
|---|---|---|
| `$other` | `mixed` | The item to evaluate. |
| `$description` | `string` | Additional information about the test (3.6+). |
| `$returnResult` | `bool` | Whether to return a result or throw an exception (3.6+). |

Returns `?``bool`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `count()` | `Constraint` | Counts the number of constraint elements. |
| `toString()` | `SelfDescribing` | Returns a string representation of the object. |
