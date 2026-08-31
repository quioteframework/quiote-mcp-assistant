# Rule

> A declarative description of one canonical-array shape, structural only (allowed keys, enums-of-kind, nesting) -- not required-ness that depends on runtime state or document processing order, which stays a Layer-2 semantic check in the handler's own executeArray()/toCanonicalArray().

A declarative description of one canonical-array shape, structural only (allowed keys, enums-of-kind, nesting) -- not required-ness that depends on runtime state or document processing order, which stays a Layer-2 semantic check in the handler's own executeArray()/toCanonicalArray().

$closed on a Struct means an unrecognized key is a diagnostic rather than silently ignored, matching the XSDs' closed-content-model default.

## Synopsis

`final readonly class Rule`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Schema/Rule.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$closed` | `bool` | _readonly._ |
| `$enumValues` | `array` | _readonly._ |
| `$items` | `?`[`Rule`](/api/config/schema/rule/) | _readonly._ |
| `$keys` | `array` | _readonly._ |
| `$nullable` | `bool` | _readonly._ |
| `$required` | `array` | _readonly._ |
| `$type` | [`SchemaType`](/api/config/schema/schema-type/) | _readonly._ |
| `$variants` | `array` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`bool(bool $nullable = false): Rule`](#bool) | Builds a rule for a real PHP bool, or null when $nullable is set. |
| [`dictOf(Rule $value, bool $nullable = false): Rule`](#dictof) | Builds a rule for a map with dynamic string keys whose every value must match $value. |
| [`enumOf(list<string> $values, bool $nullable = false): Rule`](#enumof) |  |
| [`int(bool $nullable = false): Rule`](#int) | Builds a rule for a real PHP int, or null when $nullable is set. |
| [`listOf(Rule $item, bool $nullable = false): Rule`](#listof) | Builds a rule for a sequential list whose every element must match $item. |
| [`mixed(): Rule`](#mixed) | Builds a rule that accepts any value, including null. |
| [`oneOf(Rule ...$variants): Rule`](#oneof) | Builds a rule for a value that may take any one of $variants' shapes. |
| [`phpClass(bool $nullable = false): Rule`](#phpclass) | Builds a rule for a non-empty string that is shaped like a PHP class name. |
| [`string(bool $nullable = false): Rule`](#string) | Builds a rule for a PHP string value, or null when $nullable is set. |
| [`struct(array<string, Rule> $keys, list<string> $required = [], bool $closed = true, bool $nullable = false): Rule`](#struct) |  |

### bool()

`public static function bool(bool $nullable = false): Rule`

Builds a rule for a real PHP bool, or null when $nullable is set.

Strings such as "true" and "on" do not pass; the canonical array is expected to have had such literals coerced by the config handler before it reaches schema validation.

| Parameter | Type | Description |
|---|---|---|
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### dictOf()

`public static function dictOf(Rule $value, bool $nullable = false): Rule`

Builds a rule for a map with dynamic string keys whose every value must match $value.

Use this where the key set is data rather than schema -- a connection-name-keyed map of database entries, say -- and [`Rule::struct()`](/api/config/schema/rule/#struct) where the keys are known up front. Non-string keys are reported; the keys themselves are otherwise unconstrained. Pass $nullable to also accept null in this position.

| Parameter | Type | Description |
|---|---|---|
| `$value` | [`Rule`](/api/config/schema/rule/) |  |
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### enumOf()

`public static function enumOf(list<string> $values, bool $nullable = false): Rule`

| Parameter | Type | Description |
|---|---|---|
| `$values` | `list``<``string``>` |  |
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### int()

`public static function int(bool $nullable = false): Rule`

Builds a rule for a real PHP int, or null when $nullable is set.

Numeric strings and floats do not pass, so a value read straight from XML must have been cast by the config handler first.

| Parameter | Type | Description |
|---|---|---|
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### listOf()

`public static function listOf(Rule $item, bool $nullable = false): Rule`

Builds a rule for a sequential list whose every element must match $item.

The value has to be a real list -- an array with contiguous integer keys from zero -- so a string-keyed map in this position is reported rather than accepted. Pass $nullable to also accept null.

| Parameter | Type | Description |
|---|---|---|
| `$item` | [`Rule`](/api/config/schema/rule/) |  |
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### mixed()

`public static function mixed(): Rule`

Builds a rule that accepts any value, including null.

Nothing below this point is inspected, so it is how an open-ended region of the canonical array -- a free-form parameter bag, for instance -- is marked as deliberately unconstrained rather than left out of the schema. There is no $nullable argument because such a rule is always nullable.

Returns [`Rule`](/api/config/schema/rule/)

### oneOf()

`public static function oneOf(Rule ...$variants): Rule`

Builds a rule for a value that may take any one of $variants' shapes.

For a position that is genuinely alternative-shaped -- a bool that a `%env(...)%` placeholder string stands in for until the compiled artifact is loaded, say -- rather than one whose shape is unknown, which is what [`Rule::mixed()`](/api/config/schema/rule/#mixed) is for. A value matching no variant is reported once, against this position: the variants' own diagnostics would each describe a shape the value was never meant to have.

| Parameter | Type | Description |
|---|---|---|
| `$variants` | [`Rule`](/api/config/schema/rule/) |  |

Returns [`Rule`](/api/config/schema/rule/)

### phpClass()

`public static function phpClass(bool $nullable = false): Rule`

Builds a rule for a non-empty string that is shaped like a PHP class name.

Only the syntax is checked -- optional leading backslash, backslash-separated identifier segments -- because schema validation is pure and does not autoload. Whether the class exists is left to whoever instantiates it. Pass $nullable to also accept null.

| Parameter | Type | Description |
|---|---|---|
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### string()

`public static function string(bool $nullable = false): Rule`

Builds a rule for a PHP string value, or null when $nullable is set.

The check is on the PHP type only: numeric strings and the empty string both pass. Use [`Rule::enumOf()`](/api/config/schema/rule/#enumof) to restrict the value set and [`Rule::phpClass()`](/api/config/schema/rule/#phpclass) for class-name strings.

| Parameter | Type | Description |
|---|---|---|
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)

### struct()

`public static function struct(array<string, Rule> $keys, list<string> $required = [], bool $closed = true, bool $nullable = false): Rule`

| Parameter | Type | Description |
|---|---|---|
| `$keys` | `array``<``string``, `[`Rule`](/api/config/schema/rule/)`>` |  |
| `$required` | `list``<``string``>` |  |
| `$closed` | `bool` |  |
| `$nullable` | `bool` |  |

Returns [`Rule`](/api/config/schema/rule/)
