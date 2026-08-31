# ProcOpenAzureCliProcessRunner

> Default AzureCliProcessRunner: runs the command directly via `proc_open()`'s array form, never through a shell, so there is nothing for the fixed, argument-free `az` invocation to inject into.

Default [`AzureCliProcessRunner`](/api/storage/azure/azure-cli-process-runner/): runs the command directly via `proc_open()`'s array form, never through a shell, so there is nothing for the fixed, argument-free `az` invocation to inject into.

## Synopsis

`final class ProcOpenAzureCliProcessRunner implements AzureCliProcessRunner`

|  |  |
|---|---|
| Implements | [`AzureCliProcessRunner`](/api/storage/azure/azure-cli-process-runner/) |
| Source | `ProcOpenAzureCliProcessRunner.php` |

## Methods

| Method | Description |
|---|---|
| [`run(list<string> $command): string`](#run) |  |

### run()

`public function run(list<string> $command): string`

Argv, never passed through a shell.

| Parameter | Type | Description |
|---|---|---|
| `$command` | `list``<``string``>` | Argv, never passed through a shell. |

Returns `string`

| Throws | When |
|---|---|
| `AzureStorageException` | If the process could not be started or exited non-zero. |
