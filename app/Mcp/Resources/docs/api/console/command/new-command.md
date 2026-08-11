# NewCommand

> Scaffolds a new Quiote application: a Default module (Index/About/Boom actions), the minimal config set needed to boot (settings, factories, routing, output_types -- config_handlers.xml/compile.xml/translation.xml/databases.xml can all be omitted and still boot cleanly), and a FrankenPHP-ready pub/index.php.

Scaffolds a new Quiote application: a Default module (Index/About/Boom actions), the minimal config set needed to boot (settings, factories, routing, output_types -- config_handlers.xml/compile.xml/translation.xml/databases.xml can all be omitted and still boot cleanly), and a FrankenPHP-ready pub/index.php.

Deliberately pre-bootstrap: this command never touches Quiote\Context or Quiote::bootstrap() -- it only writes files. The generated app is self-contained (its own spl_autoload_register in pub/index.php) so it needs no composer.json of its own; it just needs to find *some* vendor/autoload.php that has quioteframework/quiote in it. Since the target directory can be anywhere (e.g. /tmp, or a samples/ dir inside this very monorepo) with no vendor/ of its own, walking upward from pub/index.php alone cannot be relied on to find one -- so we resolve the autoloader actually in effect for *this* `quiote` invocation (mirroring bin/quiote's own two candidates) and bake that absolute path into the generated front controller as the first candidate; an upward walk stays as a fallback for a generated app later moved next to its own vendor/.

## Synopsis

`final class NewCommand extends Command`

|  |  |
|---|---|
| Extends | `Command` |
| Since | `1.0.0` |
| Source | `Console/Command/NewCommand.php` |

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
