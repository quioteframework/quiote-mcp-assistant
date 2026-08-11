# DateTimeFacade

> Lightweight modern replacement for legacy DateFormat / calendar stack.

Lightweight modern replacement for legacy DateFormat / calendar stack.

Responsibilities: - Parse simple datetime strings with a subset of legacy pattern tokens (yyyy, MM, dd, HH, mm, ss) - Format DateTimeInterface using same subset - Provide explicit timezone & locale handling without custom Olson DB. This is intentionally minimal; extend only when concrete application usages require more tokens.

Formatting and parsing both go through `IntlDateFormatter`: ext-intl is a hard requirement of the framework (see composer.json), so there is no second implementation to keep in step -- one that would, being locale-blind, quietly disagree with this one.

The supported tokens are spelled the same way in ICU, so a pattern is handed to ICU as written; [`DateTimeFacade::assertSupportedTokens()`](/api/i18n/date-time-facade/#assertsupportedtokens) is what keeps a pattern inside that subset.

## Synopsis

`final class DateTimeFacade`

|  |  |
|---|---|
| Source | `I18n/DateTimeFacade.php` |

## Methods

| Method | Description |
|---|---|
| [`format(DateTimeInterface $dt, string $pattern, ?string $locale = null): string`](#format) | Format a DateTime using a legacy-style pattern. |
| [`parse(string $value, string $pattern, ?string $timezone = null, ?string $locale = null): DateTimeImmutable`](#parse) | Parse a datetime string according to a legacy-style pattern. |

### format()

`public static function format(DateTimeInterface $dt, string $pattern, ?string $locale = null): string`

Format a DateTime using a legacy-style pattern.

| Parameter | Type | Description |
|---|---|---|
| `$dt` | [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php) |  |
| `$pattern` | `string` |  |
| `$locale` | `?``string` |  |

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | if the pattern holds an unsupported token, or ICU cannot format the value. |

### parse()

`public static function parse(string $value, string $pattern, ?string $timezone = null, ?string $locale = null): DateTimeImmutable`

Parse a datetime string according to a legacy-style pattern.

Supports fixed-width tokens: yyyy, MM, dd, HH, mm, ss (24h clock).

The whole value must be consumed, so trailing text is a parse failure rather than something silently ignored.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |
| `$pattern` | `string` |  |
| `$timezone` | `?``string` |  |
| `$locale` | `?``string` |  |

Returns [`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)

| Throws | When |
|---|---|
| `RuntimeException` | if the pattern holds an unsupported token, or the value does not parse against it. |
