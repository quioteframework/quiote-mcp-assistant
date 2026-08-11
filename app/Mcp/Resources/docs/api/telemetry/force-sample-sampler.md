# ForceSampleSampler

> Head-based force sampling: \"trace this one request\" without touching the global sampling ratio.

Head-based force sampling: "trace this one request" without touching the global sampling ratio.

Wraps a delegate sampler. If the span-creation attributes carry `quiote.force_sample = true` (set by `` when the configured force-sample header or PSR-7 request attribute is present), the decision is RECORD_AND_SAMPLE unconditionally — bypassing the delegate (ratio, parent, everything) for this span. Every other span defers entirely to the delegate.

This is a *head* decision made at span-creation time. Outcome-based ("keep failed/slow requests") tail sampling belongs in an OTel Collector downstream, not here.

## Synopsis

`final class ForceSampleSampler implements SamplerInterface`

|  |  |
|---|---|
| Implements | `SamplerInterface` |
| Source | `ForceSampleSampler.php` |

## Constructor

### __construct()

`public function __construct(SamplerInterface $delegate, string $attributeKey = 'quiote.force_sample'): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$delegate` | `SamplerInterface` |  |
| `$attributeKey` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getDescription(): string`](#getdescription) | The sampler's description for the exported resource, wrapping the delegate's own description so the effective configuration stays visible. |
| [`shouldSample(ContextInterface $parentContext, string $traceId, string $spanName, int $spanKind, AttributesInterface<non-empty-string, array|bool|float|int|string|null> $attributes, list<LinkInterface> $links): SamplingResult`](#shouldsample) | Returns SamplingResult. |

### getDescription()

`public function getDescription(): string`

The sampler's description for the exported resource, wrapping the delegate's own description so the effective configuration stays visible.

Returns `string`

### shouldSample()

`public function shouldSample(ContextInterface $parentContext, string $traceId, string $spanName, int $spanKind, AttributesInterface<non-empty-string, array|bool|float|int|string|null> $attributes, list<LinkInterface> $links): SamplingResult`

Returns SamplingResult.

Collection of links that will be associated with the Span to be created.
                    Typically, useful for batch operations.

| Parameter | Type | Description |
|---|---|---|
| `$parentContext` | `ContextInterface` | Context with parent Span. The Span's SpanContext may be invalid to indicate a root span. |
| `$traceId` | `string` | TraceId of the Span to be created. It can be different from the TraceId in the SpanContext. Typically in situations when the Span to be created starts a new Trace. |
| `$spanName` | `string` | Name of the Span to be created. |
| `$spanKind` | `int` | Span kind. |
| `$attributes` | `AttributesInterface``<``non-empty-string``, ``array``|``bool``|``float``|``int``|``string``|``null``>` | Initial set of Attributes for the Span being constructed. |
| `$links` | `list``<``LinkInterface``>` | Collection of links that will be associated with the Span to be created. Typically, useful for batch operations. |

Returns `SamplingResult`
