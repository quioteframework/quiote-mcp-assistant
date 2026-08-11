# GettextTranslator

> GettextTranslator defines the translator interface for gettext.

GettextTranslator defines the translator interface for gettext.

## Synopsis

`class GettextTranslator extends BasicTranslator`

|  |  |
|---|---|
| Extends | [`BasicTranslator`](/api/translation/basic-translator/) |
| Since | `1.0.0` |
| Source | `Translation/GettextTranslator.php` |

## Methods

| Method | Description |
|---|---|
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Translator. |
| [`loadDomainData(string $domain): void`](#loaddomaindata) | Loads the data from the data file for the given domain with the current locale. |
| [`localeChanged(QuioteLocale $newLocale): mixed`](#localechanged) | This method gets called by the translation manager when the default locale has been changed. |
| [`reset(): void`](#reset) | Reset per-request locale state for worker compatibility. |
| [`translate(mixed $message, string $domain, ?QuioteLocale $locale = null): string`](#translate) | Translates a message into the defined language. |

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this Translator.

An associative array of initialization parameters

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters |

### loadDomainData()

`public function loadDomainData(string $domain): void`

Loads the data from the data file for the given domain with the current locale.

The domain to load the data for.

| Parameter | Type | Description |
|---|---|---|
| `$domain` | `string` | The domain to load the data for. |

### localeChanged()

`public function localeChanged(QuioteLocale $newLocale): mixed`

This method gets called by the translation manager when the default locale has been changed.

The new default locale.

| Parameter | Type | Description |
|---|---|---|
| `$newLocale` | [`QuioteLocale`](/api/translation/quiote-locale/) | The new default locale. |

Returns `mixed`

### reset()

`public function reset(): void`

Reset per-request locale state for worker compatibility.

Only clears what localeChanged()/loadDomainData() derive from the current locale -- context, domainPathPattern, domainPaths and the store-calls settings are configured once from initialize() parameters and never restored afterward, so clearing them here would silently break every subsequent request's translations for the rest of the worker's lifetime.

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
| `getContext()` | [`BasicTranslator`](/api/translation/basic-translator/) | Retrieve the current application context. |
