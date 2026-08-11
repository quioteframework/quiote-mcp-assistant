# Bars

> Renders a value/ceiling ratio as a fixed-width filled/empty block bar -- the dashboard's stand-in for a Gauge widget (`symfony/tui` has none; see Spark's docblock for the same widget-gap note).

Renders a value/ceiling ratio as a fixed-width filled/empty block bar -- the dashboard's stand-in for a Gauge widget (`symfony/tui` has none; see [`Spark`](/api/telemetry/dashboard/spark/)'s docblock for the same widget-gap note).

## Synopsis

`final class Bars`

|  |  |
|---|---|
| Source | `Bars.php` |

## Methods

| Method | Description |
|---|---|
| [`ratio(float $value, float $ceiling): float`](#ratio) | The clamped [0.0, 1.0] fraction of $ceiling that $value represents. |
| [`render(float $value, float $ceiling, int $width = 20, string $fill = '█', string $empty = '░'): string`](#render) | Renders $value against $ceiling as exactly $width characters: the clamped ratio (see [`Bars::ratio()`](/api/telemetry/dashboard/bars/#ratio)) worth of $fill, padded out with $empty. |

### ratio()

`public static function ratio(float $value, float $ceiling): float`

The clamped [0.0, 1.0] fraction of $ceiling that $value represents.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `float` |  |
| `$ceiling` | `float` |  |

Returns `float`

### render()

`public static function render(float $value, float $ceiling, int $width = 20, string $fill = '█', string $empty = '░'): string`

Renders $value against $ceiling as exactly $width characters: the clamped ratio (see [`Bars::ratio()`](/api/telemetry/dashboard/bars/#ratio)) worth of $fill, padded out with $empty.

Returns the empty string for a non-positive $width. A non-positive ceiling or a non-finite input renders as an all-empty bar rather than failing.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `float` |  |
| `$ceiling` | `float` |  |
| `$width` | `int` |  |
| `$fill` | `string` |  |
| `$empty` | `string` |  |

Returns `string`
