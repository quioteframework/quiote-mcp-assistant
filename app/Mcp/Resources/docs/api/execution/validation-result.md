# ValidationResult

> Lightweight immutable validation result for container-less execution paths.

Lightweight immutable validation result for container-less execution paths.

## Synopsis

`class ValidationResult`

|  |  |
|---|---|
| Source | `Execution/ValidationResult.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$data` | `array` | _readonly._ |
| `$ok` | `bool` | _readonly._ |

## Constructor

### __construct()

`public function __construct(bool $ok, array<string, mixed> $data = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$ok` | `bool` |  |
| `$data` | `array``<``string``, ``mixed``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`failure(array<string, mixed> $data = []): ValidationResult`](#failure) |  |
| [`getErrors(): array<int|string, mixed>`](#geterrors) |  |
| [`getTrace(): ?ValidationTrace`](#gettrace) | Returns the validation trace carried in the result data, or null when none was recorded. |
| [`success(array<string, mixed> $data = []): ValidationResult`](#success) |  |

### failure()

`public static function failure(array<string, mixed> $data = []): ValidationResult`

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>` |  |

Returns [`ValidationResult`](/api/execution/validation-result/)

### getErrors()

`public function getErrors(): array<int|string, mixed>`

Returns `array``<``int``|``string``, ``mixed``>`

### getTrace()

`public function getTrace(): ?ValidationTrace`

Returns the validation trace carried in the result data, or null when none was recorded.

Tracing is optional, so an absent entry is the normal case rather than an error.

Returns `?`[`ValidationTrace`](/api/execution/validation-trace/)

| Throws | When |
|---|---|
| `UnexpectedValueException` | If the data holds a "trace" entry that is not a ValidationTrace. |

### success()

`public static function success(array<string, mixed> $data = []): ValidationResult`

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>` |  |

Returns [`ValidationResult`](/api/execution/validation-result/)
