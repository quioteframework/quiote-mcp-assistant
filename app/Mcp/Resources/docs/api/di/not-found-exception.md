# NotFoundException

> PSR-11 `NotFoundExceptionInterface`: nothing is bound under the requested id and no autowireable class or alias answers to it either.

PSR-11 `NotFoundExceptionInterface`: nothing is bound under the requested id and no autowireable class or alias answers to it either.

Thrown by [`Container::get()`](/api/di/container/#get) only when resolution finds no candidate at all. A candidate that exists but cannot be built fails with [`ContainerException`](/api/di/container-exception/) instead, so "there is no such service" stays distinguishable from "the service is broken". [`Container::tryGet()`](/api/di/container/#tryget) answers null rather than raising this.

## Synopsis

`class NotFoundException extends RuntimeException implements NotFoundExceptionInterface`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Implements | `NotFoundExceptionInterface` |
| Source | `DI/Container.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
