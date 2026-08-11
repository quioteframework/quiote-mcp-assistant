# AppWriter

> Writes the actual files for `quiote new`.

Writes the actual files for `quiote new`.

Kept separate from NewCommand so the (fairly mechanical) file templates don't crowd the command's option-parsing/error-reporting concerns.

The generated app deliberately mixes config formats to exercise all three FormatDrivers: settings in whichever format was requested (default php), factories in YAML, databases/output_types in XML. Routing is a plain PHP `Routing` subclass rather than a config file at all -- `Quiote\Config\RoutingConfigHandler` (the class routing.xml would need) doesn't exist, so routing.xml is not a working option today. The generated AppRouting also demonstrates that file-based and #[Route]-attribute routing coexist: Index/About/Boom are declared by hand, Contact is declared via a #[Route] attribute on ContactAction and pulled in with AttributeRoutes::mergeInto().

## Synopsis

`final class AppWriter`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Console/Command/Scaffold/AppWriter.php` |

## Constructor

### __construct()

`public function __construct(string $path, string $namespace, string $format, ?string $activeAutoloadPath = null, string|null $workerRuntime = null): mixed`

Alias of a persistent worker runtime to
       scaffold an entrypoint for ("roadrunner", "swoole"). Null (the
       default) writes only pub/index.php, which already covers php-fpm,
       `php -S` and FrankenPHP worker mode -- writing every runtime's
       files unconditionally would just clutter a fresh app.

| Parameter | Type | Description |
|---|---|---|
| `$path` | `string` |  |
| `$namespace` | `string` |  |
| `$format` | `string` |  |
| `$activeAutoloadPath` | `?``string` |  |
| `$workerRuntime` | `string``|``null` | Alias of a persistent worker runtime to scaffold an entrypoint for ("roadrunner", "swoole"). Null (the default) writes only pub/index.php, which already covers php-fpm, `php -S` and FrankenPHP worker mode -- writing every runtime's files unconditionally would just clutter a fresh app. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`write(): void`](#write) | Creates the application's directory tree and writes every scaffolded file into it. |

### write()

`public function write(): void`

Creates the application's directory tree and writes every scaffolded file into it.

Directories are created first, then config, routing, the Default module's actions, views and templates, the front controller, and a PHPStan setup. Existing files are overwritten without asking, so the caller is responsible for having established that the target is safe to write into. The worker entrypoint and its server config are written only when a worker runtime was named on construction, and go to the application root rather than pub/ so the document root cannot serve them.

| Throws | When |
|---|---|
| `ConfigurationException` | If a directory could not be created, a file could not be written, or the requested config format is not one of php, yaml or xml. |
