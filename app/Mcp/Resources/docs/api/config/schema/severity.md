# Severity

> The Severity enum in Quiote\\Config\\Schema.

The `Severity` enum. It carries no description of its own yet.

## Synopsis

`enum Severity: string`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Schema/Severity.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Error` | `'error'` |  |
| `Warning` | `'warning'` |  |

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

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
