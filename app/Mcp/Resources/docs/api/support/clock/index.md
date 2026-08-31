# Clock

> The Quiote\\Support\\Clock namespace — 5 documented types.

Everything under `Quiote\Support\Clock`.

## Classes

| Class | Description |
|---|---|
| [`Clock`](/api/support/clock/clock/) | Static facade over the process-wide clock, mirroring [`Config`](/api/config/config/). |
| [`FrozenClock`](/api/support/clock/frozen-clock/) | A clock that does not move except when told to: every read answers the wall-clock/monotonic values last set, however much real time elapses between two calls. |
| [`OffsetClock`](/api/support/clock/offset-clock/) | A clock that ticks in real time but reports a fixed offset from another clock -- "the client's clock is ten minutes fast", "this node's clock has * drifted 30 seconds behind the cluster". |
| [`SystemClock`](/api/support/clock/system-clock/) | The real clock: [`ClockInterface::now()`](/api/support/clock/clock-interface/#now)/[`ClockInterface::unixTimestamp()`](/api/support/clock/clock-interface/#unixtimestamp)/ [`ClockInterface::microtime()`](/api/support/clock/clock-interface/#microtime) answer from the system wall clock exactly like `new DateTimeImmutable()`/`time()`/`microtime(true)` always did, and [`ClockInterface::monotonic()`](/api/support/clock/clock-interface/#monotonic) from `hrtime(true)`. |

## Interfaces

| Interface | Description |
|---|---|
| [`ClockInterface`](/api/support/clock/clock-interface/) | The one seam every direct time()/microtime()/new DateTime() call site in core is meant to go through instead. |
