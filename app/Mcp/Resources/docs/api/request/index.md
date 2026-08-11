# Request

> The Quiote\\Request namespace — 25 documented types.

Everything under `Quiote\Request`.

## Classes

| Class | Description |
|---|---|
| [`BracketPath`](/api/request/bracket-path/) | Stateless resolution of legacy bracket-path parameter names (e.g. |
| [`RequestDtoMapper`](/api/request/request-dto-mapper/) | Constructs a #[MapRequest] DTO instance from an already-validated WebRequest. |
| [`RequestDtoRegistry`](/api/request/request-dto-registry/) | In-process cache for #[MapRequest] reflection results, mirroring Quiote\DI\Container::classPlan()'s per-class caching style: a DTO's shape never changes mid-process, so both the parsed RequestDtoDefinition and the "which execute*() parameter (if any) is a #[MapRequest] DTO" lookup are computed once and reused for the life of the worker/request. |
| [`RequestParameterStore`](/api/request/request-parameter-store/) | Immutable holder for WebRequest's runtime (internal) parameters and the strict-validation whitelist. |
| [`RequestState`](/api/request/request-state/) | The seam onto the request that is current *now*. |
| [`RequestUrl`](/api/request/request-url/) | Immutable holder for the URL metadata WebRequest exposes alongside the wrapped PSR-7 request: scheme, host, port, path, query, and the derived request URI / full URL / protocol string. |
| [`TrustedHosts`](/api/request/trusted-hosts/) | The `core.trusted_hosts` allow-list, applied to a hostname taken from the request. |
| [`WebRequest`](/api/request/web-request/) | WebRequest provides additional support for web-only client requests such as cookie and file manipulation. |

## Traits

| Trait | Description |
|---|---|
| [`Psr7DelegationTrait`](/api/request/psr7-delegation-trait/) | Pure one-line delegations to the wrapped Nyholm\Psr7\ServerRequest. |
| [`Psr7RequestTrait`](/api/request/psr7-request-trait/) | Reading and stripping of intrinsic PSR-7 request data, used by [`WebRequest`](/api/request/web-request/). |
| [`RequestInspectionTrait`](/api/request/request-inspection-trait/) | "Is this field empty/absent?" convenience helpers shared by WebRequest, one per input source (parameter, cookie, header, file). |
| [`UploadedFileAccessTrait`](/api/request/uploaded-file-access-trait/) | Convenience accessors returning flat lists of UploadedFileInterface instances, hiding PSR-7's nested-array upload structure from callers. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Attribute`](/api/request/attribute/) | 10 types |
| [`Compiler`](/api/request/compiler/) | 3 types |
