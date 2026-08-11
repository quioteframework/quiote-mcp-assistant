# Regexp

> Constrains a string property's value against a regular expression.

Constrains a string property's value against a regular expression.

Backed by Quiote\Validator\RegexValidator.

## Synopsis

`final class Regexp`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Attribute/Constraint/Regexp.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$match` | `bool` | _readonly._ |
| `$message` | `?``string` | _readonly._ |
| `$pattern` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $pattern, bool $match = true, ?string $message = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$pattern` | `string` |  |
| `$match` | `bool` |  |
| `$message` | `?``string` |  |

Returns `mixed`
