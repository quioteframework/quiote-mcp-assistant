# ObjectMetadata

> The subset of a stored object's HEAD response worth typing: everything else a provider returns (storage class, versioning, generation, SSE and custom metadata headers) is available from the raw response via the client's own `request()` method for callers that need it.

The subset of a stored object's HEAD response worth typing: everything else a provider returns (storage class, versioning, generation, SSE and custom metadata headers) is available from the raw response via the client's own `request()` method for callers that need it.

Every field is nullable because a HEAD response is not contractually obliged to carry it -- a proxy or an S3-compatible server may omit Content-Length or ETag, and callers that require a value should say so with their own error rather than get a silently invented zero.

Shared across providers: the three fields and their parsing are HTTP semantics, not provider semantics, so S3, GCS and Azure describe an object the same way.

## Synopsis

`final readonly class ObjectMetadata`

|  |  |
|---|---|
| Since | `3.2.0` |
| Source | `Storage/ObjectMetadata.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$contentLength` | `?``int` | _readonly._ |
| `$etag` | `?``string` | _readonly._ |
| `$lastModified` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) | _readonly._ |

## Constructor

### __construct()

`public function __construct(?int $contentLength, ?DateTimeImmutable $lastModified, ?string $etag): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$contentLength` | `?``int` |  |
| `$lastModified` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |
| `$etag` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`fromResponse(ResponseInterface $response): ObjectMetadata`](#fromresponse) | Reads the typed fields out of a HEAD (or GET) response's headers. |

### fromResponse()

`public static function fromResponse(ResponseInterface $response): ObjectMetadata`

Reads the typed fields out of a HEAD (or GET) response's headers.

Each field independently becomes null when its header is absent or unusable: a `Content-Length` that is not all digits, an unparseable `Last-Modified`, an empty `ETag`. The ETag's surrounding quotes are stripped. Nothing throws — a response with none of the three headers yields an all-null instance.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`ResponseInterface`](https://www.php-fig.org/psr/psr-7/) |  |

Returns [`ObjectMetadata`](/api/storage/object-metadata/)
