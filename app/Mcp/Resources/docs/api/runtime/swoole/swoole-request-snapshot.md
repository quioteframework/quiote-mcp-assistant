# SwooleRequestSnapshot

> A Swoole HTTP request reduced to plain arrays.

A Swoole HTTP request reduced to plain arrays.

ext-swoole is a `suggest` rather than a `require`, so the conversion logic has to be checkable and testable on a machine without the extension. Only [`SwooleRequestSnapshotFactory`](/api/runtime/swoole/swoole-request-snapshot-factory/) names \Swoole\Http\Request; everything downstream works off this.

## Synopsis

`final readonly class SwooleRequestSnapshot`

|  |  |
|---|---|
| Source | `SwooleRequestSnapshot.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$cookie` | `array` | _readonly._ |
| `$files` | `array` | _readonly._ |
| `$get` | `array` | _readonly._ |
| `$header` | `array` | _readonly._ |
| `$post` | `array` | _readonly._ |
| `$rawContent` | `string` | _readonly._ |
| `$server` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(array<string, mixed> $server = [], array<string, string> $header = [], array<string, mixed> $get = [], array<string, mixed> $post = [], array<string, string> $cookie = [], array<string, mixed> $files = [], string $rawContent = ''): mixed`

$_FILES-shaped.

| Parameter | Type | Description |
|---|---|---|
| `$server` | `array``<``string``, ``mixed``>` | Swoole's own $request->server -- note the keys are LOWERCASE. |
| `$header` | `array``<``string``, ``string``>` | Lowercase header names. |
| `$get` | `array``<``string``, ``mixed``>` |  |
| `$post` | `array``<``string``, ``mixed``>` |  |
| `$cookie` | `array``<``string``, ``string``>` |  |
| `$files` | `array``<``string``, ``mixed``>` | $_FILES-shaped. |
| `$rawContent` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`serverValue(string $key): ?string`](#servervalue) | Returns a server entry as a string, or null when it is absent or unusable. |

### serverValue()

`public function serverValue(string $key): ?string`

Returns a server entry as a string, or null when it is absent or unusable.

The key is Swoole's own lowercase name (`request_method`, not `REQUEST_METHOD`). A non-scalar value answers null rather than being coerced, so a caller's `??` default applies.

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |

Returns `?``string`
