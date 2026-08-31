# ObjectListing

> One page of ListableObjectStoreClientInterface::listObjects().

One page of [`ListableObjectStoreClientInterface::listObjects()`](/api/storage/listable-object-store-client-interface/#listobjects).

`$commonPrefixes` is only ever non-empty when the call passed a delimiter: it is the "directories" one level below the prefix, the same grouping S3, GCS and Azure each fold keys into when asked to stop at the first delimiter after the prefix. Without a delimiter every matching key comes back in `$objects`, flat.

## Synopsis

`final readonly class ObjectListing`

|  |  |
|---|---|
| Since | `4.2.0` |
| Source | `ObjectListing.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$commonPrefixes` | `array` | _readonly._ |
| `$nextContinuationToken` | `?``string` | _readonly._ |
| `$objects` | `array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(list<ObjectSummary> $objects, list<string> $commonPrefixes, ?string $nextContinuationToken): mixed`

Each ending in the delimiter that produced it.

| Parameter | Type | Description |
|---|---|---|
| `$objects` | `list``<`[`ObjectSummary`](/api/storage/object-summary/)`>` | In the order the provider returned them. |
| `$commonPrefixes` | `list``<``string``>` | Each ending in the delimiter that produced it. |
| `$nextContinuationToken` | `?``string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`isTruncated(): bool`](#istruncated) | Whether another page follows -- pass `$nextContinuationToken` back in to fetch it. |

### isTruncated()

`public function isTruncated(): bool`

Whether another page follows -- pass `$nextContinuationToken` back in to fetch it.

Returns `bool`
