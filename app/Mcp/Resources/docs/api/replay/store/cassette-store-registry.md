# CassetteStoreRegistry

> Process-global registry mapping short store aliases (`file`, `azure-blob`, `s3`, `gcs`, `pdo`) to the CassetteStoreInterface class that implements them, so `replay.store` can say `file` instead of a fully-qualified class name.

Process-global registry mapping short store aliases (`file`, `azure-blob`, `s3`, `gcs`, `pdo`) to the [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) class that implements them, so `replay.store` can say `file` instead of a fully-qualified class name.

Mirrors [`QueueDriverRegistry`](/api/queue/queue-driver-registry/)/[`DatabaseDriverRegistry`](/api/database/database-driver-registry/) exactly.

Only `file` ships here. `azure-blob` and `pdo` register their own alias from their own plugin (`quioteframework/replay-azure`, `quioteframework/replay-pdo`), with zero change to this class; `s3`/`gcs` would do the same from their own plugin once one exists.

## Synopsis

`final class CassetteStoreRegistry`

|  |  |
|---|---|
| Source | `Store/CassetteStoreRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`aliases(): array<string, class-string<CassetteStoreInterface>>`](#aliases) |  |
| [`factoryFor(string $alias): \Closure(\Quiote\DI\Container): CassetteStoreInterface|null`](#factoryfor) | The factory for $alias, or null when its package registered none. |
| [`has(string $alias): bool`](#has) | Whether $alias has been registered -- a fully-qualified class name is not an alias. |
| [`instantiateClassFor(string $aliasOrClass): string`](#instantiateclassfor) | Resolves an alias or class name to a loadable [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) implementation and returns its class name -- nothing is instantiated here. |
| [`register(string $alias, class-string<CassetteStoreInterface> $storeClass, \Closure(\Quiote\DI\Container): CassetteStoreInterface|null $factory = null): void`](#register) |  |
| [`reset(): void`](#reset) | Test isolation: restore the built-in aliases only. |
| [`resolve(string $aliasOrClass): string`](#resolve) | A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through. |

### aliases()

`public static function aliases(): array<string, class-string<CassetteStoreInterface>>`

Returns `array``<``string``, ``class-string``<`[`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/)`>``>`

### factoryFor()

`public static function factoryFor(string $alias): \Closure(\Quiote\DI\Container): CassetteStoreInterface|null`

The factory for $alias, or null when its package registered none.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `\Closure(\Quiote\DI\Container): CassetteStoreInterface``|``null`

### has()

`public static function has(string $alias): bool`

Whether $alias has been registered -- a fully-qualified class name is not an alias.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `bool`

### instantiateClassFor()

`public static function instantiateClassFor(string $aliasOrClass): string`

Resolves an alias or class name to a loadable [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) implementation and returns its class name -- nothing is instantiated here.

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | if the resolved class does not exist, or exists but does not implement [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/). |

### register()

`public static function register(string $alias, class-string<CassetteStoreInterface> $storeClass, \Closure(\Quiote\DI\Container): CassetteStoreInterface|null $factory = null): void`

How to build it.
       Required for any store `ReplayPlugin` does not know how to construct itself, which is
       every store but the built-in file one -- see `$factories`.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |
| `$storeClass` | `class-string``<`[`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/)`>` |  |
| `$factory` | `\Closure(\Quiote\DI\Container): CassetteStoreInterface``|``null` | How to build it. Required for any store `ReplayPlugin` does not know how to construct itself, which is every store but the built-in file one -- see `$factories`. |

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
