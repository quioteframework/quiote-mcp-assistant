# QuioteLocale

> Represents a single locale: its identifier plus the language/territory/ script/variant and the calendar/currency/timezone options carried in the identifier's '@key=value' suffix.

Represents a single locale: its identifier plus the language/territory/ script/variant and the calendar/currency/timezone options carried in the identifier's '@key=value' suffix.

All CLDR-derived metadata (calendar names, number symbols, display names, …) is served directly from ext/intl by the formatters and the [`TranslationManager`](/api/translation/translation-manager/); this class only resolves the identifier and its options.

## Synopsis

`class QuioteLocale extends ParameterHolder`

|  |  |
|---|---|
| Extends | [`ParameterHolder`](/api/util/parameter-holder/) |
| Since | `1.0.0` |
| Source | `Translation/QuioteLocale.php` |

## Methods

| Method | Description |
|---|---|
| [`getCharacterOrientation(): string`](#getcharacterorientation) | Which way this locale's text runs: `left-to-right` or `right-to-left`. |
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`getCurrencyDisplayName(string $code): ?string`](#getcurrencydisplayname) | The name of a currency as this locale writes it: `EUR` as "Euro" in `en`, "euro" in `fi`. |
| [`getIdentifier(): ?string`](#getidentifier) | Returns the identifier of this locale |
| [`getLocaleCalendar(): ?string`](#getlocalecalendar) |  |
| [`getLocaleCurrency(): ?string`](#getlocalecurrency) |  |
| [`getLocaleLanguage(): ?string`](#getlocalelanguage) |  |
| [`getLocaleScript(): ?string`](#getlocalescript) |  |
| [`getLocaleTerritory(): ?string`](#getlocaleterritory) |  |
| [`getLocaleTimeZone(): ?string`](#getlocaletimezone) |  |
| [`getLocaleVariant(): ?string`](#getlocalevariant) |  |
| [`getLookupPath(string|null|array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string} $localeIdentifier): array<int, string>`](#getlookuppath) | Returns all file names which need to be considered for the given identifier. |
| [`getTimeZoneOptionString(DateTimeInterface|DateTimeZone|string|int $item, string $prefix = '@'): string`](#gettimezoneoptionstring) | Returns the locale option string containing the timezone option set to the timezone of this calendar. |
| [`initialize(Context $context, array<string, mixed> $parameters = [], string $identifier = null, array<string, mixed> $data = []): void`](#initialize) | Initialize this Locale. |
| [`parseLocaleIdentifier(string $identifier): array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}`](#parselocaleidentifier) | Parses a locale identifier and returns its parts. |
| [`reset(): void`](#reset) | Returns this locale to its just-constructed state for reuse across requests. |

### getCharacterOrientation()

`public function getCharacterOrientation(): string`

Which way this locale's text runs: `left-to-right` or `right-to-left`.

The answer a template needs to decide `dir="rtl"`, which is the only thing anything has ever asked this for.

Resolved from the locale's *script*, because that is what decides direction -- and asked of ICU rather than of the identifier, since a bare `ar` or `ur` names no script. `addLikelySubtags()` is how ICU says which script a language is written in by default, so `ur` resolves through `ur_Arab_PK` and an explicit `az_Latn` is taken at its word.

Left-to-right is the answer when the script cannot be determined at all. It is the direction of the overwhelming majority of locales, and a page laid out left to right for a locale nobody could identify is a smaller wrong than one laid out backwards.

Returns `string` — `left-to-right` or `right-to-left`.

### getContext()

`final public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

### getCurrencyDisplayName()

`public function getCurrencyDisplayName(string $code): ?string`

The name of a currency as this locale writes it: `EUR` as "Euro" in `en`, "euro" in `fi`.

An ISO 4217 code, e.g. `EUR`.

| Parameter | Type | Description |
|---|---|---|
| `$code` | `string` | An ISO 4217 code, e.g. `EUR`. |

Returns `?``string` — The localized name, or null when this locale's data does not name the code.

### getIdentifier()

`public function getIdentifier(): ?string`

Returns the identifier of this locale

Returns `?``string` — The identifier.

### getLocaleCalendar()

`public function getLocaleCalendar(): ?string`

Returns `?``string` — The calendar identifier of this locale.

### getLocaleCurrency()

`public function getLocaleCurrency(): ?string`

Returns `?``string` — The currency code of this locale.

### getLocaleLanguage()

`public function getLocaleLanguage(): ?string`

Returns `?``string` — The language of this locale.

### getLocaleScript()

`public function getLocaleScript(): ?string`

Returns `?``string` — The script of this locale.

### getLocaleTerritory()

`public function getLocaleTerritory(): ?string`

Returns `?``string` — The territory of this locale.

### getLocaleTimeZone()

`public function getLocaleTimeZone(): ?string`

Returns `?``string` — The timezone identifier of this locale.

### getLocaleVariant()

`public function getLocaleVariant(): ?string`

Returns `?``string` — The variant of this locale.

### getLookupPath()

`public static function getLookupPath(string|null|array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string} $localeIdentifier): array<int, string>`

Returns all file names which need to be considered for the given identifier.

The locale identifier or the result of
                  QuioteLocale::parseLocaleIdentifier. A null identifier is
                  treated as the empty string, which parseLocaleIdentifier
                  rejects as invalid.

| Parameter | Type | Description |
|---|---|---|
| `$localeIdentifier` | `string``|``null``|``array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}` | The locale identifier or the result of QuioteLocale::parseLocaleIdentifier. A null identifier is treated as the empty string, which parseLocaleIdentifier rejects as invalid. |

Returns `array``<``int``, ``string``>` — The filenames.

### getTimeZoneOptionString()

`public static function getTimeZoneOptionString(DateTimeInterface|DateTimeZone|string|int $item, string $prefix = '@'): string`

Returns the locale option string containing the timezone option set to the timezone of this calendar.

The prefix which will be applied to the timezone option
                   string. Use ';' here if you intend to use several
                   locale options and append the result of this method
                   to your locale string.

| Parameter | Type | Description |
|---|---|---|
| `$item` | [`DateTimeInterface`](https://www.php.net/manual/en/class.datetimeinterface.php)`|``DateTimeZone``|``string``|``int` | The item to determine the timezone from |
| `$prefix` | `string` | The prefix which will be applied to the timezone option string. Use ';' here if you intend to use several locale options and append the result of this method to your locale string. |

Returns `string` — Returns an empty string (NOT containing the $prefix) if $item is invalid or no timezone could be determined

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = [], string $identifier = null, array<string, mixed> $data = []): void`

Initialize this Locale.

The locale data.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |
| `$identifier` | `string` | The identifier of the locale |
| `$data` | `array``<``string``, ``mixed``>` | The locale data. |

### parseLocaleIdentifier()

`public static function parseLocaleIdentifier(string $identifier): array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}`

Parses a locale identifier and returns its parts.

The locale identifier.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | The locale identifier. |

Returns `array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}` — The parts of the identifier

### reset()

`public function reset(): void`

Returns this locale to its just-constructed state for reuse across requests.

Drops the context, the loaded locale data, the identifier and the parameters, so a pooled worker re-initializes the locale from scratch rather than serving the previous request's language.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
