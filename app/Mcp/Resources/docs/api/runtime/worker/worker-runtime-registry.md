# WorkerRuntimeRegistry

> Process-global registry mapping short runtime aliases (e.g.

Process-global registry mapping short runtime aliases (e.g.

"frankenphp", "roadrunner") to the [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/) class that implements them. Mirrors [`FilesystemDriverRegistry`](/api/filesystem/filesystem-driver-registry/) exactly.

Only `sapi` and `frankenphp` ship in core. Other hosts register their own alias from their own plugin (e.g. `quioteframework/worker-roadrunner`'s `WorkerRoadRunnerPlugin`), which is why [`WorkerRuntimeRegistry::detect()`](/api/runtime/worker/worker-runtime-registry/#detect) lives here rather than as a hardcoded list in the Kernel.

## Synopsis

`final class WorkerRuntimeRegistry`

|  |  |
|---|---|
| Source | `Runtime/Worker/WorkerRuntimeRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`aliases(): array<string, class-string<WorkerRuntimeInterface>>`](#aliases) |  |
| [`detect(): class-string<WorkerRuntimeInterface>`](#detect) | The registered runtime that claims the current process: the highest detectionPriority() among those reporting isSupported(), ties broken by registration order so the result is deterministic. |
| [`has(string $alias): bool`](#has) | Whether $alias has been registered. |
| [`instantiateClassFor(string $aliasOrClass): class-string<WorkerRuntimeInterface>`](#instantiateclassfor) |  |
| [`register(string $alias, class-string<WorkerRuntimeInterface> $runtimeClass): void`](#register) |  |
| [`reset(): void`](#reset) | Test isolation: restore the built-in aliases only. |
| [`resolve(string $aliasOrClass): string`](#resolve) | A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through. |

### aliases()

`public static function aliases(): array<string, class-string<WorkerRuntimeInterface>>`

Returns `array``<``string``, ``class-string``<`[`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)`>``>`

### detect()

`public static function detect(): class-string<WorkerRuntimeInterface>`

The registered runtime that claims the current process: the highest detectionPriority() among those reporting isSupported(), ties broken by registration order so the result is deterministic.

Always resolves -- [`SapiRuntime`](/api/runtime/worker/sapi-runtime/) claims every process at PHP_INT_MIN -- so callers never have to handle "no runtime".

Returns `class-string``<`[`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)`>`

### has()

`public static function has(string $alias): bool`

Whether $alias has been registered.

Only tests the alias table; a fully-qualified class name that [`WorkerRuntimeRegistry::resolve()`](/api/runtime/worker/worker-runtime-registry/#resolve) would happily pass through is not an alias and reports false here.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `bool`

### instantiateClassFor()

`public static function instantiateClassFor(string $aliasOrClass): class-string<WorkerRuntimeInterface>`

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `class-string``<`[`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)`>`

### register()

`public static function register(string $alias, class-string<WorkerRuntimeInterface> $runtimeClass): void`

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |
| `$runtimeClass` | `class-string``<`[`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)`>` |  |

### reset()

`public static function reset(): void`

Test isolation: restore the built-in aliases only.

### resolve()

`public static function resolve(string $aliasOrClass): string`

A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through.

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `string`
