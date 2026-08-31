# IsolatedReplay

> Runs a cassette against stubs built from its own recorded effects, so nothing the original request did is performed again.

Runs a cassette against stubs built from its own recorded effects, so nothing the original request did is performed again.

This is the mode the `Stubbed*` classes were written for. They existed, and were unit-tested, and nothing ever constructed them: what was missing was a step that substitutes them for a request's real collaborators, dispatches, and puts everything back. That step is here.

Every subsystem is swapped through a seam that already existed for it, which is why this is assembly rather than new machinery -- `Clock::useClock()`, `Randomness::useRandomness()` and `Environment::useEnvironmentReader()` each set a value and return the previous one, `CacheManager::setCache()` swaps the process cache, and the container binds the HTTP client and the queue driver. All of it is undone in a `finally`, including when the dispatch throws, because leaving a stub installed would make every later request in the same process silently replay-shaped.

**The clock is frozen at the cassette's `recorded_at`.** Nothing records individual clock reads, so there are no clock effects to match -- but a replay that runs at the recorded instant reproduces every `now()`-dependent branch the original took, which is most of the value a recorded clock would have given. Randomness is deliberately *not* substituted: nothing recorded the values, so any substitute would be inventing them, and inventing input is what an isolated replay exists to avoid.

**The database is the one subsystem that cannot always be isolated**, and this refuses to run rather than pretend otherwise. Serving a recorded row needs a seam that sits *in front of* the real execution: Doctrine's DBAL driver middleware is such a decorator, and Propulsion, whose observers only bracket a query that has already run, instead lets the connection itself be replaced. Eloquent's `QueryExecuted` event and Cycle's PSR-3 logger fire after the fact and offer no equivalent, so a replay through them would touch the real database. See [`IsolatesFromLedger`](/api/replay/replay/isolates-from-ledger/).

## Synopsis

`final class IsolatedReplay`

|  |  |
|---|---|
| Source | `Replay/IsolatedReplay.php` |

## Methods

| Method | Description |
|---|---|
| [`run(Context $context, Cassette $cassette, ServerRequestInterface $request): IsolatedReplayResult`](#run) | Dispatches $request against stubs built from $cassette's effects. |

### run()

`public function run(Context $context, Cassette $cassette, ServerRequestInterface $request): IsolatedReplayResult`

Dispatches $request against stubs built from $cassette's effects.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`IsolatedReplayResult`](/api/replay/replay/isolated-replay-result/)

| Throws | When |
|---|---|
| `ReplayException` | if a registered [`EffectSource`](/api/replay/recording/effect-source/) cannot serve from the ledger, or if the app is missing a PSR-17 factory pair the HTTP stub needs. |
