# Inflector

> Inflector allows you to singularize or pluralize an English word

Inflector allows you to singularize or pluralize an English word

## Synopsis

`final class Inflector`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Util/Inflector.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `UNCOUNTABLE_REGEX` | `'/(\n			advice|\n			equipment|\n			information|\n			(?<![a-z0-…'` |  |

## Methods

| Method | Description |
|---|---|
| [`pluralize(string $word): string`](#pluralize) | Translates a noun from its singular form in its plural form |
| [`singularize(string $word): string`](#singularize) | Translates a noun from its plural form in its singular form |

### pluralize()

`public static function pluralize(string $word): string`

Translates a noun from its singular form in its plural form

Word to pluralize

| Parameter | Type | Description |
|---|---|---|
| `$word` | `string` | Word to pluralize |

Returns `string` — The plural form of the word

### singularize()

`public static function singularize(string $word): string`

Translates a noun from its plural form in its singular form

Word to singularize

| Parameter | Type | Description |
|---|---|---|
| `$word` | `string` | Word to singularize |

Returns `string` — The singular form of the word
