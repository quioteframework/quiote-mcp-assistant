# LedgerMatcher

> The fingerprint-then-sequence matching algorithm: a replayed call is matched against the first not-yet-consumed effect of the same EffectKind whose fingerprint is identical, so two identical queries recorded back to back are still matched in the order they happened.

The fingerprint-then-sequence matching algorithm: a replayed call is matched against the first not-yet-consumed effect of the same [`EffectKind`](/api/replay/cassette/effect-kind/) whose fingerprint is identical, so two identical queries recorded back to back are still matched in the order they happened.

Only when no fingerprint matches does it fall back to the next not-yet-consumed effect of that kind regardless of fingerprint -- and it reports that it did, via [`LedgerMatch::$fuzzy`](/api/replay/replay/ledger-match/#fuzzy).

That report is what makes the fallback safe to have at all. A sequence match hands over a *different* call's recorded result, and the fallback cannot tell the case it exists for -- a fingerprint that could not be computed identically twice -- apart from genuine drift, where the code now makes a call it did not make when recorded. Returning both as an indistinguishable [`Effect`](/api/replay/cassette/effect/) meant drift was answered with plausible-looking data and no miss recorded anywhere, which for an isolated replay is a test that passes on fabricated input. [`EffectLedger`](/api/replay/replay/effect-ledger/) decides what to do with a fuzzy match; the matcher only has to be honest about which kind it made.

Stateless: [`EffectLedger`](/api/replay/replay/effect-ledger/) owns which effects have already been consumed and passes that set in on every call.

## Synopsis

`final class LedgerMatcher`

|  |  |
|---|---|
| Source | `Replay/LedgerMatcher.php` |

## Methods

| Method | Description |
|---|---|
| [`match(list<Effect> $effects, array<non-negative-int, true> $consumedSeqs, EffectKind $kind, string $fingerprint): ?LedgerMatch`](#match) |  |

### match()

`public static function match(list<Effect> $effects, array<non-negative-int, true> $consumedSeqs, EffectKind $kind, string $fingerprint): ?LedgerMatch`

Effect::$seq values already matched.

| Parameter | Type | Description |
|---|---|---|
| `$effects` | `list``<`[`Effect`](/api/replay/cassette/effect/)`>` | All recorded effects, in original order. |
| `$consumedSeqs` | `array``<``non-negative-int``, ``true``>` | Effect::$seq values already matched. |
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) |  |
| `$fingerprint` | `string` |  |

Returns `?`[`LedgerMatch`](/api/replay/replay/ledger-match/)
