# MiddlewareDefinition

> The scanned contents of one `#[Middleware]` attribute, plus the class it was found on and where it was discovered — mirrors `Quiote\\Routing\\Compiler\\RouteDefinition`'s role for `#[Route]`.

The scanned contents of one `#[Middleware]` attribute, plus the class it was found on and where it was discovered — mirrors `Quiote\Routing\Compiler\RouteDefinition`'s role for `#[Route]`.

## Synopsis

`final class MiddlewareDefinition`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Middleware/Compiler/MiddlewareDefinition.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$after` | `?``string` | _readonly._ |
| `$before` | `?``string` | _readonly._ |
| `$enabled` | `bool` | _readonly._ |
| `$fqcn` | `string` | _readonly._ |
| `$phase` | `string` | _readonly._ |
| `$priority` | `int` | _readonly._ |
| `$sourceRef` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $fqcn, string $phase, int $priority, ?string $before, ?string $after, bool $enabled, string $sourceRef): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |
| `$phase` | `string` |  |
| `$priority` | `int` |  |
| `$before` | `?``string` |  |
| `$after` | `?``string` |  |
| `$enabled` | `bool` |  |
| `$sourceRef` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`shortName(): string`](#shortname) | Short class name, used to resolve before/after references given as bare class names. |

### shortName()

`public function shortName(): string`

Short class name, used to resolve before/after references given as bare class names.

Returns `string`
