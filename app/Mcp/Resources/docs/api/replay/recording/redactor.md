# Redactor

> Header/cookie/param/session/body scrubbing.

Header/cookie/param/session/body scrubbing.

Applied at capture time, inside [`RecordingSession`](/api/replay/recording/recording-session/)'s record methods -- never deferred to serialization, so a denied value never enters process memory in an unredacted form that a later dump could leak.

Cookie names are matched against the same denylist as params: a cookie carrying a session/auth token (`token`, `secret`, ...) is exactly as sensitive as a request parameter by the same name, and the config surface has no separate `replay.redact.cookies` key.

## Synopsis

`final readonly class Redactor`

|  |  |
|---|---|
| Source | `Recording/Redactor.php` |

## Constructor

### __construct()

`public function __construct(list<string> $deniedHeaders, list<string> $deniedParams, list<string> $deniedSessionKeys, RedactionMode $mode = Quiote\Replay\Recording\RedactionMode::Drop, string $hashSalt = ''): mixed`

Prefixed to a value before hashing in [`RedactionMode::Hash`](/api/replay/recording/redaction-mode/#hash).
       Empty means unsalted -- see [`Redactor::apply()`](/api/replay/recording/redactor/#apply) for why that is not the default.

| Parameter | Type | Description |
|---|---|---|
| `$deniedHeaders` | `list``<``string``>` | lower-cased header names |
| `$deniedParams` | `list``<``string``>` | lower-cased param/cookie field names |
| `$deniedSessionKeys` | `list``<``string``>` | lower-cased session key names |
| `$mode` | [`RedactionMode`](/api/replay/recording/redaction-mode/) |  |
| `$hashSalt` | `string` | Prefixed to a value before hashing in [`RedactionMode::Hash`](/api/replay/recording/redaction-mode/#hash). Empty means unsalted -- see [`Redactor::apply()`](/api/replay/recording/redactor/#apply) for why that is not the default. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromConfig(): Redactor`](#fromconfig) | Builds a Redactor from the current `replay.redact.*` config, the one place every consumer -- the recorder middleware, and any driver-specific package's own query/row recorder -- gets its denylists/mode from, so they can never drift apart. |
| [`redactColumnValue(?string $columnName, mixed $value): mixed`](#redactcolumnvalue) | Redacts a single value against the same denylist [`Redactor::redactParams()`](/api/replay/recording/redactor/#redactparams) uses, by an explicit column name rather than an array key -- for a captured database value (a bound query parameter, a single fetched column) that isn't sitting in a keyed structure. |
| [`redactCookies(array<string, mixed> $cookies): array<string, mixed>`](#redactcookies) |  |
| [`redactHeaders(array<string, array<string>> $headers): array<string, array<string>>`](#redactheaders) |  |
| [`redactParams(array<array-key, mixed> $params): array<array-key, mixed>`](#redactparams) | Redacts a params/body structure, descending into nested arrays so a denied field name is caught regardless of nesting depth. |
| [`redactRowValues(array<int, string>|null $columns, array<array-key, mixed> $values): array<array-key, mixed>`](#redactrowvalues) | Redacts a list-shaped fetched row (`PDO::FETCH_NUM` order) by zipping it against the column names it came with. |
| [`redactSession(array<string, mixed> $session): array<string, mixed>`](#redactsession) |  |

### fromConfig()

`public static function fromConfig(): Redactor`

Builds a Redactor from the current `replay.redact.*` config, the one place every consumer -- the recorder middleware, and any driver-specific package's own query/row recorder -- gets its denylists/mode from, so they can never drift apart.

Returns [`Redactor`](/api/replay/recording/redactor/)

### redactColumnValue()

`public function redactColumnValue(?string $columnName, mixed $value): mixed`

Redacts a single value against the same denylist [`Redactor::redactParams()`](/api/replay/recording/redactor/#redactparams) uses, by an explicit column name rather than an array key -- for a captured database value (a bound query parameter, a single fetched column) that isn't sitting in a keyed structure.

A `null` column name (no column identity was known for this value -- a raw/manual PDO bind) never matches, so the value passes through unredacted: there is nothing to check it against.

| Parameter | Type | Description |
|---|---|---|
| `$columnName` | `?``string` |  |
| `$value` | `mixed` |  |

Returns `mixed`

### redactCookies()

`public function redactCookies(array<string, mixed> $cookies): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$cookies` | `array``<``string``, ``mixed``>` |  |

Returns `array``<``string``, ``mixed``>`

### redactHeaders()

`public function redactHeaders(array<string, array<string>> $headers): array<string, array<string>>`

| Parameter | Type | Description |
|---|---|---|
| `$headers` | `array``<``string``, ``array``<``string``>``>` |  |

Returns `array``<``string``, ``array``<``string``>``>`

### redactParams()

`public function redactParams(array<array-key, mixed> $params): array<array-key, mixed>`

Redacts a params/body structure, descending into nested arrays so a denied field name is caught regardless of nesting depth.

| Parameter | Type | Description |
|---|---|---|
| `$params` | `array``<``array-key``, ``mixed``>` |  |

Returns `array``<``array-key``, ``mixed``>`

### redactRowValues()

`public function redactRowValues(array<int, string>|null $columns, array<array-key, mixed> $values): array<array-key, mixed>`

Redacts a list-shaped fetched row (`PDO::FETCH_NUM` order) by zipping it against the column names it came with.

| Parameter | Type | Description |
|---|---|---|
| `$columns` | `array``<``int``, ``string``>``|``null` |  |
| `$values` | `array``<``array-key``, ``mixed``>` |  |

Returns `array``<``array-key``, ``mixed``>`

### redactSession()

`public function redactSession(array<string, mixed> $session): array<string, mixed>`

| Parameter | Type | Description |
|---|---|---|
| `$session` | `array``<``string``, ``mixed``>` |  |

Returns `array``<``string``, ``mixed``>`
