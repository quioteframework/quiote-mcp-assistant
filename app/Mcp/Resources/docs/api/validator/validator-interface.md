# ValidatorInterface

> What a validator container asks of a validator: configure it, run it against a request, and read back what it named, decided and exported.

What a validator container asks of a validator: configure it, run it against a request, and read back what it named, decided and exported.

The [`Validator`](/api/validator/validator/) base class supplies all of it, along with ~40 protected helpers for writing one. This interface is the public contract a container and a test double need, so nothing has to depend on that base class to hold or drive a validator.

## Synopsis

`interface ValidatorInterface`

|  |  |
|---|---|
| Implemented by | [`Validator`](/api/validator/validator/) |
| Since | `3.2.0` |
| Source | `Validator/ValidatorInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`execute(WebRequest $parameters): int`](#execute) | Run this validator against $parameters. |
| [`getArguments(): array<int|string, mixed>`](#getarguments) | The argument names this validator targets. |
| [`getBase(): mixed`](#getbase) | The base path relative argument names resolve against. |
| [`getDependencyManager(): ?DependencyManager`](#getdependencymanager) | The dependency manager coordinating provides/depends between validators. |
| [`getMutatedRequest(): ?WebRequest`](#getmutatedrequest) | The request this validator produced, when it exported values, or null when it changed nothing. |
| [`getName(): ?string`](#getname) | This validator's declared name. |
| [`getParentContainer(): ?IValidatorContainer`](#getparentcontainer) | The container holding this validator. |
| [`initialize(Context $context, array<string, mixed> $parameters = [], array<int|string, mixed> $arguments = [], array<int|string, mixed> $errors = []): mixed`](#initialize) | Configure this validator from its declaration. |
| [`setErrorMessage(string $index, string $message): void`](#seterrormessage) | Override the message reported for one error index. |
| [`setParentContainer(IValidatorContainer $parent): mixed`](#setparentcontainer) | Attach this validator to its container. |
| [`shutdown(): mixed`](#shutdown) | Release anything held for the duration of one validation run. |

### execute()

`abstract public function execute(WebRequest $parameters): int`

Run this validator against $parameters.

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | [`WebRequest`](/api/request/web-request/) |  |

Returns `int` — The validation result code.

### getArguments()

`abstract public function getArguments(): array<int|string, mixed>`

The argument names this validator targets.

Returns `array``<``int``|``string``, ``mixed``>`

### getBase()

`abstract public function getBase(): mixed`

The base path relative argument names resolve against.

Returns `mixed`

### getDependencyManager()

`abstract public function getDependencyManager(): ?DependencyManager`

The dependency manager coordinating provides/depends between validators.

Returns `?`[`DependencyManager`](/api/validator/dependency-manager/)

### getMutatedRequest()

`abstract public function getMutatedRequest(): ?WebRequest`

The request this validator produced, when it exported values, or null when it changed nothing.

Validators run against an immutable request, so an export is a new instance the caller has to pick up.

Returns `?`[`WebRequest`](/api/request/web-request/)

### getName()

`abstract public function getName(): ?string`

This validator's declared name.

Returns `?``string`

### getParentContainer()

`abstract public function getParentContainer(): ?IValidatorContainer`

The container holding this validator.

Returns `?`[`IValidatorContainer`](/api/validator/i-validator-container/)

### initialize()

`abstract public function initialize(Context $context, array<string, mixed> $parameters = [], array<int|string, mixed> $arguments = [], array<int|string, mixed> $errors = []): mixed`

Configure this validator from its declaration.

Error messages by index.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` | Validator parameters. |
| `$arguments` | `array``<``int``|``string``, ``mixed``>` | Argument names this validator targets. |
| `$errors` | `array``<``int``|``string``, ``mixed``>` | Error messages by index. |

Returns `mixed`

### setErrorMessage()

`abstract public function setErrorMessage(string $index, string $message): void`

Override the message reported for one error index.

| Parameter | Type | Description |
|---|---|---|
| `$index` | `string` |  |
| `$message` | `string` |  |

### setParentContainer()

`abstract public function setParentContainer(IValidatorContainer $parent): mixed`

Attach this validator to its container.

| Parameter | Type | Description |
|---|---|---|
| `$parent` | [`IValidatorContainer`](/api/validator/i-validator-container/) |  |

Returns `mixed`

### shutdown()

`abstract public function shutdown(): mixed`

Release anything held for the duration of one validation run.

Returns `mixed`
