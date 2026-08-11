# ValidatorDeclarationApplier

> Builds the validators a compiled validator config declares and attaches them to a validation manager.

Builds the validators a compiled validator config declares and attaches them to a validation manager.

This is the code that used to be the compiled artifact itself: `new X(); ->initialize(...); ->addChild(...)`, emitted as text and executed in the caller's scope. It is here instead, so the artifact is data -- a poisoned config cache entry can then only describe wrong validators, not run code -- and so registration can be tested directly rather than by executing a generated string.

## Synopsis

`final class ValidatorDeclarationApplier`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Validator/Compiler/Runtime/ValidatorDeclarationApplier.php` |

## Methods

| Method | Description |
|---|---|
| [`apply(mixed $declaration, ValidationManager $validationManager, string $method, Context $context, string $sourceRef): void`](#apply) | Register the declared validators for one request method. |

### apply()

`public static function apply(mixed $declaration, ValidationManager $validationManager, string $method, Context $context, string $sourceRef): void`

Register the declared validators for one request method.

The validator config file, for diagnostics.

| Parameter | Type | Description |
|---|---|---|
| `$declaration` | `mixed` | The value the compiled validator config returned. |
| `$validationManager` | [`ValidationManager`](/api/validator/validation-manager/) | The manager to register against. |
| `$method` | `string` | The request method token the declaration is matched against (lowercase, as the compiler wrote it). |
| `$context` | [`Context`](/api/context/) | The context validators are initialized with. |
| `$sourceRef` | `string` | The validator config file, for diagnostics. |

| Throws | When |
|---|---|
| `ConfigurationException` | If the declaration is not the shape the compiler produces. |
