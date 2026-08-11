# ValidatorSpec

> A fluent handle onto a single, already-registered Validator instance.

A fluent handle onto a single, already-registered Validator instance.

Every setter here is a thin wrapper over Validator::setParameter() -- safe to call any time before ValidationManager::execute() actually validates, since parameters are read lazily by validate(). There is no separate "build"/"commit" step: ValidatorBuilder addChild()s the validator immediately when a spec is created, so a caller who never chains anything still gets a correctly registered (if minimally configured) validator.

## Synopsis

`final class ValidatorSpec`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/Runtime/ValidatorSpec.php` |

## Constructor

### __construct()

`public function __construct(Validator $validator): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$validator` | [`Validator`](/api/validator/validator/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`breakOnFirst(bool $break = true): ValidatorSpec`](#breakonfirst) | Sets the `break` parameter, deciding whether the operator stops running children once one has settled the outcome. |
| [`caseSensitive(bool $caseSensitive = true): ValidatorSpec`](#casesensitive) | Sets the `case` parameter, deciding whether the allowlist comparison respects letter case. |
| [`castTo(string $type): ValidatorSpec`](#castto) | Sets the `cast_to` parameter, the type the accepted value is converted to before it is exported. |
| [`error(string $message, ?string $for = null): ValidatorSpec`](#error) | Sets an error message on the validator. |
| [`export(string $to): ValidatorSpec`](#export) | Sets the `export` parameter, naming the request-data key the validated value is written back to. |
| [`max(int|float $max): ValidatorSpec`](#max) | Sets the `max` parameter, the largest accepted numeric value. |
| [`maxLength(int $max): ValidatorSpec`](#maxlength) | Sets the `max` parameter, the longest accepted string length. |
| [`min(int|float $min): ValidatorSpec`](#min) | Sets the `min` parameter, the smallest accepted numeric value. |
| [`minLength(int $min): ValidatorSpec`](#minlength) | Sets the `min` parameter, the shortest accepted string length. |
| [`required(bool $required = true): ValidatorSpec`](#required) | Sets the `required` parameter, deciding whether a missing argument is itself an error. |
| [`severity(string $severity): ValidatorSpec`](#severity) | Sets the `severity` parameter, which decides how far a failure of this validator escalates the request's overall validation result. |
| [`shouldMatch(bool $shouldMatch = true): ValidatorSpec`](#shouldmatch) | Sets the `match` parameter; false inverts the regex test, so the value passes only when the pattern does *not* match. |
| [`skipErrors(bool $skip = true): ValidatorSpec`](#skiperrors) | Sets the `skip_errors` parameter, deciding whether the errors reported by child validators are discarded in favour of the operator's own message. |
| [`strict(bool $strict = true): ValidatorSpec`](#strict) | Sets the `strict` parameter, deciding whether the allowlist comparison also requires a matching type. |
| [`translationDomain(string $domain): ValidatorSpec`](#translationdomain) | Sets the `translation_domain` parameter used when this validator's error messages are translated. |
| [`trim(bool $trim = true): ValidatorSpec`](#trim) | Sets the `trim` parameter, deciding whether surrounding whitespace is stripped before the value is checked. |
| [`type(string $type): ValidatorSpec`](#type) | Sets the `type` parameter, the numeric type the value must conform to. |
| [`utf8(bool $utf8 = true): ValidatorSpec`](#utf8) | Sets the `utf8` parameter, deciding whether lengths are counted in UTF-8 characters rather than bytes. |
| [`validator(): Validator`](#validator) | Returns the live Validator instance, for anything the setters below do not cover. |

### breakOnFirst()

`public function breakOnFirst(bool $break = true): ValidatorSpec`

Sets the `break` parameter, deciding whether the operator stops running children once one has settled the outcome.

| Parameter | Type | Description |
|---|---|---|
| `$break` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### caseSensitive()

`public function caseSensitive(bool $caseSensitive = true): ValidatorSpec`

Sets the `case` parameter, deciding whether the allowlist comparison respects letter case.

| Parameter | Type | Description |
|---|---|---|
| `$caseSensitive` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### castTo()

`public function castTo(string $type): ValidatorSpec`

Sets the `cast_to` parameter, the type the accepted value is converted to before it is exported.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `string` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### error()

`public function error(string $message, ?string $for = null): ValidatorSpec`

Sets an error message on the validator.

`$for` names the specific failure the message belongs to; omitting it (or passing null) registers the message under the empty key, which is the validator's default message for any failure without its own text.

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` |  |
| `$for` | `?``string` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### export()

`public function export(string $to): ValidatorSpec`

Sets the `export` parameter, naming the request-data key the validated value is written back to.

| Parameter | Type | Description |
|---|---|---|
| `$to` | `string` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### max()

`public function max(int|float $max): ValidatorSpec`

Sets the `max` parameter, the largest accepted numeric value.

| Parameter | Type | Description |
|---|---|---|
| `$max` | `int``|``float` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### maxLength()

`public function maxLength(int $max): ValidatorSpec`

Sets the `max` parameter, the longest accepted string length.

| Parameter | Type | Description |
|---|---|---|
| `$max` | `int` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### min()

`public function min(int|float $min): ValidatorSpec`

Sets the `min` parameter, the smallest accepted numeric value.

| Parameter | Type | Description |
|---|---|---|
| `$min` | `int``|``float` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### minLength()

`public function minLength(int $min): ValidatorSpec`

Sets the `min` parameter, the shortest accepted string length.

| Parameter | Type | Description |
|---|---|---|
| `$min` | `int` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### required()

`public function required(bool $required = true): ValidatorSpec`

Sets the `required` parameter, deciding whether a missing argument is itself an error.

| Parameter | Type | Description |
|---|---|---|
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### severity()

`public function severity(string $severity): ValidatorSpec`

Sets the `severity` parameter, which decides how far a failure of this validator escalates the request's overall validation result.

| Parameter | Type | Description |
|---|---|---|
| `$severity` | `string` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### shouldMatch()

`public function shouldMatch(bool $shouldMatch = true): ValidatorSpec`

Sets the `match` parameter; false inverts the regex test, so the value passes only when the pattern does *not* match.

| Parameter | Type | Description |
|---|---|---|
| `$shouldMatch` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### skipErrors()

`public function skipErrors(bool $skip = true): ValidatorSpec`

Sets the `skip_errors` parameter, deciding whether the errors reported by child validators are discarded in favour of the operator's own message.

| Parameter | Type | Description |
|---|---|---|
| `$skip` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### strict()

`public function strict(bool $strict = true): ValidatorSpec`

Sets the `strict` parameter, deciding whether the allowlist comparison also requires a matching type.

| Parameter | Type | Description |
|---|---|---|
| `$strict` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### translationDomain()

`public function translationDomain(string $domain): ValidatorSpec`

Sets the `translation_domain` parameter used when this validator's error messages are translated.

| Parameter | Type | Description |
|---|---|---|
| `$domain` | `string` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### trim()

`public function trim(bool $trim = true): ValidatorSpec`

Sets the `trim` parameter, deciding whether surrounding whitespace is stripped before the value is checked.

| Parameter | Type | Description |
|---|---|---|
| `$trim` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### type()

`public function type(string $type): ValidatorSpec`

Sets the `type` parameter, the numeric type the value must conform to.

| Parameter | Type | Description |
|---|---|---|
| `$type` | `string` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### utf8()

`public function utf8(bool $utf8 = true): ValidatorSpec`

Sets the `utf8` parameter, deciding whether lengths are counted in UTF-8 characters rather than bytes.

| Parameter | Type | Description |
|---|---|---|
| `$utf8` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### validator()

`public function validator(): Validator`

Returns the live Validator instance, for anything the setters below do not cover.

Returns [`Validator`](/api/validator/validator/)
