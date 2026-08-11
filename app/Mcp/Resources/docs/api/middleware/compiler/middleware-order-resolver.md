# MiddlewareOrderResolver

> Turns scanned `MiddlewareDefinition`s into a single pipeline order.

Turns scanned `MiddlewareDefinition`s into a single pipeline order.

`phase` (see MiddlewarePhase::ORDER) is the primary grouping; within/across phases, explicit `before`/`after` edges are hard constraints (a Kahn topological sort), and `priority` (higher runs earlier) plus scan order break remaining ties. `before`/`after` may name either a short class name (e.g. "RoutingMiddleware", matching how the framework's own attributes are written today) or a fully-qualified class name.

## Synopsis

`final class MiddlewareOrderResolver`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Middleware/Compiler/MiddlewareOrderResolver.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CODE_AMBIGUOUS_REFERENCE` | `'AMBIGUOUS_REFERENCE'` |  |
| `CODE_UNRESOLVED_REFERENCE` | `'UNRESOLVED_REFERENCE'` |  |

## Constructor

### __construct()

`public function __construct(?list<string> $guardedClasses = null): mixed`

Defaults to the framework's own guarded set;
       pass an explicit list (including `[]`) to override, e.g. in unit tests that
       exercise the lenient path.

| Parameter | Type | Description |
|---|---|---|
| `$guardedClasses` | `?``list``<``string``>` | Defaults to the framework's own guarded set; pass an explicit list (including `[]`) to override, e.g. in unit tests that exercise the lenient path. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |
| [`resolve(array<MiddlewareDefinition> $definitions): array<MiddlewareDefinition>`](#resolve) |  |

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded during the last resolve().

### resolve()

`public function resolve(array<MiddlewareDefinition> $definitions): array<MiddlewareDefinition>`

| Parameter | Type | Description |
|---|---|---|
| `$definitions` | `array``<`[`MiddlewareDefinition`](/api/middleware/compiler/middleware-definition/)`>` |  |

Returns `array``<`[`MiddlewareDefinition`](/api/middleware/compiler/middleware-definition/)`>` — Same definitions, reordered.

| Throws | When |
|---|---|
| `MiddlewareOrderException` | if before/after constraints cycle, or if a guarded (framework) middleware's constraint cannot be resolved. |
