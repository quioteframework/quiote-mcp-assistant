# CompiledValidatorRegistry

> Resolves and loads the compiled/hand-written PHP validator-builder file for a module/action, if one exists, and applies it to a ValidatorBuilder scoped to the given container.

Resolves and loads the compiled/hand-written PHP validator-builder file for a module/action, if one exists, and applies it to a ValidatorBuilder scoped to the given container.

Wired into Action::registerValidators() by default, so committing a generated (or hand-written) validator file is all it takes to activate it -- no per-action boilerplate.

The file is a plain `require` (opcache-backed): no parsing happens at request time beyond what any other PHP include already costs. It must `return` a callable accepting a single ValidatorBuilder argument -- the exact shape FluentSourceEmitter produces, and the shape a developer can hand-write for an action that never had an XML config at all.

Registering through this path gives the same guarantee as the XML path: ValidationManager derives its strict-mode whitelist from whichever validators got addChild()'d before it executes (see ValidatorBuilder/ValidatorSpec), so a parameter with no validator here is pruned from the request exactly as it would be for an XML-declared action -- there is no separate, weaker guarantee for the fluent path.

Since this now runs by default for every action (most of which have no compiled/hand-written validator file at all), path resolution is memoized per (moduleDir, module, action) the same way ConfigCache::isModified() memoizes its own filesystem checks -- a documented optimization for persistent workers (FrankenPHP etc.) where "no such file" is trusted across the worker's lifetime rather than re-stat()'d on every request, and a resolved path is re-verified with a single stat() so a file removed between requests is still noticed. Both caches are process-wide by design; deploying a new/changed validator file is expected to go through a worker restart, exactly like every other compiled-artifact cache in this framework.

## Synopsis

`final class CompiledValidatorRegistry`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/Runtime/CompiledValidatorRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`apply(string $moduleDir, string $module, string $action, IValidatorContainer $container, Context $context, ?string $method = null): bool`](#apply) |  |

### apply()

`public function apply(string $moduleDir, string $module, string $action, IValidatorContainer $container, Context $context, ?string $method = null): bool`

| Parameter | Type | Description |
|---|---|---|
| `$moduleDir` | `string` |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$container` | [`IValidatorContainer`](/api/validator/i-validator-container/) |  |
| `$context` | [`Context`](/api/context/) |  |
| `$method` | `?``string` |  |

Returns `bool` — True if a compiled/hand-written validator file was found and applied, false if neither candidate exists (not every action needs validators -- this is not an error).
