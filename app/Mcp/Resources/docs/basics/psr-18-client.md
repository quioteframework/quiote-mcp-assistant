# Bring your own PSR-18 client

> Binding a Psr\Http\Client\ClientInterface in the container for the packages that need one — the cloud filesystem, session and replay-store backends.

Several optional packages — the S3, GCS and Azure [filesystem](/basics/filesystem/#bring-your-own-psr-18-client) disks, the matching [session](/basics/sessions/#cloud-object-storage-backends) backends, and [`replay-azure`](/advanced/record-replay/#azure-blob-replay-azure) — carry no vendor cloud SDK. Each is a small, signed REST client built directly against `Psr\Http\Client\ClientInterface`, and each resolves one from the [container](/architecture/container/) rather than constructing its own. That keeps them thin and lets one HTTP stack serve every cloud integration an app uses — but it also means **nothing binds `ClientInterface` for you**: an app that enables one of these packages without binding a client gets a `RuntimeException` at boot, naming the interface and telling you to bind one.

This is a different thing from Quiote's own [named HTTP client factory](/basics/http-client/). That factory is for outbound calls *your own code* makes to *named* APIs (`$factory->client('github')`). What these packages want is a single, unnamed, plain `ClientInterface` — the raw contract, not the factory around it.

## The fastest binding

Quiote already knows how to build a bare PSR-18 client with no dependency on anything else — `TransportFactory::default()` returns Guzzle if it's installed, otherwise the zero-dependency `CurlTransport`, both of which already implement `ClientInterface` directly. Binding that is enough to satisfy every package above:

```php
use Psr\Http\Client\ClientInterface;
use Quiote\DI\Container;
use Quiote\Http\Client\TransportFactory;
use Quiote\Plugin\Attribute\Plugin as PluginAttribute;
use Quiote\Plugin\PluginInterface;
use Quiote\Plugin\PluginRegistrar;

#[PluginAttribute(name: 'app/psr18-client')]
final class Psr18ClientPlugin implements PluginInterface
{
    public function register(PluginRegistrar $registrar): void
    {
        $registrar->service(
            ClientInterface::class,
            static fn(Container $container): ClientInterface => TransportFactory::default(),
            Container::SCOPE_SINGLETON,
        );
    }
}
```

Register it in `Config/plugins.*` like any other plugin, **before** enabling any of the packages above (or at least before they're actually resolved — the container reads `ClientInterface::class` lazily, but the binding still has to exist by then):

```yaml
# Config/plugins.yaml
- class: App\Plugin\Psr18ClientPlugin
  enabled: true
- class: Quiote\Replay\Store\Azure\ReplayAzurePlugin
  enabled: true
```

`Container::SCOPE_SINGLETON` means one client, constructed once, reused by every package that resolves it — the filesystem disk, the session backend and the replay store all share the same underlying connection pool rather than each opening their own.

## Sharing retries and tracing too

`HttpClient` (what the named-client factory hands back from `client()`) also implements `ClientInterface`, so binding through the factory instead gets the cloud packages the same retry policy and [trace propagation](/basics/http-client/#trace-propagation) as the rest of your outbound HTTP, rather than a bare transport with neither:

```php
use Psr\Http\Client\ClientInterface;
use Quiote\DI\Container;
use Quiote\Http\Client\HttpClientConfig;
use Quiote\Http\Client\HttpClientFactory;
use Quiote\Plugin\Attribute\Plugin as PluginAttribute;
use Quiote\Plugin\PluginInterface;
use Quiote\Plugin\PluginRegistrar;

#[PluginAttribute(name: 'app/psr18-client')]
final class Psr18ClientPlugin implements PluginInterface
{
    public function register(PluginRegistrar $registrar): void
    {
        $registrar->httpClient('cloud', function (HttpClientConfig $c): void {
            $c->retry(attempts: 3, baseDelayMs: 100);
        });

        $registrar->service(
            ClientInterface::class,
            static fn(Container $container): ClientInterface =>
                $container->get(HttpClientFactory::class)->client('cloud'),
            Container::SCOPE_SINGLETON,
        );
    }
}
```

Naming the client `cloud` here is a convention, not a requirement — pick whatever name groups these calls sensibly in your own app; the packages above only ever look up the *unnamed* `ClientInterface::class` binding, never the `cloud` name itself.

## What needs this binding

| Package | Throws from | Config that selects it |
|---|---|---|
| `quioteframework/filesystem-s3` | `S3FilesystemPlugin::resolveHttpClient()` | `filesystem.default_disk: s3` |
| `quioteframework/filesystem-gcs` | `GcsFilesystemPlugin::resolveHttpClient()` | `filesystem.default_disk: gcs` |
| `quioteframework/filesystem-azure` | `AzureFilesystemPlugin::resolveHttpClient()` | `filesystem.default_disk: azure` |
| `quioteframework/session-s3` | `S3SessionFactory` | `session.driver: s3` |
| `quioteframework/session-gcs` | `GcsSessionFactory` | `session.driver: gcs` |
| `quioteframework/session-azure` | `AzureSessionParameters` (shared by both factories) | `session.driver: azure_blob` / `azure_table` |
| `quioteframework/replay-azure` | `ReplayAzurePlugin::requireHttpClient()` | `replay.store: azure-blob` |

Each one calls `$container->tryGet(ClientInterface::class)` rather than `get()` specifically so it can throw its own descriptive message instead of a generic autowiring failure — the exception text always names `Psr\Http\Client\ClientInterface` and tells you to bind one, which is the signal that you've reached this page rather than a real configuration mistake in the package's own settings.

<Aside type="note" title="Only if you enable one of these">
Nothing requires this binding by default. An app that never enables an S3/GCS/Azure filesystem disk, session backend or `replay-azure` never needs a `ClientInterface` bound at all, and the framework's own outbound calls go through the [named HTTP client factory](/basics/http-client/) instead, which builds its own transport per client with no bare `ClientInterface` binding required.
</Aside>
