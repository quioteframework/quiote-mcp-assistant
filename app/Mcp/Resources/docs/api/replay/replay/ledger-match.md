# LedgerMatch

> What LedgerMatcher found, and how it found it.

What [`LedgerMatcher`](/api/replay/replay/ledger-matcher/) found, and how it found it.

The distinction is the whole point of the type: a fingerprint match is the recorded counterpart of the call being replayed, while a sequence match is only the next unconsumed effect of the same kind -- a different call's recorded result, handed over because nothing better was available. Returning a bare [`Effect`](/api/replay/cassette/effect/) made the two indistinguishable to the caller, so a stub could not refuse the second and a drift report could not mention it.

## Synopsis

`final readonly class LedgerMatch`

|  |  |
|---|---|
| Source | `Replay/LedgerMatch.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$effect` | [`Effect`](/api/replay/cassette/effect/) | _readonly._ |
| `$fuzzy` | `bool` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`exact(Effect $effect): LedgerMatch`](#exact) | The recorded effect whose fingerprint is identical to the replayed call's. |
| [`fuzzy(Effect $effect): LedgerMatch`](#fuzzy) | The next unconsumed effect of the right kind, whose fingerprint does *not* match. |

### exact()

`public static function exact(Effect $effect): LedgerMatch`

The recorded effect whose fingerprint is identical to the replayed call's.

| Parameter | Type | Description |
|---|---|---|
| `$effect` | [`Effect`](/api/replay/cassette/effect/) |  |

Returns [`LedgerMatch`](/api/replay/replay/ledger-match/)

### fuzzy()

`public static function fuzzy(Effect $effect): LedgerMatch`

The next unconsumed effect of the right kind, whose fingerprint does *not* match.

Its result belongs to a different call.

| Parameter | Type | Description |
|---|---|---|
| `$effect` | [`Effect`](/api/replay/cassette/effect/) |  |

Returns [`LedgerMatch`](/api/replay/replay/ledger-match/)
