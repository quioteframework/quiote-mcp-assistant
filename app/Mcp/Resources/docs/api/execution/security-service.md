# SecurityService

> Lightweight security checker mapping Action security methods to a decision enum.

Lightweight security checker mapping Action security methods to a decision enum.

Currently only supports isSecure + credentials check via context user.

## Synopsis

`class SecurityService`

|  |  |
|---|---|
| Source | `Execution/SecurityService.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`decide(Action $action): SecurityDecision`](#decide) | Decides how the controller should proceed with a security-guarded action. |

### decide()

`public function decide(Action $action): SecurityDecision`

Decides how the controller should proceed with a security-guarded action.

An action that does not declare itself secure is allowed outright. Otherwise the user is resolved from the controller's context container: anything that is not an ISecurityUser, or an ISecurityUser that is not authenticated, yields a login forward. An authenticated user that lacks the action's declared credentials yields a secure forward; one that has them, or an action declaring no credentials, is allowed.

| Parameter | Type | Description |
|---|---|---|
| `$action` | [`Action`](/api/action/action/) |  |

Returns [`SecurityDecision`](/api/execution/security-decision/)
