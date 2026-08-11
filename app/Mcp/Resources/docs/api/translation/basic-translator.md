# BasicTranslator

> BasicTranslator defines some base functions for all translators.

BasicTranslator defines some base functions for all translators.

## Synopsis

`abstract class BasicTranslator implements ITranslator, ResetInterface`

|  |  |
|---|---|
| Implements | [`ITranslator`](/api/translation/i-translator/), `ResetInterface` |
| Since | `1.0.0` |
| Source | `Translation/BasicTranslator.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$context` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`getContext(): ?Context`](#getcontext) | Retrieve the current application context. |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this Translator. |
| [`localeChanged(QuioteLocale $newLocale): mixed`](#localechanged) | This method gets called by the translation manager when the default locale has been changed. |
| [`reset(): void`](#reset) | Reset per-request state for worker compatibility. |

### getContext()

`final public function getContext(): ?Context`

Retrieve the current application context.

Returns `?`[`Context`](/api/context/) — The current Context instance.

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

Reset per-request state for worker compatibility.

Context is set once at initialize() time and nothing re-initializes a translator between requests, so it is deliberately left alone here; subclasses override this to clear whatever locale-derived state they hold.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `translate()` | [`ITranslator`](/api/translation/i-translator/) | Translates a message into the defined language. |
