# ContextRegistry

> Owns the live Context instances -- one per named profile.

Owns the live [`Context`](/api/context/) instances -- one per named profile.

A context profile is a configuration identity (web, console, a named profile), and something has to guarantee there is exactly one context per identity for the life of the process. That guarantee was a static map on Context itself, which made Context responsible both for being a context and for knowing about all the others. This is the second half, on its own.

Constructor-inject this to reach a context by name. [`Context::getInstance()`](/api/context/#getinstance) answers from [`ContextRegistry::shared()`](/api/context-registry/#shared), so both reach the same instances.

## Synopsis

`final class ContextRegistry`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `ContextRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`clear(): void`](#clear) | Forget every live context without resetting them. |
| [`get(?string $profile = null, ?class-string<Context> $fallbackClass = null): Context`](#get) | Retrieve the context for a profile, initializing it on first request. |
| [`has(?string $profile = null): bool`](#has) | Whether a profile has a live context. |
| [`names(): array<int, string>`](#names) | The profile names of every live context. |
| [`resetAll(?string $preferred = null): void`](#resetall) | Reset every live context at a worker request boundary. |
| [`shared(): ContextRegistry`](#shared) | The process-wide registry. |

### clear()

`public function clear(): void`

Forget every live context without resetting them.

For tests that need a clean process-level slate. Not a request-boundary operation -- [`ContextRegistry::resetAll()`](/api/context-registry/#resetall) is, and dropping contexts there would rebuild the whole configuration on every request.

### get()

`public function get(?string $profile = null, ?class-string<Context> $fallbackClass = null): Context`

Retrieve the context for a profile, initializing it on first request.

The implementation to build when
            `core.context_implementation` is unset. Null means [`Context`](/api/context/) itself. This
            is how [`Context::getInstance()`](/api/context/#getinstance) keeps its late-static-binding behaviour:
            `SubContext::getInstance()` builds a SubContext without needing the setting.

| Parameter | Type | Description |
|---|---|---|
| `$profile` | `?``string` | A profile name, or null for `core.default_context`. |
| `$fallbackClass` | `?``class-string``<`[`Context`](/api/context/)`>` | The implementation to build when `core.context_implementation` is unset. Null means [`Context`](/api/context/) itself. This is how [`Context::getInstance()`](/api/context/#getinstance) keeps its late-static-binding behaviour: `SubContext::getInstance()` builds a SubContext without needing the setting. |

Returns [`Context`](/api/context/)

| Throws | When |
|---|---|
| `Exception` | Whatever construction or initialize() raised. Bootstrap runs before any PSR-15 pipeline exists, so there is no ErrorHandlingMiddleware to hand a failure to; it is logged here and propagated rather than rendered. |

### has()

`public function has(?string $profile = null): bool`

Whether a profile has a live context.

Does not create one -- this is for callers that need to act on what exists rather than bring it into being.

| Parameter | Type | Description |
|---|---|---|
| `$profile` | `?``string` |  |

Returns `bool`

### names()

`public function names(): array<int, string>`

The profile names of every live context.

Returns `array``<``int``, ``string``>`

### resetAll()

`public function resetAll(?string $preferred = null): void`

Reset every live context at a worker request boundary.

The profile that served the request, reset first.

| Parameter | Type | Description |
|---|---|---|
| `$preferred` | `?``string` | The profile that served the request, reset first. |

### shared()

`public static function shared(): ContextRegistry`

The process-wide registry.

Built on first use.

Returns [`ContextRegistry`](/api/context-registry/)
