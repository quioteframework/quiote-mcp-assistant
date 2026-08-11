# DatabaseDefinitions

> What the compiled `databases` configuration declares, as data.

What the compiled `databases` configuration declares, as data.

The compiled form used to be statements `require`d inside [`DatabaseManager::initialize()`](/api/database/database-manager/#initialize), assigning into `$this->databases` and `$this->defaultDatabaseName` from a scope it had no business reaching. It is a declaration now, for the same reasons the compiled factories configuration is -- see [`FactoryDefinitions`](/api/config/factory/factory-definitions/).

## Synopsis

`final readonly class DatabaseDefinitions`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Database/DatabaseDefinitions.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$databases` | `array` | _readonly._ |
| `$default` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<string, array{class: class-string<Database>, parameters: array<string, mixed>}> $databases, string $default): mixed`

The connection answered when none is named.

| Parameter | Type | Description |
|---|---|---|
| `$databases` | `array``<``string``, ``array{class: class-string<Database>, parameters: array<string, mixed>}``>` | Keyed by connection name, in declaration order. |
| `$default` | `string` | The connection answered when none is named. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromCompiled(mixed $compiled, string $source = 'the compiled databases cache'): DatabaseDefinitions`](#fromcompiled) | Read a compiled declaration, rejecting anything malformed. |

### fromCompiled()

`public static function fromCompiled(mixed $compiled, string $source = 'the compiled databases cache'): DatabaseDefinitions`

Read a compiled declaration, rejecting anything malformed.

Whatever the compiled file returned.

| Parameter | Type | Description |
|---|---|---|
| `$compiled` | `mixed` | Whatever the compiled file returned. |
| `$source` | `string` |  |

Returns [`DatabaseDefinitions`](/api/database/database-definitions/)

| Throws | When |
|---|---|
| `ConfigurationException` | When $compiled is not a declaration this version understands -- most likely a cache compiled by an earlier one. |
