# Event

> Base class for framework/domain events dispatched through Events.

Base class for framework/domain events dispatched through [`Events`](/api/event/events/).

A plain marker — it carries no state of its own; concrete events add their own readonly payload. Extend [`StoppableEvent`](/api/event/stoppable-event/) instead if listeners should be able to halt propagation (PSR-14 stoppable semantics).

This is deliberately separate from the request-pipeline middleware: middleware models the HTTP request/response lifecycle, events model framework/domain moments (kernel boot, route matched, action before/after, response sending) that plugins and app code hook into without inserting themselves into the PSR-15 stack.

## Synopsis

`abstract class Event`

|  |  |
|---|---|
| Source | `Event/Event.php` |
