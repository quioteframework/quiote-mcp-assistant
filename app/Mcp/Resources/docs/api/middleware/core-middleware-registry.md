# CoreMiddlewareRegistry

> The single declaration of the middleware the framework ships.

The single declaration of the middleware the framework ships.

One entry per middleware, carrying both of the things the framework needs to know about it: how to construct it, and whether config may silently reorder or disable it. Deriving both answers from the same list is the point -- a middleware added to a construction map but forgotten in a separate guard list is unguarded, which is how a `<use>` entry in any installed module's `middleware.*` was once able to switch CSRF validation off with no acknowledgement.

Ordering is not declared here. It comes from each class's own `#[Middleware]` attribute (phase, before/after, priority) and is resolved by `MiddlewareOrderResolver`, so a middleware states its own placement next to its implementation.

## Synopsis

`final class CoreMiddlewareRegistry`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Middleware/CoreMiddlewareRegistry.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `CORE` | `['Quiote\\Middleware\\ErrorHandlingMiddleware', 'Quiote\\Middleware\\SessionMiddleware', 'Quiote\\Middleware\\TelemetryMiddleware', …]` | The middleware core builds itself, in declaration order. |

## Methods

| Method | Description |
|---|---|
| [`factories(Context $context): array<class-string<MiddlewareInterface>, callable(Context): \Psr\Http\Server\MiddlewareInterface>`](#factories) | Construction closures for the middleware core builds itself, keyed by class name. |
| [`guardedClasses(): list<string>`](#guardedclasses) | Every class `MiddlewareConfigRegistry` guards against silent config-driven reordering or disabling: what core builds, plus the first-party middleware a plugin delivers. |
| [`pluginProvidedClasses(): list<string>`](#pluginprovidedclasses) | First-party middleware delivered by a plugin rather than constructed by core. |

### factories()

`public static function factories(Context $context): array<class-string<MiddlewareInterface>, callable(Context): \Psr\Http\Server\MiddlewareInterface>`

Construction closures for the middleware core builds itself, keyed by class name.

Each factory receives the Context whose pipeline is being built, so a middleware needing a per-context collaborator gets the right one without capturing anything at declaration time. A zero-argument factory simply ignores it, as any PHP callable does.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `array``<``class-string``<`[`MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/)`>``, ``callable(Context): \Psr\Http\Server\MiddlewareInterface``>`

### guardedClasses()

`public static function guardedClasses(): list<string>`

Every class `MiddlewareConfigRegistry` guards against silent config-driven reordering or disabling: what core builds, plus the first-party middleware a plugin delivers.

Needs no Context, so a guard can consult it from anywhere.

Returns `list``<``string``>`

### pluginProvidedClasses()

`public static function pluginProvidedClasses(): list<string>`

First-party middleware delivered by a plugin rather than constructed by core.

Returns `list``<``string``>`
