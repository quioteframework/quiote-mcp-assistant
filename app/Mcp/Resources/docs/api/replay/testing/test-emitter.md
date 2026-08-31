# TestEmitter

> Turns one Cassette into a `Quiote\\Support\\Compiler\\EmittedArtifact` -- PHP source for a ReplayTestCase subclass.

Turns one [`Cassette`](/api/replay/cassette/cassette/) into a `Quiote\Support\Compiler\EmittedArtifact` -- PHP source for a [`ReplayTestCase`](/api/replay/testing/replay-test-case/) subclass.

This class only generates source text; writing it (and the cassette copy it references) to disk is the caller's job, via `Quiote\Support\Compiler\FilesystemArtifactWriter`, the same generator/writer split `Quiote\Validator\Compiler\ValidatorCompiler` already follows.

Scaffolds a deliberately narrow assertion set, no more: `assertStatus()` always, `assertJsonEquals()` for a JSON response body, `assertSee()` on the exception message for an error cassette, `assertHeader('Location', ...)` for a redirect. A DB write or enqueued-job effect is called out as a plain comment naming the SQL/fingerprint -- not as commented-out *code* calling an assertion method that does not exist yet (no such helper exists for an effect today), which would mislead a developer into uncommenting a call that fails.

## Synopsis

`final class TestEmitter`

|  |  |
|---|---|
| Source | `Testing/TestEmitter.php` |

## Methods

| Method | Description |
|---|---|
| [`emit(Cassette $cassette, CassetteId $id, bool $expectFixed = false): EmittedArtifact`](#emit) |  |

### emit()

`public function emit(Cassette $cassette, CassetteId $id, bool $expectFixed = false): EmittedArtifact`

| Parameter | Type | Description |
|---|---|---|
| `$cassette` | [`Cassette`](/api/replay/cassette/cassette/) |  |
| `$id` | [`CassetteId`](/api/replay/cassette/cassette-id/) |  |
| `$expectFixed` | `bool` |  |

Returns [`EmittedArtifact`](/api/support/compiler/emitted-artifact/)
