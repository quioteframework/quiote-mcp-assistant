# EffectRedactor

> Scrubs an effect's `call` and `result` on their way into EffectLedger, so redaction covers the effect ledger and not only the request envelope.

Scrubs an effect's `call` and `result` on their way into [`EffectLedger`](/api/replay/replay/effect-ledger/), so redaction covers the effect ledger and not only the request envelope.

Placing this at the ledger rather than at each recorder is the whole point. Before it, the only two consumers of [`Redactor`](/api/replay/recording/redactor/) in the tree were `RecorderMiddleware` and `quioteframework/replay-propulsion`'s query recorder -- every other recorder wrote raw values straight through: the full value of each environment variable read, outbound `Authorization` headers and whole HTTP response bodies, cache values on both read and write, complete job parameters, and every fetched database row. The ledger is the one point every recorder in every driver package already funnels through, so scrubbing here is the only placement a newly written recorder cannot forget.

Redaction is per [`EffectKind`](/api/replay/cassette/effect-kind/), because the shapes differ and a single key-based pass over all of them would miss most of what matters -- an outbound `Authorization` header is denied by `replay.redact.headers` and not by `replay.redact.params`, and an environment variable's sensitivity is carried by its own name rather than by an array key above it.

What this cannot do, stated rather than implied: a value carries no field name of its own, so an opaque cache value or an HTTP response body can only be matched by the key or header around it. A serialized session blob cached under an innocuous key, or a token in a JSON response body, passes through. `replay.capture_body`-style coarse controls, not this class, are the answer there.

## Synopsis

`final readonly class EffectRedactor`

|  |  |
|---|---|
| Source | `Recording/EffectRedactor.php` |

## Constructor

### __construct()

`public function __construct(Redactor $redactor, list<string> $envNeedles): mixed`

lower-cased substrings marking an env var name as secret

| Parameter | Type | Description |
|---|---|---|
| `$redactor` | [`Redactor`](/api/replay/recording/redactor/) |  |
| `$envNeedles` | `list``<``string``>` | lower-cased substrings marking an env var name as secret |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromConfig(): EffectRedactor`](#fromconfig) | Builds one from the current `replay.redact.*` config, alongside [`Redactor::fromConfig()`](/api/replay/recording/redactor/#fromconfig). |
| [`redactCall(EffectKind $kind, array<string, mixed> $call): array<string, mixed>`](#redactcall) | The `call` payload, scrubbed for its kind. |
| [`redactResult(EffectKind $kind, array<string, mixed> $call, mixed $result): mixed`](#redactresult) | The `result` payload, scrubbed for its kind. |

### fromConfig()

`public static function fromConfig(): EffectRedactor`

Builds one from the current `replay.redact.*` config, alongside [`Redactor::fromConfig()`](/api/replay/recording/redactor/#fromconfig).

Returns [`EffectRedactor`](/api/replay/recording/effect-redactor/)

### redactCall()

`public function redactCall(EffectKind $kind, array<string, mixed> $call): array<string, mixed>`

The `call` payload, scrubbed for its kind.

| Parameter | Type | Description |
|---|---|---|
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) |  |
| `$call` | `array``<``string``, ``mixed``>` |  |

Returns `array``<``string``, ``mixed``>`

### redactResult()

`public function redactResult(EffectKind $kind, array<string, mixed> $call, mixed $result): mixed`

The `result` payload, scrubbed for its kind.

| Parameter | Type | Description |
|---|---|---|
| `$kind` | [`EffectKind`](/api/replay/cassette/effect-kind/) |  |
| `$call` | `array``<``string``, ``mixed``>` |  |
| `$result` | `mixed` |  |

Returns `mixed`
