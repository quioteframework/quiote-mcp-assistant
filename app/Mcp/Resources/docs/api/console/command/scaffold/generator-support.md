# GeneratorSupport

> Shared validation/overwrite-guard helpers for the `make:*` generator commands, mirroring the checks `NewCommand` already applies to its own `--namespace` argument (see `NewCommand::execute()`).

Shared validation/overwrite-guard helpers for the `make:*` generator commands, mirroring the checks `NewCommand` already applies to its own `--namespace` argument (see `NewCommand::execute()`).

## Synopsis

`final class GeneratorSupport`

|  |  |
|---|---|
| Source | `Console/Command/Scaffold/GeneratorSupport.php` |

## Methods

| Method | Description |
|---|---|
| [`appDir(): string`](#appdir) | Returns the application root directory the generators write into, from `core.app_dir`. |
| [`appNamespace(): string`](#appnamespace) | Returns the root namespace for generated classes, from `core.namespace_prefix` and defaulting to `App`. |
| [`guardOverwrite(string $path, bool $force): void`](#guardoverwrite) |  |
| [`requireString(mixed $value, string $label): string`](#requirestring) | Symfony Console's getArgument()/getOption() are typed mixed; every caller here expects a scalar string. |
| [`validateClassNameSegment(string $name): void`](#validateclassnamesegment) |  |
| [`writeFile(string $path, string $content): void`](#writefile) | Writes a generated file, creating its parent directory tree if needed. |

### appDir()

`public static function appDir(): string`

Returns the application root directory the generators write into, from `core.app_dir`.

Returns `string`

### appNamespace()

`public static function appNamespace(): string`

Returns the root namespace for generated classes, from `core.namespace_prefix` and defaulting to `App`.

Surrounding backslashes are trimmed, so the result is always usable as a namespace segment that callers can concatenate to.

Returns `string`

### guardOverwrite()

`public static function guardOverwrite(string $path, bool $force): void`

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$force` | `bool` |  |

| Throws | When |
|---|---|
| `ConfigurationException` | if $path exists and $force is false |

### requireString()

`public static function requireString(mixed $value, string $label): string`

Symfony Console's getArgument()/getOption() are typed mixed; every caller here expects a scalar string.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `mixed` |  |
| `$label` | `string` |  |

Returns `string`

### validateClassNameSegment()

`public static function validateClassNameSegment(string $name): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

| Throws | When |
|---|---|
| `ConfigurationException` | if $name is not a valid PHP class-name segment |

### writeFile()

`public static function writeFile(string $path, string $content): void`

Writes a generated file, creating its parent directory tree if needed.

Overwrites unconditionally — call [`GeneratorSupport::guardOverwrite()`](/api/console/command/scaffold/generator-support/#guardoverwrite) first if the command honours a `--force` flag. Both the directory creation and the write are error-suppressed so the generator reports one clear exception instead of a raw PHP warning followed by it.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$content` | `string` |  |

| Throws | When |
|---|---|
| `ConfigurationException` | If the directory cannot be created or the file cannot be written. |
