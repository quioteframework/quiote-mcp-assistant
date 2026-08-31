# Azure

> The Quiote\\Replay\\Store\\Azure namespace — 2 documented types.

Everything under `Quiote\Replay\Store\Azure`.

## Classes

| Class | Description |
|---|---|
| [`ReplayAzurePlugin`](/api/replay/store/azure/replay-azure-plugin/) | Registers the `azure-blob` cassette store alias and its `CassetteStoreInterface` binding, and contributes the three cassette-index strategies -- an explicit key, a Log Analytics lookup, and a date-hinted prefix scan -- that let `quiote cassette:fetch`/`quiote replay --save` resolve a bare id copied out of a log line back to a cassette, in that order: the explicit key always wins when `--key` is given, Log Analytics resolves a bare id with no hint at all, and the prefix scan is the fallback for a developer with blob read but no workspace access. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Index`](/api/replay/store/azure/index/) | 1 type |
