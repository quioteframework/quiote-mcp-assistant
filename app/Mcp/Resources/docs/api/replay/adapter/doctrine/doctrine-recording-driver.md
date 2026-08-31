# DoctrineRecordingDriver

> Wraps the real driver so every connection it builds records -- or, during an isolated replay, never opens at all.

Wraps the real driver so every connection it builds records -- or, during an isolated replay, never opens at all.

See [`LedgerBackedConnection`](/api/replay/adapter/doctrine/ledger-backed-connection/) for why both seams are needed: refusing to execute keeps a replay's queries away from production, and refusing to *connect* is what lets one run where no database is reachable.

## Synopsis

`final class DoctrineRecordingDriver extends AbstractDriverMiddleware`

|  |  |
|---|---|
| Extends | `AbstractDriverMiddleware` |
| Source | `DoctrineRecordingDriver.php` |

## Constructor

### __construct()

`public function __construct(Driver $driver, ClockInterface $clock): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$driver` | `Driver` |  |
| `$clock` | [`ClockInterface`](/api/support/clock/clock-interface/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`connect(array<string, mixed> $params): DriverConnection`](#connect) | Attempts to create a connection with the database. |

### connect()

`public function connect(array<string, mixed> $params): DriverConnection`

Attempts to create a connection with the database.

All connection parameters.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``string``, ``mixed``>` | All connection parameters. |

Returns `DriverConnection` — The database connection.

| Throws | When |
|---|---|
| `Exception` |  |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getDatabasePlatform()` | `AbstractDriverMiddleware` |  |
| `getExceptionConverter()` | `AbstractDriverMiddleware` |  |
