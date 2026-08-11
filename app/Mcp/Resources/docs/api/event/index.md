# Event

> The Quiote\\Event namespace — 12 documented types.

Everything under `Quiote\Event`.

## Classes

| Class | Description |
|---|---|
| [`Event`](/api/event/event/) | Base class for framework/domain events dispatched through [`Events`](/api/event/events/). |
| [`EventDispatcher`](/api/event/event-dispatcher/) | A minimal PSR-14 dispatcher over a [`ListenerProvider`](/api/event/listener-provider/). |
| [`Events`](/api/event/events/) | Static facade for the event subsystem, mirroring [`Log`](/api/logging/log/) and [`Trace`](/api/telemetry/trace/): a process-global, worker-lifetime listener registry configured once (typically by plugins at boot) and used everywhere via the facade, with no per-request wiring. |
| [`ListenerProvider`](/api/event/listener-provider/) | Priority-ordered PSR-14 listener provider. |
| [`StoppableEvent`](/api/event/stoppable-event/) | An [`Event`](/api/event/event/) whose propagation a listener can halt. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Lifecycle`](/api/event/lifecycle/) | 7 types |
