# PdoRowFormatting

> Shared by RecordingPdoStatement and StubbedPdoStatement: both serve a snapshotted result set with no live cursor to delegate to, and both need to reformat a row into whichever `PDO::FETCH_*` mode the caller asked for, entirely in PHP.

Shared by [`RecordingPdoStatement`](/api/replay/db/recording-pdo-statement/) and [`StubbedPdoStatement`](/api/replay/replay/stubbed-pdo-statement/): both serve a snapshotted result set with no live cursor to delegate to, and both need to reformat a row into whichever `PDO::FETCH_*` mode the caller asked for, entirely in PHP.

Two entry points, because the two hold different shapes for a good reason. [`PdoRowFormatting::formatPositionalRow()`](/api/replay/db/pdo-row-formatting/#formatpositionalrow) takes a positional row plus its column names, which is what the recording side captures: an associative snapshot collapses duplicate column names, so `SELECT a.id, b.id` would lose one and every positional mode rebuilt from it would be wrong. [`PdoRowFormatting::formatRow()`](/api/replay/db/pdo-row-formatting/#formatrow) takes an associative row, which is what a cassette carries -- by then the duplicate is already gone and there is nothing to recover.

Deliberately supports only ASSOC/NUM/OBJ/BOTH/default -- see each statement class's docblock for what is explicitly out of scope.

## Synopsis

`trait PdoRowFormatting`

|  |  |
|---|---|
| Source | `Db/PdoRowFormatting.php` |
