# ViewNameResolver

> ViewNameResolver: pure resolution of raw view return values to (module, canonicalViewName|NONE).

ViewNameResolver: pure resolution of raw view return values to (module, canonicalViewName|NONE).

Unlike ViewResolver, this class intentionally performs no instantiation or side-effects and can be safely used in container-less pipelines and caching layers.

## Synopsis

`final class ViewNameResolver`

|  |  |
|---|---|
| Source | `Execution/ViewNameResolver.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(string $actionModule, string $actionName, mixed $rawViewName): array{0: (string | null), 1: (string | null)}`](#resolve) |  |

### resolve()

`public function resolve(string $actionModule, string $actionName, mixed $rawViewName): array{0: (string | null), 1: (string | null)}`

Raw return (string|array|View::NONE)

| Parameter | Type | Description |
|---|---|---|
| `$actionModule` | `string` | Declared action module. |
| `$actionName` | `string` | Action name. |
| `$rawViewName` | `mixed` | Raw return (string\|array\|View::NONE) |

Returns `array{0: (string | null), 1: (string | null)}`
