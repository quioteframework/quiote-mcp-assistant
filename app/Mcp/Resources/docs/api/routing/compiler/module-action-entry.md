# ModuleActionEntry

> One `{Module}/Actions/...Action.php` file found by ModuleActionDiscovery, before any attempt to load or reflect it.

One `{Module}/Actions/...Action.php` file found by [`ModuleActionDiscovery`](/api/routing/compiler/module-action-discovery/), before any attempt to load or reflect it.

## Synopsis

`final class ModuleActionEntry`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Routing/Compiler/ModuleActionEntry.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | `string` | _readonly._ |
| `$file` | `string` | _readonly._ |
| `$fqcn` | `string` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$moduleDir` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $module, string $action, string $file, string $fqcn, string $moduleDir): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$file` | `string` |  |
| `$fqcn` | `string` |  |
| `$moduleDir` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`legacyClassName(): string`](#legacyclassname) | The pre-namespace legacy class name convention (`Controller::createActionInstance()`'s fallback), e.g. |

### legacyClassName()

`public function legacyClassName(): string`

The pre-namespace legacy class name convention (`Controller::createActionInstance()`'s fallback), e.g.

`sample_SecureSimpleAction` for module "sample", action "SecureSimple". Some actions -- typically older fixtures/apps -- are only ever defined this way and never gain a namespaced twin, so any "does this action class exist" check needs to try both names, not just `fqcn`.

Returns `string`
