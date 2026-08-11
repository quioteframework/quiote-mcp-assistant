# TranslationDefinitions

> What the compiled `translation` configuration declares, as data.

What the compiled `translation` configuration declares, as data.

The compiled form used to be statements `include`d inside [`TranslationManager::initialize()`](/api/translation/translation-manager/#initialize), assigning into its properties and calling `$this->getContext()` on it. It is a declaration now, for the same reasons the compiled factories, databases and output_types configurations are -- see [`FactoryDefinitions`](/api/config/factory/factory-definitions/).

The parsed locale identifiers are precomputed at compile time and carried here, which is why `identifierData` is part of the declared shape rather than something the manager derives.

## Synopsis

`final readonly class TranslationDefinitions`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Translation/TranslationDefinitions.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$defaultDomain` | `string` | _readonly._ |
| `$defaultLocale` | `?``string` | _readonly._ |
| `$defaultTimeZone` | `?``string` | _readonly._ |
| `$locales` | `array` | _readonly._ |
| `$translators` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $defaultDomain, ?string $defaultLocale, ?string $defaultTimeZone, array<string, array{identifier: string, identifierData: array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}, parameters: array<string, mixed>}> $locales, array<string, array<string, array{class: class-string<ITranslator>, parameters: array<string, mixed>, filters: array<int, callable>}>> $translators): mixed`

Keyed by domain, then by type ('msg', 'num', 'cur', 'date').

| Parameter | Type | Description |
|---|---|---|
| `$defaultDomain` | `string` | The domain used when a caller names none. |
| `$defaultLocale` | `?``string` | The locale identifier to start in. Null is legal here and rejected later by the manager, which has a better message for it than this class could: translation is configured but unusable without one. |
| `$defaultTimeZone` | `?``string` | Null means "fall back to PHP's default". |
| `$locales` | `array``<``string``, ``array{identifier: string, identifierData: array{language: ?string, script: ?string, territory: ?string, variant: ?string, options: array<string, string>, locale_str: ?string, option_str: ?string}, parameters: array<string, mixed>}``>` | Keyed by locale identifier, in declaration order. The parsed identifier is precomputed at compile time by [`QuioteLocale::parseLocaleIdentifier()`](/api/translation/quiote-locale/#parselocaleidentifier). |
| `$translators` | `array``<``string``, ``array``<``string``, ``array{class: class-string<ITranslator>, parameters: array<string, mixed>, filters: array<int, callable>}``>``>` | Keyed by domain, then by type ('msg', 'num', 'cur', 'date'). |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromCompiled(mixed $compiled, string $source = 'the compiled translation cache'): TranslationDefinitions`](#fromcompiled) | Read a compiled declaration, rejecting anything malformed. |

### fromCompiled()

`public static function fromCompiled(mixed $compiled, string $source = 'the compiled translation cache'): TranslationDefinitions`

Read a compiled declaration, rejecting anything malformed.

Whatever the compiled file returned.

| Parameter | Type | Description |
|---|---|---|
| `$compiled` | `mixed` | Whatever the compiled file returned. |
| `$source` | `string` |  |

Returns [`TranslationDefinitions`](/api/translation/translation-definitions/)

| Throws | When |
|---|---|
| `ConfigurationException` | When $compiled is not a declaration this version understands -- most likely a cache compiled by an earlier one. |
