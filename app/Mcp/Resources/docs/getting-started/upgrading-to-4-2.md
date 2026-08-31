# Upgrading to 4.2

> 4.2 moves the filesystem and object-store classes into their own packages — one composer require, no namespace changes.

4.2 is a small upgrade with one thing to actually do: **fourteen classes moved out of the framework into two packages, and the framework does not install them for you.** Every namespace is unchanged, so there is no code to edit. Everything else on this page is either informational or specific to plugin authors.

Coming from 4.0? There is nothing extra to do for 4.1 — see [the changelog](/getting-started/changelog/#410) for what it added.

## Filesystem and object-store classes moved into their own packages

**Action required if you use any of them.** Fourteen public classes that shipped *inside* `quioteframework/quiote` at 4.0 and 4.1 now live in two separate packages.

`quioteframework/filesystem`:

| Class | Was |
|---|---|
| `Quiote\Filesystem\FilesystemManager` | `Quiote/Filesystem/` in the framework install |
| `Quiote\Filesystem\FilesystemPlugin` | ” |
| `Quiote\Filesystem\FilesystemConfig` | ” |
| `Quiote\Filesystem\FilesystemAdapterInterface` | ” |
| `Quiote\Filesystem\ListableFilesystemInterface` | ” |
| `Quiote\Filesystem\FilesystemDriverRegistry` | ” |
| `Quiote\Filesystem\LocalFilesystemAdapter` | ” |
| `Quiote\Filesystem\ObjectStoreFilesystemAdapter` | ” |
| `Quiote\Filesystem\FilesystemStorageException` | ” |
| `Quiote\Filesystem\FileNotFoundStorageException` | ” |
| `Quiote\Session\ObjectStoreSessionPersistence` | `Quiote/Session/` in the framework install |

`quioteframework/storage`:

| Class | Was |
|---|---|
| `Quiote\Storage\ObjectStoreClientInterface` | `Quiote/Storage/` in the framework install |
| `Quiote\Storage\ObjectMetadata` | ” |
| `Quiote\Storage\ObjectStoreException` | ” |

`Quiote\Session\ObjectStoreSessionPersistence` is in `quioteframework/filesystem` rather than a `session-*` package: it is the shared base the object-store session backends extend, and it belongs with the object-store adapters it mirrors.

### Whether this affects you

You already have these classes transitively if your `composer.json` requires any of:

| You require | Which requires |
|---|---|
| `quioteframework/cloud-azure`, `cloud-s3`, `cloud-gcs` | `quioteframework/storage` |
| `quioteframework/session-azure`, `session-s3`, `session-gcs` | `quioteframework/filesystem` (and so `storage`) |
| `quioteframework/replay-storage` | `quioteframework/storage` |

`quioteframework/filesystem-azure`, `-s3` and `-gcs` only **suggest** `quioteframework/filesystem` — their clients are usable without it, and only their `FilesystemManager` disk drivers need it — so having one of those installed is *not* enough.

### The fix

```bash
composer require quioteframework/filesystem
```

`quioteframework/filesystem` requires `quioteframework/storage`, so that covers both. If all you ever touched was `Quiote\Storage\ObjectStoreClientInterface` and friends — writing your own object-store client, say — then `composer require quioteframework/storage` alone is enough.

Nothing else changes: no namespace edits, no config changes, and the `plugins` entry stays exactly as it was.

```php
'plugins' => [
    \Quiote\Filesystem\FilesystemPlugin::class,
],
```

### How it fails if you miss it

Two symptoms, neither of them a clear "package missing" message, which is why this section exists:

- **A `plugins` entry for `Quiote\Filesystem\FilesystemPlugin` is skipped, not fatal.** `PluginManager` logs `configured plugin "..." is not a Quiote\Plugin\PluginInterface` at `error` and carries on booting, because a `::class` constant still evaluates to a string for a class that no longer exists. The app comes up with no `FilesystemManager` in the container, and the first `$container->get(FilesystemManager::class)` fails there instead.
- **Direct use is a plain autoload failure**: `Class "Quiote\Filesystem\FilesystemManager" not found`.

If you are upgrading a running app, grep your logs for that `[PluginManager]` line before concluding the upgrade was clean.

### Why this is 4.2 and not 5.0

Removing classes from an install is a breaking change, and strict semver says major. 4.2 was chosen deliberately: the classes are all still present under their original namespaces, and one `composer require` is the whole migration.

## Plugin-owned static registries now clear themselves

**No action for applications. Relevant if you maintain a plugin with a static registry.**

`PluginManager::reset()` used to clear `FilesystemDriverRegistry` by name — core reaching into one optional subsystem it happened to know about. It now runs whatever cleanups plugins have contributed:

```php
PluginManager::addStateReset('my-driver-registry', static function (): void {
    MyDriverRegistry::reset();
});
```

From inside a plugin's `register()`, the same seam is on the registrar:

```php
$registrar->stateReset('my-driver-registry', static fn() => MyDriverRegistry::reset());
```

Callbacks are keyed by label, so two plugins touching the same registry collapse into one call. A plugin that keeps static state and does not register a reset will leak it between tests in the same process — the same contract as before, just without the carve-out the framework's own filesystem registry used to enjoy. See [Plugins: clearing your own static state](/architecture/plugins/#clearing-your-own-static-state).

## Two new-ish packages, plain installs

The eight `quioteframework/replay*` packages are tagged `4.0.0` and `quioteframework/cloud-azure` is tagged `4.1.0` — no `@RC` constraint or `minimum-stability` change needed, a plain `composer require` resolves them.

- **`replay*`** is new, so there is nothing to migrate. Recording is off unless configured, and `quiote replay` replays in isolation by default — it wants `replay.allow_live` *plus* `--live` before it will touch a real dependency. See [Record, replay & regression tests](/advanced/record-replay/).
- **`cloud-azure`** carries a caveat on one half of itself: the blob and table clients are in production, but the Azure AD credential path — workload identity, `az login`, and the chain of the two — has never authenticated against real Azure.

### If you tracked `cloud-azure` on `dev-main`

`AzureBlobClient`'s third constructor argument changed from a `string $accountKey` to an `AzureCredential`. Wrap what you were passing:

```php
new AzureBlobClient($httpClient, $accountName, new SharedKeyCredential($accountKey));
```

That is the same Shared Key signing as before, byte for byte. Apps that build the client from config through `AzureCredentialFactory` — which `session-azure` and `filesystem-azure` both do — need no change: set `auth` to `shared_key`, `workload_identity`, `cli` or `chain`. `shared_key` cannot authenticate the AAD-only APIs, so a container using one of the token providers must use a non-`shared_key` value.

## Worth knowing, nothing to do

- **The three `cloud-*` packages no longer require the framework**, so they are usable from a plain PHP project. Their contracts moved to `quioteframework/storage`, whose only dependency is `psr/http-message`.
- **All three cloud filesystem disks can list now.** `listObjects()` is a normalized, paginated operation on every `cloud-*` client, and `S3FilesystemAdapter`/`GcsFilesystemAdapter`/`AzureFilesystemAdapter` all implement `ListableFilesystemInterface` — so `listableDisk('s3')->listContents('reports/')` works where it previously refused at resolution. See [Listing a cloud disk](/basics/filesystem/#listing-a-cloud-disk).
- **`Quiote\Support\Clock`, `Quiote\Support\Random` and `Quiote\Support\Environment`** are new seams over `now()`, `random_bytes()`/`random_int()` and `getenv()`. Every ambient read inside the framework goes through them, which is what lets a test freeze time or seed randomness process-wide. See [Testing: other seams worth knowing](/advanced/testing/#time-randomness-and-the-environment).
