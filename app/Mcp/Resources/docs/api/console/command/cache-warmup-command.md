# CacheWarmupCommand

> Compiles the app's configuration ahead of time so a freshly started worker starts warm instead of paying the first-request cost of parsing/validating/ XSL-transforming every config file.

Compiles the app's configuration ahead of time so a freshly started worker starts warm instead of paying the first-request cost of parsing/validating/ XSL-transforming every config file.

Symfony solves this with `cache:warmup`; Quiote already has the machinery (ConfigCache / APCuConfigCache compile config -> PHP -> file/APCu, then include), it just had no CLI to drive it offline. This command is that CLI.

Backend is auto-detected the same way the runtime picks it: if QUIOTE_USE_APCU_CONFIG_CACHE is defined and true (set by Kernel::bootstrap when APCu is enabled), the APCu warmup path runs; otherwise the on-disk cache under {app_dir}/cache/config is populated. APCu is per-process shared memory, so warming it only makes sense inside the worker runtime, not from a detached CLI where apc.enable_cli is typically 0 -- for that case run the file backend and let the worker's QUIOTE_APCU_PREWARM hydrate APCu at boot.

## Synopsis

`final class CacheWarmupCommand extends AbstractAppCommand`

|  |  |
|---|---|
| Extends | [`AbstractAppCommand`](/api/console/command/abstract-app-command/) |
| Since | `1.0.0` |
| Source | `Console/Command/CacheWarmupCommand.php` |

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
