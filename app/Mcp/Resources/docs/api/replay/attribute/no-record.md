# NoRecord

> Marks an action as non-recordable -- for an endpoint handling payment or credentials, where a body's sensitive field names are not known in advance and name-based redaction is not enough.

Marks an action as non-recordable -- for an endpoint handling payment or credentials, where a body's sensitive field names are not known in advance and name-based redaction is not enough.

[`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) keeps only the metadata skeleton for a request whose resolved action carries this attribute.

Presence is the signal -- no constructor arguments -- matching the "opt-in scan" idiom `Quiote\Middleware\Compiler\MiddlewareAttributeScanner` already uses for `#[Middleware]`.

## Synopsis

`final class NoRecord`

|  |  |
|---|---|
| Source | `Attribute/NoRecord.php` |
