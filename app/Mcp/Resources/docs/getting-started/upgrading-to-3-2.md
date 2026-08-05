# Upgrading to 3.2

> What breaks moving from Quiote 3.0/3.1 to 3.2 — the response, request, config, filesystem and object-store contracts that were quietly wrong.

3.2 tightens contracts that were quietly wrong: a response could not emit half the status codes it needed, a request could report two different hosts, a PSR-7 response mutated when you copied it, configuration was a public global array, a filesystem interface declared an operation three of its four implementations refused, and the session wire format had seven implementations that disagreed with each other.

**Most applications need no changes.** The three worth grepping for are `Config::$config`, `with*()` calls on a `PsrResponseAdapter`, and imports of a provider-local `ObjectMetadata`.

Coming from 2.x? Read [Upgrading to 3.0](/getting-started/upgrading-to-3/) first — that's the release that replaced the session subsystem.

## 1. `WebResponse` accepts the full status range

`setHttpStatusCode()` used to test membership of a hardcoded per-protocol table and throw on a miss, so 422, 429, 308, 451, 507 and 511 were unsettable. Validity now comes from `Quiote\Http\HttpStatus`: any code in **100–599**.

The table selection is gone too. It fell through to the HTTP/1.0 list for anything that wasn't literally `HTTP/1.1` or `HTTP/2`, so on HTTP/3 — or whenever `getProtocol()` answered null — ordinary codes like 303 and 307 were unsettable.

**If you relied on rejection**, narrow it explicitly in a subclass; the framework never sets this property:

```php
class StrictResponse extends WebResponse
{
    /** @var ?array<int, string> */
    protected $httpStatusCodes = ['200' => 'OK', '404' => 'Not Found'];
}
```

**If you match on the exception message**, it changed and no longer names a protocol:

| Before | After |
|---|---|
| `Invalid HTTP/1.1 Status code: 999` | `Invalid HTTP status code: 999 (expected 100-599)` |
| `Invalid HTTP/1.1 Redirect Status code: 999` | `Invalid HTTP redirect status code: 999 (expected 100-599)` |

`$http10StatusCodes` and `$http11StatusCodes` are deprecated and no longer consulted. They remain as protected properties for subclasses that read them.

## 2. `PsrResponseAdapter` is immutable

**This is the change most likely to affect application code.**

Every `with*()` method used to mutate the wrapped `WebResponse` and return `$this`. The adapter is handed to views and actions by `ViewFactory`, `ActionExecutor` and `ImmutableViewInitContext`, so the ordinary PSR-7 idiom silently changed the shared response — and a caller holding the original to compare against found it altered.

`with*()` now clones and leaves both the adapter and the `WebResponse` untouched, as `ResponseInterface` requires.

```php
// Before — worked by side effect, return value discarded:
$psr = $this->getInitContext()->getPsrResponse();
$psr->withHeader('X-Thing', '1');   // now a no-op

// After — write to the response that gets sent:
$this->getResponse()->setHttpHeader('X-Thing', '1');
```

From code holding an adapter rather than a view, `getLegacy()` is still the mutable response:

```php
$adapter->getLegacy()->setHttpHeader('X-Thing', '1');
```

Two smaller corrections in the same class: `withStatus()` throws `InvalidArgumentException` as PSR-7 mandates (it previously threw `QuioteException`, which is not an `InvalidArgumentException`), and `getReasonPhrase()` returns the real phrase instead of the empty string.

A discarded `with*()` return value is now a no-op rather than a hidden mutation — which is exactly the failure this fixes. **Grep for `->with` on anything reached through `getPsrResponse()`.** See [the PSR-7 view of the response](/basics/requests-and-responses/#the-psr-7-view-of-the-response).

## 3. `Config::$config` is private

Configuration was a `public static` array, so anything could write to it and no consumer could be handed a different one. `Quiote\Config\ConfigRepository` now holds the behaviour as an ordinary object; `Config` keeps its whole static API and delegates.

**Every `Config::get*()`, `set()`, `has()`, `remove()`, `fromArray()`, `toArray()`, `clear()` and `resetWorkerState()` call is unchanged.** Only direct property access breaks:

| Before | After |
|---|---|
| `Config::$config['k'] = $v` | `Config::set('k', $v)` |
| `unset(Config::$config['k'])` | `Config::remove('k')` |
| `Config::$config['k'] ?? $d` | `Config::getString('k', $d)` (or the matching typed accessor) |
| `isset(Config::$config['k'])` | `Config::has('k')` |
| `foreach (Config::$config as ...)` | `foreach (Config::toArray() as ...)` |
| `new ReflectionProperty(Config::class, 'config')` | the accessors above |

This is mechanically rewritable. See [Configuration: the repository behind the facade](/architecture/configuration/#the-repository-behind-the-facade) for what the object buys you — injectable configuration, and `Config::useRepository()` for tests.

## 4. `ValidationMiddleware` requires a `Controller`

The constructor took `?Controller $controller = null` and resolved one from the `'web'` context by name when it was absent — which pinned the framework to a single context profile, and wrote to a property on an instance the pipeline caches for the worker's lifetime, so the first request's controller was reused by every later one.

```php
new ValidationMiddleware();          // before
new ValidationMiddleware($controller); // after
```

Only relevant if you construct the middleware yourself. The pipeline already passes one.

## 5. `WebRequest` URL mutators

`setUrlScheme()`, `setUrlHost()`, `setUrlPort()`, `setRequestUri()`, `setUrlPath()`, `setUrlQuery()` and `setProtocol()` wrote only `WebRequest`'s own URL metadata and left the wrapped PSR-7 URI alone. After `setUrlHost('other.test')`, `getUrlHost()` and `getUri()->getHost()` answered differently — so a host- or scheme-based check passed or failed depending on which of the two the caller happened to read.

**All seven keep working and keep their `void` signature.** They now also rewrite the wrapped URI, so `getUri()` reflects the change where it previously did not. If you have a check reading `getUri()` after one of these calls, it now sees the new value.

They're deprecated in favour of [`with*()` counterparts](/basics/requests-and-responses/#url-metadata) that return a new instance. Convert with the assignment or leave the setters alone — a mechanical `set` → `with` rename that drops the return value turns a working call into a silent no-op.

## 6. The session wire format has one codec

Seven backends serialized session payloads their own way, and the three that used igbinary disagreed on how to recognise it coming back. A payload satisfying one test and not the other was read differently depending on which backend held it.

`Quiote\Session\SessionCodec`, behind `SessionCodecInterface`, is now the single implementation. **No change if you configure sessions through the `session` factory slot** — each backend defaults to the codec appropriate for it.

**If you construct a persistence backend directly**, the codec is the last constructor argument and it defaults:

```php
use Quiote\Session\SessionCodec;

// session-pdo (Quiote\Session\Pdo\PdoSessionPersistence)
new PdoSessionPersistence($pdo, 'session');                            // unchanged
new PdoSessionPersistence($pdo, 'session', SessionCodec::portable());  // explicit

// core (Quiote\Session\PdoSessionPersistence) — takes a parameter array
new PdoSessionPersistence($pdo, ['table' => 'session']);
new PdoSessionPersistence($pdo, ['table' => 'session'], SessionCodec::portable());
```

Only positional arguments *past* the documented ones are affected. See [the stored wire format](/basics/sessions/#the-stored-wire-format), including the one pre-existing limitation now made explicit: a top-level session key PHP coerces to an integer cannot round-trip.

## 7. `listContents()` is no longer on `FilesystemAdapterInterface`

The interface declared it and three of four implementations threw from it unconditionally — the S3, GCS and Azure adapters are built on single-object REST calls with no list endpoint. Code holding the interface could not call the method without knowing which adapter it actually had.

It moves to `Quiote\Filesystem\ListableFilesystemInterface`, which extends the base contract.

| Before | After |
|---|---|
| `$adapter->listContents()` on a `FilesystemAdapterInterface` | type-hint `ListableFilesystemInterface` |
| — | or `$manager->listContents()` / `$manager->listableDisk()` |

`FilesystemManager::listableDisk()` resolves the configured driver and fails naming the disk alias and the driver class when it can't list — at the point the disk is resolved rather than from inside the call.

**If you implement `FilesystemAdapterInterface` yourself**, nothing breaks; you may now drop `listContents()`. **If your adapter does support listing**, declare `ListableFilesystemInterface` so `FilesystemManager` can resolve it. See [listing is a separate contract](/basics/filesystem/#listing-is-a-separate-contract).

## 8. One `ObjectMetadata` for every object store

`S3Client`, `GcsClient` and `AzureBlobClient` exposed the same operation set as three classes sharing no interface, so nearly everything downstream was written three times — including three byte-identical metadata value objects differing only in namespace.

`Quiote\Storage` now holds the shared contract: `ObjectStoreClientInterface`, one `ObjectMetadata`, and `ObjectStoreException` as the supertype of each provider's own exception.

| Removed | Use |
|---|---|
| `Quiote\Storage\S3\ObjectMetadata` | `Quiote\Storage\ObjectMetadata` |
| `Quiote\Storage\Gcs\ObjectMetadata` | `Quiote\Storage\ObjectMetadata` |
| `Quiote\Storage\Azure\BlobMetadata` | `Quiote\Storage\ObjectMetadata` |

The class is otherwise identical — same constructor, same `fromResponse()`, same three nullable fields — so a `use` statement is the whole migration.

**The provider exceptions still exist and still narrow.** `S3StorageException`, `GcsStorageException` and `AzureStorageException` now extend `ObjectStoreException`, so `catch (S3StorageException)` keeps working *and* code written against the interface can catch one type across providers.

**The six provider adapters keep their names, namespaces and constructor signatures** — `S3FilesystemAdapter`, `GcsFilesystemAdapter`, `AzureFilesystemAdapter`, `S3SessionPersistence`, `GcsSessionPersistence`, `AzureBlobSessionPersistence`. Driver aliases, `session` slot config and DI bindings are untouched. New: `AzureBlobContainerClient` binds an `AzureBlobClient` to one container so it satisfies `ObjectStoreClientInterface` like the other two, since Azure takes the container per call.

## 9. CORS refuses a wildcard origin with credentials

`cors.allowed_origins: ['*']` together with `cors.allow_credentials: true` now throws a `ConfigurationException` instead of emitting both headers. The fetch specification forbids that pairing, so browsers rejected the response and every credentialed cross-origin request failed silently — while any non-browser client honouring both headers was handed the authenticated response.

Enumerate the origins that need credentialed access, or turn credentials off. See [`quioteframework/cors`](/plugins/official-packages/#quioteframeworkcors).

## Behaviour changes that need no code edit

**A view's attributes converge on one store.** `View::initialize()` always populated an internal attribute store, but only `setAttribute()` and `getAttributes()` read it; every other accessor went to the init context's holder. The two never merged, so `setAttribute('k', $v)` was invisible to `getAttribute('k')`, `appendAttribute()` silently did nothing under the modern execution path, and `getAttribute('k', $default)` returned null instead of `$default`. All of that now behaves as the names promise. Code that worked around the old split still works, but the workaround is no longer needed.

**`Set-Cookie` serialization has one implementation.** Two divergent ones existed, differing in default value encoding, deletion handling and date formatting. Cookies queued on a `WebResponse` are unaffected — that path's semantics were kept.

**Failures on the dispatch path are logged instead of vanishing.** Status, headers, redirects and cookies dropped while bridging the global response onto the PSR-7 response now log a warning, and a lost `Set-Cookie` logs at error level. Expect new log lines where something was already going wrong silently.

## New, no migration required

- **Four contracts** — `ContextInterface`, `ControllerInterface`, `WebResponseInterface`, `ValidatorInterface` — implemented by `Context`, `Controller`, `WebResponse` and `Validator`, and bound in the container. `Quiote\ContextComponentInterface` types the `initialize()`/`startup()` pair on `WebRequest`, `User`, `Routing` and `DatabaseManager`. See [type-hinting a contract](/architecture/container/#type-hinting-a-contract-instead-of-a-class).
- **`TelemetryBootstrap` is decomposed** into `TelemetryConfig`, `TelemetryExporterFactory` and `TelemetryProviderFactory`, with its whole public static API unchanged. What's new is that provider assembly can be exercised directly, over an in-memory exporter, without OTLP configuration or bootstrap state.

## Checklist

- [ ] Grep for `Config::$config` and rewrite to the accessors
- [ ] Grep for `->with*()` on anything from `getPsrResponse()` or a `PsrResponseAdapter`; move the intent to `getResponse()`/`getLegacy()`
- [ ] Grep for `catch` blocks matching on `Invalid HTTP/1.1 Status code`
- [ ] Check subclasses reading `$http10StatusCodes` / `$http11StatusCodes`
- [ ] Pass a `Controller` if you construct `ValidationMiddleware` yourself
- [ ] Check host- or scheme-based checks that read `getUri()` after a `setUrl*()` call
- [ ] Rewrite `Quiote\Storage\{S3,Gcs}\ObjectMetadata` and `Quiote\Storage\Azure\BlobMetadata` imports
- [ ] Type-hint `ListableFilesystemInterface` (or use `FilesystemManager::listContents()`) anywhere you call `listContents()`
- [ ] Declare `ListableFilesystemInterface` on your own adapters that support listing
- [ ] Check for positional arguments past the documented ones if you construct a session persistence backend directly
- [ ] Check for session keys that PHP coerces to integers (`'0'`, `'1'`)
- [ ] Check `cors.allowed_origins` for `*` alongside `cors.allow_credentials`
- [ ] Expect new warning-level log lines on the dispatch path and at the worker request boundary
