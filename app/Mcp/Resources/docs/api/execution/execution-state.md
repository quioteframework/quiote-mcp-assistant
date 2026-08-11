# ExecutionState

> Mutable per-execution state for one action execution.

Mutable per-execution state for one action execution.

## Synopsis

`final class ExecutionState`

|  |  |
|---|---|
| Source | `Execution/ExecutionState.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$action` | `?``string` |  |
| `$actionAttributes` | `array` |  |
| `$cacheHit` | `bool` |  |
| `$forwardCount` | `int` |  |
| `$forwarded` | `bool` |  |
| `$metrics` | `?``array` |  |
| `$module` | `?``string` |  |
| `$outputType` | `?``string` |  |
| `$securityDecision` | `?`[`SecurityDecision`](/api/execution/security-decision/) |  |
| `$validationDecision` | `?`[`ValidationDecision`](/api/execution/validation-decision/) |  |
| `$viewModule` | `?``string` |  |
| `$viewName` | `?``string` |  |

## Constructor

### __construct()

`public function __construct(?string $viewModule = null, ?string $viewName = null, array<string, mixed> $actionAttributes = [], bool $cacheHit = false, ?SecurityDecision $securityDecision = null, bool $forwarded = false, ?ValidationDecision $validationDecision = null, int $forwardCount = 0, ?string $module = null, ?string $action = null, ?string $outputType = null, ?array<string, mixed> $metrics = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$viewModule` | `?``string` |  |
| `$viewName` | `?``string` |  |
| `$actionAttributes` | `array``<``string``, ``mixed``>` |  |
| `$cacheHit` | `bool` |  |
| `$securityDecision` | `?`[`SecurityDecision`](/api/execution/security-decision/) |  |
| `$forwarded` | `bool` |  |
| `$validationDecision` | `?`[`ValidationDecision`](/api/execution/validation-decision/) |  |
| `$forwardCount` | `int` |  |
| `$module` | `?``string` |  |
| `$action` | `?``string` |  |
| `$outputType` | `?``string` |  |
| `$metrics` | `?``array``<``string``, ``mixed``>` |  |

Returns `mixed`
