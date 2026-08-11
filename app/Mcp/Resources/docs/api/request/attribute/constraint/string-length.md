# StringLength

> Constrains a string property's length.

Constrains a string property's length.

Backed by Quiote\Validator\StringValidator.

## Synopsis

`final class StringLength`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Attribute/Constraint/StringLength.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$max` | `?``int` | _readonly._ |
| `$message` | `?``string` | _readonly._ |
| `$min` | `?``int` | _readonly._ |

## Constructor

### __construct()

`public function __construct(?int $min = null, ?int $max = null, ?string $message = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$min` | `?``int` |  |
| `$max` | `?``int` |  |
| `$message` | `?``string` |  |

Returns `mixed`
