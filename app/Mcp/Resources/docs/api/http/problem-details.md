# ProblemDetails

> An RFC 9457 (Problem Details for HTTP APIs; obsoletes RFC 7807) document.

An RFC 9457 (Problem Details for HTTP APIs; obsoletes RFC 7807) document.

Reusable, response-agnostic value object: build one, then render it with toArray()/toJson() and serve it as `application/problem+json` (see self::MEDIA_TYPE). [`ProblemDetails::fromValidationManager()`](/api/http/problem-details/#fromvalidationmanager) constructs the common "validation failed" shape, extracting a `field => messages` map from a validation report into the `errors` extension member.

## Synopsis

`final readonly class ProblemDetails`

|  |  |
|---|---|
| Source | `Http/ProblemDetails.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `MEDIA_TYPE` | `'application/problem+json'` |  |

## Methods

| Method | Description |
|---|---|
| [`create(int $status = 400, ?string $title = null, ?string $type = null, ?string $detail = null, ?string $instance = null, array<string, array<string>> $errors = [], array<string, mixed> $extensions = []): ProblemDetails`](#create) | Create a Problem Details document. |
| [`extractErrors(?object $validationManager): array<string, array<string>>`](#extracterrors) | Extract a `field => messages` map from a validation manager's report. |
| [`fromValidationManager(?object $validationManager, int $status = 400, ?string $title = null, ?string $type = null, ?string $detail = null, ?string $instance = null, array<string, mixed> $extensions = []): ProblemDetails`](#fromvalidationmanager) | Build a validation Problem Details document from a validation manager, extracting its incidents into the `errors` map. |
| [`getErrors(): array<string, array<string>>`](#geterrors) |  |
| [`getStatus(): int`](#getstatus) | Returns the HTTP status code this problem document describes, which the response should also carry. |
| [`toArray(): array<string, mixed>`](#toarray) |  |
| [`toJson(): string`](#tojson) | Encodes [`ProblemDetails::toArray()`](/api/http/problem-details/#toarray) as the JSON body of an `application/problem+json` response, leaving slashes and unicode unescaped. |

### create()

`public static function create(int $status = 400, ?string $title = null, ?string $type = null, ?string $detail = null, ?string $instance = null, array<string, array<string>> $errors = [], array<string, mixed> $extensions = []): ProblemDetails`

Create a Problem Details document.

| Parameter | Type | Description |
|---|---|---|
| `$status` | `int` |  |
| `$title` | `?``string` |  |
| `$type` | `?``string` |  |
| `$detail` | `?``string` |  |
| `$instance` | `?``string` |  |
| `$errors` | `array``<``string``, ``array``<``string``>``>` |  |
| `$extensions` | `array``<``string``, ``mixed``>` |  |

Returns [`ProblemDetails`](/api/http/problem-details/)

### extractErrors()

`public static function extractErrors(?object $validationManager): array<string, array<string>>`

Extract a `field => messages` map from a validation manager's report.

Non-field (model-level) messages are keyed under "".

| Parameter | Type | Description |
|---|---|---|
| `$validationManager` | `?``object` |  |

Returns `array``<``string``, ``array``<``string``>``>`

### fromValidationManager()

`public static function fromValidationManager(?object $validationManager, int $status = 400, ?string $title = null, ?string $type = null, ?string $detail = null, ?string $instance = null, array<string, mixed> $extensions = []): ProblemDetails`

Build a validation Problem Details document from a validation manager, extracting its incidents into the `errors` map.

| Parameter | Type | Description |
|---|---|---|
| `$validationManager` | `?``object` |  |
| `$status` | `int` |  |
| `$title` | `?``string` |  |
| `$type` | `?``string` |  |
| `$detail` | `?``string` |  |
| `$instance` | `?``string` |  |
| `$extensions` | `array``<``string``, ``mixed``>` |  |

Returns [`ProblemDetails`](/api/http/problem-details/)

### getErrors()

`public function getErrors(): array<string, array<string>>`

Returns `array``<``string``, ``array``<``string``>``>`

### getStatus()

`public function getStatus(): int`

Returns the HTTP status code this problem document describes, which the response should also carry.

Returns `int`

### toArray()

`public function toArray(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### toJson()

`public function toJson(): string`

Encodes [`ProblemDetails::toArray()`](/api/http/problem-details/#toarray) as the JSON body of an `application/problem+json` response, leaving slashes and unicode unescaped.

Returns `string`
