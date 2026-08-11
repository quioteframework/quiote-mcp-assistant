# LoggerFactoryInterface

> DI-injectable factory for category loggers.

DI-injectable factory for category loggers.

Delegates to the same [`LogRegistry`](/api/logging/log-registry/) the [`Log`](/api/logging/log/) facade uses, so injected and facade loggers share one configuration.

## Synopsis

`interface LoggerFactoryInterface`

|  |  |
|---|---|
| Implemented by | [`LoggerFactory`](/api/logging/logger-factory/) |
| Source | `Logging/LoggerFactoryInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`create(string $category): LoggerInterface`](#create) | Returns a logger bound to the given category name verbatim. |
| [`for(object|string $classOrObject): LoggerInterface`](#for) | Returns a logger whose category is derived from a class name or instance. |

### create()

`abstract public function create(string $category): LoggerInterface`

Returns a logger bound to the given category name verbatim.

Implementations must return a logger whose threshold and sinks come from the same configuration the [`Log`](/api/logging/log/) facade uses, so an injected logger and a facade logger for the same category behave identically.

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |

Returns [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/)

### for()

`abstract public function for(object|string $classOrObject): LoggerInterface`

Returns a logger whose category is derived from a class name or instance.

Accepts either the object itself or its fully-qualified class name; implementations must map both to the same category.

| Parameter | Type | Description |
|---|---|---|
| `$classOrObject` | `object``|``string` |  |

Returns [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/)
