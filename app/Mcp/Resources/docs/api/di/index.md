# DI

> The Quiote\\DI namespace — 6 documented types.

Everything under `Quiote\DI`.

## Classes

| Class | Description |
|---|---|
| [`Container`](/api/di/container/) | Small scope-aware DI container: supports definitions as closures, class names, or instances. |
| [`ContainerException`](/api/di/container-exception/) | PSR-11 `ContainerExceptionInterface`: the container found something for the id but could not deliver it. |
| [`NotFoundException`](/api/di/not-found-exception/) | PSR-11 `NotFoundExceptionInterface`: nothing is bound under the requested id and no autowireable class or alias answers to it either. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Attribute`](/api/di/attribute/) | 3 types |
