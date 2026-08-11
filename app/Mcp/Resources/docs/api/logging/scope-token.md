# ScopeToken

> Handle to an active LogContext scope frame.

Handle to an active [`LogContext`](/api/logging/log-context/) scope frame.

Closing it (explicitly or on destruction) pops exactly that frame. Idempotent. Usage: $scope = LogContext::push(['userId' => 7]); try { ... } finally { $scope->close(); } or simply let $scope go out of scope.

## Synopsis

`final class ScopeToken`

|  |  |
|---|---|
| Source | `Logging/ScopeToken.php` |

## Constructor

### __construct()

`public function __construct(int $id): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$id` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__destruct(): mixed`](#destruct) |  |
| [`close(): void`](#close) | Pops the scope frame this token represents. |

### __destruct()

`public function __destruct(): mixed`

Returns `mixed`

### close()

`public function close(): void`

Pops the scope frame this token represents.

Idempotent: a second call does nothing, so closing explicitly and then letting the token be destroyed pops the frame only once.
