# File storage

> The filesystem abstraction — one read/write/list contract, a local disk in core, and S3, GCS and Azure disks in their own packages.

`Quiote\Filesystem` is a general-purpose "read, write and list a file" abstraction. Application code depends on one interface, names a **disk** by a short alias, and the disk it actually talks to is a config value — a local directory in development, an object store in production, with no code change between them.

It is deliberately separate from the two other storage-shaped things in the framework: [sessions](/basics/sessions/) (`SessionPersistenceInterface`, keyed by session id and session-shaped) and the [cache](/basics/caching/) (PSR-16, expiry-driven). This one is for files your application owns — generated reports, user uploads, exported archives.

## Turning it on

The subsystem lives in core but is a **plugin**, so an application has to list it before `FilesystemManager` exists. Like every plugin, it is opt-in:

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Filesystem\FilesystemPlugin
  enabled: true
```

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Filesystem\FilesystemPlugin::class, 'enabled' => true],
];
```

#### XML

```xml
<!-- Config/plugins.xml -->
<plugin class="Quiote\Filesystem\FilesystemPlugin" />
```

That registers the `filesystem.*` config defaults, the `local` disk, and the `FilesystemManager` service. See [Plugins: registering a plugin](/architecture/plugins/#registering-a-plugin) for the mechanism.

## Reading and writing

Resolve `FilesystemManager` from the [container](/architecture/container/) and call it. The four most common operations are on the manager directly, and go to the default disk:

```php
use Quiote\Filesystem\FilesystemManager;

$fs = $this->getContext()->getContainer()->get(FilesystemManager::class);

$fs->write('reports/2026-q3.csv', $csv);
$csv = $fs->read('reports/2026-q3.csv');
$fs->exists('reports/2026-q3.csv');
$fs->delete('reports/2026-q3.csv');
```

For anything else — or to target a specific disk — go through `disk()`, which returns the `FilesystemAdapterInterface`:

```php
$fs->disk()->size('reports/2026-q3.csv');           // default disk
$fs->disk('s3')->write('exports/big.zip', $bytes);  // a named disk
```

`disk()` resolves the alias through the driver registry and then through the container, so a disk is a **long-lived memoized service**, not something rebuilt per call.

### The contract

`Quiote\Filesystem\FilesystemAdapterInterface` is six methods, all of which every driver honours:

| Method | Behaviour |
|---|---|
| `read(string $path): string` | Throws `FileNotFoundStorageException` if absent. |
| `write(string $path, string $contents): void` | Creates or overwrites. |
| `delete(string $path): void` | Best-effort — a no-op if the path does not exist. |
| `exists(string $path): bool` | — |
| `size(string $path): int` | Throws `FileNotFoundStorageException` if absent. |
| `lastModified(string $path): DateTimeImmutable` | Throws `FileNotFoundStorageException` if absent. |

Errors are `Quiote\Filesystem\FilesystemStorageException`, with `FileNotFoundStorageException` extending it for the missing-file case — so catching the base type catches everything the subsystem throws.

### Listing is a separate contract

Enumerating a directory is **not** on the base interface, because three of the four shipped drivers have no list operation behind them. It lives on `Quiote\Filesystem\ListableFilesystemInterface`, which extends the base contract with one method:

| Method | Behaviour |
|---|---|
| `listContents(string $path = ''): array` | Relative paths, **non-recursive**. |

`LocalFilesystemAdapter` implements it; the S3, GCS and Azure adapters don't. So `disk()` — which returns the base contract — has no `listContents()` on it, and you ask for the disk a different way:

```php
$files = $fs->listContents('reports/');                          // the default disk
$files = $fs->listableDisk('local')->listContents('reports/');   // a named disk
```

`listableDisk()` resolves the disk and checks it can actually list. If it can't, it throws there and then, naming the alias and the driver class, rather than letting you call a method that was only ever going to fail. In your own code, type-hint `ListableFilesystemInterface` wherever you need to list, and `FilesystemAdapterInterface` everywhere else.

This is the same shape `Quiote\Queue\PollableQueueDriverInterface` uses: not every driver can poll, not every store can enumerate.

**Writing your own driver?** Nothing on the base interface changed, so an existing implementation keeps working and may drop `listContents()`. If yours does support listing, declare `ListableFilesystemInterface` so `FilesystemManager` can resolve it.

:::note[What is deliberately not in scope]
Visibility and ACLs, MIME-type detection, streaming reads and writes, copy and move, checksums and ETags, and directory-as-object semantics. If you need those, this abstraction is not trying to be Flysystem — use the disk's own client directly.
:::

## The `local` disk

The only driver in core. Every path is resolved against a fixed root directory, defaulting to `storage/app`:

#### PHP

```php
// Config/settings.php
return [
    'filesystem.default_disk'      => 'local',
    'filesystem.disks.local.root'  => 'storage/app',
];
```

#### YAML

```yaml
# Config/settings.yaml
filesystem.default_disk: local
filesystem.disks.local.root: storage/app
```

#### XML

```xml
<!-- Config/settings.xml -->
<settings prefix="filesystem.">
  <setting name="default_disk">local</setting>
  <setting name="disks.local.root">storage/app</setting>
</settings>
```

Two properties worth knowing:

- **Paths cannot escape the root.** `..` segments and absolute paths are rejected. This guard is load-bearing here in a way it is not for sessions — a session backend hashes its keys, but a general filesystem API takes paths straight from callers, and those callers may be passing user input.
- **Writes are atomic.** Contents go to a temp file in the same directory and are renamed into place, so a reader never observes a partially written file.

The root is created (mode `0755`) if missing, and a root that is not writable fails at construction rather than at first write.

## Cloud disks

Three packages add a disk each. All three follow the same shape: install the package, enable its plugin, set its `filesystem.disks.<alias>.*` settings, and bind a PSR-18 client.

| Alias | Package | Plugin |
|---|---|---|
| `s3` | [`quioteframework/filesystem-s3`](/plugins/official-packages/#quioteframeworkfilesystem-s3) | `Quiote\Filesystem\S3\S3FilesystemPlugin` |
| `gcs` | [`quioteframework/filesystem-gcs`](/plugins/official-packages/#quioteframeworkfilesystem-gcs) | `Quiote\Filesystem\Gcs\GcsFilesystemPlugin` |
| `azure` | [`quioteframework/filesystem-azure`](/plugins/official-packages/#quioteframeworkfilesystem-azure) | `Quiote\Filesystem\Azure\AzureFilesystemPlugin` |

`read`, `write`, `delete`, `exists`, `size` and `lastModified` all work against both `local` and cloud disks. `exists()` on a cloud disk issues a HEAD, not a GET, so it does not transfer the object body.

:::caution[No cloud disk can list its contents]
The underlying REST clients implement get, put, delete and head on a single object. There is **no list operation** behind them, so none of the three adapters implements [`ListableFilesystemInterface`](#listing-is-a-separate-contract). Asking for one as a listable disk fails at resolution, naming the alias and the driver class, rather than throwing from inside a `listContents()` call it declared but could not honour.

If you need a listing in production, keep it yourself, in the database alongside whatever record owns the file. If you genuinely need to list from the bucket, see [listing from the bucket](#listing-from-the-bucket) below.
:::

`size()` and `lastModified()` read `Content-Length` and `Last-Modified` off the HEAD response. Both headers are nullable in the metadata value object, because a provider is not contractually obliged to return them — when one is missing, the adapter throws rather than inventing a zero or an epoch timestamp. In practice all three providers send both for a normal object.

### Listing from the bucket

`S3Client::request()`, `GcsClient::request()` and `AzureBlobClient::request()` sign an arbitrary request and hand back the raw PSR-7 response, so you can implement `ListObjectsV2` or `List Blobs` — pagination included — without reimplementing SigV4, HMAC or Shared-Key signing yourself:

```php
$response = $s3Client->request('GET', '', ['list-type' => '2', 'prefix' => 'reports/']);
$xml = simplexml_load_string((string) $response->getBody());
```

Two things to know about `request()`:

- **It does not interpret the status code.** Unlike `get()` and friends, a 404 or a 500 comes back as a response object; only a transport-level failure throws. Check the status yourself.
- **The signatures are not uniform.** S3 and GCS take `(method, object, query, body)`; Azure takes `(method, path, query, headers, body)` and addresses a container-scoped path rather than a bare object name.

All three clients answer `head()` with the same value object, `Quiote\Storage\ObjectMetadata`, which deliberately types only content length, last-modified and ETag. Anything else the provider returns — blob type, lease state, `x-ms-meta-*` headers, storage class — is available from the raw response by the same route.

There is one such class rather than one per provider, and the three clients share `Quiote\Storage\ObjectStoreClientInterface`, so code that reads or writes objects can be written once against the contract instead of three times. Each provider's exception (`S3StorageException`, `GcsStorageException`, `AzureStorageException`) extends `Quiote\Storage\ObjectStoreException`, so `catch` can be as narrow or as broad as you need.

:::note[Upgrading]
The per-provider metadata classes — `Quiote\Storage\S3\ObjectMetadata`, `Quiote\Storage\Gcs\ObjectMetadata` and `Quiote\Storage\Azure\BlobMetadata` — are gone. They were byte-identical apart from the namespace, so rewriting the `use` statement to `Quiote\Storage\ObjectMetadata` is the whole migration. The six provider adapters keep their names, namespaces and constructor signatures.
:::

### Bring your own PSR-18 client

None of the three packages pulls a vendor cloud SDK. Each is a small signed REST client (from the matching [`cloud-*` package](/plugins/official-packages/#cloud-transport-packages)) driven by whatever PSR-18 implementation you already use, resolved from the container by the `Psr\Http\Client\ClientInterface` id.

Bind one before enabling the disk. Without it the plugin throws at boot with a message naming exactly what is missing — the same contract the [`session-*` packages](/basics/sessions/#cloud-object-storage-backends) use, so an app using both binds one client for both.

### S3

`composer require quioteframework/filesystem-s3`, enable `S3FilesystemPlugin`, then:

```yaml
filesystem.default_disk: s3
filesystem.disks.s3.region: eu-west-1
filesystem.disks.s3.bucket: my-app-files
filesystem.disks.s3.access_key_id: '%env(AWS_ACCESS_KEY_ID)%'
filesystem.disks.s3.secret_access_key: '%env(AWS_SECRET_ACCESS_KEY)%'
filesystem.disks.s3.key_prefix: ''
filesystem.disks.s3.endpoint: ''      # set for MinIO or any S3-compatible store
```

SigV4, path-style requests. `region` defaults to `us-east-1`; the rest default to empty.

### GCS

`composer require quioteframework/filesystem-gcs`, enable `GcsFilesystemPlugin`, then:

```yaml
filesystem.default_disk: gcs
filesystem.disks.gcs.bucket: my-app-files
filesystem.disks.gcs.access_key: '%env(GCS_HMAC_ACCESS_KEY)%'
filesystem.disks.gcs.secret_key: '%env(GCS_HMAC_SECRET)%'
filesystem.disks.gcs.key_prefix: ''
filesystem.disks.gcs.endpoint: 'https://storage.googleapis.com'
```

This uses GCS's S3-compatible HMAC interoperability API, so the credentials are an **HMAC key pair**, not a service-account JSON file.

### Azure Blob

`composer require quioteframework/filesystem-azure`, enable `AzureFilesystemPlugin`, then:

```yaml
filesystem.default_disk: azure
filesystem.disks.azure.account_name: '%env(AZURE_ACCOUNT_NAME)%'
filesystem.disks.azure.account_key: '%env(AZURE_ACCOUNT_KEY)%'
filesystem.disks.azure.container: my-app-files
filesystem.disks.azure.key_prefix: ''
filesystem.disks.azure.endpoint: ''   # for Azurite or a custom endpoint
```

Shared-Key authentication against a fixed container. Azure has no bucket-equivalent bound to the client itself, which is why `container` is a disk setting rather than part of the client configuration.

:::caution[One instance per alias]
There is no multi-instance disk config — you cannot configure two differently-parameterised S3 buckets under the `s3` alias. If you need a second bucket, register a second alias pointing at your own adapter class (see below).
:::

## Settings reference

| Setting | Default | Effect |
|---|---|---|
| `filesystem.default_disk` | `local` | Alias used by `FilesystemManager`'s own methods and by `disk()` with no argument. |
| `filesystem.disks.local.root` | `storage/app` | Root directory for the local disk. |
| `filesystem.disks.s3.region` | `us-east-1` | — |
| `filesystem.disks.s3.bucket` / `.access_key_id` / `.secret_access_key` / `.endpoint` / `.key_prefix` | `''` | — |
| `filesystem.disks.gcs.bucket` / `.access_key` / `.secret_key` / `.key_prefix` | `''` | — |
| `filesystem.disks.gcs.endpoint` | `https://storage.googleapis.com` | — |
| `filesystem.disks.azure.account_name` / `.account_key` / `.container` / `.endpoint` / `.key_prefix` | `''` | — |

## Adding your own disk

A driver is a `FilesystemAdapterInterface` implementation plus a registry entry. Register the alias and the service from a [plugin](/architecture/plugins/):

```php
#[Plugin(name: 'app/filesystem-sftp')]
final class SftpFilesystemPlugin implements PluginInterface
{
    public function register(PluginRegistrar $r): void
    {
        $r->configDefault('filesystem.disks.sftp.host', '');

        FilesystemDriverRegistry::register('sftp', SftpFilesystemAdapter::class);

        $r->service(
            SftpFilesystemAdapter::class,
            static fn() => new SftpFilesystemAdapter(Config::getString('filesystem.disks.sftp.host', '')),
        );
    }
}
```

`FilesystemDriverRegistry::resolve()` passes an unrecognised string through unchanged, so `disk(SftpFilesystemAdapter::class)` works with a fully-qualified class name and no alias at all — useful for a one-off. An alias that resolves to a missing class, or to a class not implementing the interface, fails with a message that says which of the two went wrong.
