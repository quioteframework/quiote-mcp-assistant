# Choice

> Requires the property's value to be one of a fixed allowlist.

Requires the property's value to be one of a fixed allowlist.

Backed by Quiote\Validator\InarrayValidator.

## Synopsis

`final class Choice`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/Attribute/Constraint/Choice.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$message` | `?``string` | _readonly._ |
| `$values` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<int, string|int|float> $values, ?string $message = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$values` | `array``<``int``, ``string``|``int``|``float``>` |  |
| `$message` | `?``string` |  |

Returns `mixed`
