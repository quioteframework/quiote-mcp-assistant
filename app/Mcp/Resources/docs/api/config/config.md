# Config

> Static facade over the application's configuration.

Static facade over the application's configuration.

The behaviour lives in [`ConfigRepository`](/api/config/config-repository/); this is the process-wide entry point every call site already uses. Code that can accept a collaborator should take a ConfigRepository instead -- it is injectable, swappable and testable in isolation -- and reach for this only where threading one through is not practical.

## Synopsis

`class Config`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Config.php` |

## Methods

| Method | Description |
|---|---|
| [`clear(): void`](#clear) | Clear the configuration. |
| [`fromArray(array<string|int, mixed> $data): void`](#fromarray) | Import a list of configuration directives. |
| [`get(string|int $name, mixed $default = null): mixed`](#get) | Get a configuration value. |
| [`getArray(string|int $name, ?array<mixed> $default = null): array<mixed>`](#getarray) | Get a configuration value as an array. |
| [`getBool(string|int $name, bool $default = false): bool`](#getbool) | Get a configuration value as a bool. |
| [`getFloat(string|int $name, ?float $default = null, AsString $asString = false): (AsString is true ? string : float)`](#getfloat) | Get a configuration value as a float. |
| [`getInt(string|int $name, ?int $default = null, AsString $asString = false): (AsString is true ? string : int)`](#getint) | Get a configuration value as an int. |
| [`getNullableString(string|int $name, ?string $default = null): ?string`](#getnullablestring) | Get a configuration value as a string, or null if the directive genuinely isn't set. |
| [`getString(string|int $name, ?string $default = null): string`](#getstring) | Get a configuration value as a string. |
| [`getStringList(string|int $name, array<string> $default = []): array<int, string>`](#getstringlist) | Get a configuration value that may be configured as either a single string or an array of strings, normalized to a list. |
| [`has(string|int $name): bool`](#has) | Check if a configuration directive has been set. |
| [`isReadonly(string|int $name): bool`](#isreadonly) | Check if a configuration directive has been set as read-only. |
| [`remove(string|int $name): bool`](#remove) | Remove a configuration value. |
| [`repository(): ConfigRepository`](#repository) | The repository backing the facade, created on first use. |
| [`resetWorkerState(array<int, string> $preserveKeys = []): void`](#resetworkerstate) | Reset configuration state for FrankenPHP worker mode. |
| [`set(string|int $name, mixed $value, bool $overwrite = true, bool $readonly = false): bool`](#set) | Set a configuration value. |
| [`toArray(): array<string|int, mixed>`](#toarray) | Get all configuration directives and values. |
| [`useRepository(?ConfigRepository $repository): ?ConfigRepository`](#userepository) | Install a repository for the facade to delegate to. |

### clear()

`public static function clear(): void`

Clear the configuration.

### fromArray()

`public static function fromArray(array<string|int, mixed> $data): void`

Import a list of configuration directives.

An array of configuration directives.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``|``int``, ``mixed``>` | An array of configuration directives. |

### get()

`public static function get(string|int $name, mixed $default = null): mixed`

:::caution[Deprecated]
This method is deprecated. Use getString(), getInt(), getFloat(), getBool() or getArray() instead.
:::

Get a configuration value.

The value to return if the directive is not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `mixed` | The value to return if the directive is not set. |

Returns `mixed` — The value of the directive, or the default if not set.

### getArray()

`public static function getArray(string|int $name, ?array<mixed> $default = null): array<mixed>`

Get a configuration value as an array.

The value to return if the directive is not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `?``array``<``mixed``>` | The value to return if the directive is not set. |

Returns `array``<``mixed``>` — The value of the directive.

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive is unset with no default given, or does not hold an array. |

### getBool()

`public static function getBool(string|int $name, bool $default = false): bool`

Get a configuration value as a bool.

The value to return if the directive is not set. Defaults to false.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `bool` | The value to return if the directive is not set. Defaults to false. |

Returns `bool` — The value of the directive.

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive is set but does not hold a bool. |

### getFloat()

`public static function getFloat(string|int $name, ?float $default = null, AsString $asString = false): (AsString is true ? string : float)`

Get a configuration value as a float.

Whether to return the value as its string representation instead of a float.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `?``float` | The value to return if the directive is not set. |
| `$asString` | `AsString` | Whether to return the value as its string representation instead of a float. |

Returns `(AsString is true ? string : float)`

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive is unset with no default given, or does not hold a float. |

### getInt()

`public static function getInt(string|int $name, ?int $default = null, AsString $asString = false): (AsString is true ? string : int)`

Get a configuration value as an int.

Whether to return the value as its string representation instead of an int.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `?``int` | The value to return if the directive is not set. |
| `$asString` | `AsString` | Whether to return the value as its string representation instead of an int. |

Returns `(AsString is true ? string : int)`

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive is unset with no default given, or does not hold an int. |

### getNullableString()

`public static function getNullableString(string|int $name, ?string $default = null): ?string`

Get a configuration value as a string, or null if the directive genuinely isn't set.

The value to return if the directive is not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `?``string` | The value to return if the directive is not set. |

Returns `?``string` — The value of the directive, as a string, or null.

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive holds a non-scalar value. |

### getString()

`public static function getString(string|int $name, ?string $default = null): string`

Get a configuration value as a string.

The value to return if the directive is not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `?``string` | The value to return if the directive is not set. |

Returns `string` — The value of the directive, as a string.

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive is unset with no default given, or holds an array. |

### getStringList()

`public static function getStringList(string|int $name, array<string> $default = []): array<int, string>`

Get a configuration value that may be configured as either a single string or an array of strings, normalized to a list.

The value to return if the directive is not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$default` | `array``<``string``>` | The value to return if the directive is not set. |

Returns `array``<``int``, ``string``>` — The value of the directive, normalized to a list of strings.

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive holds something other than a string or an array of scalars. |

### has()

`public static function has(string|int $name): bool`

Check if a configuration directive has been set.

The name of the configuration directive.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |

Returns `bool` — Whether the directive was set.

### isReadonly()

`public static function isReadonly(string|int $name): bool`

Check if a configuration directive has been set as read-only.

The name of the configuration directive.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |

Returns `bool` — Whether the directive is read-only.

### remove()

`public static function remove(string|int $name): bool`

Remove a configuration value.

The name of the configuration directive.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |

Returns `bool` — true, if removed successfully, false otherwise.

### repository()

`public static function repository(): ConfigRepository`

The repository backing the facade, created on first use.

Returns [`ConfigRepository`](/api/config/config-repository/)

### resetWorkerState()

`public static function resetWorkerState(array<int, string> $preserveKeys = []): void`

Reset configuration state for FrankenPHP worker mode.

Configuration keys to preserve (in addition to readonly)

| Parameter | Type | Description |
|---|---|---|
| `$preserveKeys` | `array``<``int``, ``string``>` | Configuration keys to preserve (in addition to readonly) |

### set()

`public static function set(string|int $name, mixed $value, bool $overwrite = true, bool $readonly = false): bool`

Set a configuration value.

Whether or not this value should be read-only once set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` | The name of the configuration directive. |
| `$value` | `mixed` | The configuration value. |
| `$overwrite` | `bool` | Whether or not an existing value should be overwritten. |
| `$readonly` | `bool` | Whether or not this value should be read-only once set. |

Returns `bool` — Whether or not the configuration directive has been set.

### toArray()

`public static function toArray(): array<string|int, mixed>`

Get all configuration directives and values.

Returns `array``<``string``|``int``, ``mixed``>` — An associative array of configuration values.

### useRepository()

`public static function useRepository(?ConfigRepository $repository): ?ConfigRepository`

Install a repository for the facade to delegate to.

The seam for a test that needs a configuration of its own, and for embedding code that builds its configuration separately. Pass null to drop the current one, so the next access starts from an empty repository.

| Parameter | Type | Description |
|---|---|---|
| `$repository` | `?`[`ConfigRepository`](/api/config/config-repository/) |  |

Returns `?`[`ConfigRepository`](/api/config/config-repository/) — The repository that was installed before this call, so a caller can restore it.
