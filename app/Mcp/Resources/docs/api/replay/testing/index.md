# Testing

> The Quiote\\Replay\\Testing namespace — 3 documented types.

Everything under `Quiote\Replay\Testing`.

## Classes

| Class | Description |
|---|---|
| [`ReplayTestCase`](/api/replay/testing/replay-test-case/) | Base class an emitted `--as-test` test extends: `replay()` reconstructs a cassette's request and dispatches it through the same real pipeline [`HttpTestCase`](/api/testing/http-test-case/)'s own `get()`/`post()`/etc. |
| [`ReplayTestEmission`](/api/replay/testing/replay-test-emission/) | Writes a cassette's own copy plus a generated [`ReplayTestCase`](/api/replay/testing/replay-test-case/) subclass from it, the "commit this as a regression test" step behind `quiote replay --as-test`. |
| [`TestEmitter`](/api/replay/testing/test-emitter/) | Turns one [`Cassette`](/api/replay/cassette/cassette/) into a `Quiote\Support\Compiler\EmittedArtifact` -- PHP source for a [`ReplayTestCase`](/api/replay/testing/replay-test-case/) subclass. |
