# ObjectSummary

> One entry in a ObjectListing: the same three metadata fields ObjectMetadata carries for a single object, plus the key they describe, so a listing result and a ObjectStoreClientInterface::head() result read the same way.

One entry in a [`ObjectListing`](/api/storage/object-listing/): the same three metadata fields [`ObjectMetadata`](/api/storage/object-metadata/) carries for a single object, plus the key they describe, so a listing result and a [`ObjectStoreClientInterface::head()`](/api/storage/object-store-client-interface/#head) result read the same way.

Populated from a list response's body rather than headers, so it is its own type rather than an [`ObjectMetadata`](/api/storage/object-metadata/) with a key bolted on -- the two are parsed differently even though they describe the same three things.

## Synopsis

`final readonly class ObjectSummary`

|  |  |
|---|---|
| Since | `4.2.0` |
| Source | `ObjectSummary.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$etag` | `?``string` | _readonly._ |
| `$key` | `string` | _readonly._ |
| `$lastModified` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) | _readonly._ |
| `$size` | `?``int` | _readonly._ |

## Constructor

### __construct()

`public function __construct(string $key, ?int $size, ?DateTimeImmutable $lastModified, ?string $etag): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$key` | `string` |  |
| `$size` | `?``int` |  |
| `$lastModified` | `?`[`DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php) |  |
| `$etag` | `?``string` |  |

Returns `mixed`
