# RequestDtoRegistry

> In-process cache for #[MapRequest] reflection results, mirroring Quiote\\DI\\Container::classPlan()'s per-class caching style: a DTO's shape never changes mid-process, so both the parsed RequestDtoDefinition and the \"which execute*() parameter (if any) is a #[MapRequest] DTO\" lookup are computed once and reused for the life of the worker/request.

In-process cache for #[MapRequest] reflection results, mirroring Quiote\DI\Container::classPlan()'s per-class caching style: a DTO's shape never changes mid-process, so both the parsed RequestDtoDefinition and the "which execute*() parameter (if any) is a #[MapRequest] DTO" lookup are computed once and reused for the life of the worker/request.

Unlike the routing module's directory-wide scan, this reflects one class at a time, so no filesystem-artifact pipeline is warranted here.

## Synopsis

`final class RequestDtoRegistry`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Request/RequestDtoRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`definitionFor(string $dtoClass): RequestDtoDefinition`](#definitionfor) | The parsed definition for a `#[MapRequest]` DTO, reflected on first request and then served from the in-process cache for the life of the worker. |
| [`dtoClassForMethod(class-string $actionClass, string $methodName): ?string`](#dtoclassformethod) | The #[MapRequest] DTO class bound to the named action method's parameter list, or null if that method has none. |

### definitionFor()

`public static function definitionFor(string $dtoClass): RequestDtoDefinition`

The parsed definition for a `#[MapRequest]` DTO, reflected on first request and then served from the in-process cache for the life of the worker.

| Parameter | Type | Description |
|---|---|---|
| `$dtoClass` | `string` |  |

Returns [`RequestDtoDefinition`](/api/request/compiler/request-dto-definition/)

### dtoClassForMethod()

`public static function dtoClassForMethod(class-string $actionClass, string $methodName): ?string`

The #[MapRequest] DTO class bound to the named action method's parameter list, or null if that method has none.

| Parameter | Type | Description |
|---|---|---|
| `$actionClass` | `class-string` |  |
| `$methodName` | `string` |  |

Returns `?``string`
