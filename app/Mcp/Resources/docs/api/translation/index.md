# Translation

> The Quiote\\Translation namespace — 11 documented types.

Everything under `Quiote\Translation`.

## Classes

| Class | Description |
|---|---|
| [`BasicTranslator`](/api/translation/basic-translator/) | BasicTranslator defines some base functions for all translators. |
| [`CurrencyFormatter`](/api/translation/currency-formatter/) | The currency formatter will format numbers according to a given format and a given currency symbol |
| [`DateFormatter`](/api/translation/date-formatter/) | The date formatter will dates numbers according to a given format |
| [`GettextTranslator`](/api/translation/gettext-translator/) | GettextTranslator defines the translator interface for gettext. |
| [`QuioteLocale`](/api/translation/quiote-locale/) | Represents a single locale: its identifier plus the language/territory/ script/variant and the calendar/currency/timezone options carried in the identifier's '@key=value' suffix. |
| [`QuioteNumberFormatter`](/api/translation/quiote-number-formatter/) | The number formatter will format numbers according to a given format |
| [`SimpleTranslator`](/api/translation/simple-translator/) | SimpleTranslator defines the translator which loads the data from its parameters. |
| [`TranslationDefinitions`](/api/translation/translation-definitions/) | What the compiled `translation` configuration declares, as data. |
| [`TranslationManager`](/api/translation/translation-manager/) | The translation manager manages the interface between the application and the current translation engine implementation |

## Interfaces

| Interface | Description |
|---|---|
| [`ITranslator`](/api/translation/i-translator/) | ITranslator defines the interface for different translator implementations (like gettext, XLIFF, ...) |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Gettext`](/api/translation/gettext/) | 1 type |
