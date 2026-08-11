# FormatAwareConfigCache

> Extension-agnostic sibling of ConfigCache::checkConfig(): given a base path with NO extension, resolves whichever of .php/.yaml/.yml/.xml actually exists (via FormatDriverRegistry::locate(), priority PHP > YAML > XML), compiles it through the given handler's array contract, and reuses ConfigCache's own cache-naming/staleness/write primitives so the compiled artifact is indistinguishable from one ConfigCache produced.

Extension-agnostic sibling of ConfigCache::checkConfig(): given a base path with NO extension, resolves whichever of .php/.yaml/.yml/.xml actually exists (via FormatDriverRegistry::locate(), priority PHP > YAML > XML), compiles it through the given handler's array contract, and reuses ConfigCache's own cache-naming/staleness/write primitives so the compiled artifact is indistinguishable from one ConfigCache produced.

Deliberately a separate, opt-in entrypoint rather than a change to ConfigCache::checkConfig()/getHandlerInfo() itself: those are on every config load in the framework, XML included, and wiring extension-agnostic discovery into config_handlers.xml's own pattern matching (so `%core.config_dir%/settings` -- no extension -- becomes the directive every module actually uses) is real follow-on work this class deliberately does not attempt yet. What exists here is the genuinely working, tested resolution + compilation path a caller (or that future config_handlers.xml integration) can already build on.

## Synopsis

`final class FormatAwareConfigCache`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/FormatAwareConfigCache.php` |

## Methods

| Method | Description |
|---|---|
| [`checkConfig(string $basePathWithoutExtension, IArrayConfigHandler&XmlConfigHandler $handler, FormatDriverRegistry $registry, ?string $environment = null, ?string $context = null): string`](#checkconfig) |  |

### checkConfig()

`public static function checkConfig(string $basePathWithoutExtension, IArrayConfigHandler&XmlConfigHandler $handler, FormatDriverRegistry $registry, ?string $environment = null, ?string $context = null): string`

e.g. "%core.config_dir%/settings"
              (directives are expanded the same way ConfigCache::checkConfig()
              expands them for its own $config argument).

| Parameter | Type | Description |
|---|---|---|
| `$basePathWithoutExtension` | `string` | e.g. "%core.config_dir%/settings" (directives are expanded the same way ConfigCache::checkConfig() expands them for its own $config argument). |
| `$handler` | [`IArrayConfigHandler`](/api/config/i-array-config-handler/)`&`[`XmlConfigHandler`](/api/config/xml-config-handler/) |  |
| `$registry` | [`FormatDriverRegistry`](/api/config/format/format-driver-registry/) |  |
| `$environment` | `?``string` |  |
| `$context` | `?``string` |  |

Returns `string` — An absolute filesystem path to the compiled cache file.

| Throws | When |
|---|---|
| `UnreadableException` | If none of the candidate extensions exist. |
