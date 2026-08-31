# Effect

> One entry in a request's effect ledger: a single observed side effect (a query, an HTTP call, a cache read, ...), recorded in the order it happened.

One entry in a request's effect ledger: a single observed side effect (a query, an HTTP call, a cache read, ...), recorded in the order it happened.

`$fingerprint` is what [`LedgerMatcher`](/api/replay/replay/ledger-matcher/) matches a replayed call against first -- normalized SQL plus a hash of bound parameters for a database call, method+URI+body-hash for HTTP, the key for a cache read -- falling back to `$seq` position within the same [`EffectKind`](/api/replay/cassette/effect-kind/) when no fingerprint matches. `$call` carries whatever a given recorder needs to describe the call beyond the fingerprint (e.g. the raw SQL and bound parameters), and `$result` the value playback answers with on a match.

## Synopsis

`final readonly class Effect`

|  |  |
|---|---|
| Source | `Cassette/Effect.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$call` | `array` | _readonly._ |
| `$durationMicros` | `?``int` | _readonly._ |
| `$fingerprint` | `string` | _readonly._ |
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) | _readonly._ |
| `$result` | `mixed` | _readonly._ |
| `$seq` | `int` | _readonly._ |

## Constructor

### __construct()

`public function __construct(non-negative-int $seq, EffectKind $kind, string $fingerprint, array<string, mixed> $call, mixed $result, non-negative-int|null $durationMicros = null): mixed`

Wall time the real call took, when known.

| Parameter | Type | Description |
|---|---|---|
| `$seq` | `non-negative-int` | Position in the ledger, in recorded order. |
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) |  |
| `$fingerprint` | `string` |  |
| `$call` | `array``<``string``, ``mixed``>` | Recorder-specific description of the call. |
| `$result` | `mixed` |  |
| `$durationMicros` | `non-negative-int``|``null` | Wall time the real call took, when known. |

Returns `mixed`
