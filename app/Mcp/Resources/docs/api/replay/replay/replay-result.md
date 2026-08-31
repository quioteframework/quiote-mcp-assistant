# ReplayResult

> What one call to ReplayEngine::replay() produced.

What one call to [`ReplayEngine::replay()`](/api/replay/replay/replay-engine/#replay) produced.

## Synopsis

`final readonly class ReplayResult`

|  |  |
|---|---|
| Source | `Replay/ReplayResult.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$drift` | [`DriftReport`](/api/replay/replay/drift-report/) | _readonly._ |
| `$ledger` | `?`[`EffectLedger`](/api/replay/replay/effect-ledger/) | _readonly._ |
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) | _readonly._ |

## Constructor

### __construct()

`public function __construct(ResponseInterface $response, DriftReport $drift, EffectLedger|null $ledger = null): mixed`

The ledger an isolated replay served from, so a caller can
       ask what was missed, unplayed or fuzzily matched. Null for a live replay, which has no
       ledger: its effects went to real collaborators, where nothing could notice one missing.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$drift` | [`DriftReport`](/api/replay/replay/drift-report/) |  |
| `$ledger` | [`EffectLedger`](/api/replay/replay/effect-ledger/)`|``null` | The ledger an isolated replay served from, so a caller can ask what was missed, unplayed or fuzzily matched. Null for a live replay, which has no ledger: its effects went to real collaborators, where nothing could notice one missing. |

Returns `mixed`
