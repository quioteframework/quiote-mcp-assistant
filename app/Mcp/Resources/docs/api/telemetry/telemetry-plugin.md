# TelemetryPlugin

> Wires the OTel-SDK-dependent exporter bootstrap (TelemetryBootstrap) into the generic event seams instead of Kernel calling it by hard FQCN.

Wires the OTel-SDK-dependent exporter bootstrap ([`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/)) into the generic event seams instead of [`Kernel`](/api/runtime/kernel/) calling it by hard FQCN.

The always-on `Trace` facade this exporter feeds ([`Trace`](/api/telemetry/trace/), [`TraceRegistry`](/api/telemetry/trace-registry/), the no-op handles) stays in core regardless — only the SDK-backed provider setup/flush moves through this seam.

`KernelBootEvent` fires at the end of [`Quiote::bootstrap()`](/api/quiote/#bootstrap), which every `Quiote\Runtime\Kernel::bootstrap()` call already goes through before it used to call `TelemetryBootstrap::configureFromConfig()` directly — routing the same call through this listener changes nothing observable. `WorkerRequestCompletedEvent` fires once per request from `Kernel`'s worker-mode reset step, replacing the old direct `TelemetryBootstrap::flushAfterRequest()` call there.

Not yet an installable package (`Quiote\Telemetry\TelemetryBootstrap` and the OTel-SDK classes still live in this repo, and `Quiote::bootstrap()` runs this plugin unconditionally today — see the "core default" note there) — when the exporter moves to `quioteframework/telemetry-otel`, that core-default call is deleted and this plugin (unchanged) is registered via the `plugins` config key instead, exactly like [`McpPlugin`](/api/mcp/mcp-plugin/).

## Synopsis

`final class TelemetryPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `TelemetryPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Binds [`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/) to the kernel lifecycle events. |

### register()

`public function register(PluginRegistrar $registrar): void`

Binds [`TelemetryBootstrap`](/api/telemetry/telemetry-bootstrap/) to the kernel lifecycle events.

`KernelBootEvent` configures the providers and exporters from config; `WorkerRequestCompletedEvent` flushes them once per request in worker mode.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
