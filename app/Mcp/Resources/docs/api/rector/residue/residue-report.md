# ResidueReport

> Collects the Context call sites no rewriting rule could handle, and writes them out once.

Collects the Context call sites no rewriting rule could handle, and writes them out once.

A Rector rule has no reporting channel: it either changes a node or it does not. So the reporter rule records into this, and this writes at process shutdown -- registered on the first recorded site, so a run that finds nothing writes nothing rather than leaving an empty file that reads as a clean result.

**Appends, under a lock, one line per site.** Rector runs parallel worker processes by default, so this class is instantiated once per worker and each worker's shutdown function fires separately. Overwriting made the report one worker's partial view with last-writer-wins -- which looked exactly like a rule that was not firing, and was misdiagnosed as such once already. Appending is what makes the file the union of what every worker saw. It also means the file must be removed between runs; stale lines from a previous run would otherwise read as current residue.

Kept separate from the rule so the collection is testable without Rector's container, and so the rule stays about recognising sites rather than about formatting and file handling.

## Synopsis

`final class ResidueReport`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `Residue/ResidueReport.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `REASON_DISCARDED_MUTATION` | `'discarded-mutation'` |  |
| `REASON_FOREIGN_RECEIVER` | `'foreign-receiver'` | A call shaped exactly like a Context call whose receiver is something else -- an OpenTelemetry span context, a Playwright browser context, a dashboard render context. |
| `REASON_NOT_AN_ACCESSOR` | `'not-an-accessor'` | The receiver really is a Context, but the method is not one Context declares -- in practice a PHPUnit mock builder on a mocked Context (`$context->method('getName')`), where the receiver resolves to `MockObject&Context`. |
| `REASON_NOT_CONTAINER_BUILT` | `'not-container-built'` |  |
| `REASON_NO_CLASS` | `'no-class-to-inject-into'` | A site in a file with no class in it: a template, or a script. |
| `REASON_NULLABLE_ACCESSOR` | `'nullable-accessor'` |  |
| `REASON_UNHANDLED` | `'unhandled-accessor'` |  |
| `REASON_UNRESOLVABLE_ARGUMENT` | `'unresolvable-argument'` |  |
| `REASON_UNRESOLVED_RECEIVER` | `'unresolved-receiver'` | Shaped like a Context call, and the receiver's type cannot be resolved at all -- in practice an untyped `$context = null` parameter, whose type is `mixed`. |

## Methods

| Method | Description |
|---|---|
| [`add(string $file, int $line, string $accessor, string $reason): void`](#add) | Records one accessor site that could not be rewritten, with the reason why. |
| [`countsByReason(): array<string, int>`](#countsbyreason) | Sites grouped by reason, most numerous first -- which is the order the work should be planned in, since a whole category usually has one answer. |
| [`render(): string`](#render) | The report as text: a summary by reason, then every site. |
| [`sites(): array<int, array{file: string, line: int, accessor: string, reason: string}>`](#sites) |  |
| [`write(): void`](#write) | Write the report, to `QUIOTE_RECTOR_RESIDUE` or the working directory. |

### add()

`public function add(string $file, int $line, string $accessor, string $reason): void`

Records one accessor site that could not be rewritten, with the reason why.

Sites are keyed by file, line and accessor, so a rule and the reporter both reaching the same site record it once. The first recorded site also registers a shutdown function that writes the collected report out, so callers do not have to flush it themselves.

| Parameter | Type | Description |
|---|---|---|
| `$file` | `string` |  |
| `$line` | `int` |  |
| `$accessor` | `string` |  |
| `$reason` | `string` |  |

### countsByReason()

`public function countsByReason(): array<string, int>`

Sites grouped by reason, most numerous first -- which is the order the work should be planned in, since a whole category usually has one answer.

Returns `array``<``string``, ``int``>`

### render()

`public function render(): string`

The report as text: a summary by reason, then every site.

Returns `string`

### sites()

`public function sites(): array<int, array{file: string, line: int, accessor: string, reason: string}>`

Returns `array``<``int``, ``array{file: string, line: int, accessor: string, reason: string}``>`

### write()

`public function write(): void`

Write the report, to `QUIOTE_RECTOR_RESIDUE` or the working directory.

Failure to write is reported to STDERR rather than thrown: this runs at shutdown, after Rector has finished, and throwing here would turn a successful run into a confusing one.
