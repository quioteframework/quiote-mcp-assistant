# RouteDefinition

> Format-independent description of one route, whatever front-end produced it (today: a #[Route] attribute; later, possibly routing.xml or a programmatic builder).

Format-independent description of one route, whatever front-end produced it (today: a #[Route] attribute; later, possibly routing.xml or a programmatic builder).

Every back-end (RouteCollectionBuilder, a compiled-matcher emitter, routes:list) consumes this shape and never needs to know the source.

## Synopsis

`final class RouteDefinition`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/RouteDefinition.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | `string` | _readonly._ |
| `$condition` | `?``string` | _readonly._ |
| `$defaults` | `array` | _readonly._ |
| `$host` | `?``string` | _readonly._ |
| `$meta` | `array` | _readonly._ |
| `$methods` | `array` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$name` | `string` | _readonly._ |
| `$outputType` | `?``string` | _readonly._ |
| `$path` | `string` | _readonly._ |
| `$priority` | `int` | _readonly._ |
| `$requirements` | `array` | _readonly._ |
| `$sourceRef` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $name, string $path, string $module, string $action, array<string> $methods, array<string, mixed> $defaults, array<string, string> $requirements, ?string $host, ?string $condition, int $priority, ?string $outputType, array{gen_path: string, cut: bool, path: string} $meta, string $sourceRef): mixed`

Quiote's own
       reverse-routing meta, in the shape Routing::gen() expects.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$path` | `string` |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$methods` | `array``<``string``>` |  |
| `$defaults` | `array``<``string``, ``mixed``>` |  |
| `$requirements` | `array``<``string``, ``string``>` |  |
| `$host` | `?``string` |  |
| `$condition` | `?``string` |  |
| `$priority` | `int` |  |
| `$outputType` | `?``string` |  |
| `$meta` | `array{gen_path: string, cut: bool, path: string}` | Quiote's own reverse-routing meta, in the shape Routing::gen() expects. |
| `$sourceRef` | `string` |  |

Returns `mixed`
