# LoggerFactory

> Default LoggerFactoryInterface: thin wrapper over the Log facade (and thus LogRegistry) for constructor injection via the DI container.

Default [`LoggerFactoryInterface`](/api/logging/logger-factory-interface/): thin wrapper over the [`Log`](/api/logging/log/) facade (and thus [`LogRegistry`](/api/logging/log-registry/)) for constructor injection via the DI container.

## Synopsis

`final class LoggerFactory implements LoggerFactoryInterface`

|  |  |
|---|---|
| Implements | [`LoggerFactoryInterface`](/api/logging/logger-factory-interface/) |
| Source | `Logging/LoggerFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`create(string $category): LoggerInterface`](#create) | Returns a logger bound to the given category name verbatim. |
| [`for(object|string $classOrObject): LoggerInterface`](#for) | Returns a logger whose category is derived from a class name or instance. |

### create()

`public function create(string $category): LoggerInterface`

Returns a logger bound to the given category name verbatim.

Implementations must return a logger whose threshold and sinks come from the same configuration the [`Log`](/api/logging/log/) facade uses, so an injected logger and a facade logger for the same category behave identically.

| Parameter | Type | Description |
|---|---|---|
| `$category` | `string` |  |

Returns [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/)

### for()

`public function for(object|string $classOrObject): LoggerInterface`

Returns a logger whose category is derived from a class name or instance.

Accepts either the object itself or its fully-qualified class name; implementations must map both to the same category.

| Parameter | Type | Description |
|---|---|---|
| `$classOrObject` | `object``|``string` |  |

Returns [`LoggerInterface`](https://www.php-fig.org/psr/psr-3/)
