# ModelClassResolver

> Turns a model name into the class that implements it.

Turns a model name into the class that implements it.

The naming conventions are the only reason this class changes: a fully qualified class name is taken at its word (with an optional `Model` suffix), and a short name is probed against the namespaced convention first, then the underscore-joined legacy one, then a direct `require` of the file the legacy convention would have put it in.

Resolution is a pure function of (model name, module name) once the class exists, so the answer -- including the reflection probe that feeds it -- is cached. The cache is per instance rather than per process: the resolver is a container singleton, so a worker resolves each model name once, and a second named context profile keeping its own cache costs a handful of `class_exists()` calls rather than sharing mutable static state.

## Synopsis

`final class ModelClassResolver`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Model/ModelClassResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`clearCache(): void`](#clearcache) | Drop the resolution cache. |
| [`resolve(string $modelName, ?string $moduleName = null): ResolvedModel`](#resolve) | Resolve a model name to the class implementing it. |

### clearCache()

`public function clearCache(): void`

Drop the resolution cache.

For tests that define model classes between calls, and for anything that changes `core.namespace_prefix` or the model directories mid-process.

### resolve()

`public function resolve(string $modelName, ?string $moduleName = null): ResolvedModel`

Resolve a model name to the class implementing it.

A module name for a module model, null for a global one.

| Parameter | Type | Description |
|---|---|---|
| `$modelName` | `string` | A model name or fully qualified class name. |
| `$moduleName` | `?``string` | A module name for a module model, null for a global one. |

Returns [`ResolvedModel`](/api/model/resolved-model/)

| Throws | When |
|---|---|
| `QuioteException` | When no candidate class exists. |
