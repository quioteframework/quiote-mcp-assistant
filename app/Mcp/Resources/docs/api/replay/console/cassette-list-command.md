# CassetteListCommand

> `cassette:list` -- enumerates the configured store, via whichever ListableCassetteStoreInterface `replay.store` resolves to (see ResolvesCassetteStore) -- the file store's own directory listing, or `quioteframework/replay-pdo`'s table, today; an object-store-backed one would use its own `listObjects()` instead, not this interface.

`cassette:list` -- enumerates the configured store, via whichever [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) `replay.store` resolves to (see [`ResolvesCassetteStore`](/api/replay/console/resolves-cassette-store/)) -- the file store's own directory listing, or `quioteframework/replay-pdo`'s table, today; an object-store-backed one would use its own `listObjects()` instead, not this interface.

`--stale` is deliberately not offered yet: staleness is a comparison against `meta.source_hash`, and no cassette this package writes carries one yet (that needs `AppIntrospectionCompiler`'s hashing, out of scope for this step) -- a flag that could never filter anything meaningfully would be worse than no flag.

## Synopsis

`final class CassetteListCommand extends AbstractAppCommand`

|  |  |
|---|---|
| Extends | [`AbstractAppCommand`](/api/console/command/abstract-app-command/) |
| Uses | [`CollectsCassetteRows`](/api/replay/console/collects-cassette-rows/), [`ResolvesCassetteStore`](/api/replay/console/resolves-cassette-store/) |
| Source | `Console/CassetteListCommand.php` |

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
