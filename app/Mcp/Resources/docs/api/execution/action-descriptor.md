# ActionDescriptor

> Immutable value object describing which action to execute.

Immutable value object describing which action to execute.

## Synopsis

`final class ActionDescriptor`

|  |  |
|---|---|
| Source | `Execution/ActionDescriptor.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | `string` | _readonly._ |
| `$isSimple` | `bool` | _readonly._ |
| `$method` | `string` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$outputType` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $module, string $action, string $method, string $outputType, bool $isSimple): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$method` | `string` |  |
| `$outputType` | `string` |  |
| `$isSimple` | `bool` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromController(Controller $controller, string $module, string $action, string $method, string $outputType): ActionDescriptor`](#fromcontroller) | Build a descriptor by inspecting the action class (authoritative isSimple flag). |

### fromController()

`public static function fromController(Controller $controller, string $module, string $action, string $method, string $outputType): ActionDescriptor`

Build a descriptor by inspecting the action class (authoritative isSimple flag).

The class is instantiated once per unique class name per worker lifetime; subsequent calls for the same module:action pair read from the static cache.

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$method` | `string` |  |
| `$outputType` | `string` |  |

Returns [`ActionDescriptor`](/api/execution/action-descriptor/)
