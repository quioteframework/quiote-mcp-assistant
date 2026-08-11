# FactoryDefinitions

> What the compiled `factories` configuration says, as data.

What the compiled `factories` configuration says, as data.

The compiled factory configuration used to be executable PHP that was `include`d inside [`Context::initialize()`](/api/context/#initialize), where it assigned straight into the context's properties: `$this->user = new SecurityUser();`, `$this->userFactoryInfo = [...]`. Included code takes on the scope it is included into, so a generated file had full private access to the context and nothing anywhere declared which properties it was allowed to touch. Renaming or retyping one of them broke a cached file at runtime, in the boot path, with an error naming the property rather than the stale cache.

So the compiled form is now a declaration instead: an ordered list of operations naming *roles*, which something else carries out. A role is part of the configuration contract; a property name is an implementation detail the compiled file no longer knows.

## Synopsis

`final readonly class FactoryDefinitions`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Config/Factory/FactoryDefinitions.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `OP_BUILD` | `'build'` |  |
| `OP_STARTUP` | `'startup'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$factories` | `array` | _readonly._ |
| `$operations` | `array` | _readonly._ |
| `$shutdownOrder` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<int, array{op: string, role: string, class?: string, parameters?: array<string, mixed>}> $operations, array<string, array{class: string, parameters: array<string, mixed>}> $factories, array<int, string> $shutdownOrder): mixed`

Roles to shut down, in order.

| Parameter | Type | Description |
|---|---|---|
| `$operations` | `array``<``int``, ``array{op: string, role: string, class?: string, parameters?: array<string, mixed>}``>` | Ordered. Interleaving matters: a role's startup() may have to run before a later role is even constructed, which is why this is one ordered list rather than a list of components plus a list of startups. |
| `$factories` | `array``<``string``, ``array{class: string, parameters: array<string, mixed>}``>` | Roles that are not built eagerly -- the caller instantiates these on demand. |
| `$shutdownOrder` | `array``<``int``, ``string``>` | Roles to shut down, in order. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`buildInfo(string $role): ?array{class: string, parameters: array<string, mixed>}`](#buildinfo) | The class and parameters declared for a role that is built eagerly. |
| [`builtRoles(): array<int, string>`](#builtroles) | The roles built eagerly, in construction order. |
| [`fromCompiled(mixed $compiled, string $source = 'the compiled factories cache'): FactoryDefinitions`](#fromcompiled) | Read a compiled definition set, rejecting anything malformed. |

### buildInfo()

`public function buildInfo(string $role): ?array{class: string, parameters: array<string, mixed>}`

The class and parameters declared for a role that is built eagerly.

This is what the lazy worker-mode recreation paths rebuild from, so it has to be answerable for a role whose instance has since been dropped.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` |  |

Returns `?``array{class: string, parameters: array<string, mixed>}`

### builtRoles()

`public function builtRoles(): array<int, string>`

The roles built eagerly, in construction order.

Returns `array``<``int``, ``string``>`

### fromCompiled()

`public static function fromCompiled(mixed $compiled, string $source = 'the compiled factories cache'): FactoryDefinitions`

Read a compiled definition set, rejecting anything malformed.

Whatever the compiled file returned.

| Parameter | Type | Description |
|---|---|---|
| `$compiled` | `mixed` | Whatever the compiled file returned. |
| `$source` | `string` |  |

Returns [`FactoryDefinitions`](/api/config/factory/factory-definitions/)

| Throws | When |
|---|---|
| `ConfigurationException` | When $compiled is not a definition set this version understands. |
