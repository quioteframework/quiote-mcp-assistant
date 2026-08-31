# ReplayEngine

> Drives one cassette through the pipeline and reports drift, in one of two modes.

Drives one cassette through the pipeline and reports drift, in one of two modes.

[`ReplayMode::Isolated`](/api/replay/replay/replay-mode/#isolated) is the default and needs no configuration: every ledger-backed subsystem is answered from the cassette's own recorded effects and nothing is performed, so the replay can run anywhere -- which is the point of having recorded the request in the first place. It also reports more than a live replay can: in isolation every effect goes through the ledger, so "the code asked for something the recording does not contain" and "the recording contains * something the code no longer asks for" both become answerable rather than invisible. See [`IsolatedReplay`](/api/replay/replay/isolated-replay/).

[`ReplayMode::Live`](/api/replay/replay/replay-mode/#live) really re-performs the request's side effects against whatever the context is configured with. It exists for the one thing isolation cannot do -- confirm a fix works against real collaborators -- and carries the two safety rules that needs:

- it refuses unless `replay.allow_live` is `true` (default `false`); - it refuses anything but a *safe* method without `$force`.

Safe, not idempotent. `PUT` and `DELETE` are idempotent -- doing them twice leaves the same state as doing them once -- but that says nothing about whether doing them at all is harmless. Gating on idempotence let a recorded `DELETE /accounts/42` replay against a live application and delete account 42, with no prompt.

## Synopsis

`final class ReplayEngine`

|  |  |
|---|---|
| Source | `Replay/ReplayEngine.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `SAFE_METHODS` | `['GET', 'HEAD', 'OPTIONS', …]` | The HTTP methods defined as safe -- read-only by contract, so re-performing one is not expected to change server state. |

## Methods

| Method | Description |
|---|---|
| [`isSafeMethod(string $method): bool`](#issafemethod) | Whether $method is one of the safe methods a live replay will re-perform without `--force`. |
| [`replay(Context $context, Cassette $cassette, bool $force = false, ReplayMode $mode = Quiote\Replay\Replay\ReplayMode::Isolated): ReplayResult`](#replay) |  |

### isSafeMethod()

`public static function isSafeMethod(string $method): bool`

Whether $method is one of the safe methods a live replay will re-perform without `--force`.

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |

Returns `bool`

### replay()

`public function replay(Context $context, Cassette $cassette, bool $force = false, ReplayMode $mode = Quiote\Replay\Replay\ReplayMode::Isolated): ReplayResult`

Isolated by default; [`ReplayMode::Live`](/api/replay/replay/replay-mode/#live) re-performs for real.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |
| `$force` | `bool` |  |
| `$mode` | [`ReplayMode`](/api/replay/replay/replay-mode/) | Isolated by default; [`ReplayMode::Live`](/api/replay/replay/replay-mode/#live) re-performs for real. |

Returns [`ReplayResult`](/api/replay/replay/replay-result/)

| Throws | When |
|---|---|
| `ReplayException` | if the cassette has no replayable request; if isolation is impossible for the registered effect sources; or, in live mode, if `replay.allow_live` is off or the method is not a safe one and `$force` is false. |
