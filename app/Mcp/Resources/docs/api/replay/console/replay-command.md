# ReplayCommand

> `quiote replay <id>` -- re-runs a recorded cassette and reports drift, and, with `--as-test`, emits a committed regression test from it.

`quiote replay <id>` -- re-runs a recorded cassette and reports drift, and, with `--as-test`, emits a committed regression test from it.

The cassette is resolved via [`ResolvesCassetteViaIndexes`](/api/replay/console/resolves-cassette-via-indexes/): the local cache, then whichever store `replay.store` names, then -- given `--key`/`--date`/`--hour`, or none at all if a `log-analytics` index is configured -- the cassette-index chain. `--save` fetches and caches the cassette without replaying it, the same operation `quiote cassette:fetch` performs under its own name. `--live` is not offered -- see [`ReplayEngine`](/api/replay/replay/replay-engine/)'s docblock for why there is currently only one mode to run in.

## Synopsis

`final class ReplayCommand extends AbstractAppCommand`

|  |  |
|---|---|
| Extends | [`AbstractAppCommand`](/api/console/command/abstract-app-command/) |
| Uses | [`ResolvesCassetteViaIndexes`](/api/replay/console/resolves-cassette-via-indexes/) |
| Source | `Console/ReplayCommand.php` |

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
