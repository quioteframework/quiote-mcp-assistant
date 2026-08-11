# ValidatorSourceLocator

> Finds validators.xml files on disk, the same way ConfigCache resolves config_handlers.xml's `%core.module_dir%/*&#47;Validate/*.xml` pattern for ValidatorConfigHandler -- except here the result is handed to a compiler, not compiled into the request-time cache.

Finds validators.xml files on disk, the same way ConfigCache resolves config_handlers.xml's `%core.module_dir%/*&#47;Validate/*.xml` pattern for ValidatorConfigHandler -- except here the result is handed to a compiler, not compiled into the request-time cache.

Only "leaf" validator files (the per-action Validate/*.xml, or any explicit path given) need to be discovered: each resolves its own `parent` chain up to the module's and the framework's validator definitions when parsed, exactly as XmlConfigParser::run() already does for the runtime path.

## Synopsis

`class ValidatorSourceLocator`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Validator/Compiler/ValidatorSourceLocator.php` |

## Methods

| Method | Description |
|---|---|
| [`defaultRoots(): array<string>`](#defaultroots) | The pattern config_handlers.xml maps to ValidatorConfigHandler today. |
| [`discover(iterable<string> $roots): array<ValidatorSource>`](#discover) |  |

### defaultRoots()

`public static function defaultRoots(): array<string>`

The pattern config_handlers.xml maps to ValidatorConfigHandler today.

Returns `array``<``string``>`

### discover()

`public function discover(iterable<string> $roots): array<ValidatorSource>`

Glob patterns, with %directive% tokens
                               (e.g. %core.module_dir%) expanded via
                               Toolkit::expandDirectives().

| Parameter | Type | Description |
|---|---|---|
| `$roots` | `iterable``<``string``>` | Glob patterns, with %directive% tokens (e.g. %core.module_dir%) expanded via Toolkit::expandDirectives(). |

Returns `array``<`[`ValidatorSource`](/api/validator/compiler/validator-source/)`>` — Discovered sources, sorted by path for deterministic ordering.
