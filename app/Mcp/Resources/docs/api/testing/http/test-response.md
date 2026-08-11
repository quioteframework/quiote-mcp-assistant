# TestResponse

> Assertable wrapper around a PSR-7 response, returned by HttpTestCase's get()/post()/json() etc.

Assertable wrapper around a PSR-7 response, returned by [`HttpTestCase`](/api/testing/http-test-case/)'s get()/post()/json() etc.

## Synopsis

`final class TestResponse`

|  |  |
|---|---|
| Source | `Testing/Http/TestResponse.php` |

## Constructor

### __construct()

`public function __construct(ResponseInterface $response): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`__call(string $name, array<int, mixed> $arguments): mixed`](#call) |  |
| [`assertCreated(): TestResponse`](#assertcreated) | Asserts the status is 201 Created. |
| [`assertDontSee(string $needle): TestResponse`](#assertdontsee) | Asserts the response body does not contain $needle. |
| [`assertForbidden(): TestResponse`](#assertforbidden) | Asserts the status is 403 Forbidden. |
| [`assertHasXPath(string $expression): TestResponse`](#asserthasxpath) | Asserts the XPath expression matches at least one node in the response body. |
| [`assertHeader(string $name, ?string $value = null): TestResponse`](#assertheader) | Asserts the response carries the named header. |
| [`assertJson(array<mixed> $expected): TestResponse`](#assertjson) |  |
| [`assertJsonEquals(array<mixed> $expected): TestResponse`](#assertjsonequals) |  |
| [`assertJsonFragment(array<mixed> $expected): TestResponse`](#assertjsonfragment) | Looser than [`TestResponse::assertJson()`](/api/testing/http/test-response/#assertjson): the subset must match at least one element when the decoded body is a list of records. |
| [`assertNoContent(): TestResponse`](#assertnocontent) | Asserts the status is 204 No Content. |
| [`assertNotFound(): TestResponse`](#assertnotfound) | Asserts the status is 404 Not Found. |
| [`assertOk(): TestResponse`](#assertok) | Asserts the status is 200 OK. |
| [`assertRedirect(?string $uri = null): TestResponse`](#assertredirect) | Asserts the status is any 3xx redirect. |
| [`assertSee(string $needle): TestResponse`](#assertsee) | Asserts the response body contains $needle. |
| [`assertStatus(int $expected): TestResponse`](#assertstatus) | Asserts the response status is exactly $expected. |
| [`assertUnauthorized(): TestResponse`](#assertunauthorized) | Asserts the status is 401 Unauthorized. |
| [`assertXml(string $expectedXml): TestResponse`](#assertxml) | Asserts the response body is XML equivalent to $expectedXml. |
| [`clearExtensions(): void`](#clearextensions) | Drops every registered assertion. |
| [`extend(string $name, callable $assertion): void`](#extend) | Registers a custom assertion callable in the process-global extension table, callable on any instance as `$response->$name(...)`. |
| [`getContent(): string`](#getcontent) | Returns the response body as a string. |
| [`getHeaderLine(string $name): string`](#getheaderline) | Returns the named header's values joined with commas, or an empty string if it is absent. |
| [`getPsrResponse(): ResponseInterface`](#getpsrresponse) | Returns the wrapped PSR-7 response, for assertions this class does not cover. |
| [`getStatusCode(): int`](#getstatuscode) | Returns the response's HTTP status code. |
| [`hasExtension(string $name): bool`](#hasextension) | Whether an assertion has been registered under $name. |
| [`json(): array<mixed>`](#json) |  |
| [`xml(): SimpleXMLElement`](#xml) | Parses the response body as XML and returns its root element. |

### __call()

`public function __call(string $name, array<int, mixed> $arguments): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$arguments` | `array``<``int``, ``mixed``>` |  |

Returns `mixed`

### assertCreated()

`public function assertCreated(): TestResponse`

Asserts the status is 201 Created.

Returns $this for chaining.

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertDontSee()

`public function assertDontSee(string $needle): TestResponse`

Asserts the response body does not contain $needle.

The same raw, case-sensitive substring match as [`TestResponse::assertSee()`](/api/testing/http/test-response/#assertsee). Returns $this for chaining.

| Parameter | Type | Description |
|---|---|---|
| `$needle` | `string` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertForbidden()

`public function assertForbidden(): TestResponse`

Asserts the status is 403 Forbidden.

Returns $this for chaining.

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertHasXPath()

`public function assertHasXPath(string $expression): TestResponse`

Asserts the XPath expression matches at least one node in the response body.

Evaluated against the parsed document from [`TestResponse::xml()`](/api/testing/http/test-response/#xml), so a body that is not valid XML fails there first. The failure message includes the body. Returns $this for chaining.

| Parameter | Type | Description |
|---|---|---|
| `$expression` | `string` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertHeader()

`public function assertHeader(string $name, ?string $value = null): TestResponse`

Asserts the response carries the named header.

Passing $value additionally asserts the header line equals it exactly; a multi-valued header is compared as its comma-joined form. Returns $this for chaining.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `?``string` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertJson()

`public function assertJson(array<mixed> $expected): TestResponse`

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `array``<``mixed``>` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertJsonEquals()

`public function assertJsonEquals(array<mixed> $expected): TestResponse`

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `array``<``mixed``>` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertJsonFragment()

`public function assertJsonFragment(array<mixed> $expected): TestResponse`

Looser than [`TestResponse::assertJson()`](/api/testing/http/test-response/#assertjson): the subset must match at least one element when the decoded body is a list of records.

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `array``<``mixed``>` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertNoContent()

`public function assertNoContent(): TestResponse`

Asserts the status is 204 No Content.

Does not check that the body is empty. Returns $this for chaining.

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertNotFound()

`public function assertNotFound(): TestResponse`

Asserts the status is 404 Not Found.

Returns $this for chaining.

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertOk()

`public function assertOk(): TestResponse`

Asserts the status is 200 OK.

Returns $this for chaining.

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertRedirect()

`public function assertRedirect(?string $uri = null): TestResponse`

Asserts the status is any 3xx redirect.

Passing $uri additionally asserts the `Location` header equals it exactly; omitting it checks only that a redirect happened. Returns $this for chaining.

| Parameter | Type | Description |
|---|---|---|
| `$uri` | `?``string` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertSee()

`public function assertSee(string $needle): TestResponse`

Asserts the response body contains $needle.

A raw, case-sensitive substring match on the body as sent — no HTML parsing or entity decoding. Returns $this for chaining.

| Parameter | Type | Description |
|---|---|---|
| `$needle` | `string` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertStatus()

`public function assertStatus(int $expected): TestResponse`

Asserts the response status is exactly $expected.

The failure message carries the body, so an unexpected 500 shows what went wrong rather than only the number. Returns $this so assertions chain.

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `int` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertUnauthorized()

`public function assertUnauthorized(): TestResponse`

Asserts the status is 401 Unauthorized.

Returns $this for chaining.

Returns [`TestResponse`](/api/testing/http/test-response/)

### assertXml()

`public function assertXml(string $expectedXml): TestResponse`

Asserts the response body is XML equivalent to $expectedXml.

Both sides are run through C14N canonicalization before comparison, so insignificant whitespace, attribute order and namespace-prefix spelling do not matter. Either side failing to parse fails the test with the parser's messages. Returns $this for chaining.

| Parameter | Type | Description |
|---|---|---|
| `$expectedXml` | `string` |  |

Returns [`TestResponse`](/api/testing/http/test-response/)

### clearExtensions()

`public static function clearExtensions(): void`

Drops every registered assertion.

The table is static, so a suite that registers extensions in one test and needs the next to start clean calls this from its tear-down.

### extend()

`public static function extend(string $name, callable $assertion): void`

Registers a custom assertion callable in the process-global extension table, callable on any instance as `$response->$name(...)`.

The callable is bound to the TestResponse it is invoked on, so `$this` inside it is the response under assertion. Re-registering an existing name replaces it and logs a warning rather than failing, since a test bootstrap may legitimately run more than once.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$assertion` | `callable` |  |

### getContent()

`public function getContent(): string`

Returns the response body as a string.

The stream is rewound and drained on the first call and the result kept, so repeated assertions against the body do not consume it and every one sees the same bytes.

Returns `string`

### getHeaderLine()

`public function getHeaderLine(string $name): string`

Returns the named header's values joined with commas, or an empty string if it is absent.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `string`

### getPsrResponse()

`public function getPsrResponse(): ResponseInterface`

Returns the wrapped PSR-7 response, for assertions this class does not cover.

Returns [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/)

### getStatusCode()

`public function getStatusCode(): int`

Returns the response's HTTP status code.

Returns `int`

### hasExtension()

`public static function hasExtension(string $name): bool`

Whether an assertion has been registered under $name.

Real methods on the class are not extensions, so this is false for them.

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### json()

`public function json(): array<mixed>`

Returns `array``<``mixed``>`

### xml()

`public function xml(): SimpleXMLElement`

Parses the response body as XML and returns its root element.

The parse happens once and is kept for subsequent calls. libxml's own error reporting is captured for the duration so a malformed body fails the test with the parser's messages and the body itself, instead of emitting warnings; the previous libxml setting is restored either way.

Returns `SimpleXMLElement`
