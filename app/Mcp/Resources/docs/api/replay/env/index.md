# Env

> The Quiote\\Replay\\Env namespace — 1 documented type.

Everything under `Quiote\Replay\Env`.

## Classes

| Class | Description |
|---|---|
| [`RecordingEnvironmentReader`](/api/replay/env/recording-environment-reader/) | A decorating environment reader: wraps a real inner [`EnvironmentReaderInterface`](/api/support/environment/environment-reader-interface/) and appends one [`EffectKind::Env`](/api/replay/cassette/effect-kind/#env) entry per `get()` call to an injected [`EffectLedger`](/api/replay/replay/effect-ledger/), returning the real value completely untouched to the caller. |
