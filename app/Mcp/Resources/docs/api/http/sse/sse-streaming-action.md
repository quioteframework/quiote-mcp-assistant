# SseStreamingAction

> Actions implementing this interface bypass the normal Action/View dispatch entirely -- DispatchMiddleware detects it and streams the returned events directly as a `text/event-stream` response, with no caching, validation short-circuiting, or View involved.

Actions implementing this interface bypass the normal Action/View dispatch entirely -- DispatchMiddleware detects it and streams the returned events directly as a `text/event-stream` response, with no caching, validation short-circuiting, or View involved.

## Synopsis

`interface SseStreamingAction`

|  |  |
|---|---|
| Source | `Http/Sse/SseStreamingAction.php` |

## Methods

| Method | Description |
|---|---|
| [`streamEvents(WebRequest $request): iterable<SseEvent|string>`](#streamevents) |  |

### streamEvents()

`abstract public function streamEvents(WebRequest $request): iterable<SseEvent|string>`

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`WebRequest`](/api/request/web-request/) |  |

Returns `iterable``<`[`SseEvent`](/api/http/sse/sse-event/)`|``string``>`
