# ListableCassetteStoreInterface

> A CassetteStoreInterface whose store can also enumerate what it holds.

A [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) whose store can also enumerate what it holds.

Separate from the base contract for the same reason [`ListableObjectStoreClientInterface`](/api/storage/listable-object-store-client-interface/) is separate from [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/): `cassette:list` and `cassette:prune` need this, but a store that genuinely cannot list (a pure key-value backend with no enumeration API at all) should not have to implement a method it cannot honour. Every store this package or its driver packages ship today (file, PDO, object-store-backed) does implement it, each over its own underlying listing mechanism.

## Synopsis

`interface ListableCassetteStoreInterface extends CassetteStoreInterface`

|  |  |
|---|---|
| Implements | [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) |
| Implemented by | [`FileCassetteStore`](/api/replay/store/file-cassette-store/), [`PdoCassetteStore`](/api/replay/store/pdo/pdo-cassette-store/), [`ObjectStoreCassetteStore`](/api/replay/store/storage/object-store-cassette-store/) |
| Source | `Store/ListableCassetteStoreInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`slugs(): list<string>`](#slugs) | Every cassette id currently in the store, as slugs (not raw ids -- a store never learns a cassette's raw id without decoding it). |

### slugs()

`abstract public function slugs(): list<string>`

Every cassette id currently in the store, as slugs (not raw ids -- a store never learns a cassette's raw id without decoding it).

Returns `list``<``string``>`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `delete()` | [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) | Removes the cassette at $id. |
| `get()` | [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) | Null when no cassette is stored under this id. |
| `has()` | [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) |  |
| `put()` | [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) |  |
