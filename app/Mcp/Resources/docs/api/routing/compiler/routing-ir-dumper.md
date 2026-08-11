# RoutingIrDumper

> Dumps/loads the routing IR (a RoutePlan's RouteDefinitions) as an opcache-friendly `return [...]` PHP artifact, so AttributeRouting::build() can skip AttributeRouteScanner's live scan (recursive glob() per module Actions/ tree, require_once + ReflectionClass per action class) on every Routing construction -- a per-request cost under classic PHP-FPM.

Dumps/loads the routing IR (a RoutePlan's RouteDefinitions) as an opcache-friendly `return [...]` PHP artifact, so AttributeRouting::build() can skip AttributeRouteScanner's live scan (recursive glob() per module Actions/ tree, require_once + ReflectionClass per action class) on every Routing construction -- a per-request cost under classic PHP-FPM.

Unlike CompiledMatcherDumper, this artifact cannot be keyed by a signature of the *built* routes: the whole point is to avoid building them. It's instead keyed by the scan *inputs* (module directories + namespace prefix) -- the same values AttributeRouteScanner::scan() itself defaults to -- and trusted unconditionally once written, gated by core.routing.trust_compiled_ir (default false; set true in production after `cache:warmup`, mirroring core.config_check_freshness's "trust the cache" contract from item 7).

## Synopsis

`final class RoutingIrDumper`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/RoutingIrDumper.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(RoutePlan $plan): EmittedArtifact`](#emit) | Emit the routing IR PHP (a file that `return`s a plain array reconstructible into a RoutePlan by load()), without writing it. |
| [`load(): ?RoutePlan`](#load) | Load a previously dumped routing IR artifact, or null if none exists or it's malformed (a bad/stale artifact must never break routing -- the caller falls back to a live scan). |
| [`targetFor(): string`](#targetfor) | The path the routing IR artifact is written to / loaded from, keyed by the default scan inputs (core.module_dir + plugin module directories + core.namespace_prefix). |

### emit()

`public static function emit(RoutePlan $plan): EmittedArtifact`

Emit the routing IR PHP (a file that `return`s a plain array reconstructible into a RoutePlan by load()), without writing it.

| Parameter | Type | Description |
|---|---|---|
| `$plan` | [`RoutePlan`](/api/routing/compiler/route-plan/) |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)

### load()

`public static function load(): ?RoutePlan`

Load a previously dumped routing IR artifact, or null if none exists or it's malformed (a bad/stale artifact must never break routing -- the caller falls back to a live scan).

Returns `?`[`RoutePlan`](/api/routing/compiler/route-plan/)

### targetFor()

`public static function targetFor(): string`

The path the routing IR artifact is written to / loaded from, keyed by the default scan inputs (core.module_dir + plugin module directories + core.namespace_prefix).

A Routing subclass overriding moduleDirs() to something non-default is never covered by this artifact -- callers must check that themselves before relying on it (see AttributeRouting::build()).

Returns `string`
