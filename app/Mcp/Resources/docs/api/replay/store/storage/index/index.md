# Index

> The Quiote\\Replay\\Store\\Storage\\Index namespace — 2 documented types.

Everything under `Quiote\Replay\Store\Storage\Index`.

## Classes

| Class | Description |
|---|---|
| [`ExplicitKeyIndex`](/api/replay/store/storage/index/explicit-key-index/) | The zero-dependency, always-works fallback: a key pasted straight out of a pointer log line, fetched from the object store directly. |
| [`PrefixScanIndex`](/api/replay/store/storage/index/prefix-scan-index/) | Reconstructs a key prefix from a `--date` (and, optionally, `--hour`) hint and enumerates it with `listObjects()`, needing no index service or Log Analytics access -- only blob read, which makes it the right fallback for a developer who has a storage RBAC grant but not a workspace one. |
