# LogEvent

> An immutable structured log event.

An immutable structured log event.

Nothing is flattened early: the message template and property bag are preserved so structured sinks (JSON) can emit named fields, while text sinks call [`LogEvent::renderMessage()`](/api/logging/log-event/#rendermessage) to interpolate.

## Synopsis

`final readonly class LogEvent`

|  |  |
|---|---|
| Source | `Logging/LogEvent.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$category` | `string` | _readonly._ |
| `$exception` | `?`[`Throwable`](https://www.php.net/manual/en/class.throwable.php) | _readonly._ |
| `$level` | [`Level`](/api/logging/level/) | _readonly._ |
| `$messageTemplate` | `string` | _readonly._ |
| `$properties` | `array` | _readonly._ |
| `$scope` | `array` | _readonly._ |
| `$timestamp` | `float` | _readonly._ |

## Constructor

### __construct()

`public function __construct(float $timestamp, Level $level, string $category, string $messageTemplate, array<string, mixed> $properties = [], array<string, mixed> $scope = [], Throwable|null $exception = null): mixed`

From $context['exception'] per PSR-3.

| Parameter | Type | Description |
|---|---|---|
| `$timestamp` | `float` | UNIX timestamp with microseconds (microtime(true)). |
| `$level` | [`Level`](/api/logging/level/) |  |
| `$category` | `string` |  |
| `$messageTemplate` | `string` | Raw template, e.g. "Order {orderId} shipped". |
| `$properties` | `array``<``string``, ``mixed``>` | Named properties (PSR-3 $context sans "exception"). |
| `$scope` | `array``<``string``, ``mixed``>` | Ambient scope properties merged in at emit time. |
| `$exception` | [`Throwable`](https://www.php.net/manual/en/class.throwable.php)`|``null` | From $context['exception'] per PSR-3. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`renderMessage(): string`](#rendermessage) | Interpolate {placeholder} tokens in the template using properties then scope. |

### renderMessage()

`public function renderMessage(): string`

Interpolate {placeholder} tokens in the template using properties then scope.

Non-scalar / non-stringable values are left as-is (placeholder kept). Mirrors PSR-3 interpolation semantics.

Returns `string`
