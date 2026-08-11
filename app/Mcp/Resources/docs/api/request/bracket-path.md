# BracketPath

> Stateless resolution of legacy bracket-path parameter names (e.g.

Stateless resolution of legacy bracket-path parameter names (e.g.

"data[0][Application]") against a plain nested array.

## Synopsis

`final class BracketPath`

|  |  |
|---|---|
| Source | `Request/BracketPath.php` |

## Methods

| Method | Description |
|---|---|
| [`resolve(string $path, array<array-key, mixed> $rootArray): mixed`](#resolve) | Manual, conservative bracket path resolution for nested parameters like foo[0][bar]. |

### resolve()

`public static function resolve(string $path, array<array-key, mixed> $rootArray): mixed`

Manual, conservative bracket path resolution for nested parameters like foo[0][bar].

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$rootArray` | `array``<``array-key``, ``mixed``>` |  |

Returns `mixed`
