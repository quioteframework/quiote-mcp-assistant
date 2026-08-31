# EffectLedger

> A request's effect ledger: written to by appending during recording, read from by matching during replay.

A request's effect ledger: written to by appending during recording, read from by matching during replay.

One instance serves exactly one direction at a time -- a fresh ledger for recording starts empty and only ever calls [`EffectLedger::record()`](/api/replay/replay/effect-ledger/#record); a ledger for replay is constructed from a cassette's stored effects and only ever calls [`EffectLedger::match()`](/api/replay/replay/effect-ledger/#match).

Match/miss accounting falls out of three queries answerable at any point during replay: [`EffectLedger::misses()`](/api/replay/replay/effect-ledger/#misses) is every call replay asked for that had no recorded counterpart -- the code now does something it did not do when recorded -- [`EffectLedger::unplayed()`](/api/replay/replay/effect-ledger/#unplayed) is every recorded effect nothing asked for -- the code no longer does something it used to -- and [`EffectLedger::fuzzyMatches()`](/api/replay/replay/effect-ledger/#fuzzymatches) is every call answered from a recorded effect with a *different* fingerprint, which is a weaker claim than a match and worth reporting as such. All three are diagnostics, not exceptions; a stub built on top of this class (e.g. `StubbedPdo`) decides what a miss means for its own subsystem, typically raising in isolated mode rather than inventing a result.

## Synopsis

`final class EffectLedger`

|  |  |
|---|---|
| Source | `Replay/EffectLedger.php` |

## Constructor

### __construct()

`public function __construct(list<Effect> $effects = [], int|null $maxPayloadBytes = null, EffectRedactor|null $redactor = null, LedgerDirection $direction = Quiote\Replay\Replay\LedgerDirection::Recording): mixed`

Applied to every recorded `call`/`result`. Null skips
       redaction, for a ledger on the replay side -- a cassette's effects were already
       scrubbed when they were recorded, and scrubbing them again on read would only remove
       data replay needs.

| Parameter | Type | Description |
|---|---|---|
| `$effects` | `list``<`[`Effect`](/api/replay/cassette/effect/)`>` | Effects loaded from a cassette, in original recorded order. |
| `$maxPayloadBytes` | `int``|``null` | Ceiling on the total size of the `call`/`result` payloads [`EffectLedger::record()`](/api/replay/replay/effect-ledger/#record) keeps. Null means unbounded, for a ledger built from an already-bounded cassette on the replay side, where there is nothing to bound. |
| `$redactor` | [`EffectRedactor`](/api/replay/recording/effect-redactor/)`|``null` | Applied to every recorded `call`/`result`. Null skips redaction, for a ledger on the replay side -- a cassette's effects were already scrubbed when they were recorded, and scrubbing them again on read would only remove data replay needs. |
| `$direction` | [`LedgerDirection`](/api/replay/replay/ledger-direction/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`all(): list<Effect>`](#all) |  |
| [`direction(): LedgerDirection`](#direction) |  |
| [`forRecording(?int $maxPayloadBytes = null, ?EffectRedactor $redactor = null): EffectLedger`](#forrecording) | A ledger that observes a live request, bounded and scrubbed. |
| [`forReplay(list<Effect> $effects): EffectLedger`](#forreplay) | A ledger that serves a recorded request from a cassette's effects. |
| [`fuzzyMatches(): list<array{kind: EffectKind, fingerprint: string, matched: string}>`](#fuzzymatches) | Replayed calls answered from a recorded effect whose fingerprint differed -- matched by position within their kind, not by identity. |
| [`isReplaying(): bool`](#isreplaying) | Whether a collaborator looking at this ledger should answer from it rather than perform the call. |
| [`match(EffectKind $kind, string $fingerprint, bool $allowFuzzy = false): ?Effect`](#match) | Consumes and returns the best-matching recorded effect for a replayed call (see [`LedgerMatcher`](/api/replay/replay/ledger-matcher/)), or null on a miss. |
| [`misses(): list<array{kind: EffectKind, fingerprint: string}>`](#misses) |  |
| [`payloadTruncated(): bool`](#payloadtruncated) | Whether any effect's payload was replaced with a marker because the budget ran out. |
| [`record(EffectKind $kind, string $fingerprint, array<string, mixed> $call, mixed $result, non-negative-int|null $durationMicros = null): Effect`](#record) | Appends a freshly observed effect, assigning it the next sequence number. |
| [`unplayed(): list<Effect>`](#unplayed) |  |

### all()

`public function all(): list<Effect>`

Returns `list``<`[`Effect`](/api/replay/cassette/effect/)`>` — Every effect this ledger holds, in original recorded order.

### direction()

`public function direction(): LedgerDirection`

Returns [`LedgerDirection`](/api/replay/replay/ledger-direction/)

### forRecording()

`public static function forRecording(?int $maxPayloadBytes = null, ?EffectRedactor $redactor = null): EffectLedger`

A ledger that observes a live request, bounded and scrubbed.

| Parameter | Type | Description |
|---|---|---|
| `$maxPayloadBytes` | `?``int` |  |
| `$redactor` | `?`[`EffectRedactor`](/api/replay/recording/effect-redactor/) |  |

Returns [`EffectLedger`](/api/replay/replay/effect-ledger/)

### forReplay()

`public static function forReplay(list<Effect> $effects): EffectLedger`

A ledger that serves a recorded request from a cassette's effects.

| Parameter | Type | Description |
|---|---|---|
| `$effects` | `list``<`[`Effect`](/api/replay/cassette/effect/)`>` |  |

Returns [`EffectLedger`](/api/replay/replay/effect-ledger/)

### fuzzyMatches()

`public function fuzzyMatches(): list<array{kind: EffectKind, fingerprint: string, matched: string}>`

Replayed calls answered from a recorded effect whose fingerprint differed -- matched by position within their kind, not by identity.

Only ever populated when a caller opted into a fuzzy match; `matched` names the fingerprint the answer actually came from.

Returns `list``<``array{kind: EffectKind, fingerprint: string, matched: string}``>`

### isReplaying()

`public function isReplaying(): bool`

Whether a collaborator looking at this ledger should answer from it rather than perform the call.

This is the question a driver decorator installed permanently on a connection has to ask before it does anything: recording means execute and append, replaying means do not touch the connection and serve what was recorded.

Returns `bool`

### match()

`public function match(EffectKind $kind, string $fingerprint, bool $allowFuzzy = false): ?Effect`

Consumes and returns the best-matching recorded effect for a replayed call (see [`LedgerMatcher`](/api/replay/replay/ledger-matcher/)), or null on a miss.

A miss is recorded for [`EffectLedger::misses()`](/api/replay/replay/effect-ledger/#misses) regardless of what the caller does with the null.

`$allowFuzzy` decides what happens when the matcher can only offer a sequence match -- the next unconsumed effect of the right kind, carrying a *different* call's recorded result. It defaults to refusing that: a stub answering a read from it would hand the caller data that belongs to another call, which is indistinguishable from a correct answer and is how an isolated replay ends up passing on fabricated input. A refused fuzzy match is recorded as a miss, so the drift it represents is reported rather than smoothed over.

Pass `true` where a fingerprint genuinely cannot be recomputed identically across runs and positional matching is the intended semantics. The match is then recorded in [`EffectLedger::fuzzyMatches()`](/api/replay/replay/effect-ledger/#fuzzymatches) so a drift report can still say the answer was approximate.

| Parameter | Type | Description |
|---|---|---|
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) |  |
| `$fingerprint` | `string` |  |
| `$allowFuzzy` | `bool` |  |

Returns `?`[`Effect`](/api/replay/cassette/effect/)

### misses()

`public function misses(): list<array{kind: EffectKind, fingerprint: string}>`

Returns `list``<``array{kind: EffectKind, fingerprint: string}``>` — Replayed calls that had no recorded counterpart.

### payloadTruncated()

`public function payloadTruncated(): bool`

Whether any effect's payload was replaced with a marker because the budget ran out.

The cassette says so in `meta.effects_truncated`, so a reader can tell an incomplete recording apart from a complete one -- otherwise replay reports the missing data as drift in the application.

Returns `bool`

### record()

`public function record(EffectKind $kind, string $fingerprint, array<string, mixed> $call, mixed $result, non-negative-int|null $durationMicros = null): Effect`

Appends a freshly observed effect, assigning it the next sequence number.

| Parameter | Type | Description |
|---|---|---|
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) |  |
| `$fingerprint` | `string` |  |
| `$call` | `array``<``string``, ``mixed``>` |  |
| `$result` | `mixed` |  |
| `$durationMicros` | `non-negative-int``|``null` |  |

Returns [`Effect`](/api/replay/cassette/effect/)

| Throws | When |
|---|---|
| `LogicException` | if this ledger is replaying -- appending to a cassette's effects mid-replay would mean a stub inventing history, and every caller that could do it by accident is a decorator that should have checked [`EffectLedger::isReplaying()`](/api/replay/replay/effect-ledger/#isreplaying) first. Every `call`/`result` goes through [`EffectRedactor`](/api/replay/recording/effect-redactor/) first when one was supplied. That placement is deliberate: the ledger is the single point every recorder in every driver package already funnels through, so a recorder cannot forget to redact the way most of them had -- see [`EffectRedactor`](/api/replay/recording/effect-redactor/)'s own docblock for what each one was leaking. An effect's `result` is the largest thing a cassette carries after the request and response bodies -- a cache value, a captured result set, an HTTP response body -- and `replay.max_effects` bounds only how *many* effects are kept, not how large. Charging the payload against `$maxPayloadBytes` here is what keeps a request that reads two thousand cached page fragments from building a multi-gigabyte cassette in memory before gzip ever sees it. Past the ceiling the `result` is replaced with a marker naming what was dropped, rather than the effect being discarded: that a call happened, and with what fingerprint, is the part replay needs most and the part that costs least. |

### unplayed()

`public function unplayed(): list<Effect>`

Returns `list``<`[`Effect`](/api/replay/cassette/effect/)`>` — Recorded effects nothing during replay ever asked for.
