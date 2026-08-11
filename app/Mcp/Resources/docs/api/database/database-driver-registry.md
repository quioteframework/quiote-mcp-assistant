# DatabaseDriverRegistry

> Process-global registry mapping short driver aliases (e.g.

Process-global registry mapping short driver aliases (e.g.

"eloquent", "doctrine", "cycle") to the [`Database`](/api/database/database/) adapter class that implements them, so `databases.xml` can say `class="eloquent"` instead of a fully-qualified class name.

This is a *static seam* in the same spirit as [`MiddlewareCatalog`](/api/middleware/middleware-catalog/) and [`Events`](/api/event/events/): plugins contribute aliases during [`PluginManager::bootFromConfig()`](/api/plugin/plugin-manager/#bootfromconfig) (via [`PluginRegistrar::databaseDriver()`](/api/plugin/plugin-registrar/#databasedriver)), which runs before any context — and therefore before `DatabaseConfigHandler` compiles a `databases.xml` — so aliases are known by the time they're resolved.

Only `pdo` ships in core (the one always-available driver). ORM adapters register their own aliases from their plugin.

## Synopsis

`final class DatabaseDriverRegistry`

|  |  |
|---|---|
| Source | `Database/DatabaseDriverRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`aliases(): array<string, class-string<Database>>`](#aliases) |  |
| [`has(string $alias): bool`](#has) | Whether $alias has been registered as a driver alias. |
| [`instantiate(string $classOrAlias): Database`](#instantiate) | Resolve and instantiate an adapter. |
| [`register(string $alias, class-string<Database> $adapterClass): void`](#register) | Register (or override) a driver alias. |
| [`reset(): void`](#reset) | Test isolation: restore the built-in aliases only. |
| [`resolve(string $classOrAlias): string`](#resolve) | Resolve an alias to its adapter class. |

### aliases()

`public static function aliases(): array<string, class-string<Database>>`

Returns `array``<``string``, ``class-string``<`[`Database`](/api/database/database/)`>``>`

### has()

`public static function has(string $alias): bool`

Whether $alias has been registered as a driver alias.

Fully-qualified class names are not aliases, so this is false for them.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `bool`

### instantiate()

`public static function instantiate(string $classOrAlias): Database`

Resolve and instantiate an adapter.

Used by callers that build a database outside the compiled config path; the compiled config emits `new <FQCN>()` with the alias already resolved at compile time.

| Parameter | Type | Description |
|---|---|---|
| `$classOrAlias` | `string` |  |

Returns [`Database`](/api/database/database/)

### register()

`public static function register(string $alias, class-string<Database> $adapterClass): void`

Register (or override) a driver alias.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |
| `$adapterClass` | `class-string``<`[`Database`](/api/database/database/)`>` |  |

### reset()

`public static function reset(): void`

Test isolation: restore the built-in aliases only.

### resolve()

`public static function resolve(string $classOrAlias): string`

Resolve an alias to its adapter class.

A string that is not a registered alias is returned unchanged, so fully-qualified class names in `databases.xml` pass straight through.

| Parameter | Type | Description |
|---|---|---|
| `$classOrAlias` | `string` |  |

Returns `string`
