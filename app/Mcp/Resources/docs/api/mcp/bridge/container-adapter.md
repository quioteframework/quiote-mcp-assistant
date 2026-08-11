# ContainerAdapter

> Wraps Quiote's DI Container as the PSR-11 container `mcp/sdk` uses (`Mcp\\Server\\Builder::setContainer()`) to resolve string/array tool handlers (`Mcp\\Capability\\Registry\\ReferenceHandler::getClassInstance()`).

Wraps Quiote's DI [`Container`](/api/di/container/) as the PSR-11 container `mcp/sdk` uses (`Mcp\Server\Builder::setContainer()`) to resolve string/array tool handlers (`Mcp\Capability\Registry\ReferenceHandler::getClassInstance()`).

Quiote's own `Container::has()` deliberately reflects only explicit registrations/aliases, not autowireable classes (see its docblock) — so ordinary callers can't observe autowiring through a PSR-11 `has()` check. But MCP tool/resource/prompt handler classes are typically plain autowireable classes that are never explicitly bound. If `has()` returned false for those, `ReferenceHandler` falls back to `new $class()`, bypassing DI (and any constructor dependencies) entirely. This adapter reports any loadable class as present so `get()`'s autowiring path resolves it instead.

## Synopsis

`final class ContainerAdapter implements ContainerInterface`

|  |  |
|---|---|
| Implements | [`ContainerInterface`](https://www.php-fig.org/psr/psr-11/) |
| Source | `Bridge/ContainerAdapter.php` |

## Constructor

### __construct()

`public function __construct(Container $container): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$container` | [`Container`](/api/di/container/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`get(string $id): mixed`](#get) | Resolves $id through the wrapped Quiote container, autowiring it when it has no explicit registration. |
| [`has(string $id): bool`](#has) | Reports whether $id can be resolved. |

### get()

`public function get(string $id): mixed`

Resolves $id through the wrapped Quiote container, autowiring it when it has no explicit registration.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

Returns `mixed`

### has()

`public function has(string $id): bool`

Reports whether $id can be resolved.

True for anything the wrapped Quiote container has an explicit registration or alias for, and additionally for any loadable class name, so `mcp/sdk` routes autowireable handler classes through [`ContainerAdapter::get()`](/api/mcp/bridge/container-adapter/#get) instead of instantiating them itself.

| Parameter | Type | Description |
|---|---|---|
| `$id` | `string` |  |

Returns `bool`
