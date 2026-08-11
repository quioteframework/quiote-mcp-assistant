# SwooleConverterOptions

> The handful of things a Swoole request cannot tell us and the server operator has to.

The handful of things a Swoole request cannot tell us and the server operator has to.

## Synopsis

`final readonly class SwooleConverterOptions`

|  |  |
|---|---|
| Source | `SwooleConverterOptions.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$https` | `bool` | _readonly._ |
| `$scriptName` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $scriptName = '/index.php', bool $https = false): mixed`

Whether Swoole itself is terminating TLS. Not inferred:
       behind a TLS-terminating proxy this is false and the X-Forwarded-*
       correction in WorkerRequestFactory is what makes the request https.

| Parameter | Type | Description |
|---|---|---|
| `$scriptName` | `string` | Swoole has no front-controller script, but Routing reads $_SERVER['SCRIPT_NAME'] when generating URLs, so a plausible value has to be synthesised. |
| `$https` | `bool` | Whether Swoole itself is terminating TLS. Not inferred: behind a TLS-terminating proxy this is false and the X-Forwarded-* correction in WorkerRequestFactory is what makes the request https. |

Returns `mixed`
