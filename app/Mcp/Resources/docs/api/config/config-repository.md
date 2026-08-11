# ConfigRepository

> An instance-backed store of configuration directives, with typed accessors that fail loudly when a directive does not hold the shape the caller asked for.

An instance-backed store of configuration directives, with typed accessors that fail loudly when a directive does not hold the shape the caller asked for.

This is where the behaviour lives; [`Config`](/api/config/config/) is a static facade over one default instance of it. Having a real object means a consumer can be handed a repository -- through the container, or directly in a test -- instead of reaching into process-wide state, and two configurations can exist side by side.

A directive marked read-only cannot be overwritten or removed, and survives [`ConfigRepository::clear()`](/api/config/config-repository/#clear) and [`ConfigRepository::resetWorkerState()`](/api/config/config-repository/#resetworkerstate).

## Synopsis

`class ConfigRepository`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Config/ConfigRepository.php` |

## Constructor

### __construct()

`public function __construct(array<string|int, mixed> $config = []): mixed`

Initial directives.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``string``|``int``, ``mixed``>` | Initial directives. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`clear(): void`](#clear) | Drop every directive except read-only ones that still hold their read-only value. |
| [`fromArray(array<string|int, mixed> $data): void`](#fromarray) | Import directives, in precedence order: a read-only directive keeps its value, then the incoming data wins, then anything already set that the data does not mention. |
| [`get(string|int $name, mixed $default = null): mixed`](#get) | The raw value of a directive, or $default when unset. |
| [`getArray(string|int $name, ?array<mixed> $default = null): array<mixed>`](#getarray) |  |
| [`getBool(string|int $name, bool $default = false): bool`](#getbool) |  |
| [`getFloat(string|int $name, ?float $default = null): float`](#getfloat) | An int value is widened to float without complaint. |
| [`getInt(string|int $name, ?int $default = null): int`](#getint) |  |
| [`getNullableString(string|int $name, ?string $default = null): ?string`](#getnullablestring) | A directive as a string, or null when it genuinely is not set. |
| [`getString(string|int $name, ?string $default = null): string`](#getstring) | A directive as a string. |
| [`getStringList(string|int $name, array<string> $default = []): array<int, string>`](#getstringlist) | A directive configurable as either a single string or an array of strings, normalized to a list. |
| [`has(string|int $name): bool`](#has) | Whether a directive with the given name is present. |
| [`isReadonly(string|int $name): bool`](#isreadonly) | Whether the named directive was set read-only and can no longer be changed. |
| [`remove(string|int $name): bool`](#remove) | Remove a directive, unless it is read-only. |
| [`resetWorkerState(array<int, string> $preserveKeys = []): void`](#resetworkerstate) | Drop request-specific directives at a worker request boundary, keeping read-only ones and anything named in $preserveKeys. |
| [`set(string|int $name, mixed $value, bool $overwrite = true, bool $readonly = false): bool`](#set) | Set a directive, unless it is read-only, or already set and $overwrite is false. |
| [`toArray(): array<string|int, mixed>`](#toarray) |  |

### clear()

`public function clear(): void`

Drop every directive except read-only ones that still hold their read-only value.

Compared with strict equality on matching keys rather than array_intersect_assoc(), which stringifies values and would treat any two array-valued directives as equal.

### fromArray()

`public function fromArray(array<string|int, mixed> $data): void`

Import directives, in precedence order: a read-only directive keeps its value, then the incoming data wins, then anything already set that the data does not mention.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``|``int``, ``mixed``>` |  |

### get()

`public function get(string|int $name, mixed $default = null): mixed`

The raw value of a directive, or $default when unset.

Prefer the typed accessors: this cannot be checked at the call site, so a wrongly-shaped value propagates silently instead of failing where it was configured.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getArray()

`public function getArray(string|int $name, ?array<mixed> $default = null): array<mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `?``array``<``mixed``>` |  |

Returns `array``<``mixed``>`

| Throws | When |
|---|---|
| `ConfigurationException` | If unset with no default, or not holding an array. |

### getBool()

`public function getBool(string|int $name, bool $default = false): bool`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `bool` |  |

Returns `bool`

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive is set but does not hold a bool. |

### getFloat()

`public function getFloat(string|int $name, ?float $default = null): float`

An int value is widened to float without complaint.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `?``float` |  |

Returns `float`

| Throws | When |
|---|---|
| `ConfigurationException` | If unset with no default, or not holding a float. |

### getInt()

`public function getInt(string|int $name, ?int $default = null): int`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `?``int` |  |

Returns `int`

| Throws | When |
|---|---|
| `ConfigurationException` | If unset with no default, or not holding an int. |

### getNullableString()

`public function getNullableString(string|int $name, ?string $default = null): ?string`

A directive as a string, or null when it genuinely is not set.

For settings where "unconfigured" is itself meaningful, such as an absent environment override, so a missing directive is not an error.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `?``string` |  |

Returns `?``string`

| Throws | When |
|---|---|
| `ConfigurationException` | If the directive holds a non-scalar value. |

### getString()

`public function getString(string|int $name, ?string $default = null): string`

A directive as a string.

Scalars are cast; an array has no sensible string form and is rejected.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `?``string` |  |

Returns `string`

| Throws | When |
|---|---|
| `ConfigurationException` | If unset with no default, or holding an array. |

### getStringList()

`public function getStringList(string|int $name, array<string> $default = []): array<int, string>`

A directive configurable as either a single string or an array of strings, normalized to a list.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$default` | `array``<``string``>` |  |

Returns `array``<``int``, ``string``>`

| Throws | When |
|---|---|
| `ConfigurationException` | If it holds anything other than a string or an array of scalars. |

### has()

`public function has(string|int $name): bool`

Whether a directive with the given name is present.

A directive explicitly set to null still counts as present.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |

Returns `bool`

### isReadonly()

`public function isReadonly(string|int $name): bool`

Whether the named directive was set read-only and can no longer be changed.

[`ConfigRepository::set()`](/api/config/config-repository/#set) refuses to overwrite such a directive and reports false rather than throwing.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |

Returns `bool`

### remove()

`public function remove(string|int $name): bool`

Remove a directive, unless it is read-only.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |

Returns `bool` — Whether it was removed.

### resetWorkerState()

`public function resetWorkerState(array<int, string> $preserveKeys = []): void`

Drop request-specific directives at a worker request boundary, keeping read-only ones and anything named in $preserveKeys.

| Parameter | Type | Description |
|---|---|---|
| `$preserveKeys` | `array``<``int``, ``string``>` |  |

### set()

`public function set(string|int $name, mixed $value, bool $overwrite = true, bool $readonly = false): bool`

Set a directive, unless it is read-only, or already set and $overwrite is false.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string``|``int` |  |
| `$value` | `mixed` |  |
| `$overwrite` | `bool` |  |
| `$readonly` | `bool` |  |

Returns `bool` — Whether the directive was set.

### toArray()

`public function toArray(): array<string|int, mixed>`

Returns `array``<``string``|``int``, ``mixed``>`
