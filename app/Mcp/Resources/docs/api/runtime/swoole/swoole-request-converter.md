# SwooleRequestConverter

> Turns a SwooleRequestSnapshot into a PSR-7 request.

Turns a [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/) into a PSR-7 request.

Swoole hands over its own request shape rather than CGI-style server params, so this is where the two are reconciled. Three details are easy to get wrong and each breaks something specific:

- `$request->server` keys are **lowercase** (`request_method`, not `REQUEST_METHOD`), so everything reading CGI names sees nothing unless they are translated. - Swoole supplies no `SCRIPT_NAME`. `Quiote\Routing\Routing` reads it when generating URLs, so omitting it corrupts generated links rather than failing loudly. Hence [`SwooleConverterOptions::$scriptName`](/api/runtime/swoole/swoole-converter-options/#scriptname). - `content-type`/`content-length` become bare `CONTENT_TYPE`/`CONTENT_LENGTH` without the `HTTP_` prefix, matching CGI -- `Quiote\Request\WebRequest` reads `$_SERVER['CONTENT_TYPE']` directly.

Reverse-proxy correction is deliberately *not* done here: every runtime funnels through [`WorkerRequestFactory`](/api/runtime/request/worker-request-factory/), which applies it uniformly.

## Synopsis

`final class SwooleRequestConverter`

|  |  |
|---|---|
| Source | `SwooleRequestConverter.php` |

## Constructor

### __construct()

`public function __construct(SwooleConverterOptions $options = new SwooleConverterOptions(…), Psr17Factory $psr17 = new Psr17Factory(…), ClockInterface $clock = new SystemClock(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$options` | [`SwooleConverterOptions`](/api/runtime/swoole/swoole-converter-options/) |  |
| `$psr17` | `Psr17Factory` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`toPsr7(SwooleRequestSnapshot $snapshot): ServerRequestInterface`](#topsr7) | Builds a PSR-7 server request from a Swoole request snapshot. |

### toPsr7()

`public function toPsr7(SwooleRequestSnapshot $snapshot): ServerRequestInterface`

Builds a PSR-7 server request from a Swoole request snapshot.

Swoole's lowercase server keys are translated to CGI names, the request target gets its query string re-attached, and headers, cookies, query params and uploaded files are carried across. The parsed body is only set when Swoole itself parsed a form body — a JSON or other raw body is left unparsed so downstream payload handling can read it off the stream.

| Parameter | Type | Description |
|---|---|---|
| `$snapshot` | [`SwooleRequestSnapshot`](/api/runtime/swoole/swoole-request-snapshot/) |  |

Returns [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/)
