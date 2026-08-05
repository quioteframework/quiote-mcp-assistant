# Server-Sent Events

> Streaming a text/event-stream response from an action with SseStreamingAction and SseEvent, and how streaming differs per worker runtime.

Everything else in Quiote's response pipeline is **string-buffered**: a View's `execute{OutputType}()` return value is cast to a final string before `DispatchMiddleware` ever sees it, and the emitter sends the whole body in one go. `Quiote\Http\Sse\SseStreamingAction` is the one deliberate exception — an action that produces events *incrementally*, flushed to the client as they are yielded.

## Writing a streaming action

Implement the interface on an ordinary action and yield events from `streamEvents()`:

```php
<?php
namespace App\Modules\Live\Actions;

use Quiote\Action\Action;
use Quiote\Http\Sse\SseEvent;
use Quiote\Http\Sse\SseStreamingAction;
use Quiote\Request\WebRequest;

class TickerAction extends Action implements SseStreamingAction
{
    public function isSimple(): bool { return true; }

    public function streamEvents(WebRequest $request): iterable
    {
        for ($i = 0; $i < 10; $i++) {
            yield SseEvent::of(['tick' => $i], event: 'tick');
            sleep(1);
        }
    }
}
```

`streamEvents()` returns any `iterable` of `SseEvent` or plain `string` — a generator is the usual choice, since that's what makes the events arrive one at a time rather than all at the end. A plain string is wrapped as a data-only event.

The response is built for you with the headers a streaming endpoint needs:

| Header | Value | Why |
|---|---|---|
| `Content-Type` | `text/event-stream` | What makes the browser's `EventSource` accept it. |
| `Cache-Control` | `no-cache` | An event stream must never be cached. |
| `Connection` | `keep-alive` | The connection stays open for the stream's lifetime. |
| `X-Accel-Buffering` | `no` | Stops nginx and Caddy buffering the proxied response — without it a reverse proxy will happily hold your events and deliver them in one lump. |

### Building events

```php
new SseEvent(string $data, ?string $event = null, ?string $id = null, ?int $retryMs = null)
SseEvent::of(string|array $data, ?string $event = null, ?string $id = null, ?int $retryMs = null)
```

`SseEvent::of()` is the convenient form: an array argument is JSON-encoded for you. The optional fields map directly onto the [SSE wire format](https://html.spec.whatwg.org/multipage/server-sent-events.html#event-stream-interpretation) — `event` names the event type (so the client can `addEventListener('tick', …)`), `id` sets the last-event-id the browser will send back on reconnect, and `retryMs` tells the browser how long to wait before reconnecting. Multi-line `data` is split into one `data:` line per line, as the spec requires.

## What a streaming action skips

A streaming action is a **parallel dispatch path**, not a new output type. `DispatchMiddleware` detects the interface and short-circuits, so these actions bypass:

- **The View layer entirely.** There is no View, no Template, no output type. `streamEvents()` *is* the response body.
- **Caching.** A stream has nothing to cache.
- **Validation-decision bridging.** Reach for the request object directly if the stream is parameterised.

That is a design choice worth explaining, because "why isn't this just an output type?" is the obvious question. A View's return value is cast to a string before the middleware sees it, so there was no seam in that contract to hang incremental output off of — supporting streaming through the View layer would have meant either rewriting that contract or bolting an exception onto it. A separate opt-in path keeps the ordinary case unchanged and makes the streaming case honest about what does and doesn't apply to it.

## Streaming per runtime

All four shipped [worker runtimes](/architecture/deployment/#choosing-a-runtime) stream, but only some can tell that the client has gone away — which matters a great deal if your stream is endless.

| Runtime | How events are sent | Client-disconnect signal |
|---|---|---|
| `sapi` | `echo` + `flush()` per event | `connection_aborted()` |
| `frankenphp` | as `sapi` | `connection_aborted()` |
| `roadrunner` | one relay frame per event | **none** |
| `swoole` | one `write()` per event | `write()` returning `false` |

Under RoadRunner there is **no disconnect signal available to the worker at all**. An endless stream there ends when the server recycles the worker, not when the browser closes the tab. If you deploy on RoadRunner, bound your streams — a maximum event count, a deadline, or a heartbeat the client must answer.

Swoole cannot use `connection_aborted()` (off-SAPI it always reports `0`), which is why it keys off the `write()` return value instead.

:::caution[True byte-at-a-time delivery also depends on php.ini]
The framework flushes after each event, but it deliberately does **not** tear down userland output buffers it didn't set up itself — doing so would also destroy any buffer a caller or test had wrapped around the emit. For genuinely incremental delivery, `output_buffering` must be off at the php.ini/webserver level. The `X-Accel-Buffering: no` header covers the reverse-proxy half of this problem; the php.ini half is yours.
:::

Streaming works unchanged under FrankenPHP worker mode, because flushing happens within a single request-handling callback — exactly as it does under classic PHP-FPM.

## Draining the stream yourself

`SseStream` is a PSR-7 `StreamInterface`, so it turns up wherever a response body does. It can be drained three ways, and **only one per instance**:

| Way | Used by |
|---|---|
| `writeTo($sink)` — push loop, stops early when the sink says the client is gone | the SAPI/FrankenPHP emitter |
| `read()` / `eof()` — incremental pull, chunk at a time | the RoadRunner responder |
| `getContents()` / `(string)` — buffers everything in one pass | dev-exception rendering, `HttpTestCase` assertions |

The backing iterable can only be traversed once, so mixing them **throws** rather than silently dropping events. In practice this only bites if you write your own emitter or inspect a streaming response's body and then let it be emitted as well.
