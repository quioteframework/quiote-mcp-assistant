# API reference

> Every class, interface, trait and enum the framework ships — 744 types across 42 namespaces.

This reference is generated from the source, so it describes the version you have installed rather than a release note. Each namespace below lists its own types; a type's page carries its methods, the types they take and return, and where each one is declared.

For how the pieces fit together, start from the guides instead: [the request lifecycle](/architecture/request-lifecycle/) explains the path a request takes, and [actions and views](/architecture/actions-and-views/) covers the two classes you write most.

## Namespaces

| Namespace | Contents |
|---|---|
| [`Quiote\Action`](/api/action/) | 3 types |
| [`Quiote\Asset`](/api/asset/) | 1 type |
| [`Quiote\Cache`](/api/cache/) | 5 types |
| [`Quiote\Config`](/api/config/) | 67 types |
| [`Quiote\Console`](/api/console/) | 18 types |
| [`Quiote\Controller`](/api/controller/) | 4 types |
| [`Quiote\DI`](/api/di/) | 6 types |
| [`Quiote\Database`](/api/database/) | 16 types |
| [`Quiote\Docs`](/api/docs/) | 26 types |
| [`Quiote\Event`](/api/event/) | 12 types |
| [`Quiote\Exception`](/api/exception/) | 27 types |
| [`Quiote\Execution`](/api/execution/) | 33 types |
| [`Quiote\Filesystem`](/api/filesystem/) | 16 types |
| [`Quiote\Http`](/api/http/) | 21 types |
| [`Quiote\I18n`](/api/i18n/) | 1 type |
| [`Quiote\Introspection`](/api/introspection/) | 2 types |
| [`Quiote\Logging`](/api/logging/) | 16 types |
| [`Quiote\Mcp`](/api/mcp/) | 16 types |
| [`Quiote\Middleware`](/api/middleware/) | 29 types |
| [`Quiote\Model`](/api/model/) | 6 types |
| [`Quiote\Openapi`](/api/openapi/) | 3 types |
| [`Quiote\Plugin`](/api/plugin/) | 5 types |
| [`Quiote\Queue`](/api/queue/) | 29 types |
| [`Quiote\Rector`](/api/rector/) | 11 types |
| [`Quiote\Renderer`](/api/renderer/) | 7 types |
| [`Quiote\Request`](/api/request/) | 25 types |
| [`Quiote\Response`](/api/response/) | 4 types |
| [`Quiote\Routing`](/api/routing/) | 27 types |
| [`Quiote\Runtime`](/api/runtime/) | 35 types |
| [`Quiote\Scheduler`](/api/scheduler/) | 8 types |
| [`Quiote\Security`](/api/security/) | 59 types |
| [`Quiote\Service`](/api/service/) | 2 types |
| [`Quiote\Session`](/api/session/) | 19 types |
| [`Quiote\Storage`](/api/storage/) | 19 types |
| [`Quiote\Support`](/api/support/) | 7 types |
| [`Quiote\Telemetry`](/api/telemetry/) | 36 types |
| [`Quiote\Testing`](/api/testing/) | 21 types |
| [`Quiote\Translation`](/api/translation/) | 11 types |
| [`Quiote\User`](/api/user/) | 5 types |
| [`Quiote\Util`](/api/util/) | 26 types |
| [`Quiote\Validator`](/api/validator/) | 49 types |
| [`Quiote\View`](/api/view/) | 4 types |

## At the root

| Type | Description |
|---|---|
| [`Context`](/api/context/) | An execution profile -- web, console, a named one -- and the container its services resolve from. |
| [`ContextComponentInterface`](/api/context-component-interface/) | A core component the [`Context`](/api/context/) constructs from the factory metadata captured at [`Context::initialize()`](/api/context/#initialize) and drives through a two-step lifecycle. |
| [`ContextInterface`](/api/context-interface/) | What a collaborator needs from the application context: which profile this execution belongs to, and a way to reach its services. |
| [`ContextLifecycle`](/api/context-lifecycle/) | A context's per-request state machine: armed, claimed, cleared, armed again. |
| [`ContextRegistry`](/api/context-registry/) | Owns the live [`Context`](/api/context/) instances -- one per named profile. |
| [`Quiote`](/api/quiote/) | Main framework class used for autoloading and initial bootstrapping of Quiote. |
| [`ShutdownSequence`](/api/shutdown-sequence/) | The ordered list of components to shut down, and the operations on that order. |
