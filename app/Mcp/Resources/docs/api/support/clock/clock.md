# Clock

> Static facade over the process-wide clock, mirroring Config.

Static facade over the process-wide clock, mirroring [`Config`](/api/config/config/).

A handful of framework classes are fully static (no constructor, no container) and have no seam to receive a [`ClockInterface`](/api/support/clock/clock-interface/) through -- [`CacheManager`](/api/cache/cache-manager/), [`APCuConfigCache`](/api/config/apcu-config-cache/), [`WorkerManager`](/api/util/worker-manager/) among them. This is their way in. Code that can accept a collaborator should take a ClockInterface constructor parameter instead -- it is injectable, swappable and testable in isolation -- and reach for this only where threading one through is not practical.

Deliberately not read from the DI container: [`Config`](/api/config/config/) isn't either, for the same reason -- a fully static call site has no request-scoped `Context` to resolve through in general, and `Quiote\Context::registerCoreServicesInContainer()` seeds the container's own `ClockInterface` binding from [`Clock::instance()`](/api/support/clock/clock/#instance), not the other way round, so installing a clock here before bootstrap also reaches the container.

## Synopsis

`final class Clock`

|  |  |
|---|---|
| Source | `Support/Clock/Clock.php` |

## Methods

| Method | Description |
|---|---|
| [`instance(): ClockInterface`](#instance) | The clock backing the facade, created on first use. |
| [`useClock(?ClockInterface $clock): ?ClockInterface`](#useclock) | Install a clock for the facade to delegate to. |

### instance()

`public static function instance(): ClockInterface`

The clock backing the facade, created on first use.

Returns [`ClockInterface`](/api/support/clock/clock-interface/)

### useClock()

`public static function useClock(?ClockInterface $clock): ?ClockInterface`

Install a clock for the facade to delegate to.

The seam for a test that needs a clock of its own. Pass null to drop the current one, so the next access starts from a fresh SystemClock.

| Parameter | Type | Description |
|---|---|---|
| `$clock` | `?`[`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `?`[`ClockInterface`](/api/support/clock/clock-interface/) — The clock that was installed before this call, so a caller can restore it.
