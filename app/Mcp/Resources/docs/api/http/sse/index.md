# Sse

> The Quiote\\Http\\Sse namespace — 3 documented types.

Everything under `Quiote\Http\Sse`.

## Classes

| Class | Description |
|---|---|
| [`SseEvent`](/api/http/sse/sse-event/) | A single Server-Sent Events wire-format message. |
| [`SseStream`](/api/http/sse/sse-stream/) | A write-once PSR-7 stream backed by an iterable of SseEvent (or plain string) items, typically a generator produced by an SseStreamingAction::streamEvents() implementation. |

## Interfaces

| Interface | Description |
|---|---|
| [`SseStreamingAction`](/api/http/sse/sse-streaming-action/) | Actions implementing this interface bypass the normal Action/View dispatch entirely -- DispatchMiddleware detects it and streams the returned events directly as a `text/event-stream` response, with no caching, validation short-circuiting, or View involved. |
