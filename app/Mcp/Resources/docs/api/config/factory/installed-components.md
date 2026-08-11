# InstalledComponents

> The components a ComponentInstaller built, keyed by role.

The components a [`ComponentInstaller`](/api/config/factory/component-installer/) built, keyed by role.

The point of handing these back rather than writing them into their owner is that the owner then assigns them itself, by name and with a declared type:

```php $this->routing = $installed->need('routing', Routing::class); ```

That line is checked statically and breaks at compile time if the property is renamed or retyped. The compiled configuration it ultimately came from names only the role, and cannot reach a property at all.

## Synopsis

`final readonly class InstalledComponents`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Config/Factory/InstalledComponents.php` |

## Constructor

### __construct()

`public function __construct(array<string, object> $components): mixed`

Keyed by role.

| Parameter | Type | Description |
|---|---|---|
| `$components` | `array``<``string``, ``object``>` | Keyed by role. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`has(string $role): bool`](#has) | Whether a role was built. |
| [`need(string $role, class-string<T> $expected): T`](#need) | The component for a required role. |
| [`optional(string $role, class-string<T> $expected): ?T`](#optional) | The component for an optional role, or null when the configuration declares none. |
| [`roles(): array<int, string>`](#roles) | The roles that were built. |

### has()

`public function has(string $role): bool`

Whether a role was built.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` |  |

Returns `bool`

### need()

`public function need(string $role, class-string<T> $expected): T`

The component for a required role.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` |  |
| `$expected` | `class-string``<``T``>` |  |

Returns `T`

| Throws | When |
|---|---|
| `ConfigurationException` | When the role was not built, or was built as something else. Both mean the configuration and this code disagree about what a role is, which is worth saying rather than discovering through a type error on assignment. |

### optional()

`public function optional(string $role, class-string<T> $expected): ?T`

The component for an optional role, or null when the configuration declares none.

| Parameter | Type | Description |
|---|---|---|
| `$role` | `string` |  |
| `$expected` | `class-string``<``T``>` |  |

Returns `?``T`

| Throws | When |
|---|---|
| `ConfigurationException` | When the role was built as something else. Absent is fine; present and wrong is still a configuration error. |

### roles()

`public function roles(): array<int, string>`

The roles that were built.

Returns `array``<``int``, ``string``>`
