# ArrayMergeStrategy

> Format-agnostic parent/child config inheritance (phase 4).

Format-agnostic parent/child config inheritance (phase 4).

Every FormatDriver resolves its own `parent` chain the same way: load the parent's array first, then deep-merge this file's array on top of it via array_replace_recursive() semantics -- child values win, nested arrays merge key-by-key rather than replacing wholesale.

This mirrors XmlConfigParser's own parent-chain resolution (parent files loaded first, in reverse order, then merged), just operating on plain arrays instead of DOM documents so the same merge logic works regardless of which FormatDriver produced either side.

## Synopsis

`final class ArrayMergeStrategy`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/ArrayMergeStrategy.php` |

## Methods

| Method | Description |
|---|---|
| [`merge(array<TKey, mixed> $base, array<TKey, mixed> $override): array<TKey, mixed>`](#merge) | Deep-merges $override onto $base. |

### merge()

`public function merge(array<TKey, mixed> $base, array<TKey, mixed> $override): array<TKey, mixed>`

Deep-merges $override onto $base.

| Parameter | Type | Description |
|---|---|---|
| `$base` | `array``<``TKey``, ``mixed``>` |  |
| `$override` | `array``<``TKey``, ``mixed``>` |  |

Returns `array``<``TKey``, ``mixed``>` — The merged result. Neither input is mutated.
