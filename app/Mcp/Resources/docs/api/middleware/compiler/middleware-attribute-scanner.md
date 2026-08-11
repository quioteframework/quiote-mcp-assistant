# MiddlewareAttributeScanner

> Reflects a list of candidate classes for `#[Middleware]` attributes and builds the `MiddlewareDefinition`s that `MiddlewareOrderResolver` sorts into a pipeline order.

Reflects a list of candidate classes for `#[Middleware]` attributes and builds the `MiddlewareDefinition`s that `MiddlewareOrderResolver` sorts into a pipeline order.

Modeled on `Quiote\Routing\Compiler\AttributeRouteScanner`, but takes an explicit FQCN list rather than globbing directories: unlike actions (which always live under a module's `Actions/` tree), middleware has no established directory convention to scan, so candidates are whatever the framework's own core list plus `MiddlewareCatalog::getAttributedCandidates()` supply.

A class is only a candidate for scanning if it's already been supplied by the caller — this scanner never does its own class discovery. Classes without a `#[Middleware]` attribute, or that don't implement `MiddlewareInterface`, are silently skipped (the same "presence is opt-in" rule `AttributeRouteScanner` uses for `#[Route]`).

## Synopsis

`final class MiddlewareAttributeScanner`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Middleware/Compiler/MiddlewareAttributeScanner.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CODE_CLASS_NOT_FOUND` | `'CLASS_NOT_FOUND'` |  |
| `CODE_DUPLICATE_CANDIDATE` | `'DUPLICATE_CANDIDATE'` |  |
| `CODE_NOT_A_MIDDLEWARE` | `'NOT_A_MIDDLEWARE'` |  |

## Methods

| Method | Description |
|---|---|
| [`getDiagnostics(): array<Diagnostic>`](#getdiagnostics) |  |
| [`scan(iterable<string> $candidateFqcns): array<MiddlewareDefinition>`](#scan) |  |

### getDiagnostics()

`public function getDiagnostics(): array<Diagnostic>`

Returns `array``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>` — Diagnostics recorded during the last scan().

### scan()

`public function scan(iterable<string> $candidateFqcns): array<MiddlewareDefinition>`

| Parameter | Type | Description |
|---|---|---|
| `$candidateFqcns` | `iterable``<``string``>` |  |

Returns `array``<`[`MiddlewareDefinition`](/api/middleware/compiler/middleware-definition/)`>`
