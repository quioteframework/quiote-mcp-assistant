# Logging

> The Quiote\\Logging namespace — 16 documented types.

Everything under `Quiote\Logging`.

## Classes

| Class | Description |
|---|---|
| [`CategoryLogger`](/api/logging/category-logger/) | A PSR-3 logger bound to a single category. |
| [`Log`](/api/logging/log/) | Static facade for the logging subsystem: configuration (called in index.php before Kernel::run()) and logger acquisition (used everywhere else). |
| [`LogContext`](/api/logging/log-context/) | Ambient, stack-based logging context (Serilog LogContext / .NET BeginScope). |
| [`LogEvent`](/api/logging/log-event/) | An immutable structured log event. |
| [`LogRegistry`](/api/logging/log-registry/) | Process-global store of logging configuration: the default minimum level, the per-category minimum levels, and the registered sinks. |
| [`LoggerFactory`](/api/logging/logger-factory/) | Default [`LoggerFactoryInterface`](/api/logging/logger-factory-interface/): thin wrapper over the [`Log`](/api/logging/log/) facade (and thus [`LogRegistry`](/api/logging/log-registry/)) for constructor injection via the DI container. |
| [`ScopeToken`](/api/logging/scope-token/) | Handle to an active [`LogContext`](/api/logging/log-context/) scope frame. |

## Interfaces

| Interface | Description |
|---|---|
| [`LoggerFactoryInterface`](/api/logging/logger-factory-interface/) | DI-injectable factory for category loggers. |

## Enums

| Enum | Description |
|---|---|
| [`Level`](/api/logging/level/) | Ordinal log level with minimum-level (>=) semantics. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Sink`](/api/logging/sink/) | 7 types |
