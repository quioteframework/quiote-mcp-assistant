# ValidatorBuilder

> Fluent facade for registering validators directly in PHP, without an intervening XML file.

Fluent facade for registering validators directly in PHP, without an intervening XML file.

This is the runtime counterpart to FluentSourceEmitter's generated code: both target the exact same addChild() call the XML path has always used (ValidatorConfigHandler/ValidatorDeclarationApplier), so a validator registered this way gets the same strict-mode whitelist/pruning guarantee as one declared in validators.xml -- see Action::registerValidators() and CompiledValidatorRegistry.

A misspelled call here (e.g. ->onArray() instead of ->oneOf()) is a fatal "call to undefined method" at registration time, not a silently ignored parameter -- which is the whole point: this is the fix for the incident where `values="a,b,c"` was silently absorbed by a validator that never read it.

## Synopsis

`final class ValidatorBuilder`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/Runtime/ValidatorBuilder.php` |

## Constructor

### __construct()

`public function __construct(IValidatorContainer $container, Context $context, ?string $method = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`IValidatorContainer`](/api/validator/i-validator-container/) |  |
| `$context` | [`Context`](/api/context/) |  |
| `$method` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`boolean(string $argument, bool $required = true): ValidatorSpec`](#boolean) | Registers a BooleanValidator on `$argument`, accepting any literal BooleanValidator recognises, and returns its spec. |
| [`email(string $argument, bool $required = true): ValidatorSpec`](#email) | Registers an EmailValidator on `$argument` and returns its spec. |
| [`enum(string $argument, array<mixed> $values, bool $required = true): ValidatorSpec`](#enum) |  |
| [`getContext(): Context`](#getcontext) | Returns the context this builder initializes every validator it creates against. |
| [`group(string $operator, callable $configure): ValidatorSpec`](#group) | Registers an and/or/not/xor container and yields a nested builder scoped to it, so children addChild() onto the container instead of the outer validation manager. |
| [`isNotEmpty(string $argument, bool $required = true): ValidatorSpec`](#isnotempty) | Registers an IsNotEmptyValidator on `$argument` and returns its spec. |
| [`isSet(string $argument, bool $required = true): ValidatorSpec`](#isset) | Registers an IssetValidator on `$argument` and returns its spec. |
| [`json(string $argument, bool $required = true): ValidatorSpec`](#json) | Registers a JsonValidator on `$argument` and returns its spec. |
| [`method(): ?string`](#method) | The resolved action method token this builder was constructed for ('read'/'write'/... |
| [`number(string $argument, bool $required = true): ValidatorSpec`](#number) | Registers a NumberValidator on `$argument` and returns its spec. |
| [`on(IValidatorContainer $container, Context $context, ?string $method = null): ValidatorBuilder`](#on) |  |
| [`raw(class-string<Validator> $class, array<int|string, mixed> $arguments, array<string, mixed> $parameters = [], array<string, string> $errors = [], callable(self): void|null $children = null): ValidatorSpec`](#raw) | The general form, for any validator class without a dedicated fluent method above (custom app validators, or framework validators this builder hasn't grown a helper for yet -- see FluentSourceEmitter's UNMAPPABLE_PARAMETER passthrough). |
| [`regex(string $argument, string $pattern, bool $shouldMatch = true, bool $required = true): ValidatorSpec`](#regex) | Registers a RegexValidator on `$argument` and returns its spec. |
| [`string(string $argument, bool $required = true): ValidatorSpec`](#string) | Registers a StringValidator on `$argument` and returns its spec. |

### boolean()

`public function boolean(string $argument, bool $required = true): ValidatorSpec`

Registers a BooleanValidator on `$argument`, accepting any literal BooleanValidator recognises, and returns its spec.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### email()

`public function email(string $argument, bool $required = true): ValidatorSpec`

Registers an EmailValidator on `$argument` and returns its spec.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### enum()

`public function enum(string $argument, array<mixed> $values, bool $required = true): ValidatorSpec`

The allowlist. This is what the incident's
                       `values="a,b,c"` attribute was meant to be --
                       here it's a required, typed argument instead
                       of an attribute a validator might silently
                       ignore.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$values` | `array``<``mixed``>` | The allowlist. This is what the incident's `values="a,b,c"` attribute was meant to be -- here it's a required, typed argument instead of an attribute a validator might silently ignore. |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### getContext()

`public function getContext(): Context`

Returns the context this builder initializes every validator it creates against.

Returns [`Context`](/api/context/)

### group()

`public function group(string $operator, callable $configure): ValidatorSpec`

Registers an and/or/not/xor container and yields a nested builder scoped to it, so children addChild() onto the container instead of the outer validation manager.

One of 'and', 'or', 'not', 'xor' — not enforced by
               the native `string` param type, so callers can pass an
               invalid value at runtime, which is what the check below
               catches.

| Parameter | Type | Description |
|---|---|---|
| `$operator` | `string` | One of 'and', 'or', 'not', 'xor' — not enforced by the native `string` param type, so callers can pass an invalid value at runtime, which is what the check below catches. |
| `$configure` | `callable` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### isNotEmpty()

`public function isNotEmpty(string $argument, bool $required = true): ValidatorSpec`

Registers an IsNotEmptyValidator on `$argument` and returns its spec.

The value's content is not inspected at all; what counts as empty is decided by the request data holder.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### isSet()

`public function isSet(string $argument, bool $required = true): ValidatorSpec`

Registers an IssetValidator on `$argument` and returns its spec.

Only presence is checked, so an argument that is set but empty still passes; the content is never looked at.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### json()

`public function json(string $argument, bool $required = true): ValidatorSpec`

Registers a JsonValidator on `$argument` and returns its spec.

The decoded value is only written back if an `export` target is set on the returned spec; otherwise the argument keeps its raw JSON string.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### method()

`public function method(): ?string`

The resolved action method token this builder was constructed for ('read'/'write'/...

or null), mirroring the `$method` variable available in compiled XML validator code, so hand-written registrars can branch the same way: `if ($v->method() === 'write') { ... }`.

Returns `?``string`

### number()

`public function number(string $argument, bool $required = true): ValidatorSpec`

Registers a NumberValidator on `$argument` and returns its spec.

No bounds or numeric type are set here; chain `min()`, `max()`, `type()` or `castTo()` on the returned spec for those.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### on()

`public static function on(IValidatorContainer $container, Context $context, ?string $method = null): ValidatorBuilder`

The resolved action method token
                           ('read'/'write'/...), i.e. the same value
                           ValidationService passes as its own
                           $method argument -- NOT the raw HTTP verb.
                           Callers (CompiledValidatorRegistry) already
                           have this from the validation call they're
                           servicing.

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`IValidatorContainer`](/api/validator/i-validator-container/) |  |
| `$context` | [`Context`](/api/context/) |  |
| `$method` | `?``string` | The resolved action method token ('read'/'write'/...), i.e. the same value ValidationService passes as its own $method argument -- NOT the raw HTTP verb. Callers (CompiledValidatorRegistry) already have this from the validation call they're servicing. |

Returns [`ValidatorBuilder`](/api/validator/compiler/runtime/validator-builder/)

### raw()

`public function raw(class-string<Validator> $class, array<int|string, mixed> $arguments, array<string, mixed> $parameters = [], array<string, string> $errors = [], callable(self): void|null $children = null): ValidatorSpec`

The general form, for any validator class without a dedicated fluent method above (custom app validators, or framework validators this builder hasn't grown a helper for yet -- see FluentSourceEmitter's UNMAPPABLE_PARAMETER passthrough).

If given, and the
       created validator implements IValidatorContainer, invoked
       with a nested builder scoped to it -- for operator-like
       validators (including ones with parameters/base paths that
       don't fit group()'s generic assumptions) that still need
       children attached.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `class-string``<`[`Validator`](/api/validator/validator/)`>` |  |
| `$arguments` | `array``<``int``|``string``, ``mixed``>` |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$errors` | `array``<``string``, ``string``>` |  |
| `$children` | `callable(self): void``|``null` | If given, and the created validator implements IValidatorContainer, invoked with a nested builder scoped to it -- for operator-like validators (including ones with parameters/base paths that don't fit group()'s generic assumptions) that still need children attached. |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### regex()

`public function regex(string $argument, string $pattern, bool $shouldMatch = true, bool $required = true): ValidatorSpec`

Registers a RegexValidator on `$argument` and returns its spec.

`$pattern` is a full PCRE pattern including delimiters. Passing false for `$shouldMatch` inverts the test, so the value passes only when the pattern does not match.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$pattern` | `string` |  |
| `$shouldMatch` | `bool` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)

### string()

`public function string(string $argument, bool $required = true): ValidatorSpec`

Registers a StringValidator on `$argument` and returns its spec.

Length, trimming and UTF-8 handling are left at the validator's own defaults; chain the corresponding ValidatorSpec setters to change them.

| Parameter | Type | Description |
|---|---|---|
| `$argument` | `string` |  |
| `$required` | `bool` |  |

Returns [`ValidatorSpec`](/api/validator/compiler/runtime/validator-spec/)
