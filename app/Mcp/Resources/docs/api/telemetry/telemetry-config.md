# TelemetryConfig

> The `telemetry.*` settings, read once and resolved into concrete values.

The `telemetry.*` settings, read once and resolved into concrete values.

Every decision that depends on configuration or on the environment is made here, so the factories that build exporters and providers take plain values and can be exercised without touching process-wide config. That is the whole point of the separation: the interesting part of telemetry setup is which exporter and sampler you end up with, and testing that should not require mutating globals.

## Synopsis

`final readonly class TelemetryConfig`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `TelemetryConfig.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$exportMode` | `string` | _readonly._ |
| `$exporter` | `string` | _readonly._ |
| `$otlpEndpoint` | `string` | _readonly._ |
| `$otlpHeaders` | `array` | _readonly._ |
| `$otlpProtocol` | `string` | _readonly._ |
| `$resourceAttributes` | `array` | _readonly._ |
| `$samplingRatio` | `float` | _readonly._ |
| `$samplingStrategy` | `string` | _readonly._ |
| `$serviceName` | `string` | _readonly._ |
| `$serviceNamespace` | `string` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $serviceName, string $serviceNamespace, array<string, mixed> $resourceAttributes, string $exporter, string $exportMode, string $samplingStrategy, float $samplingRatio, string $otlpEndpoint, string $otlpProtocol, array<string, string> $otlpHeaders): mixed`

Header name => value, already stringified.

| Parameter | Type | Description |
|---|---|---|
| `$serviceName` | `string` |  |
| `$serviceNamespace` | `string` |  |
| `$resourceAttributes` | `array``<``string``, ``mixed``>` | Extra resource attributes. |
| `$exporter` | `string` |  |
| `$exportMode` | `string` |  |
| `$samplingStrategy` | `string` |  |
| `$samplingRatio` | `float` |  |
| `$otlpEndpoint` | `string` |  |
| `$otlpProtocol` | `string` |  |
| `$otlpHeaders` | `array``<``string``, ``string``>` | Header name => value, already stringified. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromConfig(): TelemetryConfig`](#fromconfig) | Read the settings, resolving the defaults that depend on the environment. |

### fromConfig()

`public static function fromConfig(): TelemetryConfig`

Read the settings, resolving the defaults that depend on the environment.

The export mode defaults by runtime: batching only pays off when the process outlives the request. This is read during boot, before the Kernel has selected a runtime, so WorkerRuntimeInfo answers from auto-detection rather than from an installed runtime -- which is correct, because plugins (including any contributing a runtime) have already registered.

Returns [`TelemetryConfig`](/api/telemetry/telemetry-config/)
