# DateFormatter

> The date formatter will dates numbers according to a given format

The date formatter will dates numbers according to a given format

## Synopsis

`class DateFormatter implements ITranslator, ResetInterface`

|  |  |
|---|---|
| Implements | [`ITranslator`](/api/translation/i-translator/), `ResetInterface` |
| Since | `1.0.0` |
| Source | `Translation/DateFormatter.php` |

## Methods

| Method | Description |
|---|---|
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`initialize(Context $context, array $parameters = []): mixed`](#initialize) | Initializes this formatter from its factory parameters. |
| [`localeChanged(mixed $newLocale): mixed`](#localechanged) | Adopts a new locale and re-resolves the cached ICU pattern for it. |
| [`reset(): void`](#reset) | Reset per-request locale state for worker compatibility. |
| [`resolveFormat(?string $format, QuioteLocale $locale, string $type = 'datetime'): ?string`](#resolveformat) |  |
| [`translate(mixed $message, mixed $domain, ?QuioteLocale $locale = null): mixed`](#translate) | Formats a date value for the given locale and translation domain. |

### getContext()

`public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

### initialize()

`public function initialize(Context $context, array $parameters = []): mixed`

Initializes this formatter from its factory parameters.

Recognises "type" ('date', 'time' or 'datetime', anything else leaves the default 'datetime'), "format" (an ICU pattern, a format specifier, or a map of locale lookup path to format) and "translation_domain". A "format" given as an array is already per-locale, so it clears the translation domain: the map is used directly instead of being run through the translation manager.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `QuioteException` | If "translation_domain" is present but not a string. |

### localeChanged()

`public function localeChanged(mixed $newLocale): mixed`

Adopts a new locale and re-resolves the cached ICU pattern for it.

A format configured as a map is looked up along the new locale's lookup path; a plain format string is used as-is unless a translation domain is configured, in which case the pattern is resolved per call in [`DateFormatter::translate()`](/api/translation/date-formatter/#translate) instead.

| Parameter | Type | Description |
|---|---|---|
| `$newLocale` | `mixed` |  |

Returns `mixed`

| Throws | When |
|---|---|
| `QuioteException` | If the configured format resolves to a non-string value for the new locale. |

### reset()

`public function reset(): void`

Reset per-request locale state for worker compatibility.

type, customFormat and translationDomain are configured once from initialize() parameters and never restored afterward -- clearing them here would silently revert to the default 'datetime' type/format for every subsequent request. Only locale and resolvedPattern, which localeChanged() always recomputes for the active locale, are per-request.

### resolveFormat()

`public static function resolveFormat(?string $format, QuioteLocale $locale, string $type = 'datetime'): ?string`

The date type ('date', 'time' or 'datetime').

| Parameter | Type | Description |
|---|---|---|
| `$format` | `?``string` | A date format specifier or explicit pattern. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/) | The locale to resolve the format for. |
| `$type` | `string` | The date type ('date', 'time' or 'datetime'). |

Returns `?``string` — The resolved pattern, or the original format if it wasn't a specifier.

### translate()

`public function translate(mixed $message, mixed $domain, ?QuioteLocale $locale = null): mixed`

Formats a date value for the given locale and translation domain.

$message may be anything the internal coercion accepts (a DateTimeInterface, a timestamp or a parsable string); the result is that value rendered with the resolved ICU pattern. When an explicit $locale is passed, the work is done on a clone re-resolved for that locale, so this instance keeps the locale the translation manager gave it. When the format is a translatable specifier, it is looked up in the configured translation domain, suffixed with $domain.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `mixed` |  |
| `$domain` | `mixed` |  |
| `$locale` | `?`[`QuioteLocale`](/api/translation/quiote-locale/) |  |

Returns `mixed`

| Throws | When |
|---|---|
| `QuioteException` | If no locale has been set and none was passed, if a translation domain is configured but translations are disabled, or if no pattern could be resolved. |
