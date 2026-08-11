# MiddlewareConfigRegistry

> Process-global accumulator for `<use>` entries contributed by compiled `middleware.{xml,php,yaml,yml}` files (the app's own plus any module's `Config/middleware.*`), mirroring PluginManager's role for `plugins.*`.

Process-global accumulator for `<use>` entries contributed by compiled `middleware.{xml,php,yaml,yml}` files (the app's own plus any module's `Config/middleware.*`), mirroring [`PluginManager`](/api/plugin/plugin-manager/)'s role for `plugins.*`.

Contributions are validated here, at compile/bootstrap time, rather than deferred to [`MiddlewarePipeline`](/api/middleware/middleware-pipeline/)'s first build: a config file that tries to touch one of the framework's own shipped middleware classes (see [`CoreMiddlewareRegistry::guardedClasses()`](/api/middleware/core-middleware-registry/#guardedclasses), which covers both the pipeline's own map and first-party security middleware shipped in its own package, such as CSRF) without both the per-entry `override-framework="true"` attribute AND the global `core.middleware.allow_framework_overrides` setting fails loudly the moment that file is loaded, not on the first HTTP request.

## Synopsis

`final class MiddlewareConfigRegistry`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Middleware/Config/MiddlewareConfigRegistry.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `OVERRIDE_SETTING` | `'core.middleware.allow_framework_overrides'` |  |

## Methods

| Method | Description |
|---|---|
| [`all(): list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool, sourceRef: string}>`](#all) |  |
| [`contribute(list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}> $entries, string $sourceRef): void`](#contribute) |  |
| [`reset(): void`](#reset) | Test isolation. |

### all()

`public static function all(): list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool, sourceRef: string}>`

Returns `list``<``array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool, sourceRef: string}``>`

### contribute()

`public static function contribute(list<array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}> $entries, string $sourceRef): void`

| Parameter | Type | Description |
|---|---|---|
| `$entries` | `list``<``array{class: string, phase: ?string, priority: ?int, before: ?string, after: ?string, enabled: ?bool, override_framework: bool}``>` |  |
| `$sourceRef` | `string` |  |

### reset()

`public static function reset(): void`

Test isolation.
