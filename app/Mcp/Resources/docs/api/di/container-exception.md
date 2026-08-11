# ContainerException

> PSR-11 `ContainerExceptionInterface`: the container found something for the id but could not deliver it.

PSR-11 `ContainerExceptionInterface`: the container found something for the id but could not deliver it.

Raised for every failure of the resolution machinery itself: a circular dependency in the resolving stack, a factory that threw (wrapped, unless it threw a [`QuioteException`](/api/exception/quiote-exception/), which is rethrown as-is), a constructor that threw, an unsatisfied or untyped constructor parameter, a class name that does not exist, a binding whose value is not an instance of the class-name id that was asked for, a `#[Required]` method the container refuses to call, and the captive-dependency guard's refusal to inject a request-scoped service into a singleton.

## Synopsis

`class ContainerException extends RuntimeException implements ContainerExceptionInterface`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Implements | `ContainerExceptionInterface` |
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
