# IsolatedReplayResult

> What one IsolatedReplay::run() produced: the response, the response diff, and what the ledger was asked for.

What one [`IsolatedReplay::run()`](/api/replay/replay/isolated-replay/#run) produced: the response, the response diff, and what the ledger was asked for.

The ledger half is the part a live replay cannot report. In isolation every effect the code performs goes through the ledger, so three questions become answerable that are otherwise guesswork:

- [`EffectLedger::misses()`](/api/replay/replay/effect-ledger/#misses) -- calls the code made that the recording has no counterpart for. The code now does something it did not do when recorded. - [`EffectLedger::unplayed()`](/api/replay/replay/effect-ledger/#unplayed) -- recorded effects nothing asked for. The code no longer does something it used to. - [`EffectLedger::fuzzyMatches()`](/api/replay/replay/effect-ledger/#fuzzymatches) -- calls answered from a recorded effect with a different fingerprint, which is a weaker claim than a match.

[`IsolatedReplayResult::effectDiagnostics()`](/api/replay/replay/isolated-replay-result/#effectdiagnostics) turns those into the same [`Diagnostic`](/api/support/compiler/diagnostic/) shape the response diff uses, so a caller reports one list rather than two.

## Synopsis

`final readonly class IsolatedReplayResult`

|  |  |
|---|---|
| Source | `Replay/IsolatedReplayResult.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$drift` | [`DriftReport`](/api/replay/replay/drift-report/) | _readonly._ |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) | _readonly._ |
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(ResponseInterface $response, DriftReport $drift, EffectLedger $ledger): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$drift` | [`DriftReport`](/api/replay/replay/drift-report/) |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`allDiagnostics(string $cassetteId): DriftReport`](#alldiagnostics) | The response diff and the effect drift as one list. |
| [`effectDiagnostics(string $cassetteId): list<Diagnostic>`](#effectdiagnostics) | Effect drift as diagnostics, alongside the response diff's own. |

### allDiagnostics()

`public function allDiagnostics(string $cassetteId): DriftReport`

The response diff and the effect drift as one list.

| Parameter | Type | Description |
|---|---|---|
| `$cassetteId` | `string` |  |

Returns [`DriftReport`](/api/replay/replay/drift-report/)

### effectDiagnostics()

`public function effectDiagnostics(string $cassetteId): list<Diagnostic>`

Effect drift as diagnostics, alongside the response diff's own.

A miss is an error: the code reached for something the recording cannot answer, so whatever it did next was built on a default rather than on what happened. An unplayed effect and a fuzzy match are warnings -- both mean the run diverged, but the response is still the code's own answer rather than a fabricated one.

| Parameter | Type | Description |
|---|---|---|
| `$cassetteId` | `string` |  |

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`
