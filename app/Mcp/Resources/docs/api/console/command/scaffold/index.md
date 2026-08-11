# Scaffold

> The Quiote\\Console\\Command\\Scaffold namespace — 3 documented types.

Everything under `Quiote\Console\Command\Scaffold`.

## Classes

| Class | Description |
|---|---|
| [`ActionWriter`](/api/console/command/scaffold/action-writer/) | Writes the files for `make:action`: the Action class itself, and (optionally) a matching View + Template. |
| [`AppWriter`](/api/console/command/scaffold/app-writer/) | Writes the actual files for `quiote new`. |
| [`GeneratorSupport`](/api/console/command/scaffold/generator-support/) | Shared validation/overwrite-guard helpers for the `make:*` generator commands, mirroring the checks `NewCommand` already applies to its own `--namespace` argument (see `NewCommand::execute()`). |
