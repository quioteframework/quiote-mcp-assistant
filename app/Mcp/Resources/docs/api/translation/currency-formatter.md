# CurrencyFormatter

> The currency formatter will format numbers according to a given format and a given currency symbol

The currency formatter will format numbers according to a given format and a given currency symbol

## Synopsis

`class CurrencyFormatter extends DecimalFormatter implements ITranslator`

|  |  |
|---|---|
| Extends | [`DecimalFormatter`](/api/util/decimal-formatter/) |
| Implements | [`ITranslator`](/api/translation/i-translator/) |
| Since | `1.0.0` |
| Source | `Translation/CurrencyFormatter.php` |

## Methods

| Method | Description |
|---|---|
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`getCurrencyCode(): string`](#getcurrencycode) | Returns the iso code of the currency which should be used when formatting. |
| [`getCurrencySymbol(): string`](#getcurrencysymbol) | Returns the currency symbol which should be used when formatting. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Translator. |
| [`localeChanged(QuioteLocale $newLocale): void`](#localechanged) | This method gets called by the translation manager when the default locale has been changed. |
| [`reset(): void`](#reset) | Reset per-request locale state for worker compatibility. |
| [`setFractionDigits(int $count): void`](#setfractiondigits) | Sets the amount of fractional digits to be shown. |
| [`translate(mixed $message, string $domain, ?QuioteLocale $locale = null): string`](#translate) | Translates a message into the defined language. |

### getContext()

`final public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

### getCurrencyCode()

`public function getCurrencyCode(): string`

Returns the iso code of the currency which should be used when formatting.

Returns `string` — The currency iso code.

### getCurrencySymbol()

`public function getCurrencySymbol(): string`

Returns the currency symbol which should be used when formatting.

Returns `string` — The currency symbol

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this Translator.

An associative array of initialization parameters

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters |

### localeChanged()

`public function localeChanged(QuioteLocale $newLocale): void`

This method gets called by the translation manager when the default locale has been changed.

The new default locale.

| Parameter | Type | Description |
|---|---|---|
| `$newLocale` | [`QuioteLocale`](/api/translation/quiote-locale/) | The new default locale. |

### reset()

`public function reset(): void`

Reset per-request locale state for worker compatibility.

context, customFormat, currencyCode and translationDomain are configured once from initialize() parameters and never restored afterward -- clearing them here would silently lose the configured currency/format for every subsequent request. Only locale (and the derived format fields cleared by parent::reset(), which localeChanged() always recomputes) are per-request.

### setFractionDigits()

`public function setFractionDigits(int $count): void`

Sets the amount of fractional digits to be shown.

The amount of digits.

| Parameter | Type | Description |
|---|---|---|
| `$count` | `int` | The amount of digits. |

### translate()

`public function translate(mixed $message, string $domain, ?QuioteLocale $locale = null): string`

Translates a message into the defined language.

The locale to which the message should be
                        translated.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `mixed` | The message to be translated. |
| `$domain` | `string` | The domain of the message. |
| `$locale` | `?`[`QuioteLocale`](/api/translation/quiote-locale/) | The locale to which the message should be translated. |

Returns `string` — The translated message.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `formatCurrency()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Formats the given currency and returns the formatted result. |
| `formatNumber()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Formats the given number and returns the formatted result. |
| `getFormat()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Returns the format which is currently used to format numbers. |
| `getRoundingMode()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Returns the rounding mode. |
| `getRoundingModeFromString()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Maps a string rounding mode definition to the rounding mode constants. |
| `parse()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Parses a string into float or int. |
| `setFormat()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Sets the format to be used for formatting numbers. |
| `setRoundingMode()` | [`DecimalFormatter`](/api/util/decimal-formatter/) | Sets the rounding mode. |
