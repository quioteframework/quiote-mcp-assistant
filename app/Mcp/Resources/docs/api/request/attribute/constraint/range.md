# Range

> Constrains a numeric property's value.

Constrains a numeric property's value.

Backed by Quiote\Validator\NumberValidator.

## Synopsis

`final class Range`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Attribute/Constraint/Range.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$max` | `int``|``float``|``null` | _readonly._ |
| `$message` | `?``string` | _readonly._ |
| `$min` | `int``|``float``|``null` | _readonly._ |

## Constructor

### __construct()

`public function __construct(int|float|null $min = null, int|float|null $max = null, ?string $message = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$min` | `int``|``float``|``null` |  |
| `$max` | `int``|``float``|``null` |  |
| `$message` | `?``string` |  |

Returns `mixed`
