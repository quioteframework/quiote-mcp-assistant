# SecurityDecision

> The outcome of the security check for an action: run it, or forward somewhere else.

The outcome of the security check for an action: run it, or forward somewhere else.

Produced by [`SecurityService`](/api/execution/security-service/) and [`SecurityMiddleware`](/api/middleware/security-middleware/) and recorded on [`ExecutionState::$securityDecision`](/api/execution/execution-state/#securitydecision), where the cache layer stores and replays it with the rest of the execution state.

`Allow` means the action is not secure, security is globally disabled, or the user satisfied it. `LoginForward` means the user is not authenticated and the configured login action is dispatched instead. `SecureForward` means the user is authenticated but lacks a credential the action requires, and the configured secure action is dispatched instead.

## Synopsis

`enum SecurityDecision: string`

|  |  |
|---|---|
| Source | `Execution/SecurityDecision.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Allow` | `'allow'` |  |
| `LoginForward` | `'login'` |  |
| `SecureForward` | `'secure'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`from(string|int $value): static`](#from) |  |
| [`tryFrom(string|int $value): ?static`](#tryfrom) |  |

### cases()

`public static function cases(): array`

Returns `array`

### from()

`public static function from(string|int $value): static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `static`

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
