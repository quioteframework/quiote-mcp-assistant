# ReplayPlugin

> Registers the replay configuration defaults, the cassette store, the recorder middleware and the cassette console commands, through the generic plugin seam -- mirroring RateLimitPlugin's shape.

Registers the replay configuration defaults, the cassette store, the recorder middleware and the cassette console commands, through the generic plugin seam -- mirroring [`RateLimitPlugin`](/api/security/rate-limit/rate-limit-plugin/)'s shape.

`replay.enabled` defaults to false and `replay.record` to `never`, so installing the package alone changes nothing: [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) checks both at the top of `process()` and passes straight through when either says not to record, the same pattern `ratelimit.http.enabled` and `RateLimitMiddleware` already follow -- config defaults, the store service and the middleware are still registered unconditionally, and the *behaviour* is what the flag gates.

## Synopsis

`final class ReplayPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `ReplayPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Contribute to the framework. |

### register()

`public function register(PluginRegistrar $registrar): void`

Contribute to the framework.

Called exactly once at boot. Every contribution routes through [`PluginRegistrar`](/api/plugin/plugin-registrar/) to an existing seam; a plugin does not touch framework internals directly.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
