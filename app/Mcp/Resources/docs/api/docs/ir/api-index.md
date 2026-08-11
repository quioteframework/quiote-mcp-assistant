# ApiIndex

> Every documented class, plus the lookups the emitters need across them.

Every documented class, plus the lookups the emitters need across them.

Cross-linking and the "implemented by" back-index both need to see the whole corpus, so they are resolved once here rather than rediscovered per page.

## Synopsis

`final class ApiIndex`

|  |  |
|---|---|
| Source | `Ir/ApiIndex.php` |

## Constructor

### __construct()

`public function __construct(list<ClassDoc> $classes, Slugger $slugger = new Slugger(…)): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$classes` | `list``<`[`ClassDoc`](/api/docs/ir/class-doc/)`>` |  |
| `$slugger` | [`Slugger`](/api/docs/slug/slugger/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`classes(): list<ClassDoc>`](#classes) |  |
| [`get(string $fqcn): ?ClassDoc`](#get) |  |
| [`has(string $fqcn): bool`](#has) |  |
| [`inNamespace(string $namespace): list<ClassDoc>`](#innamespace) |  |
| [`namespaces(): list<string>`](#namespaces) |  |
| [`navigableNamespaces(): list<string>`](#navigablenamespaces) | Every namespace that needs a page, including the ones holding nothing but other namespaces. |
| [`slugFor(string $fqcn): ?string`](#slugfor) | The page path for a documented class, or null when it is not part of the reference. |
| [`slugger(): Slugger`](#slugger) |  |
| [`topLevelNamespaces(): list<string>`](#toplevelnamespaces) | The namespaces the reference lists in its navigation: one level below the framework root, which is the granularity a sidebar can carry without putting every class on every page. |
| [`under(string $namespace): list<ClassDoc>`](#under) |  |

### classes()

`public function classes(): list<ClassDoc>`

Returns `list``<`[`ClassDoc`](/api/docs/ir/class-doc/)`>` — Ordered by fully-qualified name.

### get()

`public function get(string $fqcn): ?ClassDoc`

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `?`[`ClassDoc`](/api/docs/ir/class-doc/)

### has()

`public function has(string $fqcn): bool`

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `bool`

### inNamespace()

`public function inNamespace(string $namespace): list<ClassDoc>`

| Parameter | Type | Description |
|---|---|---|
| `$namespace` | `string` |  |

Returns `list``<`[`ClassDoc`](/api/docs/ir/class-doc/)`>`

### namespaces()

`public function namespaces(): list<string>`

Returns `list``<``string``>` — Namespaces that hold at least one class, ordered by name.

### navigableNamespaces()

`public function navigableNamespaces(): list<string>`

Every namespace that needs a page, including the ones holding nothing but other namespaces.

`Quiote\Config\Util` declares no types of its own, only `Quiote\Config\Util\DOM` below it. It still has to exist as a page, because the level above links to it on the way down.

Returns `list``<``string``>`

### slugFor()

`public function slugFor(string $fqcn): ?string`

The page path for a documented class, or null when it is not part of the reference.

| Parameter | Type | Description |
|---|---|---|
| `$fqcn` | `string` |  |

Returns `?``string`

### slugger()

`public function slugger(): Slugger`

Returns [`Slugger`](/api/docs/slug/slugger/)

### topLevelNamespaces()

`public function topLevelNamespaces(): list<string>`

The namespaces the reference lists in its navigation: one level below the framework root, which is the granularity a sidebar can carry without putting every class on every page.

Returns `list``<``string``>`

### under()

`public function under(string $namespace): list<ClassDoc>`

| Parameter | Type | Description |
|---|---|---|
| `$namespace` | `string` |  |

Returns `list``<`[`ClassDoc`](/api/docs/ir/class-doc/)`>` — Every class at or below $namespace.
