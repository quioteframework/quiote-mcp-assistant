# RequestInspectionTrait

> \"Is this field empty/absent?\" convenience helpers shared by WebRequest, one per input source (parameter, cookie, header, file).

"Is this field empty/absent?" convenience helpers shared by WebRequest, one per input source (parameter, cookie, header, file).

## Synopsis

`trait RequestInspectionTrait`

|  |  |
|---|---|
| Source | `Request/RequestInspectionTrait.php` |

## Methods

| Method | Description |
|---|---|
| [`hasCookie(string $name): bool`](#hascookie) | Indicates whether or not a Cookie exists. |
| [`isCookieValueEmpty(string $name): bool`](#iscookievalueempty) | Checks if there is a value of a cookie is empty or not set. |
| [`isFileValueEmpty(string $field): bool`](#isfilevalueempty) | Checks if a file is empty, i.e. |
| [`isHeaderValueEmpty(string $name): bool`](#isheadervalueempty) | Checks if there is a value of a header is empty or not set. |
| [`isParameterValueEmpty(string $field): bool`](#isparametervalueempty) | Checks if there is a value of a parameter is empty or not set. |
| [`isValueEmpty(string $source, string $field): bool`](#isvalueempty) | Checks if a field has no value (In web context this would only return true when the strings length is 0 or the field is not set. |

### hasCookie()

`public function hasCookie(string $name): bool`

Indicates whether or not a Cookie exists.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### isCookieValueEmpty()

`public function isCookieValueEmpty(string $name): bool`

Checks if there is a value of a cookie is empty or not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### isFileValueEmpty()

`public function isFileValueEmpty(string $field): bool`

Checks if a file is empty, i.e.

not set or set, but not actually uploaded.

| Parameter | Type | Description |
|---|---|---|
| `$field` | `string` |  |

Returns `bool`

### isHeaderValueEmpty()

`public function isHeaderValueEmpty(string $name): bool`

Checks if there is a value of a header is empty or not set.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### isParameterValueEmpty()

`public function isParameterValueEmpty(string $field): bool`

Checks if there is a value of a parameter is empty or not set.

| Parameter | Type | Description |
|---|---|---|
| `$field` | `string` |  |

Returns `bool`

### isValueEmpty()

`public function isValueEmpty(string $source, string $field): bool`

Checks if a field has no value (In web context this would only return true when the strings length is 0 or the field is not set.

| Parameter | Type | Description |
|---|---|---|
| `$source` | `string` |  |
| `$field` | `string` |  |

Returns `bool`
