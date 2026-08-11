# Application

> The `quiote` CLI.

The `quiote` CLI.

`new` is pre-bootstrap (it scaffolds an app from nothing, so there is no Quiote\Context to build yet); `about` and `routes:list` bootstrap an existing app via AbstractAppCommand's app-dir resolution + Quiote::bootstrap() wiring. `telemetry:dashboard` now lives in its own package, `packages/telemetry-dashboard/`, and is only registered when that package (and therefore `symfony/tui`) is actually installed -- a production install without it simply doesn't offer the command, mirroring how the `open-telemetry/*` packages are optional everywhere else. Registered eagerly here (not through the generic plugin-command-contribution seam) because `bin/quiote` builds this `Application` before any `Quiote::bootstrap()` call -- a plugin-contributed command would only appear once a bootstrap had already run in the same process, which would silently break `bin/quiote telemetry:dashboard` used standalone.

## Synopsis

`final class Application extends Application`

|  |  |
|---|---|
| Extends | `Application` |
| Since | `1.0.0` |
| Source | `Console/Application.php` |

## Constructor

### __construct()

`public function __construct(): mixed`

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`addContributedCommands(): void`](#addcontributedcommands) | Register console commands contributed by plugins via [`PluginRegistrar::command()`](/api/plugin/plugin-registrar/#command). |

### addContributedCommands()

`public function addContributedCommands(): void`

Register console commands contributed by plugins via [`PluginRegistrar::command()`](/api/plugin/plugin-registrar/#command).

Idempotent: safe to call again after a bootstrap has populated the registry (each command is only added once). Note the boundary: `bin/quiote` builds this Application before any bootstrap, so plugin commands appear only once a bootstrap has run in the same process (e.g. a programmatic `new Application()` after `Quiote::bootstrap()`).

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addCommand()` | `Application` | Adds a command object. |
| `addCommands()` | `Application` | Adds an array of command objects. |
| `all()` | `Application` | Gets the commands (registered in the given namespace if provided). |
| `areExceptionsCaught()` | `Application` | Gets whether to catch exceptions or not during commands execution. |
| `complete()` | `Application` | Adds suggestions to $suggestions for the current completion input (e.g. |
| `doRun()` | `Application` | Runs the current application. |
| `extractNamespace()` | `Application` | Returns the namespace part of the command name. |
| `find()` | `Application` | Finds a command by name or alias. |
| `findNamespace()` | `Application` | Finds a registered namespace by a name or an abbreviation. |
| `get()` | `Application` | Returns a registered command by name or alias. |
| `getAbbreviations()` | `Application` | Returns an array of possible abbreviations given a set of names. |
| `getAlarmInterval()` | `Application` | Gets the interval in seconds on which a SIGALRM signal is dispatched. |
| `getArgumentResolver()` | `Application` |  |
| `getDefinition()` | `Application` | Gets the InputDefinition related to this Application. |
| `getDispatcher()` | `Application` |  |
| `getHelp()` | `Application` | Gets the help message. |
| `getHelperSet()` | `Application` | Get the helper set associated with the command. |
| `getLongVersion()` | `Application` | Returns the long version of the application. |
| `getName()` | `Application` | Gets the name of the application. |
| `getNamespaces()` | `Application` | Returns an array of all unique namespaces used by currently registered commands. |
| `getSignalRegistry()` | `Application` |  |
| `getVersion()` | `Application` | Gets the application version. |
| `has()` | `Application` | Returns true if the command exists, false otherwise. |
| `isAutoExitEnabled()` | `Application` | Gets whether to automatically exit after a command execution or not. |
| `register()` | `Application` | Registers a new command. |
| `renderThrowable()` | `Application` |  |
| `reset()` | `Application` |  |
| `run()` | `Application` | Runs the current application. |
| `setAlarmInterval()` | `Application` | Sets the interval to schedule a SIGALRM signal in seconds. |
| `setArgumentResolver()` | `Application` |  |
| `setAutoExit()` | `Application` | Sets whether to automatically exit after a command execution or not. |
| `setCatchErrors()` | `Application` | Sets whether to catch errors or not during commands execution. |
| `setCatchExceptions()` | `Application` | Sets whether to catch exceptions or not during commands execution. |
| `setCommandLoader()` | `Application` |  |
| `setDefaultCommand()` | `Application` | Sets the default Command name. |
| `setDefinition()` | `Application` |  |
| `setDispatcher()` | `Application` |  |
| `setHelperSet()` | `Application` |  |
| `setName()` | `Application` | Sets the application name. |
| `setSignalsToDispatchEvent()` | `Application` |  |
| `setVersion()` | `Application` | Sets the application version. |
