# DecimalFormatter

> The decimal formatter will format numbers according to a given format.

The decimal formatter will format numbers according to a given format.

The format is close to the one used by [ICU](http://icu.sourceforge.net/apiref/icu4c/classDecimalFormat.html). It consists of the following elements

## Synopsis

`class DecimalFormatter implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `1.0.0` |
| Source | `Util/DecimalFormatter.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CURRENCY_CODE` | `2` |  |
| `CURRENCY_NAME` | `3` |  |
| `CURRENCY_SYMBOL` | `1` |  |
| `IN_NUMBER` | `2` |  |
| `IN_POSTFIX` | `3` |  |
| `IN_PREFIX` | `1` |  |
| `ROUND_CEIL` | `4` |  |
| `ROUND_FINANCIAL` | `2` |  |
| `ROUND_FLOOR` | `3` |  |
| `ROUND_NONE` | `0` |  |
| `ROUND_SCIENTIFIC` | `1` |  |

## Constructor

### __construct()

`public function __construct(string $format = null): mixed`

Constructs a new Decimalformatter with the optional format.

The format (if any).

| Parameter | Type | Description |
|---|---|---|
| `$format` | `string` | The format (if any). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`formatCurrency(int|float $number, string $currencySymbol): string`](#formatcurrency) | Formats the given currency and returns the formatted result. |
| [`formatNumber(int|float|string $number): string`](#formatnumber) | Formats the given number and returns the formatted result. |
| [`getFormat(): ?string`](#getformat) | Returns the format which is currently used to format numbers. |
| [`getRoundingMode(): int`](#getroundingmode) | Returns the rounding mode. |
| [`getRoundingModeFromString(string $mode): int`](#getroundingmodefromstring) | Maps a string rounding mode definition to the rounding mode constants. |
| [`parse(string $string, QuioteLocale|string|null $locale = null, bool &$hasExtraChars = false): mixed`](#parse) | Parses a string into float or int. |
| [`reset(): void`](#reset) | Clears the parsed number format so the formatter can be re-configured. |
| [`setFormat(string $format): void`](#setformat) | Sets the format to be used for formatting numbers. |
| [`setRoundingMode(int $mode): void`](#setroundingmode) | Sets the rounding mode. |

### formatCurrency()

`public function formatCurrency(int|float $number, string $currencySymbol): string`

Formats the given currency and returns the formatted result.

The currency symbol to be used when formatting.

| Parameter | Type | Description |
|---|---|---|
| `$number` | `int``|``float` | The number to be formatted. |
| `$currencySymbol` | `string` | The currency symbol to be used when formatting. |

Returns `string` — The currency formatted in the desired format.

### formatNumber()

`public function formatNumber(int|float|string $number): string`

Formats the given number and returns the formatted result.

The number to be formatted.

| Parameter | Type | Description |
|---|---|---|
| `$number` | `int``|``float``|``string` | The number to be formatted. |

Returns `string` — The number formatted in the desired format.

### getFormat()

`public function getFormat(): ?string`

Returns the format which is currently used to format numbers.

Returns `?``string` — The current format.

### getRoundingMode()

`public function getRoundingMode(): int`

Returns the rounding mode.

Returns `int` — The rounding mode.

### getRoundingModeFromString()

`public function getRoundingModeFromString(string $mode): int`

Maps a string rounding mode definition to the rounding mode constants.

The mode string.

| Parameter | Type | Description |
|---|---|---|
| `$mode` | `string` | The mode string. |

Returns `int` — The rounding mode constant.

### parse()

`public static function parse(string $string, QuioteLocale|string|null $locale = null, bool &$hasExtraChars = false): mixed`

Parses a string into float or int.

An out value indicating whether there were additional 
                 characters after the matched number.

| Parameter | Type | Description |
|---|---|---|
| `$string` | `string` | The input number string. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/)`|``string``|``null` | An optional locale to get the separators from. |
| `$hasExtraChars` | `bool` | An out value indicating whether there were additional characters after the matched number. |

Returns `mixed` — The result if parsing was successful or false when the input was no number.

### reset()

`public function reset(): void`

Clears the parsed number format so the formatter can be re-configured.

Everything derived from the format string -- separators, grouping distances, digit counts, sign and currency flags -- goes back to its default. The rounding mode is left alone, as the comment below records.

### setFormat()

`public function setFormat(string $format): void`

Sets the format to be used for formatting numbers.

The format.

| Parameter | Type | Description |
|---|---|---|
| `$format` | `string` | The format. |

### setRoundingMode()

`public function setRoundingMode(int $mode): void`

Sets the rounding mode.

The rounding mode.

| Parameter | Type | Description |
|---|---|---|
| `$mode` | `int` | The rounding mode. |
