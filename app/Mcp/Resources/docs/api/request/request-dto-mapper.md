# RequestDtoMapper

> Constructs a #[MapRequest] DTO instance from an already-validated WebRequest.

Constructs a #[MapRequest] DTO instance from an already-validated WebRequest.

Must only be called after ValidationMiddleware's ValidationManager::execute() has passed -- property names are only readable via WebRequest::getParameter() once whitelisted by their RequestDtoScanner-registered validators (see Quiote\Action\Action::registerValidators()).

Scalar casting/normalization (int/float parsing, boolean literalization) has already happened inside NumberValidator/BooleanValidator during validation, which persist the cast value back into the request's runtime parameters -- this class mostly passes values through, only handling the shapes those validators don't already normalize (JSON-encoded arrays, DateTimeImmutable, backed enums).

## Synopsis

`final class RequestDtoMapper`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/RequestDtoMapper.php` |

## Methods

| Method | Description |
|---|---|
| [`map(WebRequest $request, string $dtoClass): object`](#map) | Instantiates $dtoClass from the request's validated parameters. |

### map()

`public static function map(WebRequest $request, string $dtoClass): object`

Instantiates $dtoClass from the request's validated parameters.

Every property of the cached definition is resolved in declaration order and passed to the constructor by name. A parameter the request does not carry falls back to the property's default, then to null when it is nullable.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`WebRequest`](/api/request/web-request/) |  |
| `$dtoClass` | `string` |  |

Returns `object`

| Throws | When |
|---|---|
| `RuntimeException` | when a required property is absent — which means the registered validator did not actually enforce it — or a present value cannot be coerced to the property's declared type |
