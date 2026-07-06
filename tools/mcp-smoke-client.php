<?php

declare(strict_types=1);

/**
 * A real MCP client smoke test: launches `bin/quiote-assistant` as a stdio
 * subprocess (exactly as Claude Code / an IDE would) and drives a full JSON-RPC
 * conversation over its stdin/stdout — initialize, then list + call each
 * capability. Not a unit test; this exercises the actual transport + framing.
 *
 * Usage: php tools/mcp-smoke-client.php
 */

$repo = dirname(__DIR__);
$bin = $repo . '/bin/quiote-assistant';

$descriptors = [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
];

// Self-targeting: point --target-app-dir at this repo's own scaffolded app/,
// so the "project-aware" tools are exercised too (dogfooding again -- this
// app is both the assistant and a real, if minimal, Quiote app to
// introspect).
$proc = proc_open(['php', $bin, '--target-app-dir=' . $repo . '/app'], $descriptors, $pipes, $repo);
if (!\is_resource($proc)) {
    fwrite(STDERR, "Failed to launch server.\n");
    exit(1);
}

[$stdin, $stdout, $stderr] = $pipes;

$requests = [
    ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => [
        'protocolVersion' => '2025-11-25',
        'capabilities' => [],
        'clientInfo' => ['name' => 'smoke-client', 'version' => '1.0'],
    ]],
    ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'],
    ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/list'],
    ['jsonrpc' => '2.0', 'id' => 3, 'method' => 'resources/list'],
    ['jsonrpc' => '2.0', 'id' => 4, 'method' => 'prompts/list'],
    ['jsonrpc' => '2.0', 'id' => 5, 'method' => 'tools/call', 'params' => [
        'name' => 'search_docs',
        'arguments' => ['query' => 'define a route', 'limit' => 3],
    ]],
    ['jsonrpc' => '2.0', 'id' => 6, 'method' => 'tools/call', 'params' => [
        'name' => 'get_convention',
        'arguments' => ['topic' => 'validation'],
    ]],
    ['jsonrpc' => '2.0', 'id' => 7, 'method' => 'resources/read', 'params' => [
        'uri' => 'quiote-docs://basics/routing',
    ]],
    ['jsonrpc' => '2.0', 'id' => 8, 'method' => 'prompts/get', 'params' => [
        'name' => 'add-action',
        'arguments' => ['module' => 'Blog', 'name' => 'Post', 'verbs' => 'read,write'],
    ]],
    // Regression: title/description weighting must beat raw body-term
    // frequency (a plain word-frequency ranker put an unrelated middleware
    // doc above the plugins doc here, purely from incidental body mentions).
    ['jsonrpc' => '2.0', 'id' => 9, 'method' => 'tools/call', 'params' => [
        'name' => 'search_docs',
        'arguments' => ['query' => 'how do I add a plugin', 'limit' => 5],
    ]],
    // Regression: excerpt() must not corrupt multi-byte UTF-8 (the docs
    // contain em dashes and box-drawing glyphs) -- a byte-based substr() cut
    // one in half, breaking json_encode() and silently killing the whole
    // tools/call response with no error surfaced to the client.
    ['jsonrpc' => '2.0', 'id' => 10, 'method' => 'tools/call', 'params' => [
        'name' => 'search_docs',
        'arguments' => ['query' => 'database connection', 'limit' => 5],
    ]],
    // Reflection API: describe_symbol / list_api / get_recipe.
    ['jsonrpc' => '2.0', 'id' => 11, 'method' => 'tools/call', 'params' => [
        'name' => 'describe_symbol',
        'arguments' => ['symbol' => 'Quiote\\Action\\Action'],
    ]],
    ['jsonrpc' => '2.0', 'id' => 12, 'method' => 'tools/call', 'params' => [
        'name' => 'describe_symbol',
        'arguments' => ['symbol' => 'Quiote\\Action\\Action::getCredentials'],
    ]],
    ['jsonrpc' => '2.0', 'id' => 13, 'method' => 'tools/call', 'params' => [
        'name' => 'list_api',
        'arguments' => [],
    ]],
    ['jsonrpc' => '2.0', 'id' => 14, 'method' => 'tools/call', 'params' => [
        'name' => 'list_api',
        'arguments' => ['namespace' => 'Quiote\\Mcp'],
    ]],
    ['jsonrpc' => '2.0', 'id' => 15, 'method' => 'tools/call', 'params' => [
        'name' => 'get_recipe',
        'arguments' => ['task' => 'add-plugin'],
    ]],
    // Project-aware tools, introspecting this repo's own app/ (self-target).
    ['jsonrpc' => '2.0', 'id' => 16, 'method' => 'tools/call', 'params' => [
        'name' => 'project_info',
        'arguments' => [],
    ]],
    ['jsonrpc' => '2.0', 'id' => 17, 'method' => 'tools/call', 'params' => [
        'name' => 'list_routes',
        'arguments' => [],
    ]],
    ['jsonrpc' => '2.0', 'id' => 18, 'method' => 'tools/call', 'params' => [
        'name' => 'describe_action',
        'arguments' => ['action' => 'Default.Contact'],
    ]],
    ['jsonrpc' => '2.0', 'id' => 19, 'method' => 'tools/call', 'params' => [
        'name' => 'list_db_connections',
        'arguments' => [],
    ]],
    ['jsonrpc' => '2.0', 'id' => 20, 'method' => 'tools/call', 'params' => [
        'name' => 'list_plugins',
        'arguments' => [],
    ]],
    ['jsonrpc' => '2.0', 'id' => 21, 'method' => 'tools/call', 'params' => [
        'name' => 'list_modules',
        'arguments' => [],
    ]],
    // Regression: read_config must refuse a non-whitelisted (secret-shaped) key.
    ['jsonrpc' => '2.0', 'id' => 22, 'method' => 'tools/call', 'params' => [
        'name' => 'read_config',
        'arguments' => ['key' => 'mcp.auth_token'],
    ]],
    ['jsonrpc' => '2.0', 'id' => 23, 'method' => 'tools/call', 'params' => [
        'name' => 'read_config',
        'arguments' => ['key' => 'core.use_database'],
    ]],
];

foreach ($requests as $req) {
    fwrite($stdin, json_encode($req, JSON_THROW_ON_ERROR) . "\n");
}
fclose($stdin); // signal EOF so the server drains + exits

stream_set_blocking($stdout, false);
$responses = [];
$buffer = '';
$deadline = microtime(true) + 15.0;
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

// ---- Report ---------------------------------------------------------------
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

$init = $byId[1] ?? null;
$check('initialize', isset($init['result']['serverInfo']['name']),
    'server=' . ($init['result']['serverInfo']['name'] ?? '?') . ' v' . ($init['result']['serverInfo']['version'] ?? '?'));

$tools = $byId[2]['result']['tools'] ?? [];
$toolNames = array_map(static fn ($t) => $t['name'], $tools);
$expectedTools = [
    'search_docs', 'get_convention', 'get_recipe', 'describe_symbol', 'list_api',
    'project_info', 'list_routes', 'describe_action', 'list_db_connections',
    'list_plugins', 'list_modules', 'read_config',
];
$check('tools/list has all 12 tools (knowledge + project-aware, since --target-app-dir is set)',
    count(array_intersect($expectedTools, $toolNames)) === count($expectedTools),
    implode(', ', $toolNames));

$resources = $byId[3]['result']['resources'] ?? [];
$check('resources/list returns one resource per bundled doc', count($resources) > 0, count($resources) . ' resources');

$prompts = $byId[4]['result']['prompts'] ?? [];
$promptNames = array_map(static fn ($p) => $p['name'], $prompts);
$expectedPrompts = ['new-module', 'add-action', 'add-service', 'add-plugin', 'add-db-connection', 'expose-mcp-tool'];
$check('prompts/list has all 6 core prompts',
    count(array_intersect($expectedPrompts, $promptNames)) === 6,
    implode(', ', $promptNames));

$searchText = $byId[5]['result']['content'][0]['text'] ?? '';
$searchData = json_decode($searchText, true);
$topUri = $searchData['results'][0]['uri'] ?? '';
$check('search_docs("define a route") ranks routing first',
    $topUri === 'quiote-docs://basics/routing',
    "top={$topUri}, count=" . ($searchData['count'] ?? 0));

$convText = $byId[6]['result']['content'][0]['text'] ?? '';
$check('get_convention("validation") returns the card',
    str_contains($convText, 'ValidatorBuilder'), 'title present: ' . (str_contains($convText, 'Input validation') ? 'yes' : 'no'));

$readContents = $byId[7]['result']['contents'][0] ?? [];
$check('resources/read routing doc',
    ($readContents['mimeType'] ?? '') === 'text/markdown' && str_contains($readContents['text'] ?? '', '# Routing'),
    'mime=' . ($readContents['mimeType'] ?? '?'));

$promptMsgs = $byId[8]['result']['messages'] ?? [];
$promptText = $promptMsgs[0]['content']['text'] ?? '';
$check('prompts/get add-action interpolates args + stitches convention',
    str_contains($promptText, 'module "Blog"') && str_contains($promptText, 'read,write') && str_contains($promptText, 'Input validation'),
    count($promptMsgs) . ' message(s)');

$pluginSearchText = $byId[9]['result']['content'][0]['text'] ?? '';
$pluginSearchData = json_decode($pluginSearchText, true);
$pluginTopUri = $pluginSearchData['results'][0]['uri'] ?? '';
$check('search_docs("how do I add a plugin") ranks plugins doc first',
    $pluginTopUri === 'quiote-docs://architecture/plugins',
    "top={$pluginTopUri}, count=" . ($pluginSearchData['count'] ?? 0));

$dbSearchText = $byId[10]['result']['content'][0]['text'] ?? '';
$dbSearchData = json_decode($dbSearchText, true);
$dbTopUri = $dbSearchData['results'][0]['uri'] ?? '';
$check('search_docs("database connection") returns valid JSON and ranks databases doc first',
    $dbSearchText !== '' && $dbSearchData !== null && $dbTopUri === 'quiote-docs://basics/databases',
    "top={$dbTopUri}, count=" . ($dbSearchData['count'] ?? 0));

$describeClassText = $byId[11]['result']['content'][0]['text'] ?? '';
$describeClassData = json_decode($describeClassText, true);
$check('describe_symbol("Quiote\\Action\\Action") returns class shape',
    ($describeClassData['fqcn'] ?? '') === 'Quiote\\Action\\Action'
        && ($describeClassData['kind'] ?? '') === 'class'
        && ($describeClassData['abstract'] ?? false) === true
        && in_array('getCredentials', array_column($describeClassData['methods'] ?? [], 'name'), true),
    'kind=' . ($describeClassData['kind'] ?? '?') . ', methods=' . count($describeClassData['methods'] ?? []));

$describeMethodText = $byId[12]['result']['content'][0]['text'] ?? '';
$describeMethodData = json_decode($describeMethodText, true);
$check('describe_symbol("...::getCredentials") returns method shape',
    ($describeMethodData['method']['name'] ?? '') === 'getCredentials',
    'name=' . ($describeMethodData['method']['name'] ?? '?'));

$listApiRootText = $byId[13]['result']['content'][0]['text'] ?? '';
$listApiRootData = json_decode($listApiRootText, true);
$check('list_api() with no namespace lists top-level namespaces',
    is_array($listApiRootData['namespaces'] ?? null) && isset($listApiRootData['namespaces']['Quiote\\Mcp']),
    'namespaces=' . count($listApiRootData['namespaces'] ?? []));

$listApiMcpText = $byId[14]['result']['content'][0]['text'] ?? '';
$listApiMcpData = json_decode($listApiMcpText, true);
$mcpClassFqcns = array_column($listApiMcpData['classes'] ?? [], 'fqcn');
$check('list_api("Quiote\\Mcp") lists McpPlugin',
    in_array('Quiote\\Mcp\\McpPlugin', $mcpClassFqcns, true),
    'count=' . ($listApiMcpData['count'] ?? 0));

$recipeText = $byId[15]['result']['content'][0]['text'] ?? '';
$recipeData = json_decode($recipeText, true);
$check('get_recipe("add-plugin") returns steps with code',
    ($recipeData['task'] ?? '') === 'add-plugin'
        && count($recipeData['steps'] ?? []) > 0
        && str_contains($recipeData['steps'][0]['code'] ?? '', 'PluginInterface'),
    'steps=' . count($recipeData['steps'] ?? []));

$projectInfoText = $byId[16]['result']['content'][0]['text'] ?? '';
$projectInfoData = json_decode($projectInfoText, true);
$check('project_info() introspects this app (self-target)',
    ($projectInfoData['app_name'] ?? '') === 'QuioteMcpAssistant'
        && in_array('quiote/assistant', $projectInfoData['plugins'] ?? [], true),
    'app_name=' . ($projectInfoData['app_name'] ?? '?'));

$listRoutesText = $byId[17]['result']['content'][0]['text'] ?? '';
$listRoutesData = json_decode($listRoutesText, true);
$routeNames = array_column($listRoutesData['routes'] ?? [], 'name');
$check('list_routes() finds both programmatic and #[Route]-attributed routes',
    in_array('index', $routeNames, true) && in_array('contact', $routeNames, true),
    'routes=' . implode(',', $routeNames));

$describeActionText = $byId[18]['result']['content'][0]['text'] ?? '';
$describeActionData = json_decode($describeActionText, true);
$check('describe_action("Default.Contact") returns verbs/credentials/view',
    ($describeActionData['class'] ?? '') === 'QuioteMcpAssistant\\Modules\\Default\\Actions\\ContactAction'
        && isset($describeActionData['verbs']['read']),
    'class=' . ($describeActionData['class'] ?? '?'));

$listDbText = $byId[19]['result']['content'][0]['text'] ?? '';
$listDbData = json_decode($listDbText, true);
$check('list_db_connections() reports adapter + parameter names only, never values',
    ($listDbData['found'] ?? false) === true
        && ($listDbData['databases']['default']['class'] ?? '') === 'Quiote\\Database\\PdoDatabase'
        && in_array('dsn', $listDbData['databases']['default']['parameter_keys'] ?? [], true)
        && !str_contains($listDbText, 'sqlite') && !str_contains(strtolower($listDbText), 'mysql:'),
    'default=' . ($listDbData['default'] ?? '?'));

$listPluginsText = $byId[20]['result']['content'][0]['text'] ?? '';
$listPluginsData = json_decode($listPluginsText, true);
$check('list_plugins() reports both registered plugins',
    count($listPluginsData['plugins'] ?? []) === 2,
    'count=' . ($listPluginsData['count'] ?? 0));

$listModulesText = $byId[21]['result']['content'][0]['text'] ?? '';
$listModulesData = json_decode($listModulesText, true);
$check('list_modules() finds the Default module',
    in_array('Default', $listModulesData['modules'] ?? [], true),
    'modules=' . implode(',', $listModulesData['modules'] ?? []));

$readSecretText = $byId[22]['result']['content'][0]['text'] ?? '';
$readSecretData = json_decode($readSecretText, true);
$check('read_config("mcp.auth_token") is refused (not whitelisted)',
    isset($readSecretData['error']) && !isset($readSecretData['value']),
    'response=' . $readSecretText);

$readSafeText = $byId[23]['result']['content'][0]['text'] ?? '';
$readSafeData = json_decode($readSafeText, true);
$check('read_config("core.use_database") returns the whitelisted value',
    ($readSafeData['key'] ?? '') === 'core.use_database' && ($readSafeData['value'] ?? null) === false,
    'value=' . json_encode($readSafeData['value'] ?? null));

echo "\n";
if ($fail === 0) {
    echo "ALL CHECKS PASSED ({" . count($byId) . "} responses)\n";
} else {
    echo "{$fail} CHECK(S) FAILED\n";
    echo "\n--- stderr from server ---\n" . $errOut . "\n";
    echo "--- raw responses ---\n";
    foreach ($responses as $r) {
        echo substr(json_encode($r), 0, 400) . "\n";
    }
}

exit($fail === 0 ? 0 : 1);
