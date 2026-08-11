# QueueDriverRegistry

> Process-global registry mapping short driver aliases (e.g.

Process-global registry mapping short driver aliases (e.g.

"sync", "db") to the [`QueueDriverInterface`](/api/queue/queue-driver-interface/) class that implements them, so `queue.default_driver`/`--driver` can say `db` instead of a fully-qualified class name. Mirrors [`DatabaseDriverRegistry`](/api/database/database-driver-registry/) exactly.

Only `sync` ships in core. Persistent backends register their own alias from their plugin (e.g. `quioteframework/queue-db`'s `QueueDbPlugin`).

## Synopsis

`final class QueueDriverRegistry`

|  |  |
|---|---|
| Source | `QueueDriverRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`aliases(): array<string, class-string<QueueDriverInterface>>`](#aliases) |  |
| [`has(string $alias): bool`](#has) | Whether $alias has been registered. |
| [`instantiateClassFor(string $aliasOrClass): string`](#instantiateclassfor) | Resolves an alias or class name to a loadable [`QueueDriverInterface`](/api/queue/queue-driver-interface/) implementation and returns its class name — nothing is instantiated here. |
| [`register(string $alias, class-string<QueueDriverInterface> $driverClass): void`](#register) |  |
| [`reset(): void`](#reset) | Test isolation: restore the built-in aliases only. |
| [`resolve(string $aliasOrClass): string`](#resolve) | A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through. |

### aliases()

`public static function aliases(): array<string, class-string<QueueDriverInterface>>`

Returns `array``<``string``, ``class-string``<`[`QueueDriverInterface`](/api/queue/queue-driver-interface/)`>``>`

### has()

`public static function has(string $alias): bool`

Whether $alias has been registered.

Only tests the alias table; a fully-qualified class name that [`QueueDriverRegistry::resolve()`](/api/queue/queue-driver-registry/#resolve) would happily pass through is not an alias and reports false here.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `bool`

### instantiateClassFor()

`public static function instantiateClassFor(string $aliasOrClass): string`

Resolves an alias or class name to a loadable [`QueueDriverInterface`](/api/queue/queue-driver-interface/) implementation and returns its class name — nothing is instantiated here.

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | if the resolved class does not exist (the message distinguishes a registered alias whose package is missing from an unknown alias), or exists but does not implement [`QueueDriverInterface`](/api/queue/queue-driver-interface/). |

### register()

`public static function register(string $alias, class-string<QueueDriverInterface> $driverClass): void`

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |
| `$driverClass` | `class-string``<`[`QueueDriverInterface`](/api/queue/queue-driver-interface/)`>` |  |

### reset()

`public static function reset(): void`

Test isolation: restore the built-in aliases only.

### resolve()

`public static function resolve(string $aliasOrClass): string`

A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through.

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `string`
