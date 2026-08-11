# Spark

> Renders a numeric series as a Unicode block-glyph bar chart, using eighth blocks (`▁▂▃▄▅▆▇█`) per character row to get sub-row vertical resolution across an arbitrary number of text rows.

Renders a numeric series as a Unicode block-glyph bar chart, using eighth blocks (`▁▂▃▄▅▆▇█`) per character row to get sub-row vertical resolution across an arbitrary number of text rows.

`symfony/tui` has no built-in Chart/Sparkline widget -- this, plus [`Bars`](/api/telemetry/dashboard/bars/) and [`ChartWidget`](/api/telemetry/dashboard/chart-widget/) (which wraps this class to make it fill its assigned space and react to terminal resizes), is what stands in for one.

Scaled against an **absolute zero baseline** (`value / max`), not a relative min-max range: every value here is a non-negative count or duration (requests/s, latency ms), where "zero" is a meaningful, distinct reading -- a quiet second should draw no bar, not a token minimum-height bar that makes it look identical to "the smallest amount of *something* * happened." Min-max normalization (as a single-glyph sparkline typically uses, to guarantee every column shows *some* visible signal in the one character it has) would blur exactly that distinction.

## Synopsis

`final class Spark`

|  |  |
|---|---|
| Source | `Spark.php` |

## Methods

| Method | Description |
|---|---|
| [`renderBars(array<float> $values, int $height): array<string>`](#renderbars) |  |
| [`resample(array<float> $values, int $targetColumns): array<float>`](#resample) | Downsamples (bucket-averages) a series to at most $targetColumns values, so a chart always exactly fits its assigned width instead of overflowing or leaving it unused. |

### renderBars()

`public static function renderBars(array<float> $values, int $height): array<string>`

| Parameter | Type | Description |
|---|---|---|
| `$values` | `array``<``float``>` |  |
| `$height` | `int` |  |

Returns `array``<``string``>` — exactly $height lines, top row first, each one character per value (after [`Spark::resample()`](/api/telemetry/dashboard/spark/#resample) if needed to fit a target width)

### resample()

`public static function resample(array<float> $values, int $targetColumns): array<float>`

Downsamples (bucket-averages) a series to at most $targetColumns values, so a chart always exactly fits its assigned width instead of overflowing or leaving it unused.

| Parameter | Type | Description |
|---|---|---|
| `$values` | `array``<``float``>` |  |
| `$targetColumns` | `int` |  |

Returns `array``<``float``>`
