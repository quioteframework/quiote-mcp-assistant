# ValidatorFactory

> Builds a validator from its class name.

Builds a validator from its class name.

The single construction point for validators named at runtime -- from `validators.xml`, from the fluent builder's `raw()`/`group()`, and from [`ValidationManager::createValidator()`](/api/validator/validation-manager/#createvalidator). It exists so those paths cannot drift apart, and so there is one place that decides *how* a validator comes into being.

Construction goes through the container's [`Container::make()`](/api/di/container/#make), which means a validator may declare constructor dependencies like any other collaborator:

```php final class VatNumberValidator extends Validator { public function __construct(private readonly VatLookupService $lookup) {} } ```

That is additive. A validator with no constructor -- which is every validator the framework ships and every one written before this existed -- is `new`'d directly by `make()`, so nothing about the existing path changes.

`make()` is deliberately the entry point rather than `get()`: a validator is a per-validation object, never a shared service, and `make()` results are not container-cached. That is also what lets a validator depend on the request or the user, which a cached service could not.

Note that the configuration a validator is given -- parameters, argument names, error messages -- still arrives through [`Validator::initialize()`](/api/validator/validator/#initialize). Those are per-declaration *data* read out of a config file, not collaborators, so there is nothing for the container to resolve them from.

## Synopsis

`final class ValidatorFactory`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Validator/ValidatorFactory.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`create(class-string<T> $class): T&Validator`](#create) | Build the validator named by $class, resolving any constructor dependencies it declares. |

### create()

`public function create(class-string<T> $class): T&Validator`

Build the validator named by $class, resolving any constructor dependencies it declares.

| Parameter | Type | Description |
|---|---|---|
| `$class` | `class-string``<``T``>` |  |

Returns `T``&`[`Validator`](/api/validator/validator/)

| Throws | When |
|---|---|
| `ConfigurationException` | When $class is not a [`Validator`](/api/validator/validator/). Reported here rather than left to fail on the initialize() call above it, which would name the missing method instead of the actual mistake in the configuration. |
