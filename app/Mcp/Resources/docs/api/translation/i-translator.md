# ITranslator

> ITranslator defines the interface for different translator implementations (like gettext, XLIFF, ...)

ITranslator defines the interface for different translator implementations (like gettext, XLIFF, ...)

## Synopsis

`interface ITranslator`

|  |  |
|---|---|
| Implemented by | [`BasicTranslator`](/api/translation/basic-translator/), [`CurrencyFormatter`](/api/translation/currency-formatter/), [`DateFormatter`](/api/translation/date-formatter/), [`QuioteNumberFormatter`](/api/translation/quiote-number-formatter/) |
| Since | `1.0.0` |
| Source | `Translation/ITranslator.php` |

## Methods

| Method | Description |
|---|---|
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Translator. |
| [`localeChanged(QuioteLocale $newLocale): void`](#localechanged) | This method gets called by the translation manager when the default locale has been changed. |
| [`translate(mixed $message, string $domain, ?QuioteLocale $locale = null): string`](#translate) | Translates a message into the defined language. |

### getContext()

`abstract public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

### initialize()

`abstract public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this Translator.

An associative array of initialization parameters

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters |

### localeChanged()

`abstract public function localeChanged(QuioteLocale $newLocale): void`

This method gets called by the translation manager when the default locale has been changed.

The new default locale.

| Parameter | Type | Description |
|---|---|---|
| `$newLocale` | [`QuioteLocale`](/api/translation/quiote-locale/) | The new default locale. |

### translate()

`abstract public function translate(mixed $message, string $domain, ?QuioteLocale $locale = null): string`

Translates a message into the defined language.

The locale to which the message should be
                        translated.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `mixed` | The message to be translated. |
| `$domain` | `string` | The domain of the message. |
| `$locale` | `?`[`QuioteLocale`](/api/translation/quiote-locale/) | The locale to which the message should be translated. |

Returns `string` — The translated message.
