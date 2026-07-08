<?php

declare(strict_types=1);

/**
 * Introspection + scaffolding probe for the "project-aware" tools, run as
 * an isolated subprocess by
 * {@see \QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector} -- never
 * `require`d or invoked in-process. The `scaffold_*` capabilities are the
 * only ones that write, and only ever *create new files* -- see
 * {@see \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldWriter}
 * for the never-overwrite / dry-run-by-default guarantees.
 *
 * Why a subprocess, not an in-process bootstrap of a second app: `Quiote\Config\Config`,
 * `Quiote\Context`, and `Quiote\Plugin\PluginManager` are static, process-wide state.
 * `Quiote::bootstrap()` locks `core.app_dir`/`core.environment` (and other core.* paths)
 * *readonly*, with no supported unlock -- confirmed empirically that a `pcntl_fork()`ed
 * child inherits that lock via copy-on-write and still can't repoint it. This app is
 * itself an already-bootstrapped Quiote app, so a second, arbitrary target app can only
 * be bootstrapped in a fresh process. A subprocess also can't corrupt the real MCP
 * server's live stdio JSON-RPC stream the way a fork sharing the parent's actual
 * STDIN/STDOUT file descriptions could.
 *
 * Contract: prints exactly one JSON object to stdout and exits 0 on success; on failure
 * prints {"error": "..."} to stdout and exits 1. Never prints anything else to stdout --
 * PHP error display is redirected to stderr up front so a warning/notice from the target
 * app's own code can't corrupt the JSON.
 *
 * Usage: php probe.php --app-dir=DIR --capability=NAME [--env=ENV] [capability args...]
 *
 * Options are parsed by hand from $argv, not getopt(): when this script runs
 * from inside a PHAR, TargetAppIntrospector/ConsoleRunner invoke it via
 * `php -r 'require $argv[1];' -- phar://.../probe.php --app-dir=... ...`
 * rather than `php phar://.../probe.php ...` directly, because PHP's CLI
 * SAPI cannot execute a bare phar:// path as its main script argument
 * (confirmed: "Could not open input file"). But getopt() then returns
 * nothing despite $argv/$_SERVER['argv'] being correctly populated -- a
 * confirmed PHP quirk specific to `-r` execution, not something this app can
 * fix. A plain scan over $argv for "--key=value" tokens is unaffected by
 * that quirk and works identically under both invocation styles.
 */

ini_set('display_errors', 'stderr');

/**
 * @param list<mixed> $argv
 * @return array<string, string>
 */
function parseOptions(array $argv): array
{
    $options = [];
    foreach ($argv as $arg) {
        if (is_string($arg) && str_starts_with($arg, '--') && str_contains($arg, '=')) {
            [$key, $value] = explode('=', substr($arg, 2), 2);
            $options[$key] = $value;
        }
    }

    return $options;
}

$rawArgv = $_SERVER['argv'] ?? [];
$options = parseOptions(is_array($rawArgv) ? array_values($rawArgv) : []);

function probeFail(string $message): never
{
    echo json_encode(['error' => $message], JSON_THROW_ON_ERROR), "\n";
    exit(1);
}

$appDir = $options['app-dir'] ?? null;
$capability = $options['capability'] ?? null;
if (!is_string($appDir) || $appDir === '' || !is_dir($appDir)) {
    probeFail('Missing or invalid --app-dir.');
}
if (!is_string($capability) || $capability === '') {
    probeFail('Missing --capability.');
}

$assistantAppDir = dirname(__DIR__, 2); // app/Mcp/Introspection -> app/
require dirname($assistantAppDir) . '/vendor/autoload.php';

// A real target app is usually its own independently-managed Composer
// project, with plugin/adapter packages (e.g. an ORM adapter) this
// assistant has no reason to also require itself -- only the assistant's
// own vendor/ is loaded above, so a class that lives solely in the target
// app's dependency tree (not shared with the assistant's) would otherwise
// fail to autoload the moment introspection touches it (confirmed: a real
// app using quioteframework/db-propulsion 404s on
// Quiote\Database\Adapter\Propulsion\PropulsionDatabase without this).
// Registered *after* the assistant's own autoloader, so a class both sides
// happen to ship (e.g. quioteframework/quiote itself) still always
// resolves from the assistant's install -- this is purely a fallback for
// classes the assistant's autoloader can't find at all. The target app's
// own composer root isn't always $appDir itself (Config/Modules/etc. can
// sit under a src/<AppName> subdirectory of a differently-rooted Composer
// project, as this app's own `quiote-mcp-assistant` vs its `app/` does),
// so this walks upward looking for the nearest vendor/autoload.php. A
// `quiote new`-scaffolded standalone app has no composer.json/vendor of
// its own at all, so finding none here is normal, not an error.
$dir = $appDir;
while (true) {
    $targetAutoload = $dir . '/vendor/autoload.php';
    if (is_file($targetAutoload)) {
        require $targetAutoload;
        break;
    }
    $parent = dirname($dir);
    if ($parent === $dir) {
        break; // reached filesystem root without finding one
    }
    $dir = $parent;
}

// vendor/autoload.php only knows about vendor packages -- this app's own
// classes (including the Capabilities\* helpers this script dispatches to
// below) have no PSR-4 mapping of their own (mirrors bin/quiote-assistant).
spl_autoload_register(static function (string $class) use ($assistantAppDir): void {
    $prefix = 'QuioteMcpAssistant\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $file = $assistantAppDir . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Quiote;

$env = is_string($options['env'] ?? null) ? $options['env'] : 'development';

Config::set('core.app_dir', $appDir, true, true);
try {
    Quiote::bootstrap($env);
} catch (\Throwable $e) {
    probeFail('Could not bootstrap target app: ' . $e->getMessage());
}

// Mirrors Quiote\Console\Command\AbstractAppCommand::registerAppNamespaceFallbackAutoloader():
// a `quiote new`-scaffolded app has no composer.json of its own and relies on its front
// controller to register this mapping; a probe running outside that front controller needs
// the same fallback to resolve the target app's own action/module classes.
$namespacePrefix = trim(Config::getString('core.namespace_prefix', 'App'), '\\');
spl_autoload_register(static function (string $class) use ($namespacePrefix, $appDir): void {
    $prefix = $namespacePrefix . '\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $file = $appDir . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

$contextName = Config::getString('core.default_context', 'web');

// Only an explicit "0"/"false" turns dry-run off -- missing, "1", or "true"
// all mean "still a dry run" (dry_run defaults true).
$dryRun = !in_array($options['dry-run'] ?? '1', ['0', 'false'], true);

try {
    $result = match ($capability) {
        'project_info' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ProjectInfo::run($contextName),
        'routes' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListRoutes::run(
            $contextName,
            isset($options['module']) ? (string) $options['module'] : null,
            isset($options['action']) ? (string) $options['action'] : null,
        ),
        'action' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\DescribeAction::run(
            $contextName,
            (string) ($options['module'] ?? ''),
            (string) ($options['action'] ?? ''),
        ),
        'db' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListDbConnections::run(),
        'plugins' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListPlugins::run(),
        'modules' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListModules::run(),
        'config' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ReadConfig::run((string) ($options['key'] ?? '')),
        'validate_config' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ValidateConfig::run((string) ($options['key'] ?? '')),
        'overview' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\Overview::run($contextName),
        'diagnostics' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\Diagnostics::run($contextName),
        'scaffold_module' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldModule::run(
            $appDir,
            (string) ($options['module'] ?? ''),
            $dryRun,
        ),
        'scaffold_action' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldAction::run(
            $appDir,
            (string) ($options['module'] ?? ''),
            (string) ($options['action'] ?? ''),
            array_values(array_filter(explode(',', (string) ($options['verbs'] ?? 'read')))),
            array_values(array_filter(explode(',', (string) ($options['formats'] ?? 'html')))),
            $dryRun,
        ),
        'scaffold_plugin' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldPlugin::run(
            $appDir,
            (string) ($options['plugin'] ?? ''),
            $dryRun,
        ),
        'scaffold_db_connection' => \QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldDbConnection::run(
            $appDir,
            (string) ($options['connection'] ?? ''),
            (string) ($options['driver'] ?? 'pdo'),
            $dryRun,
        ),
        default => throw new \InvalidArgumentException('Unknown capability "' . $capability . '".'),
    };
} catch (\Throwable $e) {
    probeFail($e::class . ': ' . $e->getMessage());
}

echo json_encode($result, JSON_THROW_ON_ERROR), "\n";
exit(0);
