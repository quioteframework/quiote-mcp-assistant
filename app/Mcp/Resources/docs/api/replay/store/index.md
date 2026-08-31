# Store

> The Quiote\\Replay\\Store namespace — 12 documented types.

Everything under `Quiote\Replay\Store`.

## Classes

| Class | Description |
|---|---|
| [`CassetteStoreRegistry`](/api/replay/store/cassette-store-registry/) | Process-global registry mapping short store aliases (`file`, `azure-blob`, `s3`, `gcs`, `pdo`) to the [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) class that implements them, so `replay.store` can say `file` instead of a fully-qualified class name. |
| [`FileCassetteStore`](/api/replay/store/file-cassette-store/) | Development-default store: never the right choice in production (an AKS pod's filesystem disappears on restart/eviction/scale-down), but a zero-dependency default that makes the feature usable immediately. |

## Interfaces

| Interface | Description |
|---|---|
| [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) | Where a cassette is written and read back from. |
| [`ListableCassetteStoreInterface`](/api/replay/store/listable-cassette-store-interface/) | A [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) whose store can also enumerate what it holds. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Azure`](/api/replay/store/azure/) | 2 types |
| [`Pdo`](/api/replay/store/pdo/) | 2 types |
| [`Storage`](/api/replay/store/storage/) | 4 types |
