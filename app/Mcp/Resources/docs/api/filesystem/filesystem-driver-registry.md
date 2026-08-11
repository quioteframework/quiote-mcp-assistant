# FilesystemDriverRegistry

> Process-global registry mapping short driver aliases (e.g.

Process-global registry mapping short driver aliases (e.g.

"local", "s3") to the [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) class that implements them. Mirrors [`QueueDriverRegistry`](/api/queue/queue-driver-registry/) exactly.

Only `local` ships in core. Cloud backends register their own alias from their own plugin (e.g. `quioteframework/filesystem-s3`'s `S3FilesystemPlugin`).

## Synopsis

`final class FilesystemDriverRegistry`

|  |  |
|---|---|
| Source | `Filesystem/FilesystemDriverRegistry.php` |

## Methods

| Method | Description |
|---|---|
| [`aliases(): array<string, class-string<FilesystemAdapterInterface>>`](#aliases) |  |
| [`has(string $alias): bool`](#has) | Whether $alias has been registered as a driver alias. |
| [`instantiateClassFor(string $aliasOrClass): string`](#instantiateclassfor) | Resolves an alias (or a fully-qualified class name) to the adapter class to instantiate. |
| [`register(string $alias, class-string<FilesystemAdapterInterface> $driverClass): void`](#register) |  |
| [`reset(): void`](#reset) | Test isolation: restore the built-in alias only. |
| [`resolve(string $aliasOrClass): string`](#resolve) | A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through. |

### aliases()

`public static function aliases(): array<string, class-string<FilesystemAdapterInterface>>`

Returns `array``<``string``, ``class-string``<`[`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/)`>``>`

### has()

`public static function has(string $alias): bool`

Whether $alias has been registered as a driver alias.

Fully-qualified class names are not aliases, so this is false for them.

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |

Returns `bool`

### instantiateClassFor()

`public static function instantiateClassFor(string $aliasOrClass): string`

Resolves an alias (or a fully-qualified class name) to the adapter class to instantiate.

Returns the class name only; it does not construct anything. The message distinguishes a registered alias whose class is missing — the package is not installed — from a name that was never registered at all.

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `RuntimeException` | when the resolved class does not exist, or does not implement [`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/) |

### register()

`public static function register(string $alias, class-string<FilesystemAdapterInterface> $driverClass): void`

| Parameter | Type | Description |
|---|---|---|
| `$alias` | `string` |  |
| `$driverClass` | `class-string``<`[`FilesystemAdapterInterface`](/api/filesystem/filesystem-adapter-interface/)`>` |  |

### reset()

`public static function reset(): void`

Test isolation: restore the built-in alias only.

### resolve()

`public static function resolve(string $aliasOrClass): string`

A string that is not a registered alias is returned unchanged, so a fully-qualified class name passes through.

| Parameter | Type | Description |
|---|---|---|
| `$aliasOrClass` | `string` |  |

Returns `string`
