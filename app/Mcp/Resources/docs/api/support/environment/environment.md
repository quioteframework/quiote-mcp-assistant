# Environment

> Static facade over the process-wide environment reader, mirroring Clock and Randomness.

Static facade over the process-wide environment reader, mirroring [`Clock`](/api/support/clock/clock/) and [`Randomness`](/api/support/random/randomness/).

A handful of framework classes are fully static or construct their own collaborators before a container exists and have no seam to receive an [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) through. This is their way in. Code that can accept a collaborator should take an EnvironmentReaderInterface constructor parameter instead -- it is injectable, swappable and testable in isolation -- and reach for this only where threading one through is not practical.

Deliberately not read from the DI container, for the same reason [`Clock`](/api/support/clock/clock/) is not: a fully static call site has no request-scoped `Context` to resolve through in general, and `Quiote\Context::registerCoreServicesInContainer()` seeds the container's own `EnvironmentReaderInterface` binding from [`Environment::instance()`](/api/support/environment/environment/#instance), not the other way round, so installing a reader here before bootstrap also reaches the container.

## Synopsis

`final class Environment`

|  |  |
|---|---|
| Source | `Support/Environment/Environment.php` |

## Methods

| Method | Description |
|---|---|
| [`instance(): EnvironmentReaderInterface`](#instance) | The reader backing the facade, created on first use. |
| [`useEnvironmentReader(?EnvironmentReaderInterface $reader): ?EnvironmentReaderInterface`](#useenvironmentreader) | Install a reader for the facade to delegate to. |

### instance()

`public static function instance(): EnvironmentReaderInterface`

The reader backing the facade, created on first use.

Returns [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/)

### useEnvironmentReader()

`public static function useEnvironmentReader(?EnvironmentReaderInterface $reader): ?EnvironmentReaderInterface`

Install a reader for the facade to delegate to.

The seam for a test that needs a reader of its own. Pass null to drop the current one, so the next access starts from a fresh SystemEnvironmentReader.

| Parameter | Type | Description |
|---|---|---|
| `$reader` | `?`[`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) |  |

Returns `?`[`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) — The reader that was installed before this call, so a caller can restore it.
