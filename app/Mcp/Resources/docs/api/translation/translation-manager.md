# TranslationManager

> The translation manager manages the interface between the application and the current translation engine implementation

The translation manager manages the interface between the application and the current translation engine implementation

## Synopsis

`class TranslationManager implements ResetInterface`

|  |  |
|---|---|
| Implements | `ResetInterface` |
| Since | `1.0.0` |
| Source | `Translation/TranslationManager.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CURRENCY` | `'cur'` |  |
| `DATETIME` | `'date'` |  |
| `MESSAGE` | `'msg'` |  |
| `NUMBER` | `'num'` |  |

## Methods

| Method | Description |
|---|---|
| [`_(mixed $message, ?string $domain = null, QuioteLocale|string|null $locale = null, ?array<int, mixed> $parameters = null): string`](#) | Translate a message into the current locale. |
| [`__(string $singularMessage, string $pluralMessage, int $amount, ?string $domain = null, QuioteLocale|string|null $locale = null, ?array<int, mixed> $parameters = null): string`](#) | Translate a singular/plural message into the current locale. |
| [`_c(mixed $number, ?string $domain = null, QuioteLocale|string|null $locale = null): string`](#c) | Formats a currency amount in the current locale. |
| [`_d(mixed $date, ?string $domain = null, QuioteLocale|string|null $locale = null): string`](#d) | Formats a date in the current locale. |
| [`_n(mixed $number, ?string $domain = null, QuioteLocale|string|null $locale = null): string`](#n) | Formats a number in the current locale. |
| [`createTimeZone(mixed $id, bool $cache = true): ?DateTimeZone`](#createtimezone) | Creates a new timezone instance for the given identifier. |
| [`getAvailableLocales(): array<string, array{identifier: string, identifierData: array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}, parameters: array<string, mixed>}>`](#getavailablelocales) | Returns the list of available locales. |
| [`getContext(): Context`](#getcontext) | Retrieve the current application context. |
| [`getCurrencyFraction(string $currency): array{digits: int, rounding: int}`](#getcurrencyfraction) | Returns an array containing digits and rounding information for a currency. |
| [`getCurrentLocale(): ?QuioteLocale`](#getcurrentlocale) | Retrieve the current locale. |
| [`getCurrentLocaleIdentifier(): ?string`](#getcurrentlocaleidentifier) | Retrieve the current locale identifier. |
| [`getCurrentTimeZone(): ?DateTimeZone`](#getcurrenttimezone) | Gets the instance of the current timezone. |
| [`getDefaultDomain(): string`](#getdefaultdomain) | Retrieve the default domain. |
| [`getDefaultLocale(): QuioteLocale`](#getdefaultlocale) | Retrieve the default locale. |
| [`getDefaultLocaleIdentifier(): ?string`](#getdefaultlocaleidentifier) | Retrieve the default locale identifier. |
| [`getDefaultTimeZone(): ?DateTimeZone`](#getdefaulttimezone) | Get the default timezone instance. |
| [`getDomainTranslator(string $domain, string $type): ?ITranslator`](#getdomaintranslator) | Returns the translators for a given domain and type. |
| [`getLocale(string $identifier, bool $forceNew = false): QuioteLocale`](#getlocale) | Returns a new Locale object from the given identifier. |
| [`getLocaleIdentifier(string $identifier): string`](#getlocaleidentifier) | Returns the identifier of the available locale which matches the given locale identifier most. |
| [`getMatchingLocaleIdentifiers(string $identifier): array<int, string>`](#getmatchinglocaleidentifiers) | Returns all the identifiers of the available locales which match the given locale identifier. |
| [`getTerritoryData(string $country): array<string, mixed>`](#getterritorydata) | Returns the stored information from the ldml supplemental data about a territory. |
| [`getTimeZoneTerritory(string $id, bool &$hasMultipleZones = false): ?string`](#gettimezoneterritory) | Gets the territory id a (resolved) timezone id belongs to. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this TranslationManager. |
| [`reset(): void`](#reset) | Reset per-request locale state for worker compatibility. |
| [`resolveTimeZoneId(DateTimeZone|string $id): ?string`](#resolvetimezoneid) | Resolved the given timezone identifier to its 'real' timezone id. |
| [`setDefaultDomain(string $domain): void`](#setdefaultdomain) | Sets the default domain. |
| [`setDefaultTimeZone(DateTimeZone|string $id): void`](#setdefaulttimezone) | Sets the default time zone. |
| [`setLocale(string $identifier): void`](#setlocale) | Sets the current locale. |
| [`shutdown(): void`](#shutdown) | Execute the shutdown procedure. |
| [`startup(): void`](#startup) | Do any necessary startup work after initialization. |

### _()

`public function _(mixed $message, ?string $domain = null, QuioteLocale|string|null $locale = null, ?array<int, mixed> $parameters = null): string`

Translate a message into the current locale.

The parameters which should be used for sprintf on
                        the translated string.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `mixed` | The message. |
| `$domain` | `?``string` | The domain in which the translation should be done. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/)`|``string``|``null` | The locale which should be used for formatting. Defaults to the currently active locale. |
| `$parameters` | `?``array``<``int``, ``mixed``>` | The parameters which should be used for sprintf on the translated string. |

Returns `string` — The translated message.

### __()

`public function __(string $singularMessage, string $pluralMessage, int $amount, ?string $domain = null, QuioteLocale|string|null $locale = null, ?array<int, mixed> $parameters = null): string`

Translate a singular/plural message into the current locale.

The parameters which should be used for sprintf on
                        the translated string.

| Parameter | Type | Description |
|---|---|---|
| `$singularMessage` | `string` | The message for the singular form. |
| `$pluralMessage` | `string` | The message for the plural form. |
| `$amount` | `int` | The amount for which the translation should happen. |
| `$domain` | `?``string` | The domain in which the translation should be done. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/)`|``string``|``null` | The locale which should be used for formatting. Defaults to the currently active locale. |
| `$parameters` | `?``array``<``int``, ``mixed``>` | The parameters which should be used for sprintf on the translated string. |

Returns `string` — The translated message.

### _c()

`public function _c(mixed $number, ?string $domain = null, QuioteLocale|string|null $locale = null): string`

Formats a currency amount in the current locale.

The locale which should be used for formatting.
                        Defaults to the currently active locale.

| Parameter | Type | Description |
|---|---|---|
| `$number` | `mixed` | The number to be formatted. |
| `$domain` | `?``string` | The domain in which the amount should be formatted. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/)`|``string``|``null` | The locale which should be used for formatting. Defaults to the currently active locale. |

Returns `string` — The formatted number.

### _d()

`public function _d(mixed $date, ?string $domain = null, QuioteLocale|string|null $locale = null): string`

Formats a date in the current locale.

The locale which should be used for formatting.
                        Defaults to the currently active locale.

| Parameter | Type | Description |
|---|---|---|
| `$date` | `mixed` | The date to be formatted. |
| `$domain` | `?``string` | The domain in which the date should be formatted. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/)`|``string``|``null` | The locale which should be used for formatting. Defaults to the currently active locale. |

Returns `string` — The formatted date.

### _n()

`public function _n(mixed $number, ?string $domain = null, QuioteLocale|string|null $locale = null): string`

Formats a number in the current locale.

The locale which should be used for formatting.
                        Defaults to the currently active locale.

| Parameter | Type | Description |
|---|---|---|
| `$number` | `mixed` | The number to be formatted. |
| `$domain` | `?``string` | The domain in which the number should be formatted. |
| `$locale` | [`QuioteLocale`](/api/translation/quiote-locale/)`|``string``|``null` | The locale which should be used for formatting. Defaults to the currently active locale. |

Returns `string` — The formatted number.

### createTimeZone()

`public function createTimeZone(mixed $id, bool $cache = true): ?DateTimeZone`

Creates a new timezone instance for the given identifier.

Whether to use/populate the timezone instance cache.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `mixed` | The timezone identifier |
| `$cache` | `bool` | Whether to use/populate the timezone instance cache. |

Returns `?``DateTimeZone` — The timezone instance for the given id.

### getAvailableLocales()

`public function getAvailableLocales(): array<string, array{identifier: string, identifierData: array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}, parameters: array<string, mixed>}>`

Returns the list of available locales.

Returns `array``<``string``, ``array{identifier: string, identifierData: array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}, parameters: array<string, mixed>}``>`

### getContext()

`final public function getContext(): Context`

Retrieve the current application context.

Returns [`Context`](/api/context/) — The current Context instance.

### getCurrencyFraction()

`public function getCurrencyFraction(string $currency): array{digits: int, rounding: int}`

Returns an array containing digits and rounding information for a currency.

The uppercase 3 letter currency iso code.

| Parameter | Type | Description |
|---|---|---|
| `$currency` | `string` | The uppercase 3 letter currency iso code. |

Returns `array{digits: int, rounding: int}` — The data.

### getCurrentLocale()

`public function getCurrentLocale(): ?QuioteLocale`

Retrieve the current locale.

Returns `?`[`QuioteLocale`](/api/translation/quiote-locale/) — The current locale.

### getCurrentLocaleIdentifier()

`public function getCurrentLocaleIdentifier(): ?string`

Retrieve the current locale identifier.

This may not necessarily match what has be given to setLocale() but instead the identifier of the closest match from the available locales.

Returns `?``string` — The locale identifier.

### getCurrentTimeZone()

`public function getCurrentTimeZone(): ?DateTimeZone`

Gets the instance of the current timezone.

Returns `?``DateTimeZone` — The current timezone instance.

### getDefaultDomain()

`public function getDefaultDomain(): string`

Retrieve the default domain.

Returns `string` — The default domain.

### getDefaultLocale()

`public function getDefaultLocale(): QuioteLocale`

Retrieve the default locale.

Returns [`QuioteLocale`](/api/translation/quiote-locale/) — The current default.

### getDefaultLocaleIdentifier()

`public function getDefaultLocaleIdentifier(): ?string`

Retrieve the default locale identifier.

Returns `?``string` — The default locale identifier.

### getDefaultTimeZone()

`public function getDefaultTimeZone(): ?DateTimeZone`

Get the default timezone instance.

Returns `?``DateTimeZone` — The default timezone instance.

### getDomainTranslator()

`public function getDomainTranslator(string $domain, string $type): ?ITranslator`

Returns the translators for a given domain and type.

The type of the translator.

| Parameter | Type | Description |
|---|---|---|
| `$domain` | `string` | The domain. |
| `$type` | `string` | The type of the translator. |

Returns `?`[`ITranslator`](/api/translation/i-translator/) — The translator instance.

### getLocale()

`public function getLocale(string $identifier, bool $forceNew = false): QuioteLocale`

Returns a new Locale object from the given identifier.

Force a new instance even if an identical one exists.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | The locale identifier |
| `$forceNew` | `bool` | Force a new instance even if an identical one exists. |

Returns [`QuioteLocale`](/api/translation/quiote-locale/) — The locale instance which matches the available locales most.

### getLocaleIdentifier()

`public function getLocaleIdentifier(string $identifier): string`

Returns the identifier of the available locale which matches the given locale identifier most.

A locale identifier

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | A locale identifier |

Returns `string` — The actual locale identifier of the available locale.

### getMatchingLocaleIdentifiers()

`public function getMatchingLocaleIdentifiers(string $identifier): array<int, string>`

Returns all the identifiers of the available locales which match the given locale identifier.

A locale identifier

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | A locale identifier |

Returns `array``<``int``, ``string``>` — The actual locale identifiers of the available locales.

### getTerritoryData()

`public function getTerritoryData(string $country): array<string, mixed>`

Returns the stored information from the ldml supplemental data about a territory.

The uppercase 2 letter country iso code.

| Parameter | Type | Description |
|---|---|---|
| `$country` | `string` | The uppercase 2 letter country iso code. |

Returns `array``<``string``, ``mixed``>` — The data.

### getTimeZoneTerritory()

`public function getTimeZoneTerritory(string $id, bool &$hasMultipleZones = false): ?string`

Gets the territory id a (resolved) timezone id belongs to.

Will receive whether the territory has multiple
                   time zones

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` | The resolved timezone id. |
| `$hasMultipleZones` | `bool` | Will receive whether the territory has multiple time zones |

Returns `?``string` — The territory identifier or null.

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this TranslationManager.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

### reset()

`public function reset(): void`

Reset per-request locale state for worker compatibility.

A request that called setLocale() must not influence the next one, so the selected locale is dropped. It is restored to the configured default rather than left empty: Context::reset() calls this between requests and the manager is reused as-is, without a second initialize(), so a manager with no locale at all would make the next request's first locale-dependent lookup fail -- e.g. StreamTemplateLayer asking for the current identifier to build its template lookup path, which rejects an empty one.

Every registered translator is reset too, unconditionally: setLocale() above notifies translators of the new locale via loadCurrentLocale(), but only when there IS a default locale to fall back to and only once loadCurrentLocale() next runs. Without a default locale (or before that lazy re-check happens), translators would otherwise keep serving the previous request's locale/domain data -- the exact cross-request bleed this method exists to prevent.

### resolveTimeZoneId()

`public function resolveTimeZoneId(DateTimeZone|string $id): ?string`

Resolved the given timezone identifier to its 'real' timezone id.

The timezone id to be resolved

| Parameter | Type | Description |
|---|---|---|
| `$id` | `DateTimeZone``|``string` | The timezone id to be resolved |

Returns `?``string` — The resolved timezone id

### setDefaultDomain()

`public function setDefaultDomain(string $domain): void`

Sets the default domain.

The new default domain.

| Parameter | Type | Description |
|---|---|---|
| `$domain` | `string` | The new default domain. |

### setDefaultTimeZone()

`public function setDefaultTimeZone(DateTimeZone|string $id): void`

Sets the default time zone.

The timezone identifier

| Parameter | Type | Description |
|---|---|---|
| `$id` | `DateTimeZone``|``string` | The timezone identifier |

### setLocale()

`public function setLocale(string $identifier): void`

Sets the current locale.

The locale identifier.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | The locale identifier. |

### shutdown()

`public function shutdown(): void`

Execute the shutdown procedure.

### startup()

`public function startup(): void`

Do any necessary startup work after initialization.

This method is not called directly after initialize().
