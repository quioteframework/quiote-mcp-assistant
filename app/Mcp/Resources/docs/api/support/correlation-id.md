# CorrelationId

> Resolves a per-request correlation ID: adopt a sane inbound header value if present, else generate a fresh one.

Resolves a per-request correlation ID: adopt a sane inbound header value if present, else generate a fresh one.

Pure and dependency-free so it is unit testable without a bootstrapped [`Context`](/api/context/); the Context wires the configured header name / expose flag around it.

## Synopsis

`final class CorrelationId`

|  |  |
|---|---|
| Source | `Support/CorrelationId.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `DEFAULT_HEADER` | `'X-Correlation-Id'` |  |

## Methods

| Method | Description |
|---|---|
| [`fromRequest(ServerRequestInterface $request, string $header = self::DEFAULT_HEADER): ?string`](#fromrequest) | The sanitized inbound correlation ID from $header, or null when absent or empty after sanitization. |
| [`generate(): string`](#generate) | A fresh high-entropy correlation ID (URL/log-safe), with a non-crypto fallback. |

### fromRequest()

`public static function fromRequest(ServerRequestInterface $request, string $header = self::DEFAULT_HEADER): ?string`

The sanitized inbound correlation ID from $header, or null when absent or empty after sanitization.

The value is untrusted (it is echoed into a response header and log lines), so control bytes — CR/LF included, the header/log-injection vector — are stripped and the length is capped.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$header` | `string` |  |

Returns `?``string`

### generate()

`public static function generate(): string`

A fresh high-entropy correlation ID (URL/log-safe), with a non-crypto fallback.

base64url, not `strtr($b64, '+/=', 'ABC')`: mapping the three non-alphanumeric characters onto `A`/`B`/`C` collides them with genuine `A`/`B`/`C` output, which throws away entropy for no reason -- and it consumed the padding itself, leaving the following `rtrim($x, '=')` with nothing to strip and literal `C`s on the end of every id.

Returns `string`
