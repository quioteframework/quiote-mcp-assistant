# ReplayTestEmission

> Writes a cassette's own copy plus a generated ReplayTestCase subclass from it, the \"commit this as a regression test\" step behind `quiote replay --as-test`.

Writes a cassette's own copy plus a generated [`ReplayTestCase`](/api/replay/testing/replay-test-case/) subclass from it, the "commit this as a regression test" step behind `quiote replay --as-test`.

The cassette copy lands at `{replay.tests_path}/cassettes/{slug}.qcast` and the test at `{replay.tests_path}/Replay{slug}Test.php`, both under `core.app_dir`.

## Synopsis

`final class ReplayTestEmission`

|  |  |
|---|---|
| Source | `Testing/ReplayTestEmission.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(CassetteId $id, Cassette $cassette, bool $expectFixed): array{test: string, cassette: string}`](#emit) |  |

### emit()

`public static function emit(CassetteId $id, Cassette $cassette, bool $expectFixed): array{test: string, cassette: string}`

| Parameter | Type | Description |
|---|---|---|
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |
| `$expectFixed` | `bool` |  |

Returns `array{test: string, cassette: string}`
