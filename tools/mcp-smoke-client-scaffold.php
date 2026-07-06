<?php

declare(strict_types=1);

/**
 * Scaffolding verification: a real MCP client (proc_open, same pattern as
 * mcp-smoke-client.php) driving `scaffold_*`/`run_console` tool calls against
 * a throwaway scratch Quiote app (never this repo's own app/), so writes are
 * exercised for real without touching anything committed. Run
 * `tools/mcp-smoke-client.php` for the main knowledge + project-aware
 * regression suite; this one is separate because it requires an external
 * scratch app argument.
 *
 * Usage: php tools/mcp-smoke-client-scaffold.php /path/to/scratch/app
 */

$scratchAppDir = $argv[1] ?? null;
if ($scratchAppDir === null || !is_dir($scratchAppDir)) {
    fwrite(STDERR, "Usage: php tools/mcp-smoke-client-scaffold.php /path/to/scratch/app\n");
    exit(1);
}
$scratchAppDir = realpath($scratchAppDir);

$repo = dirname(__DIR__);
$bin = $repo . '/bin/quiote-assistant';

$proc = proc_open(['php', $bin, '--target-app-dir=' . $scratchAppDir], [
    0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w'],
], $pipes, $repo);
if (!\is_resource($proc)) {
    fwrite(STDERR, "Failed to launch server.\n");
    exit(1);
}
[$stdin, $stdout, $stderr] = $pipes;

$requests = [
    ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => [
        'protocolVersion' => '2025-11-25', 'capabilities' => [], 'clientInfo' => ['name' => 'scaffold-smoke-client', 'version' => '1.0'],
    ]],
    ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'],
    // 1. Dry-run scaffold_module must write nothing and return a diff. Uses a
    //    module name distinct from anything scaffolded for real below, since
    //    all requests are sent up-front and responses collected at the end --
    //    checking "Blog" here would race against request 3's real write.
    ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/call', 'params' => [
        'name' => 'scaffold_module', 'arguments' => ['module' => 'DryRunOnly'],
    ]],
    // 2. Real write.
    ['jsonrpc' => '2.0', 'id' => 3, 'method' => 'tools/call', 'params' => [
        'name' => 'scaffold_module', 'arguments' => ['module' => 'Blog', 'dry_run' => false],
    ]],
    // 3. Re-scaffolding must refuse to overwrite, even with dry_run=false.
    ['jsonrpc' => '2.0', 'id' => 4, 'method' => 'tools/call', 'params' => [
        'name' => 'scaffold_module', 'arguments' => ['module' => 'Blog', 'dry_run' => false],
    ]],
    // 4. list_routes must now see the scaffolded action's #[Route].
    ['jsonrpc' => '2.0', 'id' => 5, 'method' => 'tools/call', 'params' => [
        'name' => 'list_routes', 'arguments' => [],
    ]],
    // 5. scaffold_action with multiple verbs, real write.
    ['jsonrpc' => '2.0', 'id' => 6, 'method' => 'tools/call', 'params' => [
        'name' => 'scaffold_action',
        'arguments' => ['module' => 'Blog', 'action' => 'Post', 'verbs' => ['read', 'write'], 'dry_run' => false],
    ]],
    // 6. describe_action must see the new action's verbs.
    ['jsonrpc' => '2.0', 'id' => 7, 'method' => 'tools/call', 'params' => [
        'name' => 'describe_action', 'arguments' => ['action' => 'Blog.Post'],
    ]],
    // 7. scaffold_plugin, real write.
    ['jsonrpc' => '2.0', 'id' => 8, 'method' => 'tools/call', 'params' => [
        'name' => 'scaffold_plugin', 'arguments' => ['name' => 'Health', 'dry_run' => false],
    ]],
    // 8. scaffold_db_connection: databases.xml already exists in this fixture
    //    -> must refuse to touch it and return a snippet instead.
    ['jsonrpc' => '2.0', 'id' => 9, 'method' => 'tools/call', 'params' => [
        'name' => 'scaffold_db_connection', 'arguments' => ['name' => 'reporting', 'driver' => 'doctrine_dbal', 'dry_run' => false],
    ]],
    // 9. run_console whitelisted command.
    ['jsonrpc' => '2.0', 'id' => 10, 'method' => 'tools/call', 'params' => [
        'name' => 'run_console', 'arguments' => ['command' => 'routes:list', 'args' => ['json' => true]],
    ]],
    // 10. run_console must refuse an unlisted command.
    ['jsonrpc' => '2.0', 'id' => 11, 'method' => 'tools/call', 'params' => [
        'name' => 'run_console', 'arguments' => ['command' => 'migrate'],
    ]],
    // 11. run_console must refuse an unlisted option.
    ['jsonrpc' => '2.0', 'id' => 12, 'method' => 'tools/call', 'params' => [
        'name' => 'run_console', 'arguments' => ['command' => 'cache:warmup', 'args' => ['env' => 'production']],
    ]],
];

foreach ($requests as $req) {
    fwrite($stdin, json_encode($req, JSON_THROW_ON_ERROR) . "\n");
}
fclose($stdin);

stream_set_blocking($stdout, false);
$responses = [];
$buffer = '';
$deadline = microtime(true) + 20.0;
while (microtime(true) < $deadline) {
    $chunk = fread($stdout, 8192);
    if ($chunk !== false && $chunk !== '') {
        $buffer .= $chunk;
        while (($nl = strpos($buffer, "\n")) !== false) {
            $line = trim(substr($buffer, 0, $nl));
            $buffer = substr($buffer, $nl + 1);
            if ($line !== '') {
                $responses[] = json_decode($line, true);
            }
        }
    } elseif (feof($stdout)) {
        break;
    } else {
        usleep(20000);
    }
}
$errOut = stream_get_contents($stderr);
fclose($stdout);
fclose($stderr);
proc_close($proc);

$byId = [];
foreach ($responses as $r) {
    if (isset($r['id'])) {
        $byId[$r['id']] = $r;
    }
}

$fail = 0;
$check = function (string $label, bool $ok, string $detail = '') use (&$fail): void {
    printf("[%s] %s%s\n", $ok ? 'PASS' : 'FAIL', $label, $detail !== '' ? " — {$detail}" : '');
    if (!$ok) {
        ++$fail;
    }
};

$text = static fn (int $id) => json_decode($byId[$id]['result']['content'][0]['text'] ?? 'null', true);

$dryRunData = $text(2);
$check('scaffold_module dry-run defaults true and previews without writing',
    ($dryRunData['dry_run'] ?? null) === true
        && ($dryRunData['files'][0]['status'] ?? '') === 'would_create'
        && str_contains($dryRunData['files'][0]['diff'] ?? '', '+++ b/Modules/DryRunOnly/Actions/IndexAction.php'),
    'status=' . ($dryRunData['files'][0]['status'] ?? '?'));

$check('dry-run truly wrote nothing to disk',
    !is_file($scratchAppDir . '/Modules/DryRunOnly/Actions/IndexAction.php'));

$writeData = $text(3);
$check('scaffold_module dry_run=false actually creates the files',
    ($writeData['dry_run'] ?? null) === false
        && ($writeData['files'][0]['status'] ?? '') === 'created'
        && is_file($scratchAppDir . '/Modules/Blog/Actions/IndexAction.php'),
    'status=' . ($writeData['files'][0]['status'] ?? '?'));

$reScaffoldData = $text(4);
$check('re-scaffolding never overwrites an existing file, even with dry_run=false',
    ($reScaffoldData['files'][0]['status'] ?? '') === 'skipped_exists',
    'status=' . ($reScaffoldData['files'][0]['status'] ?? '?'));

$routesData = $text(5);
$routeNames = array_column($routesData['routes'] ?? [], 'name');
$check('list_routes sees the scaffolded action\'s #[Route] attribute',
    in_array('blog.index', $routeNames, true),
    'routes=' . implode(',', $routeNames));

$scaffoldActionData = $text(6);
$check('scaffold_action with verbs=[read,write] creates the action',
    ($scaffoldActionData['verbs'] ?? []) === ['read', 'write']
        && ($scaffoldActionData['files'][0]['status'] ?? '') === 'created',
    'verbs=' . implode(',', $scaffoldActionData['verbs'] ?? []));

$describeData = $text(7);
$check('describe_action sees both scaffolded verbs on Blog.Post',
    isset($describeData['verbs']['read'], $describeData['verbs']['write']),
    'verbs=' . implode(',', array_keys($describeData['verbs'] ?? [])));

$pluginData = $text(8);
$check('scaffold_plugin creates the plugin class + returns next_step guidance',
    ($pluginData['files'][0]['status'] ?? '') === 'created'
        && str_contains($pluginData['next_step'] ?? '', 'HealthPlugin::class'),
    'next_step=' . ($pluginData['next_step'] ?? '?'));

$dbData = $text(9);
$check('scaffold_db_connection refuses to touch an existing databases.xml, returns a snippet',
    ($dbData['status'] ?? '') === 'exists_manual_edit_required'
        && str_contains($dbData['snippet'] ?? '', 'name="reporting"'),
    'status=' . ($dbData['status'] ?? '?'));

$consoleData = $text(10);
$consoleOutput = json_decode($consoleData['output'] ?? 'null', true);
$check('run_console("routes:list", {json:true}) runs and returns route data',
    ($consoleData['exit_code'] ?? -1) === 0 && is_array($consoleOutput) && count($consoleOutput) >= 2,
    'exit_code=' . ($consoleData['exit_code'] ?? '?') . ', routes=' . count($consoleOutput ?? []));

// The "command" property's own JSON Schema enum rejects "migrate" at the
// protocol level (a JSON-RPC error), before our tool code even runs --
// arguably better than a graceful in-tool refusal (fails fastest).
$check('run_console refuses an unlisted command ("migrate") at the schema level',
    isset($byId[11]['error']) && str_contains($byId[11]['error']['message'] ?? '', 'allowed values'),
    'response=' . json_encode($byId[11]['error'] ?? null));

$rejectedOption = $text(12);
$check('run_console refuses an unlisted option (--env on cache:warmup)',
    isset($rejectedOption['error']),
    'response=' . json_encode($rejectedOption));

echo "\n";
if ($fail === 0) {
    echo "ALL CHECKS PASSED (" . count($byId) . " responses)\n";
} else {
    echo "{$fail} CHECK(S) FAILED\n\n--- stderr ---\n{$errOut}\n--- raw responses ---\n";
    foreach ($responses as $r) {
        echo substr(json_encode($r), 0, 500) . "\n";
    }
}

exit($fail === 0 ? 0 : 1);
