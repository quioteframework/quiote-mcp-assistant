# ValidatorNode

> Format-independent description of a single <validator> declaration: the resolved class, its parameters/arguments, the request methods it applies to, and any nested validators (and/or/not/xor children).

Format-independent description of a single <validator> declaration: the resolved class, its parameters/arguments, the request methods it applies to, and any nested validators (and/or/not/xor children).

This is the intermediate representation shared by every front-end (currently only the XML parser) and every back-end (the runtime cache emitter, the fluent-source emitter). Its shape is a snapshot of what ValidatorConfigHandler used to compute and immediately discard while emitting PHP text directly from the DOM walk.

## Synopsis

`final class ValidatorNode`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/Ir/ValidatorNode.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$arguments` | `array` | _readonly._ |
| `$base` | `string` | _readonly._ |
| `$children` | `array` | _readonly._ |
| `$declaredNames` | `array` | _readonly._ |
| `$errors` | `array` | _readonly._ |
| `$methods` | `array` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$parameters` | `array` | _readonly._ |
| `$validatorClass` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, string $validatorClass, array<int|string, mixed> $arguments, string $base, array<string, mixed> $parameters, array<int|string, mixed> $errors, array<string> $methods, array<string> $declaredNames, array<ValidatorNode> $children = []): mixed`

Nested validators (and/or/not/xor containers).

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` | The validator's name (explicit or generated). |
| `$validatorClass` | `string` | The resolved, fully-qualified validator class. |
| `$arguments` | `array``<``int``|``string``, ``mixed``>` | Request parameter names/sub-paths this validator reads. |
| `$base` | `string` | The base path from <arguments base="...">, or ''. |
| `$parameters` | `array``<``string``, ``mixed``>` | The fully resolved, already-checked parameter bag. |
| `$errors` | `array``<``int``|``string``, ``mixed``>` | Error message overrides, keyed by error index (or ''). |
| `$methods` | `array``<``string``>` | The HTTP methods this validator applies to (or [''] for all). |
| `$declaredNames` | `array``<``string``>` | Request parameter names this validator whitelists. |
| `$children` | `array``<`[`ValidatorNode`](/api/validator/compiler/ir/validator-node/)`>` | Nested validators (and/or/not/xor containers). |

Returns `mixed`
