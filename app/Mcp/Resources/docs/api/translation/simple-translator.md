# SimpleTranslator

> SimpleTranslator defines the translator which loads the data from its parameters.

SimpleTranslator defines the translator which loads the data from its parameters.

## Synopsis

`class SimpleTranslator extends BasicTranslator`

|  |  |
|---|---|
| Extends | [`BasicTranslator`](/api/translation/basic-translator/) |
| Since | `1.0.0` |
| Source | `Translation/SimpleTranslator.php` |

## Methods

| Method | Description |
|---|---|
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Translator. |
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

domainData is the parsed config catalog built once in initialize() and never restored afterward -- clearing it here would leave every subsequent request's translations resolving to their untranslated key for the rest of the worker's lifetime. Only currentData/locale, which localeChanged() re-derives from domainData for the active locale, are per-request.

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
