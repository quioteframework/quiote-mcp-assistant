# ResponseDiffer

> Diffs a fresh replay response against a cassette's recorded one: drift as a feature -- every difference is reported through Diagnostic, never silently smoothed over.

Diffs a fresh replay response against a cassette's recorded one: drift as a feature -- every difference is reported through [`Diagnostic`](/api/support/compiler/diagnostic/), never silently smoothed over.

No existing diffing helper exists anywhere in the codebase for this; this is the first one.

Status and body mismatches are [`Diagnostic::SEVERITY_ERROR`](/api/support/compiler/diagnostic/#severityerror) (the response a client would actually see changed); header differences are [`Diagnostic::SEVERITY_WARNING`](/api/support/compiler/diagnostic/#severitywarning), since a header set routinely includes ambient values. A short, fixed denylist of headers that are *expected* to differ on every single replay (`Date`, `Set-Cookie`, the correlation-id headers) is skipped entirely rather than reported as warning noise on every run.

## Synopsis

`final class ResponseDiffer`

|  |  |
|---|---|
| Source | `Replay/ResponseDiffer.php` |

## Methods

| Method | Description |
|---|---|
| [`diff(array<string, mixed> $recorded, ResponseInterface $fresh, string $cassetteId): list<Diagnostic>`](#diff) |  |

### diff()

`public function diff(array<string, mixed> $recorded, ResponseInterface $fresh, string $cassetteId): list<Diagnostic>`

The cassette's `response` section.

| Parameter | Type | Description |
|---|---|---|
| `$recorded` | `array``<``string``, ``mixed``>` | The cassette's `response` section. |
| `$fresh` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |
| `$cassetteId` | `string` |  |

Returns `list``<`[`Diagnostic`](/api/support/compiler/diagnostic/)`>`
