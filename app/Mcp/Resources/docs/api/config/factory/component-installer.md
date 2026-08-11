# ComponentInstaller

> Carries out a FactoryDefinitions operation list.

Carries out a [`FactoryDefinitions`](/api/config/factory/factory-definitions/) operation list.

This is the behaviour that used to be *generated* as PHP statements and `include`d into the context: construct, initialize, start up, in a specific interleaved order. Written once here, it is ordinary code that can be read and tested, rather than a string assembled by a config handler and executed against the context's private scope.

The order in the operation list is honoured exactly, including the interleaving of construction and startup: the database manager's startup() has to run before the user is built, because the user may read through it.

## Synopsis

`final class ComponentInstaller`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Config/Factory/ComponentInstaller.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`install(FactoryDefinitions $definitions): InstalledComponents`](#install) | Build and start up every component the definitions declare. |

### install()

`public function install(FactoryDefinitions $definitions): InstalledComponents`

Build and start up every component the definitions declare.

| Parameter | Type | Description |
|---|---|---|
| `$definitions` | [`FactoryDefinitions`](/api/config/factory/factory-definitions/) |  |

Returns [`InstalledComponents`](/api/config/factory/installed-components/)

| Throws | When |
|---|---|
| `ConfigurationException` | When a declared class is missing, is not a context component, or a startup names a role that was never built. |
