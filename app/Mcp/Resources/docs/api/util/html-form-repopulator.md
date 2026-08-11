# HtmlFormRepopulator

> Lightweight HTML form repopulation utility replacing FormPopulationFilter for container-less pipeline.

Lightweight HTML form repopulation utility replacing FormPopulationFilter for container-less pipeline.

Supports input[type=text], input[type=checkbox|radio], select/option population and simple global error list.

## Synopsis

`final class HtmlFormRepopulator`

|  |  |
|---|---|
| Source | `Util/HtmlFormRepopulator.php` |

## Methods

| Method | Description |
|---|---|
| [`repopulate(string $html, array<string, mixed> $parameters, ?ValidationReport $report = null, array<string, mixed> $config = []): string`](#repopulate) |  |

### repopulate()

`public static function repopulate(string $html, array<string, mixed> $parameters, ?ValidationReport $report = null, array<string, mixed> $config = []): string`

| Parameter | Type | Description |
|---|---|---|
| `$html` | `string` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$report` | `?`[`ValidationReport`](/api/validator/validation-report/) |  |
| `$config` | `array``<``string``, ``mixed``>` |  |

Returns `string`
