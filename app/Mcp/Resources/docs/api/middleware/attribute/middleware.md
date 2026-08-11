# Middleware

> Attribute to declare middleware metadata for auto-registration.

Attribute to declare middleware metadata for auto-registration.

## Synopsis

`class Middleware`

|  |  |
|---|---|
| Source | `Middleware/Attribute/Middleware.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$after` | `?``string` |  |
| `$before` | `?``string` |  |
| `$enabled` | `bool` |  |
| `$phase` | `string` |  |
| `$priority` | `int` |  |

## Constructor

### __construct()

`public function __construct(string $phase = 'pre', int $priority = 0, ?string $before = null, ?string $after = null, bool $enabled = true): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$phase` | `string` |  |
| `$priority` | `int` |  |
| `$before` | `?``string` |  |
| `$after` | `?``string` |  |
| `$enabled` | `bool` |  |

Returns `mixed`
