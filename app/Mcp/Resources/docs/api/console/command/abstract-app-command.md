# AbstractAppCommand

> Base for commands that need a bootstrapped Quiote application (as opposed to `new`, which is deliberately pre-bootstrap -- see NewCommand).

Base for commands that need a bootstrapped Quiote application (as opposed to `new`, which is deliberately pre-bootstrap -- see NewCommand).

Adds the `--app-dir`/`--env` options and the app-dir resolution + Quiote::bootstrap() wiring. App-dir/env resolution itself is [`AppDirResolver`](/api/console/app-dir-resolver/) (shared with `bin/quiote`'s best-effort pre-bootstrap).

If `core.app_dir` is already set (e.g. a test harness bootstrapped it before invoking the command via CommandTester), that value wins and no resolution/re-bootstrap of app-dir happens -- only the environment is (re-)applied, which Quiote::bootstrap() already treats idempotently.

## Synopsis

`abstract class AbstractAppCommand extends Command`

|  |  |
|---|---|
| Extends | `Command` |
| Since | `1.0.0` |
| Source | `Console/Command/AbstractAppCommand.php` |

## Methods

| Method | Description |
|---|---|
| [`bootstrapApp(InputInterface $input): void`](#bootstrapapp) |  |
| [`configureAppOptions(): void`](#configureappoptions) |  |

### bootstrapApp()

`protected function bootstrapApp(InputInterface $input): void`

| Parameter | Type | Description |
|---|---|---|
| `$input` | `InputInterface` |  |

### configureAppOptions()

`protected function configureAppOptions(): void`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addArgument()` | `Command` | Adds an argument. |
| `addOption()` | `Command` | Adds an option. |
| `addUsage()` | `Command` | Add a command usage example, it'll be prefixed with the command name. |
| `complete()` | `Command` | Supplies suggestions when resolving possible completion options for input (e.g. |
| `getAliases()` | `Command` | Returns the aliases for the command. |
| `getApplication()` | `Command` | Gets the application instance for this command. |
| `getCode()` | `Command` | Gets the code that is executed by the command. |
| `getDefinition()` | `Command` | Gets the InputDefinition attached to this Command. |
| `getDescription()` | `Command` | Returns the description for the command. |
| `getHelp()` | `Command` | Returns the help for the command. |
| `getHelper()` | `Command` | Gets a helper instance by name. |
| `getHelperSet()` | `Command` | Gets the helper set. |
| `getName()` | `Command` | Returns the command name. |
| `getNativeDefinition()` | `Command` | Gets the InputDefinition to be used to create representations of this Command. |
| `getProcessedHelp()` | `Command` | Returns the processed help for the command replacing the %command.name% and %command.full_name% patterns with the real values dynamically. |
| `getSubscribedSignals()` | `Command` |  |
| `getSynopsis()` | `Command` | Returns the synopsis for the command. |
| `getUsages()` | `Command` | Returns alternative usages of the command. |
| `handleSignal()` | `Command` |  |
| `ignoreValidationErrors()` | `Command` | Ignores validation errors. |
| `isEnabled()` | `Command` | Checks whether the command is enabled or not in the current environment. |
| `isHidden()` | `Command` |  |
| `run()` | `Command` | Runs the command. |
| `setAliases()` | `Command` | Sets the aliases for the command. |
| `setApplication()` | `Command` |  |
| `setCode()` | `Command` | Sets the code to execute when running this command. |
| `setDefinition()` | `Command` | Sets an array of argument and option instances. |
| `setDescription()` | `Command` | Sets the description for the command. |
| `setHelp()` | `Command` | Sets the help for the command. |
| `setHelperSet()` | `Command` |  |
| `setHidden()` | `Command` |  |
| `setName()` | `Command` | Sets the name of the command. |
| `setProcessTitle()` | `Command` | Sets the process title of the command. |
