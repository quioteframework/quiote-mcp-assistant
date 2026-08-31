# Randomness

> Static facade over the process-wide source of entropy, mirroring Clock.

Static facade over the process-wide source of entropy, mirroring [`Clock`](/api/support/clock/clock/).

[`CorrelationId`](/api/support/correlation-id/) is fully static (no constructor, no container) by design -- its own docblock states it is kept pure and dependency-free so it is unit testable without a bootstrapped [`Context`](/api/context/). This is its way in. Code that can accept a collaborator should take a RandomnessInterface constructor parameter instead -- it is injectable, swappable and testable in isolation -- and reach for this only where threading one through is not practical.

Deliberately not read from the DI container, for the same reason [`Clock`](/api/support/clock/clock/) is not: a fully static call site has no request-scoped `Context` to resolve through in general, and `Quiote\Context::registerCoreServicesInContainer()` seeds the container's own `RandomnessInterface` binding from [`Randomness::instance()`](/api/support/random/randomness/#instance), not the other way round, so installing a source of randomness here before bootstrap also reaches the container.

## Synopsis

`final class Randomness`

|  |  |
|---|---|
| Source | `Support/Random/Randomness.php` |

## Methods

| Method | Description |
|---|---|
| [`instance(): RandomnessInterface`](#instance) | The randomness backing the facade, created on first use. |
| [`useRandomness(?RandomnessInterface $randomness): ?RandomnessInterface`](#userandomness) | Install a source of randomness for the facade to delegate to. |

### instance()

`public static function instance(): RandomnessInterface`

The randomness backing the facade, created on first use.

Returns [`RandomnessInterface`](/api/support/random/randomness-interface/)

### useRandomness()

`public static function useRandomness(?RandomnessInterface $randomness): ?RandomnessInterface`

Install a source of randomness for the facade to delegate to.

The seam for a test that needs reproducible output. Pass null to drop the current one, so the next access starts from a fresh SystemRandomness.

| Parameter | Type | Description |
|---|---|---|
| `$randomness` | `?`[`RandomnessInterface`](/api/support/random/randomness-interface/) |  |

Returns `?`[`RandomnessInterface`](/api/support/random/randomness-interface/) — The source that was installed before this call, so a caller can restore it.
