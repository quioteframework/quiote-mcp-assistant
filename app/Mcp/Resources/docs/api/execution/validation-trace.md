# ValidationTrace

> Tiny immutable description of what we validated (for debugging/parity tests).

Tiny immutable description of what we validated (for debugging/parity tests).

## Synopsis

`final readonly class ValidationTrace`

|  |  |
|---|---|
| Source | `Execution/ValidationService.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | `string` | _readonly._ |
| `$configFile` | `?``string` | _readonly._ |
| `$module` | `string` | _readonly._ |
| `$validatorsLoaded` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $module, string $action, array<string> $validatorsLoaded = [], ?string $configFile = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$module` | `string` |  |
| `$action` | `string` |  |
| `$validatorsLoaded` | `array``<``string``>` |  |
| `$configFile` | `?``string` |  |

Returns `mixed`
