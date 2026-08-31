# AzureCliProcessRunner

> Runs one command and returns its standard output, so AzureCliTokenProvider can be exercised in tests without actually shelling out to `az`.

Runs one command and returns its standard output, so [`AzureCliTokenProvider`](/api/storage/azure/azure-cli-token-provider/) can be exercised in tests without actually shelling out to `az`.

## Synopsis

`interface AzureCliProcessRunner`

|  |  |
|---|---|
| Implemented by | [`ProcOpenAzureCliProcessRunner`](/api/storage/azure/proc-open-azure-cli-process-runner/) |
| Source | `AzureCliProcessRunner.php` |

## Methods

| Method | Description |
|---|---|
| [`run(list<string> $command): string`](#run) |  |

### run()

`abstract public function run(list<string> $command): string`

Argv, never passed through a shell.

| Parameter | Type | Description |
|---|---|---|
| `$command` | `list``<``string``>` | Argv, never passed through a shell. |

Returns `string`

| Throws | When |
|---|---|
| `AzureStorageException` | If the process could not be started or exited non-zero. |
