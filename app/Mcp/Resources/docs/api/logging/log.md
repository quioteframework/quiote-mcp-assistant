# Log

> Static facade for the logging subsystem: configuration (called in index.php before Kernel::run()) and logger acquisition (used everywhere else).

Static facade for the logging subsystem: configuration (called in index.php before Kernel::run()) and logger acquisition (used everywhere else).

Configuration example (index.php): use Quiote\Logging\{Log, Level}; use Quiote\Logging\Sink\JsonStdoutSink; Log::setDefaultLevel(Level::Info); Log::setLevels(['Quiote' => Level::Warning, 'App.Orders' => Level::Debug]); Log::addSink(new JsonStdoutSink(Level::Info)); Acquisition: $log = Log::for($this);          // category from the class FQCN (dot-normalized) $log = Log::create('Quiote.Routing'); All calls delegate to [`LogRegistry`](/api/logging/log-registry/), so the DI-registered [`LoggerFactory`](/api/logging/logger-factory/) and this facade share one configuration.

## Synopsis

`final class Log`

|  |  |
|---|---|
| Source | `Logging/Log.php` |

## Methods

| Method | Description |
|---|---|
| [`addSink(SinkInterface $sink): void`](#addsink) | Appends a sink to the process-global list of log destinations. |
| [`create(string $category): CategoryLogger`](#create) | The logger for an explicit dotted category, e.g. |
| [`for(object|string $classOrObject): CategoryLogger`](#for) | Category logger for a class or object; the category is the FQCN with namespace separators normalized to dots (so config prefixes like "App.Orders" match "App\Orders\OrderService"). |
| [`normalizeCategory(string $fqcn): string`](#normalizecategory) | Normalize a class name to a dotted category (leading separators stripped, "\" -> "."). |
| [`reset(): void`](#reset) | Restores the logging subsystem to its unconfigured state. |
| [`setDefaultLevel(Level $level): void`](#setdefaultlevel) | Sets the minimum level for every category without a more specific rule. |
| [`setLevel(string $categoryPrefix, Level $level): void`](#setlevel) | Sets the minimum level for one dotted category prefix, e.g. |
| [`setLevels(array<string, Level> $map): void`](#setlevels) |  |

### addSink()

`public static function addSink(SinkInterface $sink): void`

Appends a sink to the process-global list of log destinations.

Sinks accumulate rather than replace, and each applies its own minimum level on top of the category threshold. With no sink registered, records are discarded after level resolution.

| Parameter | Type | Description |
|---|---|---|
| `$sink` | [`SinkInterface`](/api/logging/sink/sink-interface/) |  |

### create()

`public static function create(string $category): CategoryLogger`

The logger for an explicit dotted category, e.g.

`Log::create(self::class)` from a static method.

Loggers are cached per category and shared by all call sites using it, so calling this repeatedly is cheap and does not allocate. Unlike [`Log::for()`](/api/logging/log/#for), the category is taken verbatim — pass an already-dotted name.

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |

Returns [`CategoryLogger`](/api/logging/category-logger/)

### for()

`public static function for(object|string $classOrObject): CategoryLogger`

Category logger for a class or object; the category is the FQCN with namespace separators normalized to dots (so config prefixes like "App.Orders" match "App\Orders\OrderService").

| Parameter | Type | Description |
|---|---|---|
| `$classOrObject` | `object``|``string` |  |

Returns [`CategoryLogger`](/api/logging/category-logger/)

### normalizeCategory()

`public static function normalizeCategory(string $fqcn): string`

Normalize a class name to a dotted category (leading separators stripped, "\" -> ".").

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `string`

### reset()

`public static function reset(): void`

Restores the logging subsystem to its unconfigured state.

Drops the registry's levels and sinks, clears any active [`LogContext`](/api/logging/log-context/) scopes, and empties this facade's logger cache so the next acquisition builds a logger against the new configuration. For test isolation and reconfiguration; not used on the request path.

### setDefaultLevel()

`public static function setDefaultLevel(Level $level): void`

Sets the minimum level for every category without a more specific rule.

Delegates to [`LogRegistry`](/api/logging/log-registry/), whose memoized per-category thresholds are invalidated, so loggers already handed out pick the change up. Configuration belongs at worker startup (index.php, before `Kernel::run()`), not per request.

| Parameter | Type | Description |
|---|---|---|
| `$level` | [`Level`](/api/logging/level/) |  |

### setLevel()

`public static function setLevel(string $categoryPrefix, Level $level): void`

Sets the minimum level for one dotted category prefix, e.g.

`Quiote.Routing`.

A prefix matches a category exactly or on a dot boundary, and the longest matching prefix wins over both shorter ones and the default level. Delegates to [`LogRegistry`](/api/logging/log-registry/), invalidating its resolved-threshold memo.

| Parameter | Type | Description |
|---|---|---|
| `$categoryPrefix` | `string` |  |
| `$level` | [`Level`](/api/logging/level/) |  |

### setLevels()

`public static function setLevels(array<string, Level> $map): void`

category-prefix => Level

| Parameter | Type | Description |
|---|---|---|
| `$map` | `array``<``string``, `[`Level`](/api/logging/level/)`>` | category-prefix => Level |
