# QueueConfig

> Typed snapshot of the `queue.*` settings family.

Typed snapshot of the `queue.*` settings family.

Defaults here are read as fallbacks only — [`QueuePlugin`](/api/queue/queue-plugin/) is what actually publishes them into [`Config`](/api/config/config/) via `configDefault()`.

## Synopsis

`final readonly class QueueConfig`

|  |  |
|---|---|
| Source | `QueueConfig.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$defaultDriver` | `string` | _readonly._ |
| `$retryBackoffSeconds` | `int` | _readonly._ |
| `$retryMaxAttempts` | `int` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $defaultDriver, int $retryMaxAttempts, int $retryBackoffSeconds): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$defaultDriver` | `string` |  |
| `$retryMaxAttempts` | `int` |  |
| `$retryBackoffSeconds` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromConfig(): QueueConfig`](#fromconfig) | Reads the `queue.*` family out of [`Config`](/api/config/config/) into one immutable snapshot, falling back to the `sync` driver with three attempts five seconds apart when the app (or [`QueuePlugin`](/api/queue/queue-plugin/)) has published nothing. |

### fromConfig()

`public static function fromConfig(): QueueConfig`

Reads the `queue.*` family out of [`Config`](/api/config/config/) into one immutable snapshot, falling back to the `sync` driver with three attempts five seconds apart when the app (or [`QueuePlugin`](/api/queue/queue-plugin/)) has published nothing.

Returns [`QueueConfig`](/api/queue/queue-config/)
