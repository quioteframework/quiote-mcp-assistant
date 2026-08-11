# CompiledMatcherDumper

> Back-end that dumps a RouteCollection to a Symfony CompiledUrlMatcher blob (the same technique Symfony's own router uses: a static-prefix tree + merged regexes emitted as plain PHP, so matching is opcache-native instead of iterating/compiling the collection at runtime).

Back-end that dumps a RouteCollection to a Symfony CompiledUrlMatcher blob (the same technique Symfony's own router uses: a static-prefix tree + merged regexes emitted as plain PHP, so matching is opcache-native instead of iterating/compiling the collection at runtime).

Slots in alongside RouteCollectionBuilder as a sibling back-end over the routing IR.

Staleness safety: the artifact is written to a path keyed by a signature of the route definitions. If the routes change and the dump is not regenerated, the live signature no longer matches any file on disk, so Routing silently falls back to the dynamic UrlMatcher — a stale dump can never route a request to the wrong action.

## Synopsis

`final class CompiledMatcherDumper`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/CompiledMatcherDumper.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(RouteCollection $routes): EmittedArtifact`](#emit) | Emit the compiled-routes PHP (a file that `return`s the array CompiledUrlMatcher's constructor expects), without writing it. |
| [`signature(RouteCollection $routes): string`](#signature) | Short, stable hash of everything about the collection that affects matching (name, path, methods, host, requirements, defaults, condition), in collection order (order is significant for same-path routes). |
| [`targetFor(RouteCollection $routes): string`](#targetfor) | The path the compiled matcher for these routes is written to / loaded from — under the app cache dir, keyed by the route signature. |
| [`targetForSignature(string $signature): string`](#targetforsignature) | The artifact path for an already-computed route signature, under `core.cache_dir`'s `routing/` directory. |

### emit()

`public static function emit(RouteCollection $routes): EmittedArtifact`

Emit the compiled-routes PHP (a file that `return`s the array CompiledUrlMatcher's constructor expects), without writing it.

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `RouteCollection` |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)

### signature()

`public static function signature(RouteCollection $routes): string`

Short, stable hash of everything about the collection that affects matching (name, path, methods, host, requirements, defaults, condition), in collection order (order is significant for same-path routes).

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `RouteCollection` |  |

Returns `string`

### targetFor()

`public static function targetFor(RouteCollection $routes): string`

The path the compiled matcher for these routes is written to / loaded from — under the app cache dir, keyed by the route signature.

| Parameter | Type | Description |
|---|---|---|
| `$routes` | `RouteCollection` |  |

Returns `string`

### targetForSignature()

`public static function targetForSignature(string $signature): string`

The artifact path for an already-computed route signature, under `core.cache_dir`'s `routing/` directory.

Lets a caller that holds a signature — a runtime lookup checking whether a dump for the live routes exists — avoid re-hashing the collection.

| Parameter | Type | Description |
|---|---|---|
| `$signature` | `string` |  |

Returns `string`
