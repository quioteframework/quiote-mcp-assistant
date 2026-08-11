# RequestDiagnostics

> Session and authentication state for a middleware's debug lines.

Session and authentication state for a middleware's debug lines.

Both readings reach through the context into state that legitimately may not exist yet -- there may be no session backend, no user, or no context at all on a console or queue path -- so each answers a placeholder instead of failing. That tolerance is why they are confined here: these values describe a request for a human reading a log, and no decision may ever be taken from them. A middleware that needs the real session or user must ask the context directly and handle its absence deliberately.

## Synopsis

`trait RequestDiagnostics`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Middleware/RequestDiagnostics.php` |
