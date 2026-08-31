# RedactionMode

> How Redactor replaces a value matched against a denylist.

How [`Redactor`](/api/replay/recording/redactor/) replaces a value matched against a denylist.

## Synopsis

`enum RedactionMode: string`

|  |  |
|---|---|
| Source | `Recording/RedactionMode.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Drop` | `'drop'` |  |
| `Hash` | `'hash'` |  |
| `Mask` | `'mask'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`from(string|int $value): static`](#from) |  |
| [`fromConfigValue(string $value): RedactionMode`](#fromconfigvalue) | An unrecognised value throws rather than silently falling back to `drop`. |
| [`tryFrom(string|int $value): ?static`](#tryfrom) |  |

### cases()

`public static function cases(): array`

Returns `array`

### from()

`public static function from(string|int $value): static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `static`

### fromConfigValue()

`public static function fromConfigValue(string $value): RedactionMode`

An unrecognised value throws rather than silently falling back to `drop`.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |

Returns [`RedactionMode`](/api/replay/recording/redaction-mode/)

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
