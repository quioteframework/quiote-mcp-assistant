# ReplayException

> A cassette cannot be replayed as given: no request was captured to replay (recorded under `#[NoRecord]`, or with `replay.capture_body` disabled), or a safety guard in ReplayEngine refused to run it.

A cassette cannot be replayed as given: no request was captured to replay (recorded under `#[NoRecord]`, or with `replay.capture_body` disabled), or a safety guard in [`ReplayEngine`](/api/replay/replay/replay-engine/) refused to run it.

## Synopsis

`final class ReplayException extends RuntimeException`

|  |  |
|---|---|
| Extends | `RuntimeException` |
| Source | `Replay/ReplayException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
